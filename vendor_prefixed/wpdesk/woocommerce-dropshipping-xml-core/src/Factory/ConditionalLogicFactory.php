<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Dependency\Resolver\Abstraction\DependencyResolverInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\Abstraction\ConditionalLogic;
use RuntimeException;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\ContainsConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\EmptyConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\EqualConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\HigherConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\LowerConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\NotContainsConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\NotEmptyConditionalLogic;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\ConditionalLogic\NotEqualConditionalLogic;
/**
 * Class ConditionalLogicFactory, factory for conditional logic.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Factory
 */
class ConditionalLogicFactory
{
    /**
     * @var DependencyResolverInterface
     */
    private $resolver;
    public function __construct(DependencyResolverInterface $dependency_resolver)
    {
        $this->resolver = $dependency_resolver;
    }
    public function create_by_name(string $name): ConditionalLogic
    {
        $all_conditional_logic = $this->get_all();
        foreach ($all_conditional_logic as $logic) {
            if ($name === $logic::get_name()) {
                return $this->resolver->resolve($logic);
            }
        }
        throw new RuntimeException('Error, conditional logic ' . $name . ' not found.');
    }
    private function get_all(): array
    {
        return [ContainsConditionalLogic::class, EmptyConditionalLogic::class, EqualConditionalLogic::class, HigherConditionalLogic::class, LowerConditionalLogic::class, NotContainsConditionalLogic::class, NotEmptyConditionalLogic::class, NotEqualConditionalLogic::class];
    }
}
