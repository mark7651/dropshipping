<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Hookable;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Abstraction\AbstractServiceListener;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Container\Abstraction\ServiceContainerInterface;
/**
 * Class HookableServiceListener, checks if service implements hookable interface and run it.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Hookable
 */
final class HookableServiceListener extends AbstractServiceListener
{
    /**
     * @see AbstractServiceListener::update()
     */
    public function update($service, ServiceContainerInterface $service_container)
    {
        if ($service instanceof Hookable) {
            $service->hooks();
        }
    }
}
