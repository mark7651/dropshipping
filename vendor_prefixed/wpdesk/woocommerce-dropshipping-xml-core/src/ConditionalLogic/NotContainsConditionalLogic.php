<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\Abstraction\ConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\ConditionalLogicComponent;
/**
 * class NotContainsConditionalLogic
 *
 * @package WPDesk\Library\DropshippingXmlCore\ConditionalLogic
 */
class NotContainsConditionalLogic extends ContainsConditionalLogic
{
    public function is_valid(): bool
    {
        return !parent::is_valid();
    }
    public function get_value_field(): string
    {
        return ConditionalLogicComponent::FIELD_NOT_CONTAINS_VALUE;
    }
    public static function get_name(): string
    {
        return ConditionalLogicComponent::FIELD_VALUE_TYPE_OPTION_NOT_CONTAINS;
    }
}
