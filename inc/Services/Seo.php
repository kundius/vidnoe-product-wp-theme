<?php

namespace DomenART\Theme\Services;

use DomenART\Theme\Service;
use DomenART\Theme\Service_Container;

/**
 * Class Seo
 *
 * @package DomenART\Theme
 */
class Seo implements Service
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
        \remove_action('wp_head', 'rel_canonical');
        \add_action('wp_head', [$this, 'add_canonical']);
        \add_action('wp_head', [$this, 'add_meta']);
        \add_action('acf/init', [$this, 'register_acf_fields']);
    }

    /**
     * @return string
     */
    public function get_service_name(): string
    {
        return 'seo';
    }

    public function register_acf_fields(): void
    {
        \acf_add_local_field_group([
            'key' => 'group_theme_seo',
            'title' => 'SEO',
            'fields' => [
                [
                    'key' => 'field_theme_seo_title',
                    'label' => 'Заголовок',
                    'name' => 'theme_seo_title',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_theme_seo_keywords',
                    'label' => 'Ключевые слова',
                    'name' => 'theme_seo_keywords',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_theme_seo_description',
                    'label' => 'Описание',
                    'name' => 'theme_seo_description',
                    'type' => 'textarea',
                    'rows' => 3,
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ],
                ],
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ],
                ],
            ],
        ]);
    }

    public function add_meta(): void
    {
        $title = '';
        $description = '';
        $keywords = '';

        if (is_archive()) {
            $term = \get_term_by('slug', \get_query_var('term'), \get_query_var('taxonomy'));
            if ($term) {
                $title = \get_field('title', $term->taxonomy . '_' . $term->term_id);
                if (empty($title)) {
                    $title = $term->name;
                }
                $description = \get_field('theme_seo_description', $term->taxonomy . '_' . $term->term_id);
                $keywords = \get_field('theme_seo_keywords', $term->taxonomy . '_' . $term->term_id);
            } elseif (\is_post_type_archive()) {
                $title = \get_queried_object()->labels->name;
            } elseif (\is_day()) {
                $title = sprintf(__('Daily Archives: %s', 'roots'), \get_the_date());
            } elseif (\is_month()) {
                $title = sprintf(__('Monthly Archives: %s', 'roots'), \get_the_date('F Y'));
            } elseif (\is_year()) {
                $title = sprintf(__('Yearly Archives: %s', 'roots'), \get_the_date('Y'));
            } elseif (\is_author()) {
                $author = \get_queried_object();
                $title = sprintf(__('Author Archives: %s', 'roots'), $author->display_name);
            } else {
                $title = \single_cat_title('', false);
            }
        } elseif (\is_search()) {
            $title = sprintf(__('Search Results for %s', 'roots'), \get_search_query());
        } elseif (\is_404()) {
            $title = 'Not Found';
        } else {
            $title = \get_field('theme_seo_title');
            if (empty($title)) {
                $title = \get_the_title();
            }
            $description = \get_field('theme_seo_description');
            $keywords = \get_field('theme_seo_keywords');
        }

        if (!empty($title)) {
            echo '<title>' . $title . '</title>';
        }

        if (!empty($keywords)) {
            echo '<meta name="keywords" content="' . $keywords . '">';
        }

        if (!empty($description)) {
            echo '<meta name="description" content="' . $description . '">';
        }
    }

    public function add_canonical(): void
    {
        if (!\is_singular()) {
            return;
        }

        $id = \get_queried_object_id();

        if (0 === $id) {
            return;
        }

        $url = \wp_get_canonical_url($id);

        if (!empty($url)) {
            echo '<link rel="canonical" itemprop="url" href="' . \esc_url($url) . '" />' . "\n";
        }
    }

}
