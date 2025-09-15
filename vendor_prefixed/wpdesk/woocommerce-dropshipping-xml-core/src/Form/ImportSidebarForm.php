<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form;

use DropshippingXmlFreeVendor\WPDesk\Forms\Form\FormWithFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Form\Abstraction\FormIdentity;
/**
 * Class ImportSidebarForm, import options form.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form
 */
class ImportSidebarForm extends FormWithFields implements FormIdentity
{
    const ID = 'item_sidebar';
    public function __construct(Fields\ImportSidebarFormFields $fields)
    {
        parent::__construct($fields->get_fields(), self::ID);
    }
    public static function get_id(): string
    {
        return self::ID;
    }
}
