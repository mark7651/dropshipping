<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Helper\PluginHelper;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Conditional\Conditional;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Initable\Initable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Request\Request;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DAO\ImportDAO;
use Exception;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\View\ImportManagerViewAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportOptionsDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportXmlSelectorDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Creator\ImportCreatorService;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory\DataProviderFactory;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Data\DataFormat;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportFileFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Provider\Abstraction\DataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Locator\FileLocatorService;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportFileDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportCsvSelectorDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportMapperDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportSidebarDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Entity\Import;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportSidebarFormFields;
/**
 * Class ImportManagerDeleteProcessAction, import delete process over import manager.
 */
class ImportManagerCloneProcessAction implements Conditional, Initable
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var PluginHelper
     */
    private $plugin_helper;
    /**
     * @var ImportFileLocatorService
     */
    private $file_locator_service;
    /**
     * @var ImportCreatorService
     */
    private $import_creator_service;
    /**
     * @var DataProviderFactory
     */
    private $data_provider_factory;
    public function __construct(Request $request, PluginHelper $plugin_helper, ImportCreatorService $import_creator_service, DataProviderFactory $data_provider_factory, FileLocatorService $file_locator_service)
    {
        $this->request = $request;
        $this->plugin_helper = $plugin_helper;
        $this->import_creator_service = $import_creator_service;
        $this->data_provider_factory = $data_provider_factory;
        $this->file_locator_service = $file_locator_service;
    }
    public function isActive(): bool
    {
        return $this->request->get_param('get.clone')->isString() && $this->plugin_helper->is_plugin_page($this->request->get_param('get.page')->getAsString());
    }
    public function init()
    {
        $this->validate_form_data();
        $this->clone_import();
    }
    private function clone_import()
    {
        $old_uid = $this->request->get_param('get.clone')->getAsString();
        $uid = $this->generate_uid();
        $this->clone_import_data($old_uid, $uid);
        $this->import_creator_service->create_import($uid, Import::STATUS_STOPPED);
        $url = $this->plugin_helper->generate_url_by_view(ImportManagerViewAction::class);
        wp_redirect($url);
        exit;
    }
    private function clone_import_data(string $from_uid, string $to_uid)
    {
        $args = ['postfix' => $from_uid];
        $connector_data_provider = $this->data_provider_factory->create_by_class_name(ImportFileDataProvider::class, $args);
        $format = $connector_data_provider->get(ImportFileFormFields::ORIGINAL_FILE_FORMAT);
        $selector_data_provider_class = DataFormat::XML == $format ? ImportXmlSelectorDataProvider::class : ImportCsvSelectorDataProvider::class;
        $data_providers = [$connector_data_provider, $this->data_provider_factory->create_by_class_name($selector_data_provider_class, $args), $this->data_provider_factory->create_by_class_name(ImportMapperDataProvider::class, $args), $this->data_provider_factory->create_by_class_name(ImportOptionsDataProvider::class, $args), $this->data_provider_factory->create_by_class_name(ImportSidebarDataProvider::class, $args)];
        foreach ($data_providers as $data_provider) {
            $this->create_data_provider_copy($data_provider, $to_uid);
        }
        $this->file_locator_service->clone_uid($from_uid, $to_uid);
    }
    private function create_data_provider_copy(DataProvider $data_provider, string $uid)
    {
        try {
            $data_provider_data = $data_provider->get_all();
            $data_provider_class = get_class($data_provider);
            $args = ['postfix' => $uid];
            $new_data_provider = $this->data_provider_factory->create_by_class_name($data_provider_class, $args);
            if (\is_array($data_provider_data)) {
                foreach ($data_provider_data as $key => $value) {
                    $new_data_provider->set($key, $value);
                }
                if ($data_provider_class === ImportFileDataProvider::class) {
                    $new_data_provider->set(ImportFileFormFields::UID, $uid);
                }
                if ($data_provider_class === ImportSidebarDataProvider::class) {
                    if ($new_data_provider->has(ImportSidebarFormFields::IMPORT_NAME) && !empty($new_data_provider->get(ImportSidebarFormFields::IMPORT_NAME))) {
                        $name = $new_data_provider->get(ImportSidebarFormFields::IMPORT_NAME);
                        $new_data_provider->set(ImportSidebarFormFields::IMPORT_NAME, $name . ' ' . __('copy', 'dropshipping-xml-for-woocommerce'));
                    }
                }
                $new_data_provider->save();
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }
    private function generate_uid(): string
    {
        return uniqid();
    }
    private function validate_form_data()
    {
        if (!wp_verify_nonce($this->request->get_param('get.nonce')->getAsString(), ImportManagerViewAction::MANAGER_NONCE)) {
            wp_die('Error, security code is not valid');
        }
        if (!current_user_can('manage_options')) {
            wp_die('Error, you are not allowed to do this action');
        }
    }
}
