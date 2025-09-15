<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\View;

use DropshippingXmlFreeVendor\WPDesk\View\Renderer\Renderer;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportFileDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportMapperDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory\DataProviderFactory;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory\ViewActionFactory;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\ImportOptionsForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Helper\PluginHelper;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Request\Request;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Initable\Initable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Registrable\Registrable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\View\Abstraction\Displayable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form\ImportOptionsFormProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\View\FormView;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportOptionsDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportMapperFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportFileFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Data\DataFormat;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportCsvSelectorFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportXmlSelectorFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportXmlSelectorDataProvider;
/**
 * Class ImportOptionsViewAction, import options view action.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Action\View
 */
class ImportOptionsViewAction implements Displayable, Registrable, Initable
{
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var PluginHelper
     */
    private $plugin_helper;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var ViewActionFactory
     */
    private $view_factory;
    /**
     * @var ImportOptionsForm
     */
    private $form;
    /**
     * @var DataProviderFactory
     */
    private $data_provider_factory;
    public function __construct(Request $request, Renderer $renderer, ImportOptionsForm $form, ViewActionFactory $view_factory, DataProviderFactory $data_provider_factory, PluginHelper $helper)
    {
        $this->renderer = $renderer;
        $this->plugin_helper = $helper;
        $this->request = $request;
        $this->view_factory = $view_factory;
        $this->form = $form;
        $this->data_provider_factory = $data_provider_factory;
    }
    public function register(): array
    {
        return [ImportOptionsFormProcessAction::class];
    }
    public function init()
    {
        $uid = $this->request->get_param('get.uid')->get();
        $data_provider = $this->data_provider_factory->create_by_class_name(ImportOptionsDataProvider::class, ['postfix' => $uid]);
        $this->form->set_data($data_provider);
    }
    public function show()
    {
        $uid = $this->request->get_param('get.uid')->get();
        $data_provider = $this->data_provider_factory->create_by_class_name(ImportMapperDataProvider::class, ['postfix' => $uid]);
        $is_variable = $data_provider->has(ImportMapperFormFields::PRODUCT_TYPE) ? $data_provider->get(ImportMapperFormFields::PRODUCT_TYPE) === ImportMapperFormFields::PRODUCT_TYPE_OPTION_VARIABLE : \false;
        $import_data_provider = $this->data_provider_factory->create_by_class_name(ImportFileDataProvider::class, ['postfix' => $uid]);
        $format = $import_data_provider->get(ImportFileFormFields::ORIGINAL_FILE_FORMAT);
        $sidebar_view = $this->view_factory->create_sidebar_by_data_type($format, ['uid' => $uid]);
        if (DataFormat::XML == $format) {
            $xml_data_provider = $this->data_provider_factory->create_by_class_name(ImportXmlSelectorDataProvider::class, ['postfix' => $uid]);
            $node_element = $xml_data_provider->get(ImportXmlSelectorFormFields::NODE_ELEMENT);
        } else {
            $node_element = ImportCsvSelectorFormFields::NODE_ELEMENT_VALUE;
        }
        $this->form->handle_request([ImportMapperFormFields::NODE_ELEMENT => $node_element]);
        $data = ['title' => __('Import options', 'dropshipping-xml-for-woocommerce'), 'form' => new FormView($this->form, $this->renderer), 'previous_step' => $this->plugin_helper->generate_url_by_view(ImportMapperViewAction::class, ['uid' => $this->request->get_param('get.uid')->get()]), 'edit' => $this->request->get_param('get.mode')->get() === 'edit', 'mode' => $this->request->get_param('get.mode')->getAsString(), 'is_variable' => $is_variable, 'sidebar' => $sidebar_view, 'renderer' => $this->renderer];
        $this->renderer->output_render('Import/Options', $data);
    }
}
