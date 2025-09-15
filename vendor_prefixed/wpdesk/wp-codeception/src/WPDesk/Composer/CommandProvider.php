<?php

namespace DropshippingXmlFreeVendor\WPDesk\Composer\Codeception;

use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTestsWithCoverage;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests;
use DropshippingXmlFreeVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTestsWithCoverage;
/**
 * Links plugin commands handlers to composer.
 */
class CommandProvider implements \DropshippingXmlFreeVendor\Composer\Plugin\Capability\CommandProvider
{
    public function getCommands()
    {
        return [new CreateCodeceptionTests(), new RunCodeceptionTests(), new RunLocalCodeceptionTests(), new RunLocalCodeceptionTestsWithCoverage(), new PrepareCodeceptionDb(), new PrepareWordpressForCodeception(), new PrepareLocalCodeceptionTests(), new PrepareLocalCodeceptionTestsWithCoverage(), new PrepareParallelCodeceptionTests()];
    }
}
