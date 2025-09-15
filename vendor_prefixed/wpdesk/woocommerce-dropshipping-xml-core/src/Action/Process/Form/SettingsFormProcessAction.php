<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory\DataProviderFactory;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Conditional\Conditional;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Initable\Initable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Request\Request;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\SettingsForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\SettingsDataProvider;
/**
 * Class SettingsFormProcessAction, settings view form process.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Action\Process\Form
 */
class SettingsFormProcessAction implements Conditional, Initable
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var SettingsForm
     */
    private $form;
    /**
     * @var DataProviderFactory
     */
    private $data_provider_factory;
    public function __construct(Request $request, SettingsForm $form, DataProviderFactory $data_provider_factory)
    {
        $this->request = $request;
        $this->form = $form;
        $this->data_provider_factory = $data_provider_factory;
    }
    public function isActive(): bool
    {
        $settings = $this->request->get_param('post.' . SettingsForm::ID);
        return $settings->isArray() && !$settings->isEmpty();
    }
    public function init()
    {
        $this->save_form_data();
    }
    private function save_form_data()
    {
        $this->form->handle_request($this->request->get_param('post.' . SettingsForm::ID)->get());
        if ($this->form->is_valid() && current_user_can('manage_options')) {
            $data_provider = $this->data_provider_factory->create_by_class_name(SettingsDataProvider::class);
            $data_provider->update($this->form);
        }
    }
}
