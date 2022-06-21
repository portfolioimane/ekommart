<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Ekommart_Customize')) {

    class Ekommart_Customize {


        public function __construct() {
          add_action('customize_register', array($this, 'customize_register'));
        }

        public function customize_register($wp_customize) {
            $this->ekommart_header_sticky($wp_customize);

        }
        
                public function ekommart_header_sticky($wp_customize) {

            $wp_customize->add_section('ekommart_header_sticky', array(
                'title' => esc_html__('Header Sticky', 'ekommart'),
            ));

            $wp_customize->add_setting('ekommart_options_show_header_sticky', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('ekommart_options_show_header_sticky', array(
                'type'    => 'checkbox',
                'section' => 'ekommart_header_sticky',
                'label'   => esc_html__('Show Header Sticky', 'ekommart'),
            ));

            $wp_customize->add_setting('ekommart_options_color_header_sticky', array(
                'type'              => 'option',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'ekommart_options_color_header_sticky',
                    array(
                        'label'   => __('Color Header Sticky', 'ekommart'),
                        'section' => 'ekommart_header_sticky',
                    ))
            );

            $wp_customize->add_setting('ekommart_options_background_header_sticky', array(
                'type'              => 'option',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'ekommart_options_background_header_sticky',
                    array(
                        'label'   => __('Background Header Sticky', 'ekommart'),
                        'section' => 'ekommart_header_sticky',
                    ))
            );

        }


    }
}