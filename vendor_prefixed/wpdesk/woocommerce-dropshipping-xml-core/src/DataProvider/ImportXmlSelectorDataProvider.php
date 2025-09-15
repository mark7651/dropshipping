<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\ImportXmlSelectorForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Provider\Abstraction\DataProvider;
/**
 * Class ImportXmlSelectorDataProvider, import xml selector data provider.
 *
 * @package WPDesk\Library\DropshippingXmlCore\DataProvider
 */
class ImportXmlSelectorDataProvider extends DropshippingDataProvider
{
    /**
     * @see DataProvider::get_id()
     */
    public static function get_id(): string
    {
        return ImportXmlSelectorForm::get_id();
    }
    protected function get_identity(): string
    {
        return self::get_id();
    }
}
