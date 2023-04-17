<?php

namespace DomenART\Theme\Services;

use DomenART\Theme\Service;
use DomenART\Theme\Service_Container;

/**
 * Class PostTypes
 *
 * @package DomenART\Theme
 */
class PostTypes implements Service
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
        \add_action('init', [$this, 'register_post_types']);
    }

    /**
     * @return string
     */
    public function get_service_name(): string
    {
        return 'post_types';
    }

    public function register_post_types(): void
    {
    }

}
