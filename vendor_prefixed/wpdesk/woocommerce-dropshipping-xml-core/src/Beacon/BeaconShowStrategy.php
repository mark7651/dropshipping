<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Beacon;

use DropshippingXmlFreeVendor\WPDesk\Beacon\BeaconShouldShowStrategy;
class BeaconShowStrategy implements BeaconShouldShowStrategy
{
    public function shouldDisplay()
    {
        return \true;
    }
}
