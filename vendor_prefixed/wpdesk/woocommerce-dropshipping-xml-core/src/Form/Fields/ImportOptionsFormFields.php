<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields;

use DropshippingXmlFreeVendor\WPDesk\Forms\Field\NoOnceField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\SelectField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\SubmitField;
use DropshippingXmlFreeVendor\WPDesk\Forms\FieldProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportOptionsDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory\DataProviderFactory;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DataProvider\ImportMapperDataProvider;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\CheckboxField;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\ConditionalLogicComponent;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\HiddenField;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration\FlexibleEanIntegration;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration\GPSRIntegration;
/**
 * Class ImportOptionsFormFields, import options form fields.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form\Fields
 */
class ImportOptionsFormFields implements FieldProvider
{
    public const UNIQUE_PRODUCT_ID = 'unique_product_id';
    public const UNIQUE_PRODUCT_SELECTOR = 'unique_product_selector';
    public const UNIQUE_PRODUCT_SELECTOR_SKU = 'sku';
    public const UNIQUE_PRODUCT_SELECTOR_EAN = 'ean';
    public const UNIQUE_PRODUCT_SELECTOR_NAME = 'name';
    public const UNIQUE_PRODUCT_SELECTOR_CUSTOM_PRODUCT_ID = 'custom_product_id';
    public const LOGICAL_CONDITIONS = 'logical_conditions';
    public const LOGICAL_CONDITIONS_ID = 'logical_conditions';
    public const SYNC_FIELD = 'sync_field';
    public const SYNC_FIELD_OPTION_TITLE = 'title';
    public const SYNC_FIELD_OPTION_DESCRIPTION = 'description';
    public const SYNC_FIELD_OPTION_SHORT_DESCRIPTION = 'short_description';
    public const SYNC_FIELD_OPTION_GENERAL_PRICE = 'general_price';
    public const SYNC_FIELD_OPTION_GENERAL_SALE_PRICE = 'general_sale_price';
    public const SYNC_FIELD_OPTION_GENERAL_TAX_STATUS = 'general_tax_status';
    public const SYNC_FIELD_OPTION_GENERAL_TAX_CLASS = 'general_tax_class';
    public const SYNC_FIELD_OPTION_GPSR = 'gpsr_fields';
    public const SYNC_FIELD_OPTION_EAN = 'ean_field';
    public const SYNC_FIELD_OPTION_STOCK_SKU = 'stock_sku';
    public const SYNC_FIELD_OPTION_STOCK_AVAILABILITY = 'stock_availability';
    public const SYNC_FIELD_OPTION_STOCK_MANAGMENT = 'stock_managment';
    public const SYNC_FIELD_OPTION_STOCK_QUANTITY = 'stock_quantity';
    public const SYNC_FIELD_OPTION_STOCK_ALLOW_BACKORDERS = 'stock_allow_backorders';
    public const SYNC_FIELD_OPTION_STOCK_LOW_AMOUNT = 'stock_low_amount';
    public const SYNC_FIELD_OPTION_STOCK_SOLD_INDIVIDUALLY = 'stock_sold_individually';
    public const SYNC_FIELD_OPTION_SHIPPING_WEIGHT = 'shipping_weight';
    public const SYNC_FIELD_OPTION_SHIPPING_DIMENSIONS = 'shipping_dimensions';
    public const SYNC_FIELD_OPTION_SHIPPING_CLASS = 'shipping_class';
    public const SYNC_FIELD_OPTION_ATTRIBUTES = 'attributes';
    public const SYNC_FIELD_OPTION_TAGS = 'tags';
    public const SYNC_FIELD_OPTION_IMAGES = 'images';
    public const SYNC_FIELD_OPTION_CATEGORIES = 'categories';
    public const CRON_WEEK_DAY = 'cron_week_days';
    public const CRON_HOURS = 'cron_hours';
    public const NONCE_ACTION = 'product_options_action';
    public const NONCE_NAME = 'product_options_nonce';
    public const NEXT_STEP = 'next_step';
    public const FIELD_REMOVED_PRODUCTS = 'removed_products';
    public const OPTION_NO_PRODUCT_DO_NOTHING = 'do_nothing';
    public const OPTION_NO_PRODUCT_EMPTY_STOCK = 'empty_stock';
    public const OPTION_NO_PRODUCT_TRASH = 'move_trash';
    public const FIELD_TURN_ON_LOGICAL_CONDITION = 'turn_logical_condition';
    public const FIELD_TURN_ON_LOGICAL_CONDITION_ID = 'turn_logical_condition';
    public const FIELD_UPDATE_ONLY_EXISTING_PRODUCTS = 'update_only_existing';
    public const FIELD_CREATE_NEW_PRODUCTS_AS_DRAFT = 'create_new_products_as_draft';
    public const NODE_ELEMENT = 'node_element';
    public const NODE_ELEMENT_ID = 'dropshipping-node-element';
    /**
     *
     * @var ImportOptionsDataProvider
     */
    private $options_data_provider;
    /**
     *
     * @var ImportMapperDataProvider
     */
    private $mapper_data_provider;
    public function __construct(DataProviderFactory $data_provider_factory, string $uid)
    {
        $this->options_data_provider = $data_provider_factory->create_by_class_name(ImportOptionsDataProvider::class, ['postfix' => $uid]);
        $this->mapper_data_provider = $data_provider_factory->create_by_class_name(ImportMapperDataProvider::class, ['postfix' => $uid]);
    }
    /**
     * @see FieldProvider::get_fields()
     */
    public function get_fields()
    {
        $product_fields = self::get_grouped_fields();
        return [(new SelectField())->set_label(__('Import into products on the basis of:', 'dropshipping-xml-for-woocommerce'))->set_name(self::UNIQUE_PRODUCT_SELECTOR)->add_class('dropshipping-select2 width-100 hs-beacon-search')->set_description(__('Choose a parameter which will be used for the identification of the products. If the product will not be found in the shop, it will be created. If the product will be found, it will be updated. The plugin will overwrite the data of the products in the shop with the values from the file.', 'dropshipping-xml-for-woocommerce'))->set_options($this->get_identity_map_options()), (new SelectField())->set_label(__('Synchronize product fields:', 'dropshipping-xml-for-woocommerce'))->set_name(self::SYNC_FIELD)->add_class('dropshipping-select2 width-100 hs-beacon-search')->set_description(__('Select product fields to update.', 'dropshipping-xml-for-woocommerce'))->set_multiple()->set_default_value($this->get_grouped_form_default_values())->set_options($product_fields), (new CheckboxField())->set_name(self::FIELD_TURN_ON_LOGICAL_CONDITION)->add_class('hs-beacon-search')->set_attribute('id', self::FIELD_TURN_ON_LOGICAL_CONDITION_ID)->set_label(__('Enable conditional logic', 'dropshipping-xml-for-woocommerce')), (new ConditionalLogicComponent())->set_label(__('Logical conditions', 'dropshipping-xml-for-woocommerce'))->set_attribute('id', self::LOGICAL_CONDITIONS_ID)->set_name(self::LOGICAL_CONDITIONS), (new CheckboxField())->set_name(self::FIELD_UPDATE_ONLY_EXISTING_PRODUCTS)->add_class('hs-beacon-search')->set_label(__('Don\'t create, only update existing products', 'dropshipping-xml-for-woocommerce')), (new CheckboxField())->set_name(self::FIELD_CREATE_NEW_PRODUCTS_AS_DRAFT)->add_class('hs-beacon-search')->set_label(__('Create new products as drafts', 'dropshipping-xml-for-woocommerce')), (new SelectField())->set_label(__('Cron schedule:', 'dropshipping-xml-for-woocommerce'))->set_name(self::CRON_WEEK_DAY)->add_class('dropshipping-select2 width-100 hs-beacon-search')->set_description(__('Select days of the week for the processes to run automatically.', 'dropshipping-xml-for-woocommerce'))->set_multiple()->set_options(self::get_week_days()), (new SelectField())->set_label('')->set_name(self::CRON_HOURS)->add_class('dropshipping-select2 width-100 hs-beacon-search')->set_description(__('Select hours for the processes to run automatically.', 'dropshipping-xml-for-woocommerce'))->set_multiple()->set_options($this->get_hours_data()), (new SelectField())->set_label(__('No product in XML/CSV file', 'dropshipping-xml-for-woocommerce'))->set_name(self::FIELD_REMOVED_PRODUCTS)->add_class('dropshipping-select2 width-100 hs-beacon-search')->set_description(__('Choose what should happen to products that have been imported into the shop from an XML file and then removed from the file by file provider.', 'dropshipping-xml-for-woocommerce'))->set_options($this->get_no_products_options()), (new HiddenField())->set_name(self::NODE_ELEMENT)->set_attribute('id', self::NODE_ELEMENT_ID), (new SubmitField())->set_name(self::NEXT_STEP)->set_label(__('Start import', 'dropshipping-xml-for-woocommerce'))->add_class('button button-primary button-hero')->set_attribute('id', self::NEXT_STEP), (new NoOnceField(self::NONCE_ACTION))->set_name(self::NONCE_NAME)];
    }
    private function get_identity_map_options(): array
    {
        $result = [self::UNIQUE_PRODUCT_SELECTOR_SKU => \esc_attr__('SKU', 'dropshipping-xml-for-woocommerce'), self::UNIQUE_PRODUCT_SELECTOR_NAME => \esc_attr__('Product name', 'dropshipping-xml-for-woocommerce'), self::UNIQUE_PRODUCT_SELECTOR_CUSTOM_PRODUCT_ID => \esc_attr__('Custom product ID', 'dropshipping-xml-for-woocommerce')];
        if (FlexibleEanIntegration::is_active()) {
            $result[self::UNIQUE_PRODUCT_SELECTOR_EAN] = \esc_attr__('EAN', 'dropshipping-xml-for-woocommerce');
        }
        return $result;
    }
    public static function get_week_days(): array
    {
        return ['1' => \esc_attr__('Monday', 'dropshipping-xml-for-woocommerce'), '2' => \esc_attr__('Tuesday', 'dropshipping-xml-for-woocommerce'), '3' => \esc_attr__('Wednesday', 'dropshipping-xml-for-woocommerce'), '4' => \esc_attr__('Thursday', 'dropshipping-xml-for-woocommerce'), '5' => \esc_attr__('Friday', 'dropshipping-xml-for-woocommerce'), '6' => \esc_attr__('Saturday', 'dropshipping-xml-for-woocommerce'), '7' => \esc_attr__('Sunday', 'dropshipping-xml-for-woocommerce')];
    }
    private function get_hours_data(): array
    {
        $result = [];
        $minutes = ['00', '15', '30', '45'];
        for ($i = 0; $i < 24; $i++) {
            foreach ($minutes as $minute) {
                $time = $i . ':' . $minute;
                $result[$time] = $i . ':' . $minute;
            }
        }
        return $result;
    }
    private function get_no_products_options(): array
    {
        return [self::OPTION_NO_PRODUCT_DO_NOTHING => \esc_attr__('Do nothing', 'dropshipping-xml-for-woocommerce'), self::OPTION_NO_PRODUCT_EMPTY_STOCK => \esc_attr__('Change shop products stock to 0', 'dropshipping-xml-for-woocommerce'), self::OPTION_NO_PRODUCT_TRASH => \esc_attr__('Move products to the trash', 'dropshipping-xml-for-woocommerce')];
    }
    private function get_grouped_form_default_values(): array
    {
        if ($this->options_data_provider->has(self::SYNC_FIELD)) {
            return [];
        } else {
            $params = self::get_grouped_fields();
            if ($this->mapper_data_provider->has(ImportMapperFormFields::PRODUCT_SHIPPING_CLASS_SYNC_DISABLED)) {
                if (CheckboxField::VALUE_TRUE === $this->mapper_data_provider->get(ImportMapperFormFields::PRODUCT_SHIPPING_CLASS_SYNC_DISABLED)) {
                    if (isset($params[self::SYNC_FIELD_OPTION_SHIPPING_CLASS])) {
                        unset($params[self::SYNC_FIELD_OPTION_SHIPPING_CLASS]);
                    }
                }
            }
            if ($this->mapper_data_provider->has(ImportMapperFormFields::PRODUCT_CATEGORIES_SYNC_DISABLED)) {
                if (CheckboxField::VALUE_TRUE === $this->mapper_data_provider->get(ImportMapperFormFields::PRODUCT_CATEGORIES_SYNC_DISABLED)) {
                    if (isset($params[self::SYNC_FIELD_OPTION_CATEGORIES])) {
                        unset($params[self::SYNC_FIELD_OPTION_CATEGORIES]);
                    }
                }
            }
            if ($this->mapper_data_provider->has(ImportMapperFormFields::PRODUCT_ATTRIBUTE_SYNC_DISABLED)) {
                if (CheckboxField::VALUE_TRUE === $this->mapper_data_provider->get(ImportMapperFormFields::PRODUCT_ATTRIBUTE_SYNC_DISABLED)) {
                    if (isset($params[self::SYNC_FIELD_OPTION_ATTRIBUTES])) {
                        unset($params[self::SYNC_FIELD_OPTION_ATTRIBUTES]);
                    }
                }
            }
            return array_keys($params);
        }
    }
    public static function get_grouped_fields(): array
    {
        $result = [self::SYNC_FIELD_OPTION_TITLE => \esc_attr__('Product title', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_DESCRIPTION => \esc_attr__('Product description', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_SHORT_DESCRIPTION => \esc_attr__('Product short description', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_GENERAL_PRICE => \esc_attr__('Product price', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_GENERAL_SALE_PRICE => \esc_attr__('Product sale price', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_GENERAL_TAX_STATUS => \esc_attr__('Product tax status', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_GENERAL_TAX_CLASS => \esc_attr__('Product tax class', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_STOCK_SKU => \esc_attr__('Product SKU', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_STOCK_MANAGMENT => \esc_attr__('Product stock', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_SHIPPING_WEIGHT => \esc_attr__('Product shipping weight', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_SHIPPING_DIMENSIONS => \esc_attr__('Product shipping dimensions', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_SHIPPING_CLASS => \esc_attr__('Product shipping class', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_ATTRIBUTES => \esc_attr__('Product attributes', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_IMAGES => \esc_attr__('Product images', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_CATEGORIES => \esc_attr__('Product categories', 'dropshipping-xml-for-woocommerce'), self::SYNC_FIELD_OPTION_TAGS => \esc_attr__('Product tags', 'dropshipping-xml-for-woocommerce')];
        if (FlexibleEanIntegration::is_active()) {
            $result[self::SYNC_FIELD_OPTION_EAN] = \esc_attr__('EAN', 'dropshipping-xml-for-woocommerce');
        }
        if (GPSRIntegration::is_active()) {
            $result[self::SYNC_FIELD_OPTION_GPSR] = \esc_attr__('GPSR', 'dropshipping-xml-for-woocommerce');
        }
        return $result;
    }
}
