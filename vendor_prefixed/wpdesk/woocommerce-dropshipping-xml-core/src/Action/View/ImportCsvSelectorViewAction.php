<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\View;

use DropshippingXmlFreeVendor\WPDesk\View\Renderer\Renderer;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Analyser\CsvAnalyser;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Analyser\XmlAnalyser;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportCsvSelectorDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory\DataProviderFactory;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportCsvSelectorFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\ImportCsvSelectorForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Data\DataFormat;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Request\Request;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Registrable\Registrable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\View\Abstraction\Displayable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Converter\FileConverterService;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Locator\FileLocatorService;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\View\FormView;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Helper\PluginHelper;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form\ImportCsvSelectorFormProcessAction;
/**
 * Class ImportCsvSelectorViewAction, csv selector view action.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Action\View
 */
class ImportCsvSelectorViewAction implements Displayable, Registrable
{
    const FIRST_PAGE = 1;
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var ImportCsvSelectorForm
     */
    private $form;
    /**
     * @var PluginHelper
     */
    private $plugin_helper;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var FileConverterService
     */
    private $converter_service;
    /**
     * @var DataProviderFactory
     */
    private $data_provider_factory;
    /**
     * @var FileLocatorService
     */
    private $file_locator;
    /**
     * @var CsvAnalyser
     */
    private $csv_analyser;
    /**
     * @var XmlAnalyser
     */
    private $xml_analyser;
    public function __construct(Request $request, Renderer $renderer, DataProviderFactory $data_provider_factory, ImportCsvSelectorForm $form, FileConverterService $converter, FileLocatorService $file_locator, CsvAnalyser $csv_analyser, XmlAnalyser $xml_analyser, PluginHelper $plugin_helper)
    {
        $this->renderer = $renderer;
        $this->form = $form;
        $this->plugin_helper = $plugin_helper;
        $this->request = $request;
        $this->converter_service = $converter;
        $this->data_provider_factory = $data_provider_factory;
        $this->file_locator = $file_locator;
        $this->csv_analyser = $csv_analyser;
        $this->xml_analyser = $xml_analyser;
    }
    public function register(): array
    {
        return [ImportCsvSelectorFormProcessAction::class];
    }
    public function show()
    {
        $uid = $this->request->get_param('get.uid')->getAsString();
        $process_data = $this->process_csv($uid);
        $data = ['title' => __('File preview', 'dropshipping-xml-for-woocommerce'), 'edit' => \false, 'mode' => $this->request->get_param('get.mode')->getAsString(), 'form' => new FormView($this->form, $this->renderer), 'previous_step' => $this->plugin_helper->generate_url_by_view(ImportFileViewAction::class, ['uid' => $uid]), 'renderer' => $this->renderer];
        $data = array_merge($data, $process_data);
        $this->renderer->output_render('Import/ImportSelector', $data);
    }
    private function process_csv(string $uid): array
    {
        $is_url_changed = $this->request->get_param('get.changed')->getAsString() === 'yes';
        $data_provider = $this->data_provider_factory->create_by_class_name(ImportCsvSelectorDataProvider::class, ['postfix' => $uid]);
        $this->form->set_data($data_provider);
        $source_file = $this->file_locator->get_source_file($uid);
        if (!$data_provider->has(ImportCsvSelectorFormFields::INPUT_SEPARATOR) || $is_url_changed) {
            $separator = $this->csv_analyser->resolve_separator($source_file);
        } else {
            $separator = $data_provider->get(ImportCsvSelectorFormFields::INPUT_SEPARATOR);
        }
        if (!$this->file_locator->is_converted_file_exists($uid) || $is_url_changed) {
            $this->converter_service->convert_from_format(DataFormat::CSV);
            $converted_file = $this->converter_service->convert($source_file, ['separator' => $separator, 'source_encoding' => $this->csv_analyser->resolve_source_encoding($source_file)]);
        } else {
            $converted_file = $this->file_locator->get_converted_file($uid);
        }
        $this->xml_analyser->load_from_file($converted_file);
        $this->form->handle_request([ImportCsvSelectorFormFields::INPUT_SEPARATOR => $separator]);
        return ['items' => $this->xml_analyser->count_element(ImportCsvSelectorFormFields::NODE_ELEMENT_VALUE), 'item_nr' => self::FIRST_PAGE, 'table_data' => ['node' => $this->xml_analyser->get_element_as_object(ImportCsvSelectorFormFields::NODE_ELEMENT_VALUE, self::FIRST_PAGE)], 'format' => DataFormat::CSV];
    }
}
