<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form;

use DropshippingXmlFreeVendor\WPDesk\Forms\Form\FormWithFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Form\Abstraction\FormIdentity;
/**
 * Class ImportManagerForm, import manager form.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form
 */
class ImportManagerForm extends FormWithFields implements FormIdentity
{
    const ID = 'import_manager';
    public function __construct(Fields\ImportManagerFormFields $fields)
    {
        parent::__construct($fields->get_fields(), self::ID);
    }
    public static function get_id(): string
    {
        return self::ID;
    }
}
