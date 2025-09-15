<?php

namespace DropshippingXmlFreeVendor\WPDesk\Forms\Serializer;

use DropshippingXmlFreeVendor\WPDesk\Forms\Serializer;
class NoSerialize implements Serializer
{
    public function serialize($value)
    {
        return $value;
    }
    public function unserialize($value)
    {
        return $value;
    }
}
