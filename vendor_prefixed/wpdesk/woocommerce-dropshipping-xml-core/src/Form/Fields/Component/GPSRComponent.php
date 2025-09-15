<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component;

use DropshippingXmlFreeVendor\WPDesk\Forms\Field\InputTextField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\TextAreaField;
class GPSRComponent extends \DropshippingXmlFreeVendor\WPDesk\Forms\Field\BasicField
{
    public const MANUFACTURER_NAME = 'manufacturer_name';
    public const MANUFACTURER_ADDRESS = 'manufacturer_address';
    public const MANUFACTURER_EMAIL = 'manufacturer_email';
    public const IMPORTER_NAME = 'importer_name';
    public const IMPORTER_ADDRESS = 'importer_address';
    public const IMPORTER_EMAIL = 'importer_email';
    public const DETAILS_TRADEMARK = 'details_trademark';
    public const DETAILS_CERTIFICATES = 'details_certificates';
    public const USAGE_INSTRUCTIONS_TEXT = 'usage_instructions_text';
    public function __construct()
    {
        parent::__construct();
        $this->attributes['multiple'] = \true;
    }
    public function get_items(): array
    {
        if (!isset($this->meta['items'])) {
            $this->meta['items'] = [(new InputTextField())->set_name(self::MANUFACTURER_NAME)->set_attribute('id', self::MANUFACTURER_NAME)->add_class('width-100')->set_label(esc_html__('Manufacturer name', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::MANUFACTURER_ADDRESS)->set_attribute('id', self::MANUFACTURER_ADDRESS)->add_class('width-100')->set_label(esc_html__('Manufacturer address', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::MANUFACTURER_EMAIL)->set_attribute('id', self::MANUFACTURER_EMAIL)->add_class('width-100')->set_label(esc_html__('Manufacturer email', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::IMPORTER_NAME)->set_attribute('id', self::IMPORTER_NAME)->add_class('width-100')->set_label(esc_html__('Importer name', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::IMPORTER_ADDRESS)->set_attribute('id', self::IMPORTER_ADDRESS)->add_class('width-100')->set_label(esc_html__('Importer address', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::IMPORTER_EMAIL)->set_attribute('id', self::IMPORTER_EMAIL)->add_class('width-100')->set_label(esc_html__('Importer email', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::DETAILS_TRADEMARK)->set_attribute('id', self::DETAILS_TRADEMARK)->add_class('width-100')->set_label(esc_html__('Details trademark', 'dropshipping-xml-for-woocommerce')), (new InputTextField())->set_name(self::DETAILS_CERTIFICATES)->set_attribute('id', self::DETAILS_CERTIFICATES)->add_class('width-100')->set_label(esc_html__('Details certificates', 'dropshipping-xml-for-woocommerce')), (new TextAreaField())->set_label(esc_html__('Usage instructions', 'dropshipping-xml-for-woocommerce'))->set_attribute('rows', 8)->set_attribute('id', self::USAGE_INSTRUCTIONS_TEXT)->add_class('width-100')->set_label(esc_html__('Usage instructions', 'dropshipping-xml-for-woocommerce'))->set_name(self::USAGE_INSTRUCTIONS_TEXT)];
        }
        return $this->meta['items'];
    }
    public function get_template_name(): string
    {
        return 'gpsr-component';
    }
}
