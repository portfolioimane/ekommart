<?php


if (!function_exists('ekommart_product_search')) {
    /**
     * Display Product Search
     *
     * @return void
     * @uses  ekommart_is_woocommerce_activated() check if WooCommerce is activated
     * @since  1.0.0
     */
    function ekommart_product_search() {
        if (!ekommart_get_theme_option('show-header-search', true)) {
            return;
        }
        if (ekommart_is_woocommerce_activated()) {
            ?>
            <div class="site-search">
                <?php the_widget('WC_Widget_Product_Search', 'title='); ?>
            </div>
            <?php
        }
    }
}

    if (!function_exists('ekommart_cart_link')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since  1.0.0
     */
    function ekommart_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'ekommart'); ?>">
            <?php /* translators: %d: number of items in cart */ ?>
            <span class="count"><?php echo wp_kses_data(sprintf(_n('%d', '%d', WC()->cart->get_cart_contents_count(), 'ekommart'), WC()->cart->get_cart_contents_count())); ?></span>
            <?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?>
        </a>
        <?php
    }
}

if (!function_exists('ekommart_header_wishlist')) {
    function ekommart_header_wishlist() {
        if (function_exists('yith_wcwl_count_all_products')) {
            if (!ekommart_get_theme_option('show-header-wishlist', true)) {
                return;
            }
            ?>
            <div class="site-header-wishlist">
                <a class="header-wishlist" href="<?php echo esc_url(get_permalink(get_option('yith_wcwl_wishlist_page_id'))); ?>">
                    <i class="ekommart-icon-heart"></i>
                    <span class="count"><?php echo esc_html(yith_wcwl_count_all_products()); ?></span>
                </a>
            </div>
            <?php
        } elseif (function_exists('woosw_init')) {
            $key = WPCleverWoosw::get_key();

            ?>
            <div class="site-header-wishlist">
                <a class="header-wishlist" href="<?php echo esc_url(WPCleverWoosw::get_url( $key, true )); ?>">
                    <i class="ekommart-icon-heart"></i>
                    <span class="count"><?php echo esc_html(WPCleverWoosw::get_count($key)); ?></span>
                </a>
            </div>
            <?php
        }
    }
}

if (!function_exists('ekommart_header_cart')) {
    /**
     * Display Header Cart
     *
     * @return void
     * @uses  ekommart_is_woocommerce_activated() check if WooCommerce is activated
     * @since  1.0.0
     */
    function ekommart_header_cart() {
        if (ekommart_is_woocommerce_activated()) {
            if (!ekommart_get_theme_option('show-header-cart', true)) {
                return;
            }
            ?>
            <div class="site-header-cart menu">
            <?php ekommart_cart_link(); ?>
                <?php

                if (!apply_filters('woocommerce_widget_cart_is_hidden', is_cart() || is_checkout())) {

                    if (ekommart_get_theme_option('header-cart-dropdown', 'side') == 'side') {
                        wp_enqueue_script('ekommart-cart-canvas');
                        add_action('wp_footer', 'ekommart_header_cart_side');
                    } else {
                        the_widget('WC_Widget_Cart', 'title=');
                    }

                }

                ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('ekommart_header_cart_side')) {
    function ekommart_header_cart_side() {
        if (ekommart_is_woocommerce_activated()) {
            ?>
            <div class="site-header-cart-side">
                <div class="cart-side-heading">
                    <span class="cart-side-title"><?php echo esc_html__('Shopping cart', 'ekommart'); ?></span>
                    <a href="#" class="close-cart-side"><?php echo esc_html__('close', 'ekommart') ?></a></div>
                <?php the_widget('WC_Widget_Cart', 'title='); ?>
            </div>
            <div class="cart-side-overlay"></div>
            <?php
        }
    }
}

if (!function_exists('ekommart_shop_messages')) {
    /**
     * ThemeBase shop messages
     *
     * @since   1.4.4
     * @uses    ekommart_do_shortcode
     */
    function ekommart_shop_messages() {
        if (!is_checkout()) {
            echo wp_kses_post(ekommart_do_shortcode('woocommerce_messages'));
        }
    }

    if (!function_exists('ekommart_handheld_footer_bar')) {
    /**
     * Display a menu intended for use on handheld devices
     *
     * @since 2.0.0
     */
    function ekommart_handheld_footer_bar() {
        $links = array(
            'shop'       => array(
                'priority' => 5,
                'callback' => 'ekommart_handheld_footer_bar_shop_link',
            ),
            'my-account' => array(
                'priority' => 10,
                'callback' => 'ekommart_handheld_footer_bar_account_link',
            ),
            'search'     => array(
                'priority' => 20,
                'callback' => 'ekommart_handheld_footer_bar_search',
            ),
            'wishlist'   => array(
                'priority' => 30,
                'callback' => 'ekommart_handheld_footer_bar_wishlist',
            ),
        );

        if (wc_get_page_id('myaccount') === -1) {
            unset($links['my-account']);
        }

        if (!function_exists('yith_wcwl_count_all_products') && !function_exists('woosw_init')) {
            unset($links['wishlist']);
        }

        $links = apply_filters('ekommart_handheld_footer_bar_links', $links);
        ?>
        <div class="ekommart-handheld-footer-bar">
            <ul class="columns-<?php echo count($links); ?>">
                <?php foreach ($links as $key => $link) : ?>
                    <li class="<?php echo esc_attr($key); ?>">
                        <?php
                        if ($link['callback']) {
                            call_user_func($link['callback'], $key, $link);
                        }
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}

if (!function_exists('ekommart_handheld_footer_bar_search')) {
    /**
     * The search callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function ekommart_handheld_footer_bar_search() {
        ?>
        <a href=""><span class="title"><?php echo esc_html__('Search', 'ekommart'); ?></span></a>
        <div class="site-search">
            <?php the_widget('WC_Widget_Product_Search', 'title='); ?>
        </div>
        <?php
    }
}

if (!function_exists('ekommart_handheld_footer_bar_cart_link')) {
    /**
     * The cart callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function ekommart_handheld_footer_bar_cart_link() {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'ekommart'); ?>">
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('ekommart_handheld_footer_bar_account_link')) {
    /**
     * The account callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function ekommart_handheld_footer_bar_account_link() {
        echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) . '"><span class="title">' . esc_attr__('My Account', 'ekommart') . '</span></a>';
    }
}

if (!function_exists('ekommart_handheld_footer_bar_shop_link')) {
    /**
     * The shop callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function ekommart_handheld_footer_bar_shop_link() {
        echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_shop_page_id'))) . '"><span class="title">' . esc_attr__('Shop', 'ekommart') . '</span></a>';
    }
}

if (!function_exists('ekommart_handheld_footer_bar_wishlist')) {
    /**
     * The wishlist callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function ekommart_handheld_footer_bar_wishlist() {
        if (function_exists('yith_wcwl_count_all_products')) {
            ?>
            <a class="footer-wishlist" href="<?php echo esc_url(get_permalink(get_option('yith_wcwl_wishlist_page_id'))); ?>">
                <span class="title"><?php echo esc_html__('Wishlist', 'ekommart'); ?></span>
                <span class="count"><?php echo esc_html(yith_wcwl_count_all_products()); ?></span>
            </a>
            <?php
        }elseif (function_exists('woosw_init')) {
            $key = WPCleverWoosw::get_key();

            ?>
            <a class="footer-wishlist" href="<?php echo esc_url(WPCleverWoosw::get_url( $key, true )); ?>">
                <span class="title"><?php echo esc_html__('Wishlist', 'ekommart'); ?></span>
                <span class="count"><?php echo esc_html(WPCleverWoosw::get_count($key)); ?></span>
            </a>
            <?php
        }
    }
}

if (!function_exists('ekommart_sticky_single_add_to_cart')) {
    /**
     * Sticky Add to Cart
     *
     * @since 2.3.0
     */
    function ekommart_sticky_single_add_to_cart() {
        global $product;

        if (!is_product()) {
            return;
        }

        $show = false;

        if ($product->is_purchasable() && $product->is_in_stock()) {
            $show = true;
        } else if ($product->is_type('external')) {
            $show = true;
        }

        if (!$show) {
            return;
        }

        $params = apply_filters(
            'ekommart_sticky_add_to_cart_params', array(
                'trigger_class' => 'entry-summary',
            )
        );

        wp_localize_script('ekommart-sticky-add-to-cart', 'ekommart_sticky_add_to_cart_params', $params);
        wp_dequeue_script('ekommart-sticky-header');
        wp_enqueue_script('ekommart-sticky-add-to-cart');
        ?>

        <section class="ekommart-sticky-add-to-cart">
            <div class="col-full">
                <div class="ekommart-sticky-add-to-cart__content">
                    <?php echo wp_kses_post(woocommerce_get_product_thumbnail()); ?>
                    <div class="ekommart-sticky-add-to-cart__content-product-info">
                        <span class="ekommart-sticky-add-to-cart__content-title"><?php esc_attr_e('You\'re viewing:', 'ekommart'); ?>
                            <strong><?php the_title(); ?></strong></span>
                        <span class="ekommart-sticky-add-to-cart__content-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                        <?php echo wp_kses_post(wc_get_rating_html($product->get_average_rating())); ?>
                    </div>
                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="ekommart-sticky-add-to-cart__content-button button alt">
                        <?php echo esc_attr($product->add_to_cart_text()); ?>
                    </a>
                </div>
            </div>
        </section><!-- .ekommart-sticky-add-to-cart -->
        <?php
    }
}
}








