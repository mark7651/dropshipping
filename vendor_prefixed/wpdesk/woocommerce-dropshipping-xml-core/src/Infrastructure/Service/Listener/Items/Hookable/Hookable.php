<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Hookable;

/**
 * Interface Hookable, add hooks method to add WordPress actions and filters.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Hookable
 */
interface Hookable
{
    /**
     * @return void
     */
    public function hooks();
}
