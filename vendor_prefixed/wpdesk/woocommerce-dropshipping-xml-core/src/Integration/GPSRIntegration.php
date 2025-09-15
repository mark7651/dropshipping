<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration;

class GPSRIntegration
{
    public const GPSR_MANUFACTURER_NAME_META = '_gpsr_manufacturer_name';
    public const GPSR_MANUFACTURER_ADDRESS_META = '_gpsr_manufacturer_address';
    public const GPSR_MANUFACTURER_EMAIL_META = '_gpsr_manufacturer_email';
    public const GPSR_IMPORTER_NAME_META = '_gpsr_importer_name';
    public const GPSR_IMPORTER_ADDRESS_META = '_gpsr_importer_address';
    public const GPSR_IMPORTER_EMAIL_META = '_gpsr_importer_email';
    public const GPSR_TRADEMARK_META = '_gpsr_trademark';
    public const GPSR_CERTIFICATES_META = '_gpsr_certificates';
    public const GPSR_INSTRUCTIONS_TYPE_META = '_gpsr_instructions_type';
    public const GPSR_INSTRUCTIONS_TEXT_META = '_gpsr_instructions_text';
    public const GPSR_INSTRUCTIONS_FILE_META = '_gpsr_instructions_file';
    public const GPSR_INSTRUCTIONS_TYPE_DEFAULT_VALUE = 'text';
    public static function is_active(): bool
    {
        return is_plugin_active('gpsr-for-woocommerce/gpsr-for-woocommerce.php');
    }
}
