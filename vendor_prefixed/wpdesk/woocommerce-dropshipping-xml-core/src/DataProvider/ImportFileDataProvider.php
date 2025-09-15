<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\ImportFileForm;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Provider\Abstraction\DataProvider;
/**
 * Class ImportFileDataProvider, import file data provider.
 *
 * @package WPDesk\Library\DropshippingXmlCore\DataProvider
 */
class ImportFileDataProvider extends DropshippingDataProvider
{
    /**
     * @see DataProvider::get_id()
     */
    public static function get_id(): string
    {
        return ImportFileForm::get_id();
    }
    protected function get_identity(): string
    {
        return self::get_id();
    }
}
