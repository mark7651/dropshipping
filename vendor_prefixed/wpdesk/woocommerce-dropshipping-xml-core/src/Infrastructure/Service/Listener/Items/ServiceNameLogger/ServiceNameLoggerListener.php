<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\ServiceNameLogger;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Abstraction\AbstractServiceListener;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Container\Abstraction\ServiceContainerInterface;
/**
 * Class ServiceNameLoggerListener, log servies class names.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\ServiceNameLogger
 */
final class ServiceNameLoggerListener extends AbstractServiceListener
{
    /**
     * @see AbstractServiceListener::update()
     */
    public function update($service, ServiceContainerInterface $service_container)
    {
        error_log(get_class($service));
    }
}
