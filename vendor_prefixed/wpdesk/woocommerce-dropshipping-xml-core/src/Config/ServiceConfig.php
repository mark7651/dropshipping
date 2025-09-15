<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Config;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Config\Abstraction\AbstractSingleConfig;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Config\Config;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Dependency\Binder\DependencyBinderCollection;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Dependency\Resolver\DependencyResolver;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Conditional\ConditionalServiceListener;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Hookable\HookableServiceListener;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Initable\InitableServiceListener;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Registrable\RegistrableServiceListener;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Container\ServiceContainer;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\ListenerCollection;
use DropshippingXmlFreeVendor\WPDesk\View\Resolver\ChainResolver;
use DropshippingXmlFreeVendor\WPDesk\View\Resolver\DirResolver;
use DropshippingXmlFreeVendor\WPDesk\View\Renderer\Renderer;
use DropshippingXmlFreeVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use DropshippingXmlFreeVendor\WPDesk\View\Resolver\Resolver;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Request\Request;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\View\FormView;
use DropshippingXmlFreeVendor\Monolog\Logger;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportOptionsFormFields;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Viewer\SidebarViewerService;
use DropshippingXmlFreeVendor\WPDesk\Logger\Settings as LoggerSettings;
use DropshippingXmlFreeVendor\WPDesk\Logger\SimpleLoggerFactory;
/**
 * Class ServiceConfig, configuration class for services and it's dependencies.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Config
 */
class ServiceConfig extends AbstractSingleConfig
{
    const ID = 'service';
    const LOGGER_NAME = 'dropshipping-import';
    public function get(): array
    {
        $config = $this->get_config();
        $request = new Request();
        return ['container' => ServiceContainer::class, 'resolver' => DependencyResolver::class, 'binder_collection' => DependencyBinderCollection::class, 'listener_collection' => ListenerCollection::class, 'bind' => [Config::class => $config, Request::class => $request, Resolver::class => function () use ($config) {
            $resolver = new ChainResolver();
            $resolver->appendResolver(new DirResolver($config->get_param('templates.dir')->get()));
            $resolver->appendResolver(new DirResolver($config->get_param('templates.form_fields_dir')->get()));
            $resolver->appendResolver(new DirResolver($config->get_param('templates.core_dir')->get()));
            $resolver->appendResolver(new DirResolver($config->get_param('templates.core_form_fields_dir')->get()));
            return $resolver;
        }, Renderer::class => SimplePhpRenderer::class, Logger::class => function () {
            $logger_options = new LoggerSettings();
            $logger_options->use_wp_log = \false;
            return (new SimpleLoggerFactory(self::LOGGER_NAME, $logger_options))->getLogger();
        }, ImportOptionsFormFields::class => ['uid' => $this->get_uid($request)], SidebarViewerService::class => ['uid' => $this->get_uid($request)]], 'forbidden' => [FormView::class], 'listeners' => [ConditionalServiceListener::class, RegistrableServiceListener::class, HookableServiceListener::class, InitableServiceListener::class]];
    }
    public function get_id(): string
    {
        return self::ID;
    }
    protected function get_uid(Request $request): string
    {
        $uid = $request->get_param('post.uid')->get();
        if (empty($uid)) {
            $uid = $request->get_param('get.uid')->get();
        }
        return !empty($uid) ? $uid : '';
    }
}
