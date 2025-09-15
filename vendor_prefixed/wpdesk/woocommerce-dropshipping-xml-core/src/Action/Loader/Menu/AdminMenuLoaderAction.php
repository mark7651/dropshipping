<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Menu;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Menu\Abstraction\MainMenuInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Menu\Abstraction\SubMenuInterface;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Conditional\Conditional;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Service\Listener\Items\Hookable\Hookable;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Config\Config;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\View\ViewAction;
/**
 * Class AdminMenuLoaderAction, admin menu loader.
 */
class AdminMenuLoaderAction implements Hookable, Conditional
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var ViewAction
     */
    private $view;
    public function __construct(Config $config, ViewAction $view)
    {
        $this->config = $config;
        $this->view = $view;
    }
    public function isActive(): bool
    {
        return is_admin();
    }
    public function hooks()
    {
        add_action('admin_menu', [$this, 'adminMenu'], 10);
    }
    public function adminMenu()
    {
        $menus = $this->config->get_param('menu');
        if ($menus->isArray() && !$menus->isEmpty()) {
            foreach ($menus->get() as $menu) {
                if ($menu instanceof MainMenuInterface) {
                    $this->create_main_menu($menu);
                    foreach ($menu->get_submenus() as $sub) {
                        $this->create_sub_menu($sub);
                    }
                } elseif ($menu instanceof SubMenuInterface) {
                    $this->create_sub_menu($menu);
                }
            }
        }
    }
    private function create_main_menu(MainMenuInterface $menu)
    {
        global $submenu;
        add_menu_page($menu->get_title(), $menu->get_title(), $menu->get_capability(), $menu->get_slug(), [$this->view, 'show'], $menu->get_icon(), $menu->get_position());
        if ($menu->is_hidden()) {
            $submenu[$menu->get_slug()] = [];
        }
    }
    private function create_sub_menu(SubMenuInterface $menu)
    {
        add_submenu_page($menu->is_hidden() ? null : $menu->get_parent_slug(), $menu->get_title(), $menu->get_title(), $menu->get_capability(), $menu->get_slug(), [$this->view, 'show'], $menu->get_position());
    }
}
