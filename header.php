<!doctype html>
<html <?php language_attributes(); ?> class="<?php echo apply_filters('html_class', $classes = 'no-js'); ?>" <?php echo apply_filters('html_attr', $attr = ''); ?>>

<head id="<?php echo str_replace('.', '-', $_SERVER['SERVER_NAME']); ?>">
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        (function(html) {
            html.className = html.className.replace(/\bno-js\b/, 'js')
        })(document.documentElement);
        var url = "<?php echo home_url(); ?>",
            page = "<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>",
            api = "<?php echo get_rest_url(); ?>",
            language = "<?php echo (function_exists('get_language') ? get_language() : ''); ?>",
            template = "<?php echo get_template_directory_uri(); ?>",
            i18n = {
                prev: "<?php _e('predchádzajúca', 'kno'); ?>",
                next: "<?php _e('ďalšia', 'kno'); ?>",
                map_text: "<?php _e('Zadajte mesto', 'kno'); ?>",
                map_notfound: "<?php _e('Mesto nebolo nájdené', 'kno'); ?>"
            },
            is_logged = <?php echo (is_user_logged_in()) ? 1 : 0; ?>;
    </script>
    <script type="text/javascript">
        window.gdprAppliesGlobally = true;
        (function() {
            function a(e) {
                if (!window.frames[e]) {
                    if (document.body && document.body.firstChild) {
                        var t = document.body;
                        var n = document.createElement("iframe");
                        n.style.display = "none";
                        n.name = e;
                        n.title = e;
                        t.insertBefore(n, t.firstChild)
                    } else {
                        setTimeout(function() {
                            a(e)
                        }, 5)
                    }
                }
            }

            function e(n, r, o, c, s) {
                function e(e, t, n, a) {
                    if (typeof n !== "function") {
                        return
                    }
                    if (!window[r]) {
                        window[r] = []
                    }
                    var i = false;
                    if (s) {
                        i = s(e, t, n)
                    }
                    if (!i) {
                        window[r].push({
                            command: e,
                            parameter: t,
                            callback: n,
                            version: a
                        })
                    }
                }
                e.stub = true;

                function t(a) {
                    if (!window[n] || window[n].stub !== true) {
                        return
                    }
                    if (!a.data) {
                        return
                    }
                    var i = typeof a.data === "string";
                    var e;
                    try {
                        e = i ? JSON.parse(a.data) : a.data
                    } catch (t) {
                        return
                    }
                    if (e[o]) {
                        var r = e[o];
                        window[n](r.command, r.parameter, function(e, t) {
                            var n = {};
                            n[c] = {
                                returnValue: e,
                                success: t,
                                callId: r.callId
                            };
                            a.source.postMessage(i ? JSON.stringify(n) : n, "*")
                        }, r.version)
                    }
                }
                if (typeof window[n] !== "function") {
                    window[n] = e;
                    if (window.addEventListener) {
                        window.addEventListener("message", t, false)
                    } else {
                        window.attachEvent("onmessage", t)
                    }
                }
            }
            e("__tcfapi", "__tcfapiBuffer", "__tcfapiCall", "__tcfapiReturn");
            a("__tcfapiLocator");
            (function(e) {
                var t = document.createElement("script");
                t.id = "spcloader";
                t.type = "text/javascript";
                t.async = true;
                t.src = "https://sdk.privacy-center.org/" + e + "/loader.js?target=" + document.location.hostname;
                t.charset = "utf-8";
                var n = document.getElementsByTagName("script")[0];
                n.parentNode.insertBefore(t, n)
            })("b149914c-df4a-49cc-8447-c9e5aaac6c60")
        })();
    </script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php do_action('body_top'); ?>
    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <linearGradient id="svg-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#5dd" />
                <stop offset="100%" style="stop-color:#75d" />
            </linearGradient>
        </defs>
    </svg>
    <a href="javascript:void(0);" class="burger print-hidden ns" aria-haspopup="true" aria-expanded="false" aria-label="<?php _e('Zobraziť menu', 'kno'); ?>"> <span class="burger--open">Menu</span><span class="burger--close">
            <?php _e('Zavrieť', 'kno'); ?>
        </span>
        <ul class="list-bare">
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </a>
    <nav class="mobile-menu print-hidden ns" role="navigation">
        <ul class="list-bare mobile-menu-content">
            <?php
            wp_nav_menu(array(
                'container' => false,
                'menu_class' => true,
                'menu_class_add' => 'mobile',
                'depth' => 3,
                'menu_id' => '',
                'theme_location' => 'primary-mobile',
                'items_wrap' => '%3$s',
                'position' => 'mobile',
                'walker' => new KNO_Walker_Nav_Menu()
            ));
            ?>
        </ul>
    </nav>
    <?php
    /*

       $countryNeedCookieBar = true;

       if ( function_exists( 'geoip_detect2_get_info_from_current_ip' ) ) {
           $userInfo    = geoip_detect2_get_info_from_current_ip();
           $countryCode = $userInfo->country->isoCode;
           $cookieLawStates = array( 'AT', 'BE', 'BG', 'BR', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'ES', 'FI', 'FR', 'GB', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK' );
           $countryNeedCookieBar = ( in_array( $countryCode, $cookieLawStates ) ) ? true : false;
       }

       if ( $countryNeedCookieBar && !isset( $_COOKIE['CookieAllowed'] ) && !isset( $_COOKIE['CookieDenied'] ) ) : ?>
       <div id="cookie-bar">
           <p><?php _e( 'Procházením webu souhlasíte s používáním cookies.', 'kno' ); ?>
               <?php if ( $privacy_page = get_option( 'wp_page_for_privacy_policy' ) ): ?>
               <a href="<?php echo get_permalink( get_page_language_by_id( $privacy_page ) ); ?>" rel="nofollow noopener noreferrer" data-alt="<?php _e( 'Podmínky o ochraně osobních údajů', 'kno'); ?>"></a>
               <?php endif; ?>
           </p>
           <span>
           <button rel="nofollow noopener noreferrer" id="cookie-bar-allow"><?php _e( 'Povolit Cookies', 'kno' ); ?></button>
           <button rel="nofollow noopener noreferrer" id="cookie-bar-deny"><?php _e( 'Zakázat Cookies', 'kno' ); ?></button>
           </span>
       </div>
       <?php endif; */
    ?>
    <?php get_template_part('template-parts/components/form-inquiry'); ?>
    <?php
    $block = parse_blocks(get_post(pll_get_post(7016))->post_content)[0];
    $block['attrs']['only_modal'] = true;
    echo render_block($block);
    ?>
    <div class="supercontainer" data-ajax="wrapper">
        <?php
        $namespace = 'default';
        if (is_front_page()) {
            $namespace = 'home';
        } elseif (is_page()) {
            global $post;
            $namespace = $post->post_name;
        } elseif (get_query_var('template')) {
            $namespace = get_query_var('template');
        } elseif (is_post_type_archive()) {
            $namespace = get_queried_object()->name;
        } elseif (is_singular('product')) {
            $namespace = 'product';
        } elseif (is_tax('product_cat'))
            $namespace = 'category';
        ?>
        <div id="<?php echo $namespace; ?>" aria-label="<?php _e('Hlavný obsah', 'kno'); ?>" data-ajax="container" data-ajax-namespace="<?php echo $namespace; ?>">
            <div data-scroll-container class="<?php body_class(); ?>">
                <header class="header<?php if (is_front_page()) echo ' floating'; ?>" role="banner">
                    <div class="header-wrapper">
                        <div class="container">
                            <div class="header-flex flex"> <a href="/" class="header-logo flex middle-xs"> <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 253 45'%3E%3C/svg%3E" data-src="<?php echo get_template_directory_uri(); ?>/img/ayvens-logo.png" width="215" height="42" alt="<?php echo get_bloginfo('name'); ?>" class="lazyload">
                                    <?php if (is_front_page()): ?>
                                        <h1 class="vh"><?php echo get_bloginfo('name'); ?></h1>
                                    <?php endif; ?>
                                </a>
                                <nav class="main-menu print-hidden ns" role="navigation">
                                    <ul class="list-bare main-menu-ul flex center-xs between-xs">
                                        <?php
                                        wp_nav_menu(array(
                                            'container' => false,
                                            'menu_class' => false,
                                            'menu_class_add' => 'main',
                                            'depth' => 3,
                                            'menu_id' => '',
                                            'theme_location' => 'primary',
                                            'items_wrap' => '%3$s',
                                            'position' => 'primary',
                                            'walker' => new KNO_Walker_Nav_Menu()
                                        ));
                                        ?>
                                    </ul>
                                </nav>
                                <?php // if ( function_exists( 'pll_default_language' ) ): 
                                ?>
                                <!--div class="header-lang popup-trigger">
                                        <div class="header-lang-actual"><?php echo str_replace('cs', 'cz', pll_current_language('slug')); ?></div>
                                        <div class="popup popup-center">
                                            <span class="popup-arrow"></span>
                                            <ul class="header-lang-list list-bare">
                                            <?php
                                            $lang = pll_the_languages(array(
                                                'display_names_as' => 'slug',
                                                'echo'             => false,
                                                'hide_current'     => true
                                            ));
                                            echo str_replace(array('/">', 'cs'), array('/" data-ajax-prevent="self">', 'cz'), $lang);
                                            ?>
                                            </ul>
                                        </div>
                                    </div -->
                                <?php // endif; 
                                ?>
                                <?php
                                $cart_count = count(WC()->cart->get_cart());
                                ?>
                                <div class="header-mini-cart popup-trigger"> <a href="<?php echo get_permalink(wc_get_page_id('checkout')); ?>" aria-label="<?php _e('Košík', 'kno'); ?>" rel="noopener" data-ajax-prevent="self" class="btn-icon">
                                        <svg class="icon icon-cart lazyload" aria-hidden="true" role="img">
                                            <use xlink:href="#icon-cart"></use>
                                        </svg>
                                        <div class="badge-placeholder<?php if ($cart_count < 1) echo ' badge-disable'; ?>">
                                            <div class="badge badge--sm">
                                                <?php if ($cart_count > 0) echo $cart_count; ?>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="popup"> <span class="popup-arrow"></span>
                                        <div class="widget_shopping_cart_content">
                                            <?php woocommerce_mini_cart(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <main>