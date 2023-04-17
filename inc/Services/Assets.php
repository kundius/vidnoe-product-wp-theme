<?php

namespace DomenART\Theme\Services;

use DomenART\Theme\Service;
use DomenART\Theme\Service_Container;

/**
 * Class Assets
 *
 * @package DomenART\Theme
 */
class Assets implements Service
{

    /**
     * @param Service_Container $container
     */
    public function register(Service_Container $container): void
    {
    }

    /**
     * @param Service_Container $container
     */
    public function boot(Service_Container $container): void
    {
        add_action('wp', [$this, 'register_assets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_print_styles', [$this, 'enqueue_styles']);
        add_filter('stylesheet_uri', [$this, 'stylesheet_uri']);
        add_action('init', [$this, 'jquery_remove']);
    }

    /**
     * @return string
     */
    public function get_service_name(): string
    {
        return 'assets';
    }

    public function register_assets(): void
    {
        $theme = wp_get_theme();

        \wp_register_style('theme-style', \get_stylesheet_uri(), [], $theme->get('Version'));
        \wp_register_script('scripts', \get_theme_file_uri('dist/scripts/bundle.js'), null, null, true);
    }

    public function enqueue_scripts(): void
    {
        \wp_enqueue_script('scripts');
    }

    public function enqueue_styles(): void
    {
        \wp_enqueue_style('theme-style');
    }

    public function stylesheet_uri(string $stylesheet_uri): string
    {
        $file = 'dist/styles/bundle.css';

        if (file_exists(\get_theme_file_path($file))) {
            return \get_theme_file_uri($file);
        }

        return $stylesheet_uri;
    }

    public function jquery_remove(): void
    {
        if (!\is_admin()) {
            \wp_deregister_script('jquery');
            \wp_register_script('jquery', false);
        }
    }

}
