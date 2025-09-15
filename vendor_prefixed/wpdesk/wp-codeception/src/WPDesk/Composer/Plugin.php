<?php

namespace DropshippingXmlFreeVendor\WPDesk\Composer\Codeception;

use DropshippingXmlFreeVendor\Composer\Composer;
use DropshippingXmlFreeVendor\Composer\IO\IOInterface;
use DropshippingXmlFreeVendor\Composer\Plugin\Capable;
use DropshippingXmlFreeVendor\Composer\Plugin\PluginInterface;
/**
 * Composer plugin.
 *
 * @package WPDesk\Composer\Codeception
 */
class Plugin implements PluginInterface, Capable
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var IOInterface
     */
    private $io;
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    public function getCapabilities()
    {
        return [\DropshippingXmlFreeVendor\Composer\Plugin\Capability\CommandProvider::class => CommandProvider::class];
    }
}
