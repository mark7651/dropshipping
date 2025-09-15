<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\ConditionalLogicComponent;
/**
 * class NotEmptyConditionalLogic
 *
 * @package WPDesk\Library\DropshippingXmlCore\ConditionalLogic
 */
class NotEmptyConditionalLogic extends EmptyConditionalLogic
{
    public function is_valid(): bool
    {
        return !parent::is_valid();
    }
    public static function get_name(): string
    {
        return ConditionalLogicComponent::FIELD_VALUE_TYPE_OPTION_NOT_EMPTY;
    }
}
