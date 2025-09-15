<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form;

use DropshippingXmlFreeVendor\WPDesk\Forms\Form\FormWithFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Form\Abstraction\FormIdentity;
/**
 * Class ImportCsvSelectorForm, import csv selector form.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form
 */
class ImportCsvSelectorForm extends FormWithFields implements FormIdentity
{
    const ID = 'item_selector_csv';
    public function __construct(Fields\ImportCsvSelectorFormFields $fields)
    {
        parent::__construct($fields->get_fields(), self::ID);
    }
    public static function get_id(): string
    {
        return self::ID;
    }
}
