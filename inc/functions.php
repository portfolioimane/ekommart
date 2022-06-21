<?php
/**
 * Ekommart functions.
 *
 * @package ekommart
 */

if (!function_exists('ekommart_get_theme_option')) {
    function ekommart_get_theme_option($option_name, $default = false) {

        if ($option = get_option('ekommart_options_' . $option_name)) {
            $default = $option;
        }

        return  $default;
    }
}

function ekommart_header_styles() {
    $is_header_image = get_header_image();
    $header_bg_image = '';

    if ( $is_header_image ) {
        $header_bg_image = 'url(' . esc_url( $is_header_image ) . ')';
    }

    $styles = array();

    if ( '' !== $header_bg_image ) {
        $styles['background-image'] = $header_bg_image;
    }

    $styles = apply_filters( 'ekommart_header_styles', $styles );

    foreach ( $styles as $style => $value ) {
        echo esc_attr( $style . ': ' . $value . '; ' );
    }
}


if ( ! function_exists( 'ekommart_is_woocommerce_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function ekommart_is_woocommerce_activated() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
}

if (!function_exists('ekommart_get_theme_option')) {
    function ekommart_get_theme_option($option_name, $default = false) {

        if ($option = get_option('ekommart_options_' . $option_name)) {
            $default = $option;
        }

        return  $default;
    }
}

function ekommart_do_shortcode( $tag, array $atts = array(), $content = null ) {
    global $shortcode_tags;

    if ( ! isset( $shortcode_tags[ $tag ] ) ) {
        return false;
    }

    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}





