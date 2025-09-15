<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Config;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Data\Abstraction\DataTypeInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Container\ParameterContainer;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Config\Abstraction\ConfigInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Config\Abstraction\AbstractSingleConfig;
/**
 * Class Config, stores all merged data from single configurations and shares data access methods.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Infrastructure\Config
 */
final class Config implements ConfigInterface
{
    /**
     * @var ParameterContainer
     */
    private $parameter_container;
    public function __construct()
    {
        $this->parameter_container = new ParameterContainer([]);
    }
    public function get_param(string $key): DataTypeInterface
    {
        return $this->parameter_container->get_param($key);
    }
    public function register_config(array $config)
    {
        foreach ($config as $conf) {
            if ($conf instanceof AbstractSingleConfig) {
                $conf->set_config($this);
                $this->parameter_container->add_params([$conf->get_id() => $conf->get()]);
            } else {
                throw new Exception\ConfigException('Config object should implements AbstractSingleConfig');
            }
        }
    }
}
