<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Mapper\Product;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportMapperFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Logger\ImportLoggerService;
use WC_Product;
use WP_Term;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Mapper\ImportMapperService;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Mapper\Product\Abstraction\ProductMapperServiceInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Exception\WPTermNotCreatedException;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportOptionsFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Exception\WPTermNotFoundException;
/**
 *  * Class ProductTagMapperService, creates woocommerce product tags.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Service\Mapper\Product
 */
class ProductTagMapperService implements ProductMapperServiceInterface
{
    public const FILTER_NAME_TAGS = 'wpdesk_dropshipping_mapper_tags';
    public const TAG_TAXONOMY_NAME = 'product_tag';
    public const FILTER_TAG_SEPARATOR = 'wpdesk_dropshipping_mapper_tag_separator';
    /**
     * @var ImportMapperService
     */
    private $mapper;
    /**
     * @var ImportLoggerService
     */
    private $logger;
    public function __construct(ImportMapperService $mapper, ImportLoggerService $logger)
    {
        $this->logger = $logger;
        $this->mapper = $mapper;
    }
    public function update_product(WC_Product $wc_product): WC_Product
    {
        if ($this->mapper->is_product_field_group_should_be_mapped($wc_product, ImportOptionsFormFields::SYNC_FIELD_OPTION_TAGS)) {
            $tags = $this->get_tags();
            $wc_product->set_tag_ids($tags);
        }
        return $wc_product;
    }
    protected function get_separator_field(): string
    {
        $separator = $this->mapper->get_raw_value(ImportMapperFormFields::PRODUCT_TAGS_SEPARATOR);
        return $separator === null ? ',' : $separator;
    }
    private function get_tags(): array
    {
        $result = [];
        $separator = apply_filters(self::FILTER_TAG_SEPARATOR, $this->get_separator_field());
        $mapped_tags_field = apply_filters(self::FILTER_NAME_TAGS, $this->mapper->map(ImportMapperFormFields::PRODUCT_TAGS));
        if (!empty($mapped_tags_field) && !empty($separator)) {
            $tags_to_map = explode($separator, $mapped_tags_field);
            foreach ($tags_to_map as $tag_to_map) {
                $mapped_tag = wc_clean(trim($tag_to_map));
                if (!empty($mapped_tag)) {
                    try {
                        $term = $this->find_tag_by_name($mapped_tag);
                        $result = array_merge($result, [$term->term_id]);
                    } catch (WPTermNotFoundException $e) {
                        $term = $this->create_tag_by_name($mapped_tag);
                        $result = array_merge($result, [$term->term_id]);
                    }
                }
            }
        }
        return array_unique($result);
    }
    private function find_tag_by_name(string $name): WP_Term
    {
        $args = ['hide_empty' => \false, 'name' => $name, 'taxonomy' => self::TAG_TAXONOMY_NAME];
        $terms = get_terms($args);
        if (\is_array($terms) && !empty($terms)) {
            $term = \reset($terms);
            if (is_object($term) && $term instanceof WP_Term) {
                return $term;
            }
        }
        throw new WPTermNotFoundException('Tag ' . $name . ' not found');
    }
    private function create_tag_by_name(string $name): WP_Term
    {
        $term_id = null;
        $term_data = wp_insert_term($name, self::TAG_TAXONOMY_NAME);
        if (\is_wp_error($term_data)) {
            $error_data = $term_data->error_data;
            if (\is_array($error_data) && isset($error_data['term_exists'])) {
                $term_id = (int) $error_data['term_exists'];
            }
        } elseif (\is_array($term_data) && isset($term_data['term_id'])) {
            $term_id = (int) $term_data['term_id'];
        }
        if (\is_int($term_id)) {
            $term = get_term($term_id, self::TAG_TAXONOMY_NAME);
            if (\is_object($term) && $term instanceof WP_Term) {
                return $term;
            }
        }
        throw new WPTermNotCreatedException('Tag ' . $name . ' can\'t be created');
    }
}
