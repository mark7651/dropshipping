<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\Abstraction\ConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\Abstraction\ConditionalLogicWithCompareValue;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\ConditionalLogicComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Exception\ConditionalLogicNoValueException;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Exception\ConditionalLogicException;
use Exception;
/**
 * class LowerConditionalLogic
 *
 * @package WPDesk\Library\DropshippingXmlCore\ConditionalLogic
 */
class LowerConditionalLogic implements ConditionalLogicWithCompareValue
{
    const FILTER_NUMERIC_VALUE = 'wpdesk_dropshipping_logic_normalize_decimal_amount';
    /**
     *
     * @var string
     */
    private $xpath_value;
    /**
     *
     * @var string
     */
    private $compare_value;
    public function set_xpath_field_value(string $xpath_value)
    {
        $this->xpath_value = $xpath_value;
    }
    public function set_compare_value(string $compare_value)
    {
        $this->compare_value = $compare_value;
    }
    public function is_valid(): bool
    {
        try {
            if (!isset($this->xpath_value) || !isset($this->compare_value)) {
                throw new ConditionalLogicNoValueException('Missing required values');
            }
            $xpath_value = self::normalize_decimal_amount($this->xpath_value);
            $compare_value = self::normalize_decimal_amount($this->compare_value);
            if (!(\is_numeric($xpath_value) && \is_numeric($compare_value))) {
                return \false;
            }
            return \floatval($xpath_value) < \floatval($compare_value);
        } catch (Exception $e) {
            return \false;
        }
    }
    public function get_value_field(): string
    {
        return ConditionalLogicComponent::FIELD_LOWER_VALUE;
    }
    public static function get_name(): string
    {
        return ConditionalLogicComponent::FIELD_VALUE_TYPE_OPTION_LOWER;
    }
    public static function normalize_decimal_amount(string $val): string
    {
        $val = \apply_filters(self::FILTER_NUMERIC_VALUE, $val);
        $input = str_replace(' ', '', $val);
        $number = str_replace(',', '.', $input);
        if (is_numeric($number)) {
            if (strpos($number, '.')) {
                $groups = explode('.', str_replace(',', '.', $number));
                $last_group = array_pop($groups);
                $number = implode('', $groups) . '.' . $last_group;
            }
        } else {
            throw new ConditionalLogicException('Value is not numeric');
        }
        return \number_format(floatval($number), 2, '.', '');
    }
}
