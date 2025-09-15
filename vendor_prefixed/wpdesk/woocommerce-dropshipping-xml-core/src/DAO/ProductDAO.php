<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\DAO;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\DAO\Exception\NotFoundException;
use WC_Product_Factory;
use WC_Product;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Integration\FlexibleEanIntegration;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportMapperFormFields;
/**
 * Class ProductDAO, data access object class for woocommerce products.
 *
 * @package WPDesk\Library\DropshippingXmlCore\DAO
 */
class ProductDAO
{
    const PRODUCT_IMPORT_ID_META = 'import_uid';
    const PRODUCT_IMPORT_STARTED_AT_META = 'import_started_at';
    const HAS_PARENT_META_KEY = 'has_parent';
    const HAS_PARENT_VALUE_YES = 'yes';
    const HAS_PARENT_VALUE_NO = 'no';
    const PRODUCT_CUSTOM_ID_META = 'custom_id';
    const RESYNC_META_KEY = 'resync';
    const RESYNC_VALUE_YES = 'yes';
    const RESYNC_VALUE_NO = 'no';
    /**
     * @var WC_Product_Factory
     */
    private $wc_factory;
    public function __construct(WC_Product_Factory $wc_factory)
    {
        $this->wc_factory = $wc_factory;
    }
    public function save(WC_Product $wc_product)
    {
        $wc_product->save();
    }
    public function delete(WC_Product $wc_product, bool $force = \false)
    {
        $wc_product->delete($force);
    }
    public function find_by_sku(string $sku): WC_Product
    {
        $post_id = wc_get_product_id_by_sku($sku);
        if (empty($post_id)) {
            throw new NotFoundException('Error, product not exists');
        }
        return $this->wc_factory->get_product($post_id);
    }
    public static function add_ean_field(WC_Product $product, string $ean): WC_Product
    {
        if (defined('WC_VERSION') && version_compare(\WC_VERSION, '9.2.0', '>=')) {
            $product->set_global_unique_id(wc_clean($ean));
        } else {
            $product->update_meta_data(FlexibleEanIntegration::META_KEY, wc_clean($ean));
        }
        return $product;
    }
    public function find_by_ean(string $ean): WC_Product
    {
        $post_id = null;
        if (defined('WC_VERSION') && version_compare(\WC_VERSION, '9.2.0', '>=')) {
            $post_id = wc_get_product_id_by_global_unique_id(esc_html($ean));
        } else {
            $posts_ids = get_posts(['posts_per_page' => 1, 'post_type' => ['product', 'product_variation'], 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => [['key' => FlexibleEanIntegration::META_KEY, 'value' => esc_html($ean), 'compare' => '=']]]);
            if (\is_array($posts_ids) && !empty($posts_ids)) {
                $post_id = reset($posts_ids);
            }
        }
        if (empty($post_id)) {
            throw new NotFoundException('Error, product not exists');
        }
        return $this->wc_factory->get_product($post_id);
    }
    public function generate_custom_id(string $uid): string
    {
        return 'custom_id_' . $uid;
    }
    public function generate_group_id(string $uid): string
    {
        return 'group_id_' . $uid;
    }
    public function find_by_group_id(string $uid, $id): WC_Product
    {
        $posts_ids = get_posts(['posts_per_page' => 1, 'post_type' => 'product', 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => [['key' => $this->generate_group_id($uid), 'value' => $id, 'compare' => '=']]]);
        if (empty($posts_ids)) {
            throw new NotFoundException('Error, product not exists');
        }
        $post_id = reset($posts_ids);
        return $this->wc_factory->get_product($post_id);
    }
    public function find_by_unique_custom_id(string $id): WC_Product
    {
        $posts_ids = get_posts(['posts_per_page' => 1, 'post_type' => ['product', 'product_variation'], 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => [['key' => self::PRODUCT_CUSTOM_ID_META, 'value' => esc_html($id), 'compare' => '=']]]);
        if (empty($posts_ids)) {
            throw new NotFoundException('Error, product not exists');
        }
        $post_id = reset($posts_ids);
        return $this->wc_factory->get_product($post_id);
    }
    public function find_by_custom_id(string $uid, $id): WC_Product
    {
        $posts_ids = get_posts(['posts_per_page' => 1, 'post_type' => 'product', 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => [['key' => $this->generate_custom_id($uid), 'value' => $id, 'compare' => '=']]]);
        if (empty($posts_ids)) {
            throw new NotFoundException('Error, product not exists');
        }
        $post_id = reset($posts_ids);
        return $this->wc_factory->get_product($post_id);
    }
    public function find_by_name(string $product_name): WC_Product
    {
        $post = get_page_by_title($product_name, \OBJECT, 'product');
        if (!\is_object($post)) {
            throw new NotFoundException('Error, product not exists');
        }
        return $this->wc_factory->get_product($post->ID);
    }
    public function find_not_imported_products(string $uid, int $started_at, int $limit = 50, bool $without_empty_stock = \false): array
    {
        $result = [];
        $meta_query = ['relation' => 'AND', ['key' => self::PRODUCT_IMPORT_ID_META, 'value' => $uid, 'compare' => '='], ['key' => self::PRODUCT_IMPORT_STARTED_AT_META, 'value' => $started_at, 'compare' => '!=']];
        if ($without_empty_stock) {
            $meta_query[] = ['key' => '_stock_status', 'value' => 'outofstock', 'compare' => 'NOT LIKE'];
        }
        $posts_ids = get_posts(['posts_per_page' => $limit, 'post_type' => 'product', 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => $meta_query]);
        $result = $this->create_products_instances($posts_ids);
        return $result;
    }
    public function find_imported_products(string $uid, int $started_at, int $limit = 50, bool $without_empty_stock = \false): array
    {
        $meta_query = ['relation' => 'AND', ['key' => self::PRODUCT_IMPORT_ID_META, 'value' => $uid, 'compare' => '='], ['key' => self::PRODUCT_IMPORT_STARTED_AT_META, 'value' => $started_at, 'compare' => '=']];
        if ($without_empty_stock) {
            $meta_query[] = ['key' => '_stock_status', 'value' => 'outofstock', 'compare' => 'NOT LIKE'];
        }
        $posts_ids = get_posts(['posts_per_page' => $limit, 'post_type' => 'product', 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => $meta_query]);
        $result = $this->create_products_instances($posts_ids);
        return $result;
    }
    public function find_variable_products_to_sync(string $uid, int $started_at, int $limit = 50): array
    {
        $meta_query = ['relation' => 'AND', ['key' => self::PRODUCT_IMPORT_ID_META, 'value' => $uid, 'compare' => '='], ['key' => self::PRODUCT_IMPORT_STARTED_AT_META, 'value' => $started_at, 'compare' => '='], ['key' => self::RESYNC_META_KEY, 'value' => self::RESYNC_VALUE_YES, 'compare' => '=']];
        $posts_ids = get_posts(['posts_per_page' => $limit, 'post_type' => 'product', 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => $meta_query]);
        $result = $this->create_products_instances($posts_ids);
        return $result;
    }
    public function find_not_imported_variations(string $uid, int $started_at, int $limit = 50): array
    {
        $meta_query = ['relation' => 'AND', ['key' => self::PRODUCT_IMPORT_ID_META, 'value' => $uid, 'compare' => '='], ['key' => self::PRODUCT_IMPORT_STARTED_AT_META, 'value' => $started_at, 'compare' => '!=']];
        $posts_ids = get_posts(['posts_per_page' => $limit, 'post_type' => 'product_variation', 'fields' => 'ids', 'post_status' => ['publish', 'draft'], 'meta_query' => $meta_query]);
        $result = $this->create_products_instances($posts_ids);
        return $result;
    }
    private function create_products_instances(array $posts_ids): array
    {
        $result = [];
        foreach ($posts_ids as $post_id) {
            $product = $this->wc_factory->get_product($post_id);
            if (\is_object($product) && $product instanceof WC_Product) {
                $result[] = $product;
            }
        }
        return $result;
    }
}
