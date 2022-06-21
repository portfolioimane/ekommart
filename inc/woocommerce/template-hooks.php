<?php

/**
 * =================================================
 * Hook ekommart_content_top
 * =================================================
 */
add_action('ekommart_content_top', 'ekommart_shop_messages', 10);

/**
 * =================================================
 * Hook ekommart_footer
 * =================================================
 */
add_action('ekommart_footer', 'ekommart_handheld_footer_bar', 25);

/**
 * =================================================
 * Hook ekommart_after_footer
 * =================================================
 */
add_action('ekommart_after_footer', 'ekommart_sticky_single_add_to_cart', 999);