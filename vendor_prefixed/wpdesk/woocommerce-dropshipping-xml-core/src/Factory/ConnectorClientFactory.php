<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Factory;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Connector\Client\CurlHttpClient;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Connector\Client\Options\CurlHttpClientOptions;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\ImportFileFormFields;
use RuntimeException;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Dependency\Resolver\Abstraction\DependencyResolverInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Connector\Abstraction\Connector;
/**
 * Class ConnectorClientFactory, connector client factory.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Factory
 */
class ConnectorClientFactory
{
    const FILTER_BYPASS_SSL = 'wpdesk_dropshipping_bypass_ssl';
    const FILTER_HTTP_CLIENT_OPTIONS = 'wpdesk_dropshipping_curl_http_client_options';
    /**
     * @var DependencyResolverInterface
     */
    protected $resolver;
    public function __construct(DependencyResolverInterface $dependency_resolver)
    {
        $this->resolver = $dependency_resolver;
    }
    public function create_client(array $parameters): Connector
    {
        $clients = $this->get_clients();
        if (isset($parameters[ImportFileFormFields::CLIENT]) && array_key_exists($parameters[ImportFileFormFields::CLIENT], $clients)) {
            $callback = $clients[$parameters[ImportFileFormFields::CLIENT]];
            return $callback($parameters);
        }
        throw new RuntimeException('Error connection: client does not exist.');
    }
    protected function get_clients(): array
    {
        return [ImportFileFormFields::CLIENT_CURL => function (array $parameters) {
            if (isset($parameters[ImportFileFormFields::FILE_URL])) {
                /**
                 * @var CurlHttpClientOptions;
                 */
                $options = $this->resolver->resolve(CurlHttpClientOptions::class);
                $options->set_url($parameters[ImportFileFormFields::FILE_URL]);
                if (\true === apply_filters(ConnectorClientFactory::FILTER_BYPASS_SSL, \false)) {
                    $options->set_ssl_verify_peer(\false);
                    $options->set_ssl_verify_host(0);
                }
                $options = \apply_filters(self::FILTER_HTTP_CLIENT_OPTIONS, $options);
                return $this->resolver->resolve(CurlHttpClient::class, ['options' => $options]);
            }
            throw new RuntimeException('Error, client used for connection is empty');
        }];
    }
}
