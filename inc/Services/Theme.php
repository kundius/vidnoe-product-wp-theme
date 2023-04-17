<?php

namespace DomenART\Theme\Services;

use DomenART\Theme\Service;
use DomenART\Theme\Service_Container;

class Theme implements Service
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
        $this->after_setup_theme();
    }

    /**
     * @return string
     */
    public function get_service_name(): string
    {
        return 'theme';
    }

    /**
     * After setup theme
     */
    public function after_setup_theme(): void
    {
        $this->add_theme_supports();
        $this->add_shortcodes();
        $this->i18n();
    }

    /**
     * Set theme supports
     */
    private function add_theme_supports(): void
    {
        // \add_filter('wpcf7_load_js', '__return_false');
        // \add_filter('wpcf7_load_css', '__return_false');

        \add_image_size('theme-medium', 600, 400, true);

        // Add the theme support basic elements
        \add_theme_support('align-wide');
        \add_theme_support('responsive-embeds');
        \add_theme_support('editor-styles');
        \add_theme_support('wp-block-styles');
        \add_theme_support('post-thumbnails');
        \add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'script', 'style']);
        \add_post_type_support('page', ['excerpt']);

        \add_action('admin_init', function() {
            if (isset($_GET['post'])) {
                $post_ID = $_GET['post'];
            } else if (isset($_POST['post_ID'])) {
                $post_ID = $_POST['post_ID'];
            }

            if (!isset($post_ID) || empty($post_ID)) {
                return;
            }

            $page_template = get_post_meta($post_ID, '_wp_page_template', true);
            if ($page_template == 'template-about.php') {
                remove_post_type_support('page', 'editor');
                remove_post_type_support('page', 'thumbnail');
            }
            // if ($page_template == 'template-contractors.php') {
            //     remove_post_type_support('page', 'editor');
            //     remove_post_type_support('page', 'thumbnail');
            // }
            // if ($page_template == 'template-price.php') {
            //     remove_post_type_support('page', 'editor');
            //     remove_post_type_support('page', 'thumbnail');
            // }
            // if ($page_template == 'template-services.php') {
            //     remove_post_type_support('page', 'editor');
            //     remove_post_type_support('page', 'thumbnail');
            // }
            // if ($page_template == 'template-catalog.php') {
            //     remove_post_type_support('page', 'editor');
            //     remove_post_type_support('page', 'thumbnail');
            // }
            // if ($page_template == 'template-downloads.php') {
            //     remove_post_type_support('page', 'editor');
            //     remove_post_type_support('page', 'thumbnail');
            // }
        });
    }

    private function add_shortcodes(): void
    {
        \add_shortcode('template_part', function ($atts, $content = null) {
            $tp_atts = \shortcode_atts([
                'path' =>  null,
            ], $atts);
            ob_start();
            \get_template_part($tp_atts['path']);
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        });
    }

    /**
     * i18n
     */
    private function i18n(): void
    {
        // Load theme texdomain
        \load_theme_textdomain('framework-textdomain', \get_theme_file_path('/languages'));
    }

    public static function cut_string($str, $length=50, $postfix='...')
    {
        if ( strlen($str) <= $length)
            return $str;

        $temp = substr($str, 0, $length);
        return substr($temp, 0, strrpos($temp, ' ') ) . $postfix;
    }

    public static function get_children_ids($post_parent)
    {
        $results = new \WP_Query([
          'post_type' => 'page',
          'post_parent' => $post_parent,
        ]);

        $child_ids = [];
        if ($results->found_posts > 0) {
          foreach ($results->posts as $post) {
            $child_ids[] = $post->ID;
          }
        }

        if (!empty($child_ids)) {
          foreach ($child_ids as $child_id) {
            $child_ids = array_merge($child_ids, self::get_children_ids($child_id));
          }
        }

        return $child_ids;
    }

    public static function excerpt($args = '') {
        global $post;

        if (is_string($args)) {
            parse_str($args, $args);
        }

        $rg = (object) array_merge([
            'maxchar'           => 350,
            'text'              => '',
            'autop'             => true,
            'more_text'         => '...',
            'ignore_more'       => false,
            'save_tags'         => '<strong><b><a><em><i><var><code><span>',
            'sanitize_callback' => static function(string $text, object $rg) {
                return strip_tags($text, $rg->save_tags);
            },
        ], $args);

        $rg = apply_filters( 'kama_excerpt_args', $rg );

        if( ! $rg->text ){
            $rg->text = $post->post_excerpt ?: $post->post_content;
        }

        $text = $rg->text;
        // strip content shortcodes: [foo]some data[/foo]. Consider markdown
        $text = preg_replace( '~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text );
        // strip others shortcodes: [singlepic id=3]. Consider markdown
        $text = preg_replace( '~\[/?[^\]]*\](?!\()~', '', $text );
        // strip direct URLs
        $text = preg_replace( '~(?<=\s)https?://.+\s~', '', $text );
        $text = trim( $text );

        // <!--more-->
        if( ! $rg->ignore_more && strpos( $text, '<!--more-->' ) ){

            preg_match( '/(.*)<!--more-->/s', $text, $mm );

            $text = trim( $mm[1] );

            $text_append = sprintf( ' <a href="%s#more-%d">%s</a>', get_permalink( $post ), $post->ID, $rg->more_text );
        }
        // text, excerpt, content
        else {

            $text = call_user_func( $rg->sanitize_callback, $text, $rg );
            $has_tags = false !== strpos( $text, '<' );

            // collect html tags
            if( $has_tags ){
                $tags_collection = [];
                $nn = 0;

                $text = preg_replace_callback( '/<[^>]+>/', static function( $match ) use ( & $tags_collection, & $nn ){
                    $nn++;
                    $holder = "~$nn";
                    $tags_collection[ $holder ] = $match[0];

                    return $holder;
                }, $text );
            }

            // cut text
            $cuted_text = mb_substr( $text, 0, $rg->maxchar );
            if( $text !== $cuted_text ){

                // del last word, it not complate in 99%
                $text = preg_replace( '/(.*)\s\S*$/s', '\\1...', trim( $cuted_text ) );
            }

            // bring html tags back
            if( $has_tags ){
                $text = strtr( $text, $tags_collection );
                $text = force_balance_tags( $text );
            }
        }

        // add <p> tags. Simple analog of wpautop()
        if( $rg->autop ){

            $text = preg_replace(
                [ "/\r/", "/\n{2,}/", "/\n/" ],
                [ '', '</p><p>', '<br />' ],
                "<p>$text</p>"
            );
        }

        $text = apply_filters( 'kama_excerpt', $text, $rg );

        if( isset( $text_append ) ){
            $text .= $text_append;
        }

        return $text;
    }
}
