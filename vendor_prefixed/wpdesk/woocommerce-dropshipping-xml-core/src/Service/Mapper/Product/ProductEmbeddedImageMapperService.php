<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Mapper\Product;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\VariationComponent;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportMapperFormFields;
/**
 * Class ProductEmbeddedImageMapperService, creates woocommerce product.
 */
class ProductEmbeddedImageMapperService extends ProductImageMapperService
{
    protected function get_img_field(): string
    {
        $img = $this->mapper->map(VariationComponent::PRODUCT_IMAGES, ImportMapperFormFields::VARIATION_EMBEDDED);
        return $img;
    }
}
