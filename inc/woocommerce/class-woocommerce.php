<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Ekommart_WooCommerce')) :

    /**
     * The Ekommart WooCommerce Integration class
     */
    class Ekommart_WooCommerce {

        public $list_shortcodes;

        private $prefix = 'remove';

        /**
         * Setup class.
         *
         * @since 1.0
         */
        
         public function __construct() {
           add_action('wp_enqueue_scripts', array($this, 'woocommerce_scripts'), 20);
           
        }

         public function woocommerce_scripts() {
            global $ekommart_version;
            wp_register_script('ekommart-cart-canvas', get_template_directory_uri() . '/assets/js/woocommerce/cart-canvas' . $suffix . '.js', array(), $ekommart_version, true);

        }

         public function woocommerce_scripts() {
            global $ekommart_version;

            if (is_product()) {
                wp_register_script('ekommart-sticky-add-to-cart', get_template_directory_uri() . '/assets/js/sticky-add-to-cart' . $suffix . '.js', array(), $ekommart_version, true);
            }

    }

endif;

return new Ekommart_WooCommerce();
