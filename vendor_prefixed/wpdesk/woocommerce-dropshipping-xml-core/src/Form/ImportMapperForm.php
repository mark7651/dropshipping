<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form;

use DropshippingXmlFreeVendor\WPDesk\Forms\Form\FormWithFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Form\Abstraction\FormIdentity;
/**
 * Class ImportMapperForm, import mapper form.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form
 */
class ImportMapperForm extends FormWithFields implements FormIdentity
{
    const ID = 'item_mapper';
    public function __construct(Fields\ImportMapperFormFields $fields)
    {
        parent::__construct($fields->get_fields(), self::ID);
    }
    public static function get_id(): string
    {
        return self::ID;
    }
}
