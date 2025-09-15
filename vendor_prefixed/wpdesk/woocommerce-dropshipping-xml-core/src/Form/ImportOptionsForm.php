<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form;

use DropshippingXmlFreeVendor\WPDesk\Forms\Form\FormWithFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Form\Abstraction\FormIdentity;
/**
 * Class ImportOptionsForm, import options form.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form
 */
class ImportOptionsForm extends FormWithFields implements FormIdentity
{
    const ID = 'item_options';
    public function __construct(Fields\ImportOptionsFormFields $fields)
    {
        parent::__construct($fields->get_fields(), self::ID);
    }
    public static function get_id(): string
    {
        return self::ID;
    }
}
