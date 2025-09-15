<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Container\Abstraction;

/**
 * Interface ServiceContainerAwareInterface allows to set service container.
 */
interface ServiceContainerAwareInterface
{
    /**
     * Service container setter.
     *
     * @param ServiceContainerInterface $service_container
     */
    public function set_service_container(ServiceContainerInterface $service_container);
}
