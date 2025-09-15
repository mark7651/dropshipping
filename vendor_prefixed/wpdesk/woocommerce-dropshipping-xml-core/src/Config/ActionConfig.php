<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Config;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Config\Abstraction\AbstractSingleConfig;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Cron\ImportCronAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Installer\PluginInstallerAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Assets\PluginAssetsLoaderAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Assets\AjaxAssetsLoaderAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Assets\WooAssetsLoaderAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Menu\AdminMenuLoaderAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Plugin\PluginLinksLoaderAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\PostType\ImportPostTypeLoaderAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form\ImportManagerFormProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\ImportProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Ajax\ConvertCsvImportAjaxAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Ajax\ConvertXmlImportAjaxAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Ajax\PreviewCsvImportAjaxAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Ajax\PreviewXmlImportAjaxAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Ajax\StopImportAjaxAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Ajax\FileImportAjaxAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Ajax\PreviewVariationsAjaxAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Cron\ClearTempFilesCronAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Process\Form\ImportSidebarFormProcessAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Product\ProductColumnLoaderAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Notification\FileLimitNotificationAction;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Assets\MenuPluginAssetsLoaderAction;
/**
 * Class ActionConfig, configuration class for actions.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Config
 */
class ActionConfig extends AbstractSingleConfig
{
    const ID = 'action';
    public function get(): array
    {
        return [PluginInstallerAction::class, FileLimitNotificationAction::class, FileImportAjaxAction::class, ConvertCsvImportAjaxAction::class, PreviewCsvImportAjaxAction::class, ConvertXmlImportAjaxAction::class, PreviewXmlImportAjaxAction::class, PreviewVariationsAjaxAction::class, StopImportAjaxAction::class, ClearTempFilesCronAction::class, ImportCronAction::class, ImportProcessAction::class, ImportManagerFormProcessAction::class, ImportSidebarFormProcessAction::class, AjaxAssetsLoaderAction::class, PluginAssetsLoaderAction::class, MenuPluginAssetsLoaderAction::class, WooAssetsLoaderAction::class, ImportPostTypeLoaderAction::class, PluginLinksLoaderAction::class, AdminMenuLoaderAction::class, ProductColumnLoaderAction::class];
    }
    public function get_id(): string
    {
        return self::ID;
    }
}
