<?php
$theme            = wp_get_theme( 'ekommart' );
$ekommart_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$ekommart = (object) array(
    'version' => $ekommart_version,
    /**
     * Initialize all the things.
     */
    'main'    => require 'inc/class-main.php',
);

if ( ! is_user_logged_in() ) {
    require get_theme_file_path('inc/modules/class-login.php');
}






require get_theme_file_path('inc/functions.php');