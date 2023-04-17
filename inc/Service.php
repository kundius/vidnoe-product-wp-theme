<?php
namespace DomenART\Theme;

/**
 * Interface Service
 *
 * @package DomenART\Theme
 */
interface Service
{

    /**
     * Register the service
     *
     * @param Service_Container $container
     */
    public function register(Service_Container $container): void;

    /**
     * Boot the service
     *
     * @param Service_Container $container
     */
    public function boot(Service_Container $container): void;

    /**
     * Get the service's name
     *
     * @return string
     */
    public function get_service_name(): string;
}
