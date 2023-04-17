<?php

namespace DomenART\Theme\Services;

use DomenART\Theme\Service;
use DomenART\Theme\Service_Container;

/**
 * Class Menu
 *
 * @package DomenART\Theme
 */
class Menu implements Service
{
    /**
     * @param Service_Container $container
     */
    public function register(Service_Container $container): void
    {}

    /**
     * @param Service_Container $container
     */
    public function boot(Service_Container $container): void
    {
        add_theme_support('menus');

        $this->register_menus();
    }

    /**
     * @return string
     */
    public function get_service_name(): string
    {
        return 'menu';
    }

    public function register_menus(): void
    {
        $nav_menu = [
            'menu-main' => 'Основное меню',
            'menu-sitemap' => 'Карта сайта',
        ];
        register_nav_menus($nav_menu);
    }
}
