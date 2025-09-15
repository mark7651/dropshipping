<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component;

use DropshippingXmlFreeVendor\WPDesk\Forms\Field\SelectField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\InputTextField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\CheckboxField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\TextAreaField;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportMapperFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration\FlexibleEanIntegration;
/**
 * Class VariationsComponent, attributes form fields component.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form\Fields\Component
 */
class VariationComponent extends \DropshippingXmlFreeVendor\WPDesk\Forms\Field\BasicField
{
    public const DEFAULT_DIMENSION_SIZE = 6;
    public const PRODUCT_VARIATION_XPATH = 'variation_xpath';
    public const PRODUCT_VIRTUAL = 'variation_virtual';
    public const PRODUCT_VIRTUAL_ID = 'variation_virtual';
    public const PRODUCT_CREATE_AS_SIMPLE = 'variation_create_as_simple';
    public const PRODUCT_CREATE_AS_SIMPLE_ID = 'variation_create_as_simple';
    public const PRODUCT_FIRST_VARIATION_AS_DEFAULT = 'variation_first_as_default';
    public const PRODUCT_FIRST_VARIATION_AS_DEFAULT_ID = 'variation_first_as_default';
    public const PRODUCT_IMAGES = 'variation_images';
    public const PRODUCT_IMAGES_ID = 'variation_images';
    public const PRODUCT_IMAGES_SCAN = 'variation_image_scan';
    public const PRODUCT_CUSTOM_ID = 'variation_custom_id';
    public const PRODUCT_SKU = 'variation_SKU';
    public const PRODUCT_EAN = 'variation_EAN';
    public const PRODUCT_PRICE = 'variation_price';
    public const PRODUCT_PRICE_MODIFICATOR = 'variation_price_mod';
    public const PRODUCT_PRICE_MODIFICATOR_OPTION_FIXED = 'fixed';
    public const PRODUCT_PRICE_MODIFICATOR_OPTION_PERCENT = 'percent';
    public const PRODUCT_PRICE_MODIFICATOR_VALUE = 'variation_price_mod_value';
    public const PRODUCT_SALE_PRICE = 'variation_sale_price';
    public const PRODUCT_WEIGHT = 'variation_weight';
    public const PRODUCT_WEIGHT_ID = 'variation_weight';
    public const PRODUCT_LENGTH = 'variation_product_length';
    public const PRODUCT_WIDTH = 'variation_product_width';
    public const PRODUCT_HEIGHT = 'variation_product_height';
    public const PRODUCT_MANAGE_STOCK = 'variation_manage_stock';
    public const PRODUCT_MANAGE_STOCK_ID = 'variation_manage_stock';
    public const PRODUCT_STOCK = 'variation_stock';
    public const PRODUCT_STOCK_ID = 'variation_stock';
    public const PRODUCT_BACKORDERS = 'variation_backorders';
    public const PRODUCT_BACKORDERS_ID = 'variation_backorders';
    public const PRODUCT_STOCK_STATUS = 'variation_stock_status';
    public const PRODUCT_STOCK_STATUS_ID = 'variation_stock_status';
    public const PRODUCT_TAX_STATUS = 'variation_tax_status';
    public const PRODUCT_TAX_STATUS_OPTION_TAXABLE = 'taxable';
    public const PRODUCT_TAX_STATUS_OPTION_SHIPPING = 'shipping';
    public const PRODUCT_TAX_STATUS_OPTION_NONE = 'none';
    public const PRODUCT_SHIPPING_CLASS = 'variation_product_shipping_class';
    public const PRODUCT_DESCRIPTION = 'variation_description';
    public const PRODUCT_ATTRIBUTE_LINE = 'variation_attribute_line';
    public const PRODUCT_ATTRIBUTE_LINE_SEPARATOR = 'variation_attribute_line_separator';
    public const PRODUCT_ATTRIBUTE_LINE_VALUE_SEPARATOR = 'variation_attribute_line_value_separator';
    public const PRODUCT_ATTRIBUTE = 'variation_attribute';
    public const PRODUCT_ATTRIBUTE_NAME = 'attribute_name';
    public const PRODUCT_ATTRIBUTE_VALUE = 'attribute_value';
    public const PRODUCT_ATTRIBUTE_AS_TAXONOMY = 'attribute_as_taxonomy';
    public const PRODUCT_PARENT_SELECTOR = 'variation_parent_selector';
    public const PRODUCT_PARENT_SELECTOR_ID = 'variation_parent_selector';
    public const PRODUCT_PARENT_OPTIONS = 'variation_parent_options';
    public const PRODUCT_PARENT_OPTIONS_REGULAR_PRICE_VALUE = 'regular_price';
    public const PRODUCT_PARENT_OPTIONS_SALE_PRICE_VALUE = 'sale_price';
    public const PRODUCT_PARENT_OPTIONS_WEIGHT_VALUE = 'weight';
    public const PRODUCT_PARENT_OPTIONS_DIMENSIONS_VALUE = 'dimensions';
    public const PRODUCT_PARENT_OPTIONS_STOCK_VALUE = 'stock';
    public const PRODUCT_PARENT_OPTIONS_SHIPPING_VALUE = 'shipping';
    public const PRODUCT_TAX_CLASS = 'variation_tax_class';
    public const PRODUCT_TAX_CLASS_XPATH_SWITCHER = 'variation_tax_class_xpath_switcher';
    public const PRODUCT_TAX_CLASS_ID_SINGLE = 'variation_product_tax_class_single';
    public const PRODUCT_TAX_CLASS_ID_MAPPED = 'variation_product_tax_class_mapped';
    public const PRODUCT_TAX_CLASS_MAPPER_FIELD = 'variation_tax_class_mapper_field';
    public const PRODUCT_TAX_CLASS_MULTI_MAP = 'variation_tax_class_map';
    public const PRODUCT_TAX_CLASS_MULTI_MAP_ID = 'variation_tax_class_map_id';
    public const PRODUCT_TAX_CLASS_MULTI_MAP_VALUE = 'variation_tax_class_map_value';
    public function __construct()
    {
        parent::__construct();
        $this->attributes['multiple'] = \true;
    }
    public function get_items(): array
    {
        if (!isset($this->meta['items'])) {
            $this->meta['items'] = [(new InputTextField())->set_name(self::PRODUCT_VARIATION_XPATH)->set_attribute('id', self::PRODUCT_VARIATION_XPATH)->add_class('width-100')->set_placeholder(__('Drag and drop tags containing xpath to first variation.', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_VIRTUAL)->set_label(__('Virtual', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_VIRTUAL_ID), (new CheckboxField())->set_name(self::PRODUCT_CREATE_AS_SIMPLE)->set_label(__('Create products without variants as simple products', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_CREATE_AS_SIMPLE_ID), (new CheckboxField())->set_name(self::PRODUCT_FIRST_VARIATION_AS_DEFAULT)->set_label(__('First variation as default value in the product dropdown', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_FIRST_VARIATION_AS_DEFAULT_ID), (new CheckboxField())->set_name(self::PRODUCT_PARENT_SELECTOR)->set_label(__('Get the values from the main products settings for the fields', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_PARENT_SELECTOR_ID), (new SelectField())->set_name(self::PRODUCT_PARENT_OPTIONS)->add_class('dropshipping-select2 width-100')->set_multiple()->set_attribute('id', self::PRODUCT_PARENT_OPTIONS)->set_options([
                self::PRODUCT_PARENT_OPTIONS_DIMENSIONS_VALUE => __('Dimensions', 'dropshipping-xml-for-woocommerce'),
                // self::PRODUCT_PARENT_OPTIONS_REGULAR_PRICE_VALUE => __( 'Regular price', 'dropshipping-xml-for-woocommerce' ),
                // self::PRODUCT_PARENT_OPTIONS_SALE_PRICE_VALUE => __( 'Sale price', 'dropshipping-xml-for-woocommerce' ),
                self::PRODUCT_PARENT_OPTIONS_STOCK_VALUE => __('Stock', 'dropshipping-xml-for-woocommerce'),
                self::PRODUCT_PARENT_OPTIONS_WEIGHT_VALUE => __('Weight', 'dropshipping-xml-for-woocommerce'),
                self::PRODUCT_PARENT_OPTIONS_SHIPPING_VALUE => __('Shipping', 'dropshipping-xml-for-woocommerce'),
            ]), (new InputTextField())->set_name(self::PRODUCT_IMAGES)->set_attribute('id', self::PRODUCT_IMAGES_ID)->add_class('width-100')->set_placeholder(__('Drag and drop tags containing image URLs to this field.', 'dropshipping-xml-for-woocommerce'))->set_label(__('Image URL', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_CUSTOM_ID)->set_description(esc_html__('Unique custom product ID', 'dropshipping-xml-for-woocommerce'))->set_placeholder(esc_html__('Drag and drop fields here to generate custom product ID', 'dropshipping-xml-for-woocommerce'))->add_class('width-100')->set_label(esc_html__('Custom product ID', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_SKU)->set_label(__('SKU', 'dropshipping-xml-for-woocommerce'))->add_class('width-100'), (new InputTextField())->set_name(self::PRODUCT_PRICE)->set_placeholder(sprintf(__('Price (%s)', 'dropshipping-xml-for-woocommerce'), get_woocommerce_currency_symbol()))->add_class('width-100')->set_label(sprintf(__('Price (%s)', 'dropshipping-xml-for-woocommerce'), get_woocommerce_currency_symbol())), (new InputTextField())->set_name(self::PRODUCT_SALE_PRICE)->add_class('width-100')->set_label(sprintf(__('Sale price (%s)', 'dropshipping-xml-for-woocommerce'), get_woocommerce_currency_symbol())), (new InputTextField())->set_name(self::PRODUCT_WEIGHT)->add_class('width-100')->set_label(sprintf(__('Weight (%s)', 'dropshipping-xml-for-woocommerce'), get_option('woocommerce_weight_unit')))->set_placeholder(0)->set_attribute('id', self::PRODUCT_WEIGHT_ID), (new InputTextField())->set_name(self::PRODUCT_LENGTH)->add_class('input-text wc_input_decimal width-100')->set_label(sprintf(__('Dimensions (%s)', 'dropshipping-xml-for-woocommerce'), get_option('woocommerce_dimension_unit')))->set_placeholder(__('Length', 'dropshipping-xml-for-woocommerce'))->set_attribute('size', self::DEFAULT_DIMENSION_SIZE), (new InputTextField())->set_name(self::PRODUCT_WIDTH)->add_class('input-text wc_input_decimal width-100')->set_placeholder(__('Width', 'dropshipping-xml-for-woocommerce'))->set_attribute('size', self::DEFAULT_DIMENSION_SIZE), (new InputTextField())->set_name(self::PRODUCT_HEIGHT)->add_class('input-text wc_input_decimal last width-100')->set_placeholder(__('Height', 'dropshipping-xml-for-woocommerce'))->set_attribute('size', self::DEFAULT_DIMENSION_SIZE), (new CheckboxField())->set_name(self::PRODUCT_MANAGE_STOCK)->set_label(__('Manage stock?', 'dropshipping-xml-for-woocommerce'))->set_description(__('Enable stock management at product level', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_MANAGE_STOCK_ID), (new InputTextField())->add_class('input-text regular-input padding-xs width-100')->set_name(self::PRODUCT_STOCK)->set_label(__('Stock quantity', 'dropshipping-xml-for-woocommerce'))->set_default_value(0)->set_attribute('id', self::PRODUCT_STOCK_ID), (new SelectField())->set_label(__('Allow backorders?', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_BACKORDERS)->add_class('select short width-100')->set_attribute('id', self::PRODUCT_BACKORDERS_ID)->set_options(wc_get_product_backorder_options()), (new SelectField())->set_label(__('Availability', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_STOCK_STATUS)->add_class('select width-100')->set_attribute('id', self::PRODUCT_STOCK_STATUS_ID)->set_options(wc_get_product_stock_status_options()), (new SelectField())->set_label(__('Shipping class', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_SHIPPING_CLASS)->add_class('select width-100')->set_options(ImportMapperFormFields::get_shipping_classes()), (new SelectField())->set_label(__('Tax status', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_STATUS)->add_class('select width-100')->set_options([self::PRODUCT_TAX_STATUS_OPTION_TAXABLE => __('Taxable', 'dropshipping-xml-for-woocommerce'), self::PRODUCT_TAX_STATUS_OPTION_SHIPPING => __('Shipping only', 'dropshipping-xml-for-woocommerce'), self::PRODUCT_TAX_STATUS_OPTION_NONE => __('None', 'dropshipping-xml-for-woocommerce')]), (new SelectField())->set_label(__('Tax class', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_CLASS)->add_class('select width-100')->set_options(wc_get_product_tax_class_options()), (new CheckboxField())->set_name(self::PRODUCT_TAX_CLASS_XPATH_SWITCHER)->set_label(__('Set the tax class from xpath', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_TAX_CLASS_XPATH_SWITCHER), (new InputTextField())->set_name(self::PRODUCT_TAX_CLASS_MAPPER_FIELD)->set_label(__('Tax class field', 'dropshipping-xml-for-woocommerce'))->set_attribute('style', 'width:100%!important')->add_class('width-100')->set_placeholder(__('Drag & drop columns from right side here', 'dropshipping-xml-for-woocommerce')), (new MappedTaxClassComponent())->set_label(__('Tax class mapper fields', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_CLASS_MULTI_MAP)->set_items([(new SelectField())->set_label(__('Select tax class', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_CLASS_MULTI_MAP_ID)->add_class('select short hs-beacon-search')->set_attribute('type', 'select')->set_options(wc_get_product_tax_class_options()), (new InputTextField())->set_name(self::PRODUCT_TAX_CLASS_MULTI_MAP_VALUE)->add_class('hs-beacon-search')->set_placeholder(__('External tax class', 'dropshipping-xml-for-woocommerce'))]), (new TextAreaField())->set_label(__('Product description', 'dropshipping-xml-for-woocommerce'))->set_attribute('rows', 8)->set_attribute('id', self::PRODUCT_DESCRIPTION)->add_class('width-100')->set_placeholder(__('Product description.', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_DESCRIPTION), (new AttributesComponent())->set_label(__('Attributes', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE)->set_items([(new InputTextField())->set_name(self::PRODUCT_ATTRIBUTE_NAME)->add_class('hs-beacon-search')->set_placeholder(__('Name', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_ATTRIBUTE_VALUE)->add_class('hs-beacon-search')->set_placeholder(__('Value', 'dropshipping-xml-for-woocommerce'))]), (new InputTextField())->set_label(__('Single line attributes', 'dropshipping-xml-for-woocommerce'))->set_placeholder(__('XPath to single line attributes', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE_LINE)->add_class('width-100'), (new InputTextField())->set_label(__('Attribute separator', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE_LINE_SEPARATOR)->add_class('width-100')->set_default_value(','), (new InputTextField())->set_label(__('Value separator', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE_LINE_VALUE_SEPARATOR)->add_class('width-100')->set_default_value(':'), (new CheckboxField())->set_name(self::PRODUCT_ATTRIBUTE_AS_TAXONOMY)->set_label(__('Add attributes as taxonomy', 'dropshipping-xml-for-woocommerce'))];
            if (FlexibleEanIntegration::is_active()) {
                $this->meta['items'][] = (new InputTextField())->set_name(self::PRODUCT_EAN)->set_label(__('EAN', 'dropshipping-xml-for-woocommerce'))->add_class('width-100');
            }
        }
        return $this->meta['items'];
    }
    public function get_template_name(): string
    {
        return 'variation-component';
    }
}
