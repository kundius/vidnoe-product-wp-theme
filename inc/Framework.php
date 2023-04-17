<?php

namespace DomenART\Theme;

use DomenART\Theme\Services\Assets;
use DomenART\Theme\Services\Editor;
use DomenART\Theme\Services\Editor_Patterns;
use DomenART\Theme\Services\Fonts;
use DomenART\Theme\Services\Menu;
use DomenART\Theme\Services\Seo;
use DomenART\Theme\Services\Acf;
use DomenART\Theme\Services\Ajax;
use DomenART\Theme\Services\Svg;
use DomenART\Theme\Services\Theme;
use DomenART\Theme\Services\PostTypes;
use DomenART\Theme\Tools\Body_Class;
use DomenART\Theme\Tools\Template_Parts;

/**
 * Class Framework
 * @author Milan Ricoul
 * @package DomenART\Theme
 */
class Framework
{
    /**
     * @var Service_Container
     */
    protected static $container;

    /**
     * @var array $services
     */
    protected static $services = [
        // Services
        Theme::class,
        Assets::class,
        Seo::class,
        Acf::class,
        Ajax::class,
        Fonts::class,
        Editor::class,
        Editor_Patterns::class,
        Svg::class,
        Menu::class,
        PostTypes::class,

        // Services as Tools
        Body_Class::class,
        Template_Parts::class,
    ];

    /**
     * @return Service_Container
     */
    public static function get_container(): Service_Container
    {
        if (is_null(self::$container)) {
            self::$container = new Service_Container();
            array_map([__CLASS__, 'register_service'], self::$services);
        }

        return self::$container;
    }

    /**
     * Register Service
     *
     * @param $name
     */
    public static function register_service($name): void
    {
        self::get_container()->register_service($name);
    }
}
