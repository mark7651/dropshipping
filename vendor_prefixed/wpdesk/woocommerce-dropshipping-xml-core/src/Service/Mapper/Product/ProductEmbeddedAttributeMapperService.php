<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Mapper\Product;

use DropshippingXmlFreeVendor\WPDesk\Forms\Field\CheckboxField;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportMapperFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\VariationComponent;
use WC_Product_Variable;
use WC_Product_Variation;
use WC_Product;
/**
 * Class ProductEmbeddedAttributeMapperService, creates attributes for embedded variations.
 */
class ProductEmbeddedAttributeMapperService extends ProductAttributeMapperService
{
    protected function get_attribute_name(): string
    {
        return VariationComponent::PRODUCT_ATTRIBUTE_NAME;
    }
    protected function get_attribute_value(): string
    {
        return VariationComponent::PRODUCT_ATTRIBUTE_VALUE;
    }
    protected function get_attributes_from_field(): array
    {
        return $this->mapper->get_raw_value(VariationComponent::PRODUCT_ATTRIBUTE, ImportMapperFormFields::VARIATION_EMBEDDED);
    }
    protected function is_attribute_taxonomy(): bool
    {
        return CheckboxField::VALUE_TRUE === $this->mapper->get_raw_value(VariationComponent::PRODUCT_ATTRIBUTE_AS_TAXONOMY, ImportMapperFormFields::VARIATION_EMBEDDED);
    }
    protected function get_line_attributes_from_field(): string
    {
        return $this->mapper->map(VariationComponent::PRODUCT_ATTRIBUTE_LINE, ImportMapperFormFields::VARIATION_EMBEDDED) ?? '';
    }
    protected function get_line_attributes_separator_from_field(): string
    {
        return $this->mapper->get_raw_value(VariationComponent::PRODUCT_ATTRIBUTE_LINE_SEPARATOR, ImportMapperFormFields::VARIATION_EMBEDDED) ?? ',';
    }
    protected function get_line_attributes_value_separator_from_field(): string
    {
        return $this->mapper->get_raw_value(VariationComponent::PRODUCT_ATTRIBUTE_LINE_VALUE_SEPARATOR, ImportMapperFormFields::VARIATION_EMBEDDED) ?? ':';
    }
}
