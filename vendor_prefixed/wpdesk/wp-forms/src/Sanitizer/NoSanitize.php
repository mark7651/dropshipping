<?php

namespace DropshippingXmlFreeVendor\WPDesk\Forms\Sanitizer;

use DropshippingXmlFreeVendor\WPDesk\Forms\Sanitizer;
class NoSanitize implements Sanitizer
{
    public function sanitize($value)
    {
        return $value;
    }
}
