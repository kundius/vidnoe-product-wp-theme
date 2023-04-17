<?php

namespace DomenART\Theme\Services;

use DomenART\Theme\Service;
use DomenART\Theme\Service_Container;

/**
 * Class Ajax
 *
 * @package DomenART\Theme
 */
class Ajax implements Service
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
        \add_action('wp_enqueue_scripts', [$this, 'ajax_data'], 99);

        \add_action('wp_ajax_get_attachment', [$this, 'get_attachment_callback']);
        \add_action('wp_ajax_nopriv_get_attachment', [$this, 'get_attachment_callback']);
    }

    /**
     * @return string
     */
    public function get_service_name(): string
    {
        return 'acf';
    }

    public function ajax_data(): void
    {
        \wp_localize_script('scripts', 'theme_ajax', [
            'url' => \admin_url('admin-ajax.php'),
        ]);
    }

    public function get_attachment_callback(): void
    {

        $id = intval($_POST['id']);

        if (!$id) {
            echo json_encode([
                'success' => false,
            ]);

            \wp_die();
        }

        echo json_encode([
            'success' => true,
            'data' => [
                'title' => \get_the_title($id),
                'url' => \wp_get_attachment_url($id),
                'caption' => \wp_get_attachment_caption($id),
            ],
        ]);

        \wp_die();
    }

}
