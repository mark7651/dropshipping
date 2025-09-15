<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form;

use DropshippingXmlFreeVendor\WPDesk\Forms\Form\FormWithFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Form\Abstraction\FormIdentity;
/**
 * Class ImportFileForm, import file form.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form
 */
class ImportFileForm extends FormWithFields implements FormIdentity
{
    const ID = 'connector';
    public function __construct(Fields\ImportFileFormFields $fields)
    {
        parent::__construct($fields->get_fields(), self::ID);
    }
    public static function get_id(): string
    {
        return self::ID;
    }
}
