<?php

if (!defined('ABSPATH')) {
    exit;
}


if (!class_exists('Ekommart')) :

    /**
     * The main Ekommart class
     */
    class Ekommart {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            add_action('after_setup_theme', array($this, 'setup'));
            add_action('wp_enqueue_scripts', array($this, 'scripts'), 10);
            add_action('widgets_init', array($this, 'widgets_init'));
        }

         public function setup() {
           /**
             * Register menu locations.
             */
            register_nav_menus(
                apply_filters(
                    'ekommart_register_nav_menus', array(
                        'primary'  => esc_html__('Primary Menu', 'ekommart'),
                        'handheld' => esc_html__('Handheld Menu', 'ekommart'),
                        'vertical' => esc_html__('Vertical Menu', 'ekommart'),
                    )
                )
            );

            // Add theme support for Custom Logo.
            add_theme_support('custom-logo', array(
                'width'       => 300,
                'height'      => 200,
                'flex-width'  => true,
                'flex-height' => true,
            ));

        }

        public function scripts() {
            global $ekommart_version;
            wp_localize_script('ekomart-theme', 'ekommartAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
             wp_register_script('ekommart-sticky-header', get_template_directory_uri() . '/assets/js/frontend/sticky-header.js', array('jquery'), $ekommart_version, true);
        }

         /**
         * Register widget area.
         *
         * @link https://codex.wordpress.org/Function_Reference/register_sidebar
         */
    public function widgets_init() {
            $sidebar_args['sidebar']        = array(
                'name'        => esc_html__('Sidebar Archive', 'ekommart'),
                'id'          => 'sidebar-blog',
                'description' => '',
            );
            $sidebar_args['sidebar-single'] = array(
                'name'        => esc_html__('Sidebar Single Post', 'ekommart'),
                'id'          => 'sidebar-single',
                'description' => '',
            );

            $rows    = intval(apply_filters('ekommart_footer_widget_rows', 1));
            $regions = intval(apply_filters('ekommart_footer_widget_columns', 5));

            for ($row = 1; $row <= $rows; $row++) {
                for ($region = 1; $region <= $regions; $region++) {
                    $footer_n = $region + $regions * ($row - 1); // Defines footer sidebar ID.
                    $footer   = sprintf('footer_%d', $footer_n);

                    if (1 === $rows) {
                        /* translators: 1: column number */
                        $footer_region_name = sprintf(esc_html__('Footer Column %1$d', 'ekommart'), $region);

                        /* translators: 1: column number */
                        $footer_region_description = sprintf(esc_html__('Widgets added here will appear in column %1$d of the footer.', 'ekommart'), $region);
                    } else {
                        /* translators: 1: row number, 2: column number */
                        $footer_region_name = sprintf(esc_html__('Footer Row %1$d - Column %2$d', 'ekommart'), $row, $region);

                        /* translators: 1: column number, 2: row number */
                        $footer_region_description = sprintf(esc_html__('Widgets added here will appear in column %1$d of footer row %2$d.', 'ekommart'), $region, $row);
                    }

                    $sidebar_args[$footer] = array(
                        'name'        => $footer_region_name,
                        'id'          => sprintf('footer-%d', $footer_n),
                        'description' => $footer_region_description,
                    );
                }
            }

            $sidebar_args = apply_filters('ekommart_sidebar_args', $sidebar_args);

            foreach ($sidebar_args as $sidebar => $args) {
                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<span class="gamma widget-title">',
                    'after_title'   => '</span>',
                );

                /**
                 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
                 *
                 * 'ekommart_header_widget_tags'
                 * 'ekommart_sidebar_widget_tags'
                 *
                 * 'ekommart_footer_1_widget_tags'
                 * 'ekommart_footer_2_widget_tags'
                 * 'ekommart_footer_3_widget_tags'
                 * 'ekommart_footer_4_widget_tags'
                 */
                $filter_hook = sprintf('ekommart_%s_widget_tags', $sidebar);
                $widget_tags = apply_filters($filter_hook, $widget_tags);

                if (is_array($widget_tags)) {
                    register_sidebar($args + $widget_tags);
                }
            }
        }



}
