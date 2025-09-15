<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory\DataProviderFactory;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Data\DataFormat;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Conditional\Conditional;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Initable\Initable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Request\Request;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\ImportFileForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\View\ImportCsvSelectorViewAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\View\ImportXmlSelectorViewAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportFileDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportFileFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Helper\PluginHelper;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DAO\ImportDAO;
/**
 * Class ImportFileFormProcessAction, import file view form process.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Action\Process\Form
 */
class ImportFileFormProcessAction implements Conditional, Initable
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var ImportFileForm
     */
    private $form;
    /**
     * @var PluginHelper
     */
    private $plugin_helper;
    /**
     * @var DataProviderFactory
     */
    private $data_provider_factory;
    /**
     * @var ImportDAO
     */
    private $import_dao;
    public function __construct(Request $request, ImportFileForm $form, DataProviderFactory $data_provider_factory, PluginHelper $helper, ImportDAO $import_dao)
    {
        $this->request = $request;
        $this->form = $form;
        $this->plugin_helper = $helper;
        $this->data_provider_factory = $data_provider_factory;
        $this->import_dao = $import_dao;
    }
    public function isActive(): bool
    {
        $settings = $this->request->get_param('post.' . ImportFileForm::get_id());
        return $settings->isArray() && !$settings->isEmpty();
    }
    public function init()
    {
        $this->save_form_data();
    }
    private function save_form_data()
    {
        $file_form_id = ImportFileForm::get_id();
        $uid = $this->request->get_param('post.' . $file_form_id . '.' . ImportFileFormFields::UID)->getAsString();
        $format = $this->request->get_param('post.' . $file_form_id . '.' . ImportFileFormFields::ORIGINAL_FILE_FORMAT)->getAsString();
        $this->form->handle_request($this->request->get_param('post.' . $file_form_id)->get());
        if ($this->form->is_valid() && current_user_can('manage_options')) {
            $data_provider = $this->data_provider_factory->create_by_class_name(ImportFileDataProvider::class, ['postfix' => $uid]);
            $data_provider->update($this->form);
            $view = DataFormat::XML == $format ? ImportXmlSelectorViewAction::class : ImportCsvSelectorViewAction::class;
            $mode = $this->request->get_param('get.mode')->getAsString();
            if (!empty($mode)) {
                $args = ['uid' => $uid, 'mode' => $mode];
                if ($this->import_dao->is_uid_exists($uid)) {
                    $import = $this->import_dao->find_by_uid($uid);
                    $url = $data_provider->get(ImportFileFormFields::FILE_URL);
                    if ($url != $import->get_url()) {
                        $import->set_url($url);
                        $this->import_dao->update($import);
                        $args['changed'] = 'yes';
                    }
                }
            } else {
                $args = ['uid' => $uid];
            }
            $this->redirect($this->plugin_helper->generate_url_by_view($view, $args));
        }
    }
    private function redirect(string $url)
    {
        wp_redirect($url);
        exit;
    }
}
