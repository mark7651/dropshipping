<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields;

use DropshippingXmlFreeVendor\WPDesk\Forms\Field\CheckboxField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\HiddenField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\InputTextField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\NoOnceField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\RadioField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\SubmitField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\TextAreaField;
use DropshippingXmlFreeVendor\WPDesk\Forms\FieldProvider;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\WyswigField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\SelectField;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\AttributesComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\MappedCategoriesComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\MappedTaxClassComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\VariationComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\PriceModificatorComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\GPSRComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration\FlexibleEanIntegration;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration\GPSRIntegration;
/**
 * Class ImportMapperFormFields, import mapper form fields.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form\Fields
 */
class ImportMapperFormFields implements FieldProvider
{
    const DEFAULT_DIMENSION_SIZE = 6;
    const NONE_SHIPPING_CLASS_VALUE = 'none';
    const TITLE = 'title';
    const EXCERPT = 'excerpt';
    const EXCERPT_ID = 'excerpt';
    const EXCERPT_EDITOR_CLASS = 'dropshipping-plugin-editor-excerpt';
    const EXCERPT_ROWS = 10;
    const CONTENT_EDITOR_CLASS = 'dropshipping-plugin-editor';
    const CONTENT_ROWS = 10;
    const CONTENT = 'content';
    const CONTENT_ID = 'content';
    const PRODUCT_TYPE = 'product_type';
    const PRODUCT_TYPE_ID = 'product-type';
    const PRODUCT_TYPE_OPTION_SIMPLE = 'simple';
    const PRODUCT_TYPE_OPTION_EXTERNAL = 'external';
    const PRODUCT_TYPE_OPTION_VARIABLE = 'variable';
    const PRODUCT_VIRTUAL = 'virtual';
    const PRODUCT_VIRTUAL_ID = '_virtual';
    const PRODUCT_EXTERNAL_URL = 'external_url';
    const PRODUCT_EXTERNAL_BUTTON_TEXT = 'button_text';
    const PRODUCT_PRICE = 'price';
    const PRODUCT_PRICE_MODIFICATOR = 'price_mod';
    const PRODUCT_PRICE_MODIFICATOR_OPTION_FIXED = 'fixed';
    const PRODUCT_PRICE_MODIFICATOR_OPTION_PERCENT = 'percent';
    const PRODUCT_PRICE_MODIFICATOR_VALUE = 'price_mod_value';
    const PRODUCT_PRICE_MODIFICATOR_CONDITIONS = 'price_mod_conditions';
    const PRODUCT_SALE_PRICE = 'sale_price';
    const PRODUCT_TAX_STATUS = 'tax_status';
    const PRODUCT_TAX_STATUS_OPTION_TAXABLE = 'taxable';
    const PRODUCT_TAX_STATUS_OPTION_SHIPPING = 'shipping';
    const PRODUCT_TAX_STATUS_OPTION_NONE = 'none';
    const PRODUCT_TAX_CLASS = 'tax_class';
    const PRODUCT_TAX_CLASS_TYPE = 'tax_class_type';
    const PRODUCT_TAX_CLASS_VALUE_SINGLE = 'single';
    const PRODUCT_TAX_CLASS_VALUE_MAPPED = 'mapped';
    const PRODUCT_TAX_CLASS_ID_SINGLE = 'product_tax_class_single';
    const PRODUCT_TAX_CLASS_ID_MAPPED = 'product_tax_class_mapped';
    const PRODUCT_TAX_CLASS_MAPPER_FIELD = 'tax_class_mapper_field';
    const PRODUCT_TAX_CLASS_MULTI_MAP = 'tax_class_map';
    const PRODUCT_TAX_CLASS_MULTI_MAP_ID = 'tax_class_map_id';
    const PRODUCT_TAX_CLASS_MULTI_MAP_VALUE = 'tax_class_map_value';
    const PRODUCT_CUSTOM_ID = 'custom_id';
    const PRODUCT_SKU = 'SKU';
    const PRODUCT_EAN = 'ean';
    const PRODUCT_MANAGE_STOCK = 'manage_stock';
    const PRODUCT_MANAGE_STOCK_ID = '_manage_stock';
    const PRODUCT_STOCK = 'stock';
    const PRODUCT_STOCK_ID = '_stock';
    const PRODUCT_BACKORDERS = 'backorders';
    const PRODUCT_BACKORDERS_ID = '_backorders';
    const PRODUCT_LOW_STOCK = 'low_stock_amount';
    const PRODUCT_LOW_STOCK_ID = '_low_stock_amount';
    const PRODUCT_STOCK_STATUS = 'stock_status';
    const PRODUCT_STOCK_STATUS_ID = '_stock_status';
    const PRODUCT_SOLD_INDIVIDUALLY = 'sold_individually';
    const PRODUCT_SOLD_INDIVIDUALLY_ID = '_sold_individually';
    const PRODUCT_WEIGHT = 'weight';
    const PRODUCT_WEIGHT_ID = '_weight';
    const PRODUCT_LENGTH = 'product_length';
    const PRODUCT_WIDTH = 'product_width';
    const PRODUCT_HEIGHT = 'product_height';
    const PRODUCT_SHIPPING_CLASS_SYNC_DISABLED = 'product_shipping_class_sync';
    const PRODUCT_SHIPPING_CLASS = 'product_shipping_class';
    const PRODUCT_ATTRIBUTE_SYNC_DISABLED = 'attribute_sync_disabled';
    const PRODUCT_ATTRIBUTE_AS_TAXONOMY = 'attribute_as_taxonomy';
    const PRODUCT_ATTRIBUTE_LINE = 'attribute_line';
    const PRODUCT_ATTRIBUTE_LINE_SEPARATOR = 'attribute_line_separator';
    const PRODUCT_ATTRIBUTE_LINE_VALUE_SEPARATOR = 'attribute_line_value_separator';
    const PRODUCT_ATTRIBUTE = 'attribute';
    const PRODUCT_ATTRIBUTE_NAME = 'attribute_name';
    const PRODUCT_ATTRIBUTE_VALUE = 'attribute_value';
    const PRODUCT_TAGS_SEPARATOR = 'tags_separator';
    const PRODUCT_TAGS = 'product-tags';
    const PRODUCT_IMAGES = 'images';
    const PRODUCT_IMAGES_ID = 'product-images';
    const PRODUCT_IMAGES_SEPARATOR = 'images_separator';
    const PRODUCT_IMAGES_SCAN = 'images_scan';
    const PRODUCT_IMAGES_FEATURED_NOT_IN_GALLERY = 'images_featured_not_in_gallery';
    const PRODUCT_IMAGES_APPEND_TO_EXISTING = 'images_append_to_existing';
    const PRODUCT_CATEGORIES_SYNC_DISABLED = 'product_categories_sync_disabled';
    const PRODUCT_CATEGORIES = 'product_categories';
    const PRODUCT_CATEGORIES_SINGLE_ID = 'product_categories_single_id';
    const PRODUCT_CATEGORIES_MULTI_ID = 'product_categories_multi_map_id';
    const PRODUCT_CATEGORIES_TREE_ID = 'product_categories_tree_id';
    const PRODUCT_CATEGORIES_SINGLE_VALUE = 'single';
    const PRODUCT_CATEGORIES_MULTI_VALUE = 'map';
    const PRODUCT_CATEGORIES_SINGLE_CATEGORY = 'category_single_id';
    const PRODUCT_CATEGORIES_MULTI_FIELD = 'category_field';
    const PRODUCT_CATEGORIES_MULTI_MAP_IMPORT = 'category_map_import';
    const PRODUCT_CATEGORIES_MULTI_MAP_IMPORT_ID = 'category_map_import_id';
    const PRODUCT_CATEGORIES_MULTI_MAP_IMPORT_AUTO_CREATE = 'category_map_import_auto_create';
    const PRODUCT_CATEGORIES_MULTI_MAP = 'category_map';
    const PRODUCT_CATEGORIES_MULTI_MAP_CATEGORY = 'category_map_id';
    const PRODUCT_CATEGORIES_MULTI_MAP_VALUE = 'category_map_value';
    const PRODUCT_CATEGORIES_TREE_VALUE = 'tree';
    const PRODUCT_CATEGORIES_TREE_FIELD_VALUE = 'category_tree_field';
    const PRODUCT_CATEGORIES_TREE_SEPARATOR_VALUE = 'category_tree_separator';
    const PRODUCT_CATEGORIES_TREE_ADD_ALL_VALUE = 'category_tree_add_all';
    const NODE_ELEMENT = 'node_element';
    const NODE_ELEMENT_ID = 'dropshipping-node-element';
    const NONCE_ACTION = 'product_mapper_action';
    const NONCE_NAME = 'product_mapper_nonce';
    const SUBMIT_NEXT_STEP = 'next_step';
    const VARIATION_TYPE = 'variation_type';
    const VARIATION_TYPE_SKU_VALUE = 'sku';
    const VARIATION_TYPE_EAN_VALUE = 'ean';
    const VARIATION_TYPE_TITLE_VALUE = 'title';
    const VARIATION_TYPE_CUSTOM_VALUE = 'custom';
    const VARIATION_TYPE_GROUP_VALUE = 'group';
    const VARIATION_TYPE_EMBEDDED_VALUE = 'embedded';
    const VARIATION_TYPE_SKU_ID = 'variation_type_sku';
    const VARIATION_TYPE_EAN_ID = 'variation_type_ean';
    const VARIATION_TYPE_TITLE_ID = 'variation_type_title';
    const VARIATION_TYPE_CUSTOM_ID = 'variation_type_custom';
    const VARIATION_TYPE_GROUP_ID = 'variation_type_group';
    const VARIATION_TYPE_EMBEDDED_ID = 'variation_type_embedded';
    const VARIATION_TYPE_SKU_PARENT_XPATH = 'variation_sku_parent_xpath';
    const VARIATION_TYPE_TITLE_PARENT_EXISTS = 'variation_title_parent_exists';
    const VARIATION_JOIN_CUSTOM_XPATH = 'variation_custom_xpath';
    const VARIATION_JOIN_CUSTOM_PARENT_XPATH = 'variation_custom_parent_xpath';
    const VARIATION_TYPE_GROUP_XPATH = 'variation_group_xpath';
    const VARIATION_TYPE_GROUP_PARENT_EXISTS = 'variation_group_parent_exists';
    const VARIATION_EMBEDDED = 'variation_embedded';
    const GPSR_FIELDS = 'gpsr_fields';
    /**
     * @see FieldProvider::get_fields()
     */
    public function get_fields()
    {
        $result = [(new RadioField())->set_name(self::VARIATION_TYPE)->set_default_value(self::VARIATION_TYPE_TITLE_VALUE)->set_attribute('type', 'radio')->set_attribute('id', self::VARIATION_TYPE_TITLE_ID)->add_class('mapper-type-selector')->set_label(esc_html__('Variable products have the same name.', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::VARIATION_TYPE_TITLE_PARENT_EXISTS)->add_class('mapper-has-parent-selector')->set_label(esc_html__('Check if variable products have a parent product in the file structure.', 'dropshipping-xml-for-woocommerce')), (new RadioField())->set_name(self::VARIATION_TYPE)->set_default_value(self::VARIATION_TYPE_SKU_VALUE)->set_attribute('type', 'radio')->set_attribute('id', self::VARIATION_TYPE_SKU_ID)->add_class('mapper-type-selector')->set_label(esc_html__('Variable products uses SKU number of the main product.', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::VARIATION_TYPE_SKU_PARENT_XPATH)->add_class('width-100')->set_placeholder(esc_attr__('XPath to the parent SKU', 'dropshipping-xml-for-woocommerce')), (new RadioField())->set_name(self::VARIATION_TYPE)->set_default_value(self::VARIATION_TYPE_CUSTOM_VALUE)->set_attribute('type', 'radio')->set_attribute('id', self::VARIATION_TYPE_CUSTOM_ID)->add_class('mapper-type-selector')->set_label(esc_html__('Variable products and the main product have different identifiers.', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::VARIATION_JOIN_CUSTOM_XPATH)->add_class('width-100')->set_placeholder(esc_attr__('XPath to the variation identifier', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::VARIATION_JOIN_CUSTOM_PARENT_XPATH)->add_class('width-100')->set_placeholder(esc_attr__('XPath to the parent product identifier', 'dropshipping-xml-for-woocommerce')), (new RadioField())->set_name(self::VARIATION_TYPE)->set_default_value(self::VARIATION_TYPE_GROUP_VALUE)->set_attribute('type', 'radio')->set_attribute('id', self::VARIATION_TYPE_GROUP_ID)->add_class('mapper-type-selector')->set_label(esc_html__('Variable products have the same identifier.', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::VARIATION_TYPE_GROUP_XPATH)->add_class('width-100')->set_placeholder(esc_attr__('XPath to the grouped field', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::VARIATION_TYPE_GROUP_PARENT_EXISTS)->add_class('mapper-has-parent-selector')->set_label(esc_html__('Check if variable products have a parent product in the file structure.', 'dropshipping-xml-for-woocommerce')), (new RadioField())->set_name(self::VARIATION_TYPE)->set_default_value(self::VARIATION_TYPE_EMBEDDED_VALUE)->set_attribute('type', 'radio')->set_attribute('id', self::VARIATION_TYPE_EMBEDDED_ID)->add_class('mapper-type-selector')->set_label(esc_html__('Variable products are embedded as child tags in XML.', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_ATTRIBUTE_AS_TAXONOMY)->set_label(esc_html__('Add attributes as taxonomy', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_label(esc_html__('Single line attributes', 'dropshipping-xml-for-woocommerce'))->set_placeholder(esc_attr__('XPath to single line attributes', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE_LINE)->add_class('width-100'), (new InputTextField())->set_label(esc_html__('Attribute separator', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE_LINE_SEPARATOR)->set_attribute('style', 'width:30px;')->set_default_value(','), (new InputTextField())->set_label(esc_html__('Value separator', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE_LINE_VALUE_SEPARATOR)->set_attribute('style', 'width:30px;')->set_default_value(':'), (new AttributesComponent())->set_label(esc_html__('Attributes', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_ATTRIBUTE)->set_items([(new InputTextField())->set_name(self::PRODUCT_ATTRIBUTE_NAME)->set_placeholder(esc_attr__('Name', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_ATTRIBUTE_VALUE)->set_placeholder(esc_attr__('Value', 'dropshipping-xml-for-woocommerce'))]), (new WyswigField())->set_label(esc_html__('Description', 'dropshipping-xml-for-woocommerce'))->set_name(self::CONTENT)->set_attribute('wpautop', \true)->set_attribute('media_buttons', \false)->set_attribute('editor_class', self::CONTENT_EDITOR_CLASS)->set_attribute('textarea_rows', self::CONTENT_ROWS)->set_attribute('id', self::CONTENT_ID), (new WyswigField())->set_label(esc_html__('Excerpt', 'dropshipping-xml-for-woocommerce'))->set_name(self::EXCERPT)->set_attribute('wpautop', \true)->set_attribute('media_buttons', \false)->set_attribute('editor_class', self::EXCERPT_EDITOR_CLASS)->set_attribute('textarea_rows', self::EXCERPT_ROWS)->set_attribute('id', self::EXCERPT_ID), (new InputTextField())->set_name(self::TITLE)->set_placeholder(esc_attr__('Drag and drop product title here', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_EXTERNAL_URL)->set_placeholder(esc_attr__('https://', 'dropshipping-xml-for-woocommerce'))->set_description(esc_html__('Enter the external URL to the product.', 'dropshipping-xml-for-woocommerce'))->set_label(esc_html__('Product URL', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_EXTERNAL_BUTTON_TEXT)->set_placeholder(esc_attr__('Buy product', 'dropshipping-xml-for-woocommerce'))->set_description(esc_html__('This text will be shown on the button linking to the external product.', 'dropshipping-xml-for-woocommerce'))->set_label(esc_html__('Button text', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_PRICE)->set_placeholder(sprintf(esc_attr__('Price (%s)', 'dropshipping-xml-for-woocommerce'), get_woocommerce_currency_symbol()))->set_label(sprintf(esc_html__('Price (%s)', 'dropshipping-xml-for-woocommerce'), get_woocommerce_currency_symbol())), (new InputTextField())->set_name(self::PRODUCT_SALE_PRICE)->set_label(sprintf(esc_html__('Sale price (%s)', 'dropshipping-xml-for-woocommerce'), get_woocommerce_currency_symbol())), (new PriceModificatorComponent())->set_name(self::PRODUCT_PRICE_MODIFICATOR_CONDITIONS), (new InputTextField())->set_name(self::PRODUCT_SKU)->set_label(esc_html__('SKU', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_SKU), (new InputTextField())->set_name(self::PRODUCT_CUSTOM_ID)->set_description(esc_html__('Unique custom product ID', 'dropshipping-xml-for-woocommerce'))->set_placeholder(esc_attr__('Drag and drop fields here to generate custom product ID', 'dropshipping-xml-for-woocommerce'))->set_label(esc_html__('Custom product ID', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_MANAGE_STOCK)->set_label(esc_html__('Manage stock?', 'dropshipping-xml-for-woocommerce'))->set_description(esc_html__('Enable stock management at product level', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_MANAGE_STOCK_ID), (new InputTextField())->add_class('input-text regular-input padding-xs')->set_name(self::PRODUCT_STOCK)->set_label(esc_html__('Stock quantity', 'dropshipping-xml-for-woocommerce'))->set_default_value(0)->set_attribute('id', self::PRODUCT_STOCK_ID), (new SelectField())->set_label(esc_html__('Allow backorders?', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_BACKORDERS)->add_class('select short')->set_attribute('id', self::PRODUCT_BACKORDERS_ID)->set_options(wc_get_product_backorder_options()), (new InputTextField())->add_class('input-text regular-input padding-xs')->set_name(self::PRODUCT_LOW_STOCK)->set_label(esc_html__('low stock threshold', 'dropshipping-xml-for-woocommerce'))->set_default_value(0)->set_attribute('id', self::PRODUCT_LOW_STOCK_ID), (new SelectField())->set_label(esc_html__('Availability', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_STOCK_STATUS)->add_class('select short')->set_attribute('id', self::PRODUCT_STOCK_STATUS_ID)->set_options(wc_get_product_stock_status_options()), (new CheckboxField())->set_name(self::PRODUCT_SOLD_INDIVIDUALLY)->set_label(esc_html__('Sold individually', 'dropshipping-xml-for-woocommerce'))->set_description(esc_html__('Enable this to only allow one of this item to be bought in a single order', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_SOLD_INDIVIDUALLY_ID), (new InputTextField())->set_name(self::PRODUCT_WEIGHT)->set_label(sprintf(esc_html__('Weight (%s)', 'dropshipping-xml-for-woocommerce'), get_option('woocommerce_weight_unit')))->set_placeholder(0)->set_attribute('id', self::PRODUCT_WEIGHT_ID), (new InputTextField())->set_name(self::PRODUCT_LENGTH)->add_class('input-text wc_input_decimal')->set_label(sprintf(esc_html__('Dimensions (%s)', 'dropshipping-xml-for-woocommerce'), get_option('woocommerce_dimension_unit')))->set_placeholder(esc_attr__('Length', 'dropshipping-xml-for-woocommerce'))->set_attribute('size', self::DEFAULT_DIMENSION_SIZE), (new InputTextField())->set_name(self::PRODUCT_WIDTH)->add_class('input-text wc_input_decimal')->set_label(sprintf(esc_html__('Width (%s)', 'dropshipping-xml-for-woocommerce'), get_option('woocommerce_dimension_unit')))->set_placeholder(esc_attr__('Width', 'dropshipping-xml-for-woocommerce'))->set_attribute('size', self::DEFAULT_DIMENSION_SIZE), (new InputTextField())->set_name(self::PRODUCT_HEIGHT)->add_class('input-text wc_input_decimal last')->set_label(sprintf(esc_html__('Height (%s)', 'dropshipping-xml-for-woocommerce'), get_option('woocommerce_dimension_unit')))->set_placeholder(esc_attr__('Height', 'dropshipping-xml-for-woocommerce'))->set_attribute('size', self::DEFAULT_DIMENSION_SIZE), (new SelectField())->set_label(esc_html__('Shipping class', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_SHIPPING_CLASS)->add_class('select short')->set_options(self::get_shipping_classes()), (new SelectField())->set_label(esc_html__('Tax status', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_STATUS)->add_class('select short')->set_options([self::PRODUCT_TAX_STATUS_OPTION_TAXABLE => esc_html__('Taxable', 'dropshipping-xml-for-woocommerce'), self::PRODUCT_TAX_STATUS_OPTION_SHIPPING => esc_html__('Shipping only', 'dropshipping-xml-for-woocommerce'), self::PRODUCT_TAX_STATUS_OPTION_NONE => esc_html__('None', 'dropshipping-xml-for-woocommerce')]), (new RadioField())->set_name(self::PRODUCT_TAX_CLASS_TYPE)->set_attribute('id', self::PRODUCT_TAX_CLASS_ID_SINGLE)->set_attribute('type', 'radio')->set_default_value(self::PRODUCT_TAX_CLASS_VALUE_SINGLE)->set_label(esc_html__('Set a single tax class to all imported products', 'dropshipping-xml-for-woocommerce')), (new RadioField())->set_name(self::PRODUCT_TAX_CLASS_TYPE)->set_attribute('id', self::PRODUCT_TAX_CLASS_ID_MAPPED)->set_attribute('type', 'radio')->set_default_value(self::PRODUCT_TAX_CLASS_VALUE_MAPPED)->set_label(esc_html__('Tax class mapper', 'dropshipping-xml-for-woocommerce')), (new SelectField())->set_label(esc_html__('Tax class', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_CLASS)->add_class('select short')->set_options(wc_get_product_tax_class_options()), (new InputTextField())->set_name(self::PRODUCT_TAX_CLASS_MAPPER_FIELD)->set_label(esc_html__('Tax class field', 'dropshipping-xml-for-woocommerce'))->set_attribute('style', 'width:100%!important')->set_placeholder(esc_attr__('Drag & drop columns from right side here', 'dropshipping-xml-for-woocommerce')), (new MappedTaxClassComponent())->set_label(esc_html__('Tax class mapper fields', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_CLASS_MULTI_MAP)->set_items([(new SelectField())->set_label(esc_html__('Select tax class', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAX_CLASS_MULTI_MAP_ID)->add_class('select short')->set_attribute('type', 'select')->set_options(wc_get_product_tax_class_options()), (new InputTextField())->set_name(self::PRODUCT_TAX_CLASS_MULTI_MAP_VALUE)->set_placeholder(esc_attr__('External tax class', 'dropshipping-xml-for-woocommerce'))]), (new SelectField())->set_name(self::PRODUCT_TYPE)->set_attribute('id', self::PRODUCT_TYPE_ID)->set_options([self::PRODUCT_TYPE_OPTION_SIMPLE => esc_attr__('Simple product', 'dropshipping-xml-for-woocommerce'), self::PRODUCT_TYPE_OPTION_VARIABLE => esc_attr__('Variable product', 'dropshipping-xml-for-woocommerce'), self::PRODUCT_TYPE_OPTION_EXTERNAL => esc_attr__('External/Affiliate product', 'dropshipping-xml-for-woocommerce')]), (new CheckboxField())->set_name(self::PRODUCT_VIRTUAL)->set_label(esc_html__('Sold individually', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_VIRTUAL_ID), (new HiddenField())->set_name(self::NODE_ELEMENT)->set_attribute('id', self::NODE_ELEMENT_ID), (new TextAreaField())->set_attribute('rows', 8)->set_attribute('id', self::PRODUCT_TAGS)->set_placeholder(esc_attr__('Drag and drop tags containing product tags to this field.', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_TAGS), (new InputTextField())->set_name(self::PRODUCT_TAGS_SEPARATOR)->set_attribute('style', 'width:30px;')->set_label(esc_html__('Tags separator', 'dropshipping-xml-for-woocommerce'))->set_default_value(','), (new TextAreaField())->set_attribute('rows', 8)->set_attribute('id', self::PRODUCT_IMAGES_ID)->set_placeholder(esc_attr__('Drag and drop tags containing image URLs to this field.', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_IMAGES), (new InputTextField())->set_name(self::PRODUCT_IMAGES_SEPARATOR)->set_attribute('style', 'width:30px;')->set_label(esc_html__('Images separator', 'dropshipping-xml-for-woocommerce'))->set_default_value(','), (new CheckboxField())->set_name(self::PRODUCT_IMAGES_SCAN)->set_label(esc_html__('Scan &lt;img&gt; tags and import images', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_IMAGES_FEATURED_NOT_IN_GALLERY)->set_label(esc_html__('Do not add Product Image to the Product Gallery', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_IMAGES_APPEND_TO_EXISTING)->set_label(esc_html__('Do not replace the existing images. Instead, append new photos to the product.', 'dropshipping-xml-for-woocommerce')), (new RadioField())->set_name(self::PRODUCT_CATEGORIES)->set_attribute('id', self::PRODUCT_CATEGORIES_SINGLE_ID)->set_attribute('type', 'radio')->set_default_value(self::PRODUCT_CATEGORIES_SINGLE_VALUE)->set_label(esc_html__('Set a single category to all imported products', 'dropshipping-xml-for-woocommerce')), (new SelectField())->set_label(esc_html__('Set default category', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_CATEGORIES_SINGLE_CATEGORY)->add_class('select short')->set_options($this->get_woocommerce_categories()), (new RadioField())->set_name(self::PRODUCT_CATEGORIES)->set_attribute('id', self::PRODUCT_CATEGORIES_MULTI_ID)->set_attribute('type', 'radio')->set_default_value(self::PRODUCT_CATEGORIES_MULTI_VALUE)->set_label(esc_html__('Map categories', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_CATEGORIES_MULTI_MAP_IMPORT)->set_attribute('id', self::PRODUCT_CATEGORIES_MULTI_MAP_IMPORT_ID)->set_label(esc_html__('Import only products from mapped categories', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_CATEGORIES_MULTI_MAP_IMPORT_AUTO_CREATE)->set_label(esc_html__('Create or select categories automatically', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_CATEGORIES_MULTI_FIELD)->set_label(esc_html__('Product category field', 'dropshipping-xml-for-woocommerce'))->set_attribute('style', 'width:100%')->set_placeholder(esc_attr__('Drag & drop columns from right side here', 'dropshipping-xml-for-woocommerce')), (new MappedCategoriesComponent())->set_label(esc_html__('Categories mapper', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_CATEGORIES_MULTI_MAP)->set_items([(new SelectField())->set_label(esc_html__('Select shop category', 'dropshipping-xml-for-woocommerce'))->set_name(self::PRODUCT_CATEGORIES_MULTI_MAP_CATEGORY)->add_class('select short')->set_attribute('type', 'select')->set_options($this->get_woocommerce_categories()), (new InputTextField())->set_name(self::PRODUCT_CATEGORIES_MULTI_MAP_VALUE)->set_placeholder(esc_attr__('External ID', 'dropshipping-xml-for-woocommerce'))]), (new RadioField())->set_name(self::PRODUCT_CATEGORIES)->set_attribute('id', self::PRODUCT_CATEGORIES_TREE_ID)->set_attribute('type', 'radio')->set_default_value(self::PRODUCT_CATEGORIES_TREE_VALUE)->set_label(esc_html__('Create category trees', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_CATEGORIES_TREE_FIELD_VALUE)->set_label(esc_html__('Product category field', 'dropshipping-xml-for-woocommerce'))->set_attribute('style', 'width:100%')->set_placeholder(esc_attr__('Drag & drop columns from right side here', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::PRODUCT_CATEGORIES_TREE_ADD_ALL_VALUE)->set_label(esc_html__('Add product to all subcategories?', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::PRODUCT_CATEGORIES_TREE_SEPARATOR_VALUE)->set_label(esc_html__('Category tree separator', 'dropshipping-xml-for-woocommerce'))->set_attribute('maxlength', '1')->set_attribute('style', 'width:60px')->set_default_value('>'), (new VariationComponent())->set_name(self::VARIATION_EMBEDDED), (new SubmitField())->set_name(self::SUBMIT_NEXT_STEP)->set_label(esc_html__('Go to the next step &rarr;', 'dropshipping-xml-for-woocommerce'))->add_class('button button-primary button-hero')->set_attribute('id', self::SUBMIT_NEXT_STEP), (new NoOnceField(self::NONCE_ACTION))->set_name(self::NONCE_NAME)];
        if (FlexibleEanIntegration::is_active()) {
            $result[] = (new InputTextField())->set_name(self::PRODUCT_EAN)->set_label(esc_html__('EAN', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::PRODUCT_EAN);
        }
        if (GPSRIntegration::is_active()) {
            $result[] = (new GPSRComponent())->set_name(self::GPSR_FIELDS);
        }
        return $result;
    }
    public static function get_shipping_classes(): array
    {
        $result = [self::NONE_SHIPPING_CLASS_VALUE => esc_html__('No shipping class', 'dropshipping-xml-for-woocommerce')];
        $shipping_classes = get_terms(['taxonomy' => 'product_shipping_class', 'hide_empty' => \false]);
        foreach ($shipping_classes as $term) {
            $result[$term->term_id] = $term->name;
        }
        return $result;
    }
    private function get_woocommerce_categories(): array
    {
        $result = [];
        $args = ['taxonomy' => 'product_cat', 'orderby' => 'name', 'show_count' => \false, 'pad_counts' => \false, 'hierarchical' => \true, 'title_li' => '', 'hide_empty' => \false];
        $all_categories = get_categories($args);
        if (is_array($all_categories)) {
            $tree = $this->build_tree($all_categories);
            ksort($tree);
            $result = $this->create_dropdown_array($tree);
        }
        return $result;
    }
    private function create_dropdown_array(array $branch, int $depth = 0): array
    {
        $result = [];
        foreach ($branch as $leaf) {
            $result[$leaf['id']] = str_repeat('-', $depth) . $leaf['name'];
            if (isset($leaf['children'])) {
                $result = $result + $this->create_dropdown_array($leaf['children'], $depth + 1);
            }
        }
        return $result;
    }
    private function build_tree(array &$all_categories, int $parent_id = 0): array
    {
        $branch = [];
        foreach ($all_categories as $key => $category) {
            if ($category->parent === $parent_id) {
                $children = $this->build_tree($all_categories, $category->term_id);
                $branch[$category->term_id]['id'] = $category->term_id;
                $branch[$category->term_id]['name'] = $category->name;
                if (!empty($children)) {
                    $branch[$category->term_id]['children'] = $children;
                }
                unset($all_categories[$key]);
            }
        }
        return $branch;
    }
}
