<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration;

use WC_Product;
/**
 * Class FlexibleEanIntegration
 */
class FlexibleEanIntegration
{
    public const META_KEY = '_global_unique_id';
    public static function is_active(): bool
    {
        return is_plugin_active('flexible-ean-for-woocommerce/flexible-ean-for-woocommerce.php') || defined('WC_VERSION') && version_compare(\WC_VERSION, '9.2.0', '>=');
    }
    public static function add_ean_field(WC_Product $product, string $ean): WC_Product
    {
        if (defined('WC_VERSION') && version_compare(\WC_VERSION, '9.2.0', '>=')) {
            $product->set_global_unique_id(wc_clean($ean));
        } else {
            $product->update_meta_data(self::META_KEY, wc_clean($ean));
        }
        return $product;
    }
}
