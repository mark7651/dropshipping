<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Dependency\Resolver\Abstraction\DependencyResolverInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Modificator\PriceModificator;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Modificator\PriceModificatorConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Modificator\PriceModificatorGroup;
/**
 * Class PriceModificatorFactory.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Factory
 */
class PriceModificatorFactory
{
    /**
     * @var DependencyResolverInterface
     */
    private $resolver;
    public function __construct(DependencyResolverInterface $dependency_resolver)
    {
        $this->resolver = $dependency_resolver;
    }
    public function create_group_from_array(array $condition, array $parameters = []): PriceModificatorGroup
    {
        return $this->resolver->resolve(PriceModificatorGroup::class, ['conditional_logic' => $this->create_conditional_logic($condition, $parameters), 'price_modificator' => $this->create_price_modificator($condition, $parameters)]);
    }
    private function create_conditional_logic(array $condition, array $parameters): PriceModificatorConditionalLogic
    {
        $parameters = array_merge($parameters, ['conditions' => $condition]);
        return $this->resolver->resolve(PriceModificatorConditionalLogic::class, $parameters);
    }
    private function create_price_modificator(array $condition, array $parameters): PriceModificator
    {
        $parameters = array_merge($parameters, ['conditions' => $condition]);
        return $this->resolver->resolve(PriceModificator::class, $parameters);
    }
}
