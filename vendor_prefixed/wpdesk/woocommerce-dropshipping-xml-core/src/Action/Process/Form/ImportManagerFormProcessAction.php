<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportManagerFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Conditional\Conditional;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Initable\Initable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Request\Request;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\ImportManagerForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\ImportManagerDeleteProcessAction;
/**
 * Class ImportManagerFormProcessAction, import manager view process.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Action\Process\Form
 */
class ImportManagerFormProcessAction implements Conditional, Initable
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var ImportManagerForm
     */
    private $form;
    /**
     *
     * @var ImportManagerDeleteProcessAction
     */
    private $delete_process;
    public function __construct(Request $request, ImportManagerForm $form, ImportManagerDeleteProcessAction $import_delete_process)
    {
        $this->request = $request;
        $this->form = $form;
        $this->delete_process = $import_delete_process;
    }
    public function isActive(): bool
    {
        $settings = $this->request->get_param('post.' . ImportManagerForm::ID);
        return $settings->isArray() && !$settings->isEmpty();
    }
    public function init()
    {
        $this->process_form_data();
    }
    private function process_form_data()
    {
        $form_data = $this->request->get_param('post.' . ImportManagerForm::ID)->get();
        $remove = \false;
        $this->form->handle_request($form_data);
        if ($this->form->is_valid() && current_user_can('manage_options')) {
            if ($this->request->get_param('post.' . ImportManagerFormFields::SUBMIT_MANAGE_APPLY)->isSet()) {
                $remove = isset($form_data[ImportManagerFormFields::SELECT_MANAGE]) && ImportManagerFormFields::SELECT_MANAGE_OPTION_REMOVE === $form_data[ImportManagerFormFields::SELECT_MANAGE];
            } elseif ($this->request->get_param('post.' . ImportManagerFormFields::SUBMIT_MANAGE_APPLY_BOTTOM)->isSet()) {
                $remove = isset($form_data[ImportManagerFormFields::SELECT_MANAGE_BOTTOM]) && ImportManagerFormFields::SELECT_MANAGE_OPTION_REMOVE === $form_data[ImportManagerFormFields::SELECT_MANAGE_BOTTOM];
            }
            if (\true === $remove) {
                if (isset($form_data['id']) && !empty($form_data['id'])) {
                    foreach ($form_data['id'] as $id) {
                        if (\is_numeric($id)) {
                            try {
                                $this->delete_process->delete_import_by_id((int) $id);
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
            }
        }
    }
}
