<?php

if (!function_exists('ekommart_site_branding')) {
    /**
     * Site branding wrapper and display
     *
     * @return void
     * @since  1.0.0
     */
    function ekommart_site_branding() {
        ?>
        <div class="site-branding">
            <?php echo ekommart_site_title_or_logo(); ?>
        </div>
        <?php
    }
}

if (!function_exists('ekommart_site_title_or_logo')) {
    /**
     * Display the site title or logo
     *
     * @param bool $echo Echo the string or return it.
     *
     * @return string
     * @since 2.1.0
     */
    function ekommart_site_title_or_logo() {
        ob_start();
        the_custom_logo(); ?>
        <div class="site-branding-text">
            <?php if (is_front_page()) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                          rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                         rel="home"><?php bloginfo('name'); ?></a></p>
            <?php endif; ?>

            <?php
            $description = get_bloginfo('description', 'display');

            if ($description || is_customize_preview()) :
                ?>
                <p class="site-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div><!-- .site-branding-text -->
        <?php
        $html = ob_get_clean();
        return $html;
    }


if (!function_exists('ekommart_mobile_navigation')) {
    /**
     * Display Handheld Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function ekommart_mobile_navigation() {
        ?>
        <nav class="mobile-navigation" aria-label="<?php esc_html_e('Mobile Navigation', 'ekommart'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'handheld',
                    'container_class' => 'handheld-navigation',
                )
            );
            ?>
        </nav>
        <?php
    }
}


    if (!function_exists('ekommart_mobile_nav')) {
    function ekommart_mobile_nav() {
        if (isset(get_nav_menu_locations()['handheld'])) {
            ?>
            <div class="ekommart-mobile-nav">
                <a href="#" class="mobile-nav-close"><i class="ekommart-icon-times"></i></a>
                <?php
                ekommart_language_switcher_mobile();
                ekommart_mobile_navigation();
                ekommart_social();
                ?>
            </div>
            <div class="ekommart-overlay"></div>
            <?php
        }
    }
}

if (!function_exists('ekommart_mobile_nav_button')) {
    function ekommart_mobile_nav_button() {
        if (isset(get_nav_menu_locations()['handheld'])) {
        wp_enqueue_script('ekommart-nav-mobile');
            ?>
            <a href="#" class="menu-mobile-nav-button">
                <span class="toggle-text screen-reader-text"><?php echo esc_attr(apply_filters('ekommart_menu_toggle_text', esc_html__('Menu', 'ekommart'))); ?></span>
            <i class="ekommart-icon-bars"></i>
            </a>
            <?php
        }
    }
}

if (!function_exists('ekommart_social')) {
    function ekommart_social() {
        $social_list = ekommart_get_theme_option('social_text', []);
        if (count($social_list) < 0) {
            return;
        }
        ?>
        <div class="ekommart-social">
            <ul>
                <?php

                foreach ($social_list as $social_item) {
                    ?>
                    <li><a href="<?php echo esc_url($social_item); ?>"></a></li>
                    <?php
                }
                ?>

            </ul>
        </div>
        <?php
    }
}

if (!function_exists('ekommart_language_switcher')) {
    function ekommart_language_switcher() {
        $languages = apply_filters('wpml_active_languages', []);
        if (!ekommart_is_wpml_activated() || count($languages) <= 0) {
            return;
        }
        ?>
        <div class="ekommart-language-switcher">
            <ul class="menu">
                <li class="item">
                    <span>
                        <img width="18" height="12" src="<?php echo esc_url($languages[ICL_LANGUAGE_CODE]['country_flag_url']) ?>" alt="<?php esc_attr($languages[ICL_LANGUAGE_CODE]['default_locale']) ?>">
                        <?php
                        echo esc_html($languages[ICL_LANGUAGE_CODE]['translated_name']);
                        ?>
                    </span>
                    <ul class="sub-item">
                        <?php
                        foreach ($languages as $key => $language) {
                            if (ICL_LANGUAGE_CODE === $key) {
                                continue;
                            }
                            ?>
                            <li>
                                <a href="<?php echo esc_url($language['url']) ?>">
                                    <img width="18" height="12" src="<?php echo esc_url($language['country_flag_url']) ?>" alt="<?php esc_attr($language['default_locale']) ?>">
                                    <?php echo esc_html($language['translated_name']); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <?php
    }
}

if (!function_exists('ekommart_language_switcher_mobile')) {
    function ekommart_language_switcher_mobile() {
        $languages = apply_filters('wpml_active_languages', []);
        if (!ekommart_is_wpml_activated() || count($languages) <= 0) {
            return;
        }
        ?>
        <div class="ekommart-language-switcher-mobile">
            <span>
                <img width="18" height="12" src="<?php echo esc_url($languages[ICL_LANGUAGE_CODE]['country_flag_url']) ?>" alt="<?php esc_attr($languages[ICL_LANGUAGE_CODE]['default_locale']) ?>">
            </span>
            <?php
            foreach ($languages as $key => $language) {
                if (ICL_LANGUAGE_CODE === $key) {
                    continue;
                }
                ?>
                <a href="<?php echo esc_url($language['url']) ?>">
                    <img width="18" height="12" src="<?php echo esc_url($language['country_flag_url']) ?>" alt="<?php esc_attr($language['default_locale']) ?>">
                </a>
                <?php
            }
            ?>
        </div>
        <?php
    }
}


if (!function_exists('ekommart_header_contact_info')) {
    function ekommart_header_contact_info() {
        echo ekommart_get_theme_option('contact-info', '');
    }

}


if (!function_exists('ekommart_header_account')) {
    function ekommart_header_account() {

        if (!ekommart_get_theme_option('show-header-account', true)) {
            return;
        }

        if (ekommart_is_woocommerce_activated()) {
            $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
        } else {
            $account_link = wp_login_url();
        }
        ?>
        <div class="site-header-account">
            <a href="<?php echo esc_html($account_link); ?>"><i class="ekommart-icon-user"></i></a>
            <div class="account-dropdown">

            </div>
        </div>
        <?php
    }
}

if (!function_exists('ekommart_template_account_dropdown')) {
    function ekommart_template_account_dropdown() {
        if (!ekommart_get_theme_option('show-header-account', true)) {
            return;
        }
        ?>
        <div class="account-wrap" style="display: none;">
            <div class="account-inner <?php if (is_user_logged_in()): echo "dashboard"; endif; ?>">
                <?php if (!is_user_logged_in()) {
                    ekommart_form_login();
                } else {
                    ekommart_account_dropdown();
                }
                ?>
            </div>
        </div>
        <?php
    }
}


if (!function_exists('ekommart_form_login')) {
    function ekommart_form_login() { ?>

        <div class="login-form-head">
            <span class="login-form-title"><?php esc_attr_e('Sign in', 'ekommart') ?></span>
            <span class="pull-right">
                <a class="register-link" href="<?php echo esc_url(wp_registration_url()); ?>"
                   title="<?php esc_attr_e('Register', 'ekommart'); ?>"><?php esc_attr_e('Create an Account', 'ekommart'); ?></a>
            </span>
        </div>
        <form class="ekommart-login-form-ajax" data-toggle="validator">
            <p>
                <label><?php esc_attr_e('Username or email', 'ekommart'); ?> <span class="required">*</span></label>
                <input name="username" type="text" required placeholder="<?php esc_attr_e('Username', 'ekommart') ?>">
            </p>
            <p>
                <label><?php esc_attr_e('Password', 'ekommart'); ?> <span class="required">*</span></label>
                <input name="password" type="password" required placeholder="<?php esc_attr_e('Password', 'ekommart') ?>">
            </p>
            <button type="submit" data-button-action class="btn btn-primary btn-block w-100 mt-1"><?php esc_html_e('Login', 'ekommart') ?></button>
            <input type="hidden" name="action" value="ekommart_login">
            <?php wp_nonce_field('ajax-ekommart-login-nonce', 'security-login'); ?>
        </form>
        <div class="login-form-bottom">
            <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>" class="lostpass-link" title="<?php esc_attr_e('Lost your password?', 'ekommart'); ?>"><?php esc_attr_e('Lost your password?', 'ekommart'); ?></a>
        </div>
        <?php
    }
}

if (!function_exists('')) {
    function ekommart_account_dropdown() { ?>
        <?php if (has_nav_menu('my-account')) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e('Dashboard', 'ekommart'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'my-account',
                    'menu_class'     => 'account-links-menu',
                    'depth'          => 1,
                ));
                ?>
            </nav><!-- .social-navigation -->
        <?php else: ?>
            <ul class="account-dashboard">

                <?php if (ekommart_is_woocommerce_activated()): ?>
                    <li>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" title="<?php esc_html_e('Dashboard', 'ekommart'); ?>"><?php esc_html_e('Dashboard', 'ekommart'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" title="<?php esc_html_e('Orders', 'ekommart'); ?>"><?php esc_html_e('Orders', 'ekommart'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>" title="<?php esc_html_e('Downloads', 'ekommart'); ?>"><?php esc_html_e('Downloads', 'ekommart'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>" title="<?php esc_html_e('Edit Address', 'ekommart'); ?>"><?php esc_html_e('Edit Address', 'ekommart'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" title="<?php esc_html_e('Account Details', 'ekommart'); ?>"><?php esc_html_e('Account Details', 'ekommart'); ?></a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo esc_url(get_dashboard_url(get_current_user_id())); ?>" title="<?php esc_html_e('Dashboard', 'ekommart'); ?>"><?php esc_html_e('Dashboard', 'ekommart'); ?></a>
                    </li>
                <?php endif; ?>
                <li>
                    <a title="<?php esc_html_e('Log out', 'ekommart'); ?>" class="tips" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log Out', 'ekommart'); ?></a>
                </li>
            </ul>
        <?php endif;

    }
}


if (!function_exists('ekommart_primary_navigation')) {
    /**
     * Display Primary Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function ekommart_primary_navigation() {
        ?>
        <nav class="main-navigation" role="navigation" aria-label="<?php esc_html_e('Primary Navigation', 'ekommart'); ?>">
            <?php
            $args = apply_filters('ekommart_nav_menu_args', [
                'fallback_cb'     => '__return_empty_string',
                'theme_location'  => 'primary',
                'container_class' => 'primary-navigation',
            ]);
            wp_nav_menu($args);
            ?>
        </nav>
        <?php
    }
}

if (!function_exists('ekommart_footer_default')) {
    function ekommart_footer_default() {
        ekommart_footer_widgets();
        get_template_part('template-parts/copyright');
    }
}


if (!function_exists('ekommart_footer_widgets')) {
    /**
     * Display the footer widget regions.
     *
     * @return void
     * @since  1.0.0
     */
    function ekommart_footer_widgets() {
        $rows    = intval(apply_filters('ekommart_footer_widget_rows', 1));
        $regions = intval(apply_filters('ekommart_footer_widget_columns', 5));
        for ($row = 1; $row <= $rows; $row++) :

            // Defines the number of active columns in this footer row.
            for ($region = $regions; 0 < $region; $region--) {
                if (is_active_sidebar('footer-' . esc_attr($region + $regions * ($row - 1)))) {
                    $columns = $region;
                    break;
                }
            }

            if (isset($columns)) :
                ?>
                <div class="col-full">
                    <div class=<?php echo '"footer-widgets row-' . esc_attr($row) . ' col-' . esc_attr($columns) . ' fix"'; ?>>
                        <?php
                        for ($column = 1; $column <= $columns; $column++) :
                            $footer_n = $column + $regions * ($row - 1);

                            if (is_active_sidebar('footer-' . esc_attr($footer_n))) :
                                ?>
                                <div class="block footer-widget-<?php echo esc_attr($column); ?>">
                                    <?php dynamic_sidebar('footer-' . esc_attr($footer_n)); ?>
                                </div>
                            <?php
                            endif;
                        endfor;
                        ?>
                    </div><!-- .footer-widgets.row-<?php echo esc_attr($row); ?> -->
                </div>
                <?php
                unset($columns);
            endif;
        endfor;
    }
}


if (!function_exists('ekommart_credit')) {
    /**
     * Display the theme credit
     *
     * @return void
     * @since  1.0.0
     */
    function ekommart_credit() {
        ?>
        <div class="site-info">
            <?php echo apply_filters('ekommart_copyright_text', $content = esc_html__('Copyright', 'ekommart') . ' &copy; ' . date('Y') . ' ' . '<a class="site-url" href="' . site_url() . '">' . get_bloginfo('name') . '</a>' . esc_html__('. All Rights Reserved.', 'ekommart')); ?>
        </div><!-- .site-info -->
        <?php
    }
}