<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Registrable;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Abstraction\AbstractServiceListener;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Container\Abstraction\ServiceContainerInterface;
/**
 * Class RegistrableServiceListener, register class or object as services.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Registrable
 */
final class RegistrableServiceListener extends AbstractServiceListener
{
    /**
     * @see AbstractServiceListener::update()
     */
    public function update($service, ServiceContainerInterface $service_container)
    {
        if ($service instanceof Registrable) {
            $servicesToRegister = $service->register();
            if (!empty($servicesToRegister)) {
                $service_container->register_from_array($servicesToRegister);
            }
        }
    }
}
