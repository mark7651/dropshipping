<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\View;

use DropshippingXmlFreeVendor\WPDesk\View\Renderer\Renderer;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\ImportManagerForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Helper\PluginHelper;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Registrable\Registrable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\View\Abstraction\Displayable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\View\FormView;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DAO\ImportDAO;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\View\ImportManagerView;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form\ImportManagerFormProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\ImportManagerActivateProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\ImportManagerCloneProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\ImportManagerDeleteProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\ImportManagerStopProcessAction;
/**
 * Class ImportManagerViewAction, import manager view action.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Action\View
 */
class ImportManagerViewAction implements Displayable, Registrable
{
    const MANAGER_NONCE = 'nonce_import_manager';
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var ImportManagerForm
     */
    private $form;
    /**
     * @var ImportDAO
     */
    private $import_dao;
    /**
     * @var PluginHelper
     */
    private $plugin_helper;
    public function __construct(Renderer $renderer, ImportManagerForm $form, ImportDAO $import_dao, PluginHelper $helper)
    {
        $this->renderer = $renderer;
        $this->form = $form;
        $this->import_dao = $import_dao;
        $this->plugin_helper = $helper;
    }
    public function register(): array
    {
        return [ImportManagerFormProcessAction::class, ImportManagerDeleteProcessAction::class, ImportManagerStopProcessAction::class, ImportManagerActivateProcessAction::class, ImportManagerCloneProcessAction::class];
    }
    public function show()
    {
        $imports = $this->import_dao->get_all();
        $imports_count = count($imports);
        $element = $imports_count > 1 ? __('elements', 'dropshipping-xml-for-woocommerce') : __('element', 'dropshipping-xml-for-woocommerce');
        $import_url = $this->plugin_helper->generate_url_by_view(ImportFileViewAction::class);
        $data = ['title' => __('Import Manager', 'dropshipping-xml-for-woocommerce'), 'import_url' => $import_url, 'header_url' => '<a href="' . $import_url . '" class="page-title-action" target="_self">' . __('create new', 'dropshipping-xml-for-woocommerce') . '</a>', 'form' => new FormView($this->form, $this->renderer), 'imports' => $imports, 'elements' => strval($imports_count) . ' ' . $element, 'nonce' => wp_create_nonce(self::MANAGER_NONCE), 'plugin_helper' => $this->plugin_helper, 'renderer' => $this->renderer];
        $this->renderer->output_render('Import/ImportManager', $data);
    }
}
