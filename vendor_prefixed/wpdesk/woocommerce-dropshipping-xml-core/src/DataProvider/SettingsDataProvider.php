<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\SettingsForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Provider\Abstraction\DataProvider;
/**
 * Class SettingsDataProvider, settings data provider.
 *
 * @package WPDesk\Library\DropshippingXmlCore\DataProvider
 */
class SettingsDataProvider extends DropshippingDataProvider
{
    /**
     * @see DataProvider::get_id()
     */
    public static function get_id(): string
    {
        return SettingsForm::get_id();
    }
    protected function get_identity(): string
    {
        return self::get_id();
    }
}
