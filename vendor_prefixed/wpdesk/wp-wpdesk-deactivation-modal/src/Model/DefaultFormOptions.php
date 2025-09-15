<?php

namespace DropshippingXmlFreeVendor\WPDesk\DeactivationModal\Model;

use DropshippingXmlFreeVendor\WPDesk\DeactivationModal\Exception\DuplicatedFormOptionKeyException;
/**
 * Default list of plugin deactivation reason for plugins using older libraries.
 */
class DefaultFormOptions extends FormOptions
{
    /**
     * @throws DuplicatedFormOptionKeyException
     */
    public function __construct()
    {
        $this->set_option(new FormOption('plugin_stopped_working', 10, __('The plugin suddenly stopped working', 'dropshipping-xml-for-woocommerce')));
        $this->set_option(new FormOption('broke_my_site', 20, __('The plugin broke my site', 'dropshipping-xml-for-woocommerce')));
        $this->set_option(new FormOption('found_better_plugin', 30, __('I found a better plugin', 'dropshipping-xml-for-woocommerce'), null, __('What\'s the plugin\'s name?', 'dropshipping-xml-for-woocommerce')));
        $this->set_option(new FormOption('plugin_for_short_period', 40, __('I only needed the plugin for a short period', 'dropshipping-xml-for-woocommerce')));
        $this->set_option(new FormOption('no_longer_need', 50, __('I no longer need the plugin', 'dropshipping-xml-for-woocommerce')));
        $this->set_option(new FormOption('temporary_deactivation', 60, __('It\'s a temporary deactivation (I\'m just debugging an issue)', 'dropshipping-xml-for-woocommerce')));
        $this->set_option(new FormOption('other', 70, __('Other', 'dropshipping-xml-for-woocommerce'), null, __('Kindly tell us the reason so we can improve', 'dropshipping-xml-for-woocommerce')));
    }
}
