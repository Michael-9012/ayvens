<?php


// predelat is_user_logged_in na global product => $product->is_purchasable()


remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

if (isset($GLOBALS['WC_Brands']))

    remove_action('woocommerce_product_meta_end', array($GLOBALS['WC_Brands'], 'show_brand'));


add_action('after_setup_theme', 'kno_woocommerce_after_setup_theme');

function kno_woocommerce_after_setup_theme()
{

    add_theme_support('woocommerce', array(

        //'thumbnail_image_width' => 150,

        //'single_image_width'    => 300,


        'product_grid' => array(

            'default_rows' => 3,

            'min_rows' => 2,

            'max_rows' => 8,

            'default_columns' => 4,

            'min_columns' => 2,

            'max_columns' => 5,

        ),

    ));

    //add_theme_support( 'wc-product-gallery-zoom' );

    //add_theme_support( 'wc-product-gallery-lightbox' );

    //add_theme_support( 'wc-product-gallery-slider' );


    remove_image_size('woocommerce_thumbnail');

    remove_image_size('woocommerce_single');

    remove_image_size('woocommerce_gallery_thumbnail');

    remove_image_size('shop_catalog');

    remove_image_size('shop_single');

    remove_image_size('shop_thumbnail');
}

// Remove WooCommerce Marketing Hub & Analytics Menu from the sidebar - for WooCommerce v4.3+
add_filter('woocommerce_admin_features', function ($features) {
    return array_values(
        array_filter($features, function ($feature) {
            return !in_array($feature, ['wcpay', 'activity-panels', 'marketing', 'analytics', 'analytics-dashboard', 'analytics-dashboard/customizable', 'store-alerts']);
        })
    );
});

add_action('init', 'woocommerce_run', 11);

function woocommerce_run()
{

    foreach (pll_languages_list() as $lang) {

        $term_id = pll_get_term(get_shop_accessories_id(), $lang);
        if (!$term_id)
            return;

        $term = get_term($term_id, 'product_cat');

        if ($term) {
            if ($lang === pll_default_language()) {
                add_rewrite_rule('^' . $term->slug . '/?$', 'index.php?product_cat=' . $term->slug . '&lang=' . $lang, 'top');
            } else {
                add_rewrite_rule('^' . $lang . '/' . $term->slug . '/?$', 'index.php?product_cat=' . $term->slug . '&lang=' . $lang, 'top');
            }
        }
    }

    foreach (pll_languages_list() as $lang) {

        $term_id = pll_get_term(get_shop_scooter_id(), $lang);
        if (!$term_id)
            return;

        $term = get_term($term_id, 'product_cat');

        if ($term) {
            if ($lang === pll_default_language()) {
                add_rewrite_rule('^' . $term->slug . '/?$', 'index.php?product_cat=' . $term->slug . '&lang=' . $lang, 'top');
            } else {
                add_rewrite_rule('^' . $lang . '/' . $term->slug . '/?$', 'index.php?product_cat=' . $term->slug . '&lang=' . $lang, 'top');
            }
        }
    }

    register_taxonomy('seller', array('product'), array(

        'labels' => array(

            'name' => __('Prodejci', 'ibd'),

            'singular_name' => __('Prodejce', 'ibd'),

            'menu_name' => __('Prodejci', 'ibd'),

            'all_items' => __('Všichni prodejci', 'ibd'),

            'parent_item' => __('Nadřazení prodejci', 'ibd'),

            'parent_item_colon' => __('Nadřazení prodejci:', 'ibd'),

            'new_item_name' => __('Nový prodejce', 'ibd'),

            'add_new_item' => __('Přidat nového prodejce', 'ibd'),

            'edit_item' => __('Upravit prodejce', 'ibd'),

            'update_item' => __('Aktualizovat prodejce', 'ibd'),

            'view_item' => __('Zobrazit', 'ibd'),

            'separate_items_with_commas' => __('Oddělte prodejce čárkami', 'ibd'),

            'add_or_remove_items' => __('Přidat či odebrat prodejce', 'ibd'),

            'choose_from_most_used' => __('Vyberte z nejpoužívanějších prodejců', 'ibd'),

            'popular_items' => __('Populární prodejci', 'ibd'),

            'search_items' => __('Vyhledat prodejce', 'ibd'),

            'not_found' => __('Nebyly nalezeni žádní prodejci.', 'ibd'),

            'items_list' => __('Seznam prodejců', 'ibd'),

            'items_list_navigation' => __('Seznam prodejců', 'ibd')

        ),

        'hierarchical' => true,

        'public' => true,

        'show_ui' => true,

        'meta_box_cb' => 'post_categories_meta_box',

        'show_in_menu' => true,

        'show_in_quick_edit' => true,

        'show_admin_column' => true,

        'show_in_nav_menus' => true,

        'show_in_rest' => true,

        'show_tagcloud' => false,

        'query_var' => 'seller',

        'rewrite' => array(

            'slug' => 'prodejci',

            'with_front' => false,

        ),

        'capabilities' => array(

            'manage_terms' => 'manage_product_terms',

            'edit_terms' => 'edit_product_terms',

            'delete_terms' => 'delete_product_terms',

            'assign_terms' => 'assign_product_terms'

        )

    ));
}


add_filter('intermediate_image_sizes_advanced', 'kno_woocommerce_intermediate_image_sizes_advanced');

function kno_woocommerce_intermediate_image_sizes_advanced($sizes)
{

    unset($sizes['shop_catalog']);

    unset($sizes['shop_single']);

    unset($sizes['shop_thumbnail']);


    unset($sizes['woocommerce_gallery_thumbnail']);

    unset($sizes['woocommerce_single']);

    unset($sizes['woocommerce_thumbnail']);


    return $sizes;
}


add_filter('subcategory_archive_thumbnail_size', 'kno_woocommerce_subcategory_archive_thumbnail_size');

function kno_woocommerce_subcategory_archive_thumbnail_size($u)
{

    return 'thumbnail';
}


add_filter('woocommerce_gallery_image_size', 'kno_woocommerce_gallery_image_size');

function kno_woocommerce_gallery_image_size($size)
{

    return 'thumbnail';
};


add_filter('single_product_archive_thumbnail_size', 'kno_woocommerce_single_product_archive_thumbnail_size');

function kno_woocommerce_single_product_archive_thumbnail_size($u)
{

    return 'thumbnail';
}


add_filter('woocommerce_single_product_image_gallery_classes', 'kno_woocommerce_single_product_image_gallery_classes');

function kno_woocommerce_single_product_image_gallery_classes()
{

    return array('product-media', 'flex', 'col');
}


add_action('woocommerce_installed', 'woocommerce_delete_deactivate_plugin_note');

add_action('woocommerce_updated', 'woocommerce_delete_deactivate_plugin_note');

function woocommerce_delete_deactivate_plugin_note()
{

    global $wpdb;

    $wpdb->update(

        $wpdb->prefix . 'wc_admin_notes',

        array(

            'is_deleted' => 1

        ),

        array(

            'is_deleted' => 0

        )

    );
}


add_action('wp', 'kno_woocommece_wp', 99);

function kno_woocommece_wp()
{


    if (is_product() || is_cart() || is_checkout() || is_account_page() || is_tax('product_cat'))

        return;


    add_filter('woocommerce_enqueue_styles', '__return_false');


    remove_theme_support('wc-product-gallery-zoom');

    remove_theme_support('wc-product-gallery-lightbox');

    remove_theme_support('wc-product-gallery-slider');
}


remove_action('wp_head', 'sb_instagram_custom_css');

remove_action('wp_footer', 'sb_instagram_custom_js');

remove_action('wp_footer', 'wc_no_js');


add_action('woocommerce_before_shop_loop', 'kno_woocommerce_remove_hook', 1);

function kno_woocommerce_remove_hook()
{

    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
}


add_action('wp_print_styles', 'kno_woocommerce_wp_print_styles', 100);

function kno_woocommerce_wp_print_styles()
{

    if (!is_admin()) {


        wp_deregister_script('wc-aelia-foundation-classes-frontend');

        wp_deregister_script('wc-aelia-currency-switcher');


        wp_deregister_script('sb_instagram_scripts');

        wp_deregister_style('wc-bundle-style');

        wp_deregister_style('brands-styles');


        if (class_exists('woocommerce')) {

            wp_dequeue_style('select2');

            wp_deregister_style('select2');


            wp_dequeue_script('select2');

            wp_deregister_script('select2');


            wp_dequeue_style('selectWoo');

            wp_deregister_style('selectWoo');


            wp_dequeue_script('selectWoo');

            wp_deregister_script('selectWoo');
        }

        /*

                if ( !is_woocommerce() && !is_cart() && !is_checkout() ) {

                    remove_action('wp_enqueue_scripts', [WC_Frontend_Scripts::class, 'load_scripts']);

                    remove_action('wp_print_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);

                    remove_action('wp_print_footer_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);

                }

        */

        if (is_product() || is_cart() || is_checkout() || is_account_page() || is_tax('product_cat'))

            return;


        // Remove Woocommerce styles

        wp_dequeue_style('selectWoo');

        wp_dequeue_style('woocommerce_frontend_styles');

        wp_dequeue_style('woocommerce-general');

        wp_dequeue_style('woocommerce-layout');

        wp_dequeue_style('woocommerce-smallscreen');

        wp_dequeue_style('woocommerce_fancybox_styles');

        wp_dequeue_style('woocommerce_chosen_styles');

        wp_dequeue_style('woocommerce_prettyPhoto_css');

        wp_dequeue_style('woocommerce-inline');

        wp_dequeue_style('select2');

        // Remove Woocommerce scripts

        //wp_dequeue_script( 'selectWoo' );

        //wp_deregister_script( 'selectWoo' );

        //wp_dequeue_script( 'select2' );

        //wp_deregister_script( 'select2' );

        wp_dequeue_script('wc-add-payment-method');

        wp_dequeue_script('wc-lost-password');

        wp_dequeue_script('wc_price_slider');

        wp_dequeue_script('wc-single-product');

        wp_dequeue_script('wc-add-to-cart');

        wp_dequeue_script('wc-cart-fragments');

        wp_dequeue_script('jquery-blockui');

        wp_dequeue_script('flexslider');

        wp_dequeue_script('photoswipe');

        wp_dequeue_script('photoswipe-ui-default');


        wp_dequeue_style('photoswipe');

        wp_dequeue_style('photoswipe-default-skin');

        wp_dequeue_script('zoom');

        wp_dequeue_script('wc-credit-card-form');

        wp_dequeue_script('wc-checkout');

        wp_dequeue_script('wc-add-to-cart-variation');

        wp_dequeue_script('wc-single-product');

        wp_dequeue_script('wc-cart');

        wp_dequeue_script('wc-chosen');

        wp_dequeue_script('woocommerce');

        wp_dequeue_script('prettyPhoto');

        wp_dequeue_script('prettyPhoto-init');

        wp_dequeue_script('jquery-blockui');

        wp_dequeue_script('jquery-placeholder');

        wp_dequeue_script('jquery-payment');

        wp_dequeue_script('fancybox');

        wp_dequeue_script('wc-country-select');

        wp_deregister_script('wc-country-select');

        wp_dequeue_script('wc-address-i18n');

        wp_deregister_script('wc-address-i18n');
    }
}


add_action('woocommerce_init', 'kno_woocommerce_init', 0);

function kno_woocommerce_init()
{

    remove_action('wp_head', 'wc_gallery_noscript');

    remove_filter('body_class', 'wc_body_class');

    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
}


add_filter('woocommerce_maxmind_geolocation_database_path', 'woocommerce_new_maxmind_geolocation_database_path');

function woocommerce_new_maxmind_geolocation_database_path($database_path)
{

    $upload_dir = wp_upload_dir();

    $database_path = trailingslashit($upload_dir['basedir']) . 'GeoIP2-City.mmdb';

    return $database_path;
}


add_filter('product_type_selector', 'remove_product_types');

function remove_product_types($types)
{

    //unset( $types['grouped'] );

    unset($types['external']);

    //unset( $types['variable'] );

    return $types;
}


add_filter('woocommerce_product_single_add_to_cart_text', 'kno_woocommerce_product_single_add_to_cart_text');

function kno_woocommerce_product_single_add_to_cart_text($default)
{

    return __('Pridať do dopytu', 'kno');
}


add_filter('woocommerce_product_add_to_cart_text', 'kno_woocommerce_product_add_to_cart_text', 10, 1);

function kno_woocommerce_product_add_to_cart_text($text)
{


    global $product;

    /*

        if ( ! $product->is_purchasable() )

            return __( 'Více', 'kno' );

    */

    if (is_singular('product')) {

        global $woocommerce_loop;

        if ($woocommerce_loop['name'] === 'up-sells')

            return __('Pridať do dopytu', 'kno');
    }


    switch (WC_Product_Factory::get_product_type($product->get_id())) {

        case 'simple':

            return __('Zobraziť detail', 'kno');

            break;

        case 'variable':

            return __('Zobraziť detail', 'kno');

            break;
        /*

               case 'external':

                   return __( 'Take me to their site!', 'kno' );

               break;

               case 'grouped':

                   return __( 'VIEW THE GOOD STUFF', 'kno' );

               break;



               case 'variable':

                   return __( 'Select the variations, yo!', 'kno' );

               break;

               */

        default:

            //return __( 'Read more', 'kno' );

            return $text;
    }
}


add_filter('woocommerce_loop_add_to_cart_link', 'kno_woocommerce_loop_add_to_cart_link', 10, 2);

function kno_woocommerce_loop_add_to_cart_link($string, $product)
{

    //<svg class="icon icon-cart lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-cart"></use></svg>


    if ($product->is_purchasable()) {

        if (is_singular('product')) {

            return sprintf(

                '<a href="%s" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s" %s data-ajax-prevent="self">%s</a>',

                esc_url($product->add_to_cart_url()),

                esc_attr($product->get_id()),

                esc_attr($product->get_sku()),

                esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),

                esc_attr(isset($args['class']) ? $args['class'] : 'btn add_to_cart_button ajax_add_to_cart'),

                isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',

                esc_html($product->add_to_cart_text())

            );
        } else {

            return sprintf(

                '<a href="%s" class="%s" data-ajax-prevent="self">%s</a>',

                esc_url(get_the_permalink($product->get_id())),

                esc_attr(isset($args['class']) ? $args['class'] : 'btn'),

                esc_html($product->add_to_cart_text())

            );
        }
    } else {

        return '';

        /*return sprintf(

                '<button rel="nofollow" class="btn modal btn-y btn-two-line" data-modal="modal-register">%s</button>',

                __( 'Let me in<br><span>to get the price</span>', 'kno' )

        );

        */
    }
};


add_filter('woocommerce_reset_variations_link', '__return_false', 10);


add_filter('woocommerce_related_products', 'kno_woocommerce_related_products', -1, 3);

function kno_woocommerce_related_products($related_posts, $product_id, $args)
{


    if (empty($related_posts)) {

        global $wpdb;

        $store = new WC_Product_Data_Store_CPT();

        $related_product_query = (array)$store->get_related_products_query(array(), array(), (array)$product_id, $args['limit']);

        $related_posts = $wpdb->get_col(implode(' ', $related_product_query));
    }


    return $related_posts;
}


add_filter('woocommerce_product_get_upsell_ids', 'kno_woocommerce_product_upsell_ids', 10, 2);

function kno_woocommerce_product_upsell_ids($upsell_ids, $product)
{

    if (empty($upsell_ids)) {

        if (version_compare(WC_VERSION, '3.0', '<')) {

            $product_id = $product->id;
        } else {

            $product_id = $product->get_id();
        }


        return wc_get_related_products($product_id, 4);
    }

    return $upsell_ids;
}


add_filter('woocommerce_cart_crosssell_ids', 'kno_woocommerce_cart_crosssell_ids', 10, 2);

function kno_woocommerce_cart_crosssell_ids($this_get_cross_sell_ids, $instance)
{


    if (empty($this_get_cross_sell_ids) && !empty(WC()->cart->get_cart())) {

        foreach (WC()->cart->get_cart() as $cart_item) {

            // compatibility with WC +3

            if (version_compare(WC_VERSION, '3.0', '<')) {

                $product_id = $cart_item['data']->id; // Before version 3.0

            } else {

                $product_id = $cart_item['data']->get_id(); // For version 3 or more

            }

            break;
        }


        if (empty($this_get_cross_sell_ids))

            return wc_get_related_products($product_id, 2);
    }


    return $this_get_cross_sell_ids;
};


add_filter('woocommerce_account_menu_item_classes', 'kno_woocommerce_account_menu_item_classes', 10, 2);

function kno_woocommerce_account_menu_item_classes($classes, $endpoint)
{


    $extra_classes = array();

    if (in_array('is-active', $classes))

        $extra_classes[] = 'current';


    $whitelist = array('current');

    $extra_classes[] = 'left-menu-item';


    $classes = array_intersect($classes, $whitelist);

    return array_merge($classes, (array)$extra_classes);
};


add_filter('woocommerce_form_field_args', 'kno_woocommerce_form_field_args', 10, 3);

function kno_woocommerce_form_field_args($args, $key, $value = null)
{


    /*********************************************************************************************/

    /** This is not meant to be here, but it serves as a reference

    /** of what is possible to be changed. /**



    $defaults = array(

        'type'              => 'text',

        'label'             => '',

        'description'       => '',

        'placeholder'       => '',

        'maxlength'         => false,

        'required'          => false,

        'id'                => $key,

        'class'             => array(),

        'label_class'       => array(),

        'input_class'       => array(),

        'return'            => false,

        'options'           => array(),

        'custom_attributes' => array(),

        'validate'          => array(),

        'default'           => '',

    );

    /*********************************************************************************************/


    // Start field type switch case


    switch ($args['type']) {


        case "select":
            /* Targets all select input type elements, except the country and state select input types */

            $args['class'][] = 'form-group'; // Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag

            $args['input_class'] = array('form-control'); // Add a class to the form input itself

            //$args['custom_attributes']['data-plugin'] = 'select2';

            //$args['label_class'] = array('control-label');

            //$args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  ); // Add custom data attributes to the form input itself

            break;


        case 'country':
            /* By default WooCommerce will populate a select with the country names - $args defined for this specific input type targets only the country select element */

            $args['class'][] = 'form-group single-country';

            //$args['label_class'] = array('control-label');

            break;


        case "state":
            /* By default WooCommerce will populate a select with state names - $args defined for this specific input type targets only the country select element */

            $args['class'][] = 'form-group'; // Add class to the field's html element wrapper

            $args['input_class'] = array('form-control'); // add class to the form input itself

            //$args['custom_attributes']['data-plugin'] = 'select2';

            //$args['label_class'] = array('control-label');

            //$args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  );

            break;


        case "password":

        case "text":

        case "email":

        case "tel":

        case "number":

            $args['class'][] = 'form-group';

            //$args['input_class'][] = 'form-control input-lg'; // will return an array of classes, the same as bellow

            $args['input_class'] = array('form-control');

            //$args['label_class'] = array('control-label');

            break;


        case 'textarea':

            $args['class'][] = 'form-group';

            $args['input_class'] = array('form-control');

            //$args['label_class'] = array('control-label');

            break;


        case 'checkbox':

            break;


        case 'radio':

            break;


        default:

            $args['class'][] = 'form-group';

            $args['input_class'] = array('form-control');

            //$args['label_class'] = array('control-label');

            break;
    }


    return $args;
}


//add_filter( 'woocommerce_form_field_password', 'kno_woocommerce_form_field', 10, 4 );

//add_filter( 'woocommerce_form_field_text', 'kno_woocommerce_form_field', 10, 4 );

//add_filter( 'woocommerce_form_field_email', 'kno_woocommerce_form_field', 10, 4 );

//add_filter( 'woocommerce_form_field_tel', 'kno_woocommerce_form_field', 10, 4 );

//add_filter( 'woocommerce_form_field_number', 'kno_woocommerce_form_field', 10, 4 );

function kno_woocommerce_form_field($field, $key, $args, $value)
{


    if ($args['required']) {

        $args['class'][] = 'required';

        //$required = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr>';

    } else {

        $required = '';
    }


    $args['maxlength'] = ($args['maxlength']) ? 'maxlength="' . absint($args['maxlength']) . '"' : '';


    $args['autocomplete'] = ($args['autocomplete']) ? 'autocomplete="' . esc_attr($args['autocomplete']) . '"' : '';


    if (is_string($args['label_class'])) {

        $args['label_class'] = array($args['label_class']);
    }


    if (is_null($value)) {

        $value = $args['default'];
    }


    // Custom attribute handling

    $custom_attributes = array();


    // Custom attribute handling

    $custom_attributes = array();


    if (!empty($args['custom_attributes']) && is_array($args['custom_attributes'])) {

        foreach ($args['custom_attributes'] as $attribute => $attribute_value) {

            $custom_attributes[] = esc_attr($attribute) . '="' . esc_attr($attribute_value) . '"';
        }
    }


    $field = '';

    $label_id = $args['id'];

    $field_container = '<div class="%1$s" id="%2$s">%3$s</div>';


    $field .= '<input type="' . esc_attr($args['type']) . '" class="input-text ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . $args['maxlength'] . ' ' . $args['autocomplete'] . ' value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';


    if (!empty($field)) {

        $field_html = '';

        if ($args['description']) {

            $field_html .= '<span class="description">' . esc_html($args['description']) . '</span>';
        }


        if ($args['label'] && 'checkbox' != $args['type']) {

            $field_html .= '<label for="' . esc_attr($label_id) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">' . $args['label'] . $required . '</label>';
        }

        $field_html .= $field;


        $container_class = esc_attr(implode(' ', $args['class']));

        $container_id = esc_attr($args['id']) . '_field';


        $after = !empty($args['clear']) ? '<div class="clear"></div>' : '';


        $field = sprintf($field_container, $container_class, $container_id, $field_html) . $after;
    }

    return $field;
}


add_filter('woocommerce_cart_item_name', 'kno_woocommerce_cart_item_name', 10, 3);

function kno_woocommerce_cart_item_name($item_name, $cart_item, $cart_item_key)
{


    $rep = str_replace(' | ', '<br /><span>', $item_name);

    if ($rep)

        $item_name = $rep . '</span>';


    return str_replace('">', '">', $item_name);
}


//add_filter( 'woocommerce_product_tabs', 'kno_woocommerce_product_tabs' );

function kno_woocommerce_product_tabs($tabs)
{

    return array();
}


add_filter('woocommerce_product_description_tab_title', 'kno_woocommerce_product_description_tab_title');

function kno_woocommerce_product_description_tab_title($title)
{

    return __('Popis produktu', 'kno');
}


add_filter('woocommerce_gallery_image_html_attachment_image_params', 'kno_woocommerce_gallery_image_html_attachment_image_params', 10, 4);

function kno_woocommerce_gallery_image_html_attachment_image_params($atts, $attachment_id, $image_size, $main_image)
{

    $atts['class'] = 'lazyload';

    return $atts;
}


add_filter('wc_add_to_cart_message_html', 'kno_wc_add_to_cart_message_html', 10, 2);

function kno_wc_add_to_cart_message_html($message, $products)
{


    $message = str_replace(

        array(

            'button wc-forward fr',

            'tabindex="1"'

        ),

        array(

            'btn',

            'tabindex="1"'

        ),
        $message
    );


    return $message;
}


add_filter('product_type_options', 'kno_product_type_options');

function kno_product_type_options($options)
{

    // if ( isset( $options['virtual'] ) ) {

    //  unset( $options['virtual'] );

    // }

    if (isset($options['downloadable'])) {

        unset($options['downloadable']);
    }

    return $options;
}


function kno_wc_price($return, $price, $args, $unformatted_price)
{

    return str_replace(array('woocommerce-Price-amount', 'woocommerce-Price-currencySymbol'), array('price-amount', 'price-currencysymbol'), $return);
}


function kno_woocommerce_available_variation($args, $product, $variation)
{

    $args['price_html'] = (!empty($args['price_html'])) ? '<div class="price">' . $variation->get_price_html() . '</div>' : '';

    return $args;
}


function kno_wc_price_args($args)
{

    if (isset($args['vat']) && $args['vat'] === 'with')

        $args['price_format'] = $args['price_format'] . '<small class="price-taxlabel">' . __('s DPH', 'kno') . '</small>';

    elseif (isset($args['vat']) && $args['vat'] === 'without')

        $args['price_format'] = $args['price_format'] . '<small class="price-taxlabel">' . __('bez DPH', 'kno') . '</small>';


    return $args;
};


if (!is_admin()) {

    //add_filter( 'woocommerce_variable_price_html', '__return_false', PHP_INT_MAX );

    //add_filter( 'woocommerce_grouped_price_html', '__return_false', 10 );

    //add_filter( 'woocommerce_variable_sale_price_html', '__return_false', 10 );


    add_filter('woocommerce_get_price_html', 'kno_woocommerce_get_price_html', 10, 2);

    add_filter('woocommerce_variable_price_html', 'kno_woocommerce_get_price_html', 10, 2);

    add_filter('woocommerce_variable_sale_price_html', 'kno_woocommerce_variable_sale_price_html', 10, 2);


    add_filter('wc_price_args', 'kno_wc_price_args', 10, 1);

    add_filter('woocommerce_available_variation', 'kno_woocommerce_available_variation', 10, 3);

    add_filter('wc_price', 'kno_wc_price', 10, 4);
}


// Disable price

/*

add_filter( 'woocommerce_product_get_price', 'kno_woocommerce_get_price', PHP_INT_MAX, 2 );

add_filter( 'woocommerce_product_get_regular_price', 'kno_woocommerce_get_price', PHP_INT_MAX, 2 );

add_filter( 'woocommerce_product_get_sale_price', 'kno_woocommerce_get_price', PHP_INT_MAX, 2 );

add_filter( 'woocommerce_product_variation_get_price', 'kno_woocommerce_get_price', PHP_INT_MAX, 2 );

add_filter( 'woocommerce_product_variation_get_regular_price', 'kno_woocommerce_get_price', PHP_INT_MAX, 2 );

add_filter( 'woocommerce_product_variation_get_sale_price', 'kno_woocommerce_get_price', PHP_INT_MAX, 2 );

*/


// Adjust price

// Variable

// Simple


//add_filter( 'woocommerce_product_get_price', 'kno_woocommerce_product_get_price', 99, 2 );

//add_filter( 'woocommerce_product_get_regular_price', 'kno_woocommerce_product_get_price', 99, 2 );

//add_filter( 'woocommerce_product_get_sale_price', 'kno_woocommerce_product_get_price', 99, 2 );


// Variable

//add_filter( 'woocommerce_product_variation_get_regular_price', 'kno_woocommerce_product_get_price', 99, 2 );

//add_filter( 'woocommerce_product_variation_get_price', 'kno_woocommerce_product_get_price', 99, 2 );

//add_filter( 'woocommerce_product_variation_get_sale_price', 'kno_woocommerce_product_get_price', 99, 2 );


// Variations (of a variable product)

//add_filter( 'woocommerce_variation_prices_price', 'kno_woocommerce_variation_prices_price', 99, 3 );

//add_filter( 'woocommerce_variation_prices_regular_price', 'kno_woocommerce_variation_prices_price', 99, 3 );


function get_cnb_kurz($currency = false)
{

    if (false === ($cnb_kurz = get_transient('cnb_kurz'))) {

        $response = wp_remote_get('https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt');

        if (!is_wp_error($response)) {

            $data = wp_remote_retrieve_body($response);

            $output = explode("\n", $data);

            if (count($output) >= 8) {

                unset($output[0]);

                unset($output[count($output)]);

                unset($output[1]);

                foreach ($output as $row) {

                    $row = explode("|", $row);

                    $kurz[trim($row[3])] = str_replace(",", ".", trim($row[4]));
                }

                $cnb_kurz = $kurz;

                set_transient('cnb_kurz', $cnb_kurz, 12 * HOUR_IN_SECONDS);
            }
        }
    }

    return (!$currency) ? $cnb_kurz : $cnb_kurz[$currency];
}


function oprava_get_cnb_eur()
{
    $url = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt';

    // Fetch the content of the text file
    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        // Handle error
        return false;
    }

    $body = wp_remote_retrieve_body($response);

    // Parse the text file content
    $lines = explode("\n", $body);

    // Check if there are at least 8 lines
    if (count($lines) >= 8) {
        // Get the 8th line
        $line = $lines[7];

        // Extract the last number separated by |
        $parts = explode('|', $line);
        $last_number = str_replace(',', '.', trim(end($parts)));

        return $last_number;
    }

    // Not enough lines in the text file
    return false;
}

function new_kno_get_price_api($price, $product)
{

    $vcetnePojisteni = !(is_product_id_shop_accessories($product->get_id()));

    $kolo_s_dph = $price; // Kč
    //echo $kolo_s_dph . ' - ' .  $product->get_id();

    // ziskani ceny bez dph
    $tax_rates    = WC_Tax::get_base_tax_rates($product->get_tax_class('unfiltered'));
    $taxes        = WC_Tax::calc_tax((float)$price, $tax_rates, true);
    $kolo_bez_dph = WC_Tax::round((float)$price * 1 - array_sum($taxes));

    //echo $kolo_bez_dph . ' - ' .  $product->get_id();
    $urok_v_percent        = 10.5; // Procenta
    $doba_najmu            = 24; // Počet měsíců
    $servis                = 0; // Kč
    $registracni_poplatek  = 0; // Kč
    $spravni_poplatek      = 0; // Kč
    $rocni_sazba_pojisteni = 3.13; // Procenta
    $akontace              = 0; // Procenta
    $asistence             = 0; // Kč
    $zh_v_percent          = 10; // Procenta
    $zh_vysledna           = $kolo_bez_dph / 100 * $zh_v_percent;
    $urok_v_percent_mezi   = $urok_v_percent * 0.01;
    $splatka_servis_doba_najmu = $doba_najmu;
    $splatka_servis        = $servis / $splatka_servis_doba_najmu * 1.1; // ( $servis ) / 24 * 1.1

    //$pojisteni = ( $kolo_bez_dph * $rocni_sazba_pojisteni * ( $doba_najmu / 12 ) / 100 ) / $doba_najmu;

    $rate = $urok_v_percent_mezi / 12;
    $nper = $doba_najmu;
    $pv = - ($kolo_bez_dph + $registracni_poplatek - $akontace);
    $fv = $zh_vysledna;
    $type = 1;
    $prepoctena_financni_splatka = (-$fv - $pv * pow(1 + $rate, $nper)) / (1 + $rate * $type) /  ((pow(1 + $rate, $nper) - 1) / $rate);

    //echo $kolo_bez_dph . '(' . $prepoctena_financni_splatka. ')'  . ' - ' .  $product->get_id();

    //echo $prepoctena_financni_splatka. ' - ' .  $product->get_id();

    $total = $prepoctena_financni_splatka + $spravni_poplatek + $asistence + $splatka_servis;

    if ($vcetnePojisteni)
        $total = $total + (($kolo_bez_dph * $rocni_sazba_pojisteni * ($doba_najmu / 12) / 100) / $doba_najmu * 1.2);

    //$taxes = WC_Tax::calc_tax( ( float )$total, $tax_rates, true );
    //echo $total . '(' . $prepoctena_financni_splatka. ')'  . ' - ' .  $product->get_id();

    return $total * 1.20;
}

function kno_get_price_api($price, $product)
{

    if (true) { //get_current_user_id() == 1
        return new_kno_get_price_api($price, $product);
    }

    $price_api = get_post_meta($product->get_id(), '_price_api', true);
    if (!empty($price_api))
        return $price_api;

    /*
    /*18.7.2023 - zakomentovano, do kalkulacky jdou ceny bez DPH!!!
    $tax_rates = WC_Tax::get_base_tax_rates( $product->get_tax_class( 'unfiltered' ) );

    $taxes = WC_Tax::calc_tax( $price * 1, $tax_rates, true );

    $price = WC_Tax::round( $price * 1 - array_sum( $taxes ) );
    */

    if (is_product_id_shop_accessories($product->get_id())) {
        $body = array('productPrice' => round($price), 'excludeInsurance' => "1");
    } else {
        $body = array('productPrice' => round($price), 'excludeInsurance' => "0");
    }

    write_log('bikeleasing.sk - dotazuju se na cenu produktu ' . $product->get_id() . ' s cenou ' . $price);

    $response = wp_remote_post('https://kalkulacka.bikeleasing.sk/api/calculation', array(

        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),

        'body' => json_encode($body),

        'method' => 'POST',

        'data_format' => 'body',

    ));

    if (!is_wp_error($response)) {

        $api_response = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($api_response['monthlyPayment'])) {

            if ($api_response['monthlyPayment'] < 1)
                $api_response['monthlyPayment'] = 1;

            update_post_meta($product->get_id(), '_price_api', $api_response['monthlyPayment']);

            write_log('bikeleasing.sk - produkt ' . $product->get_id() . ' má novou cenu ' . $api_response['monthlyPayment']);

            return $api_response['monthlyPayment'];
        }
    }


    return $price;
}


//add_action( 'wp_loaded', 'kno_api_prices', 20 );

function kno_api_prices()
{

    if ((isset($_GET['aktualizace-cen']) && $_GET['aktualizace-cen'] = 'dsf56vy46y4asd8') || (is_admin() && isset($_GET['aktualizace-cen']))) {

        $cache = array();

        global $wpdb;

        $wpdb->query("DELETE FROM $wpdb->postmeta WHERE `meta_key` = '_price_api'");

        if (!is_admin()) {

            $query = $wpdb->get_results("

                SELECT *

                FROM {$wpdb->prefix}postmeta

                WHERE {$wpdb->prefix}postmeta.meta_key = '_price' AND {$wpdb->prefix}postmeta.meta_value != ''

            ");

            foreach ($query as $row) {

                if (!isset($cache[(float)$row->meta_value])) {

                    $product = wc_get_product($row->post_id);

                    if ($product) {

                        $price = (float)$row->meta_value;

                        /*
                        /*18.7.2023 - zakomentovano, do kalkulacky jdou ceny bez DPH!!!
                        $tax_rates = WC_Tax::get_base_tax_rates( $product->get_tax_class( 'unfiltered' ) );

                        $taxes = WC_Tax::calc_tax( $price, $tax_rates, true );

                        $price = WC_Tax::round( $price * 1 - array_sum( $taxes ) );
                        */

                        $url = 'https://kalkulacka.bikeleasing.sk/api/calculation';

                        if (is_product_id_shop_accessories($row->post_id)) {
                            $url = add_query_arg('excludeInsurance', '1', $url);
                        }

                        $response = wp_remote_post($url, array(

                            'headers' => array('Content-Type' => 'application/json; charset=utf-8'),

                            'body' => json_encode(array('productPrice' => $price)),

                            'method' => 'POST',

                            'data_format' => 'body',

                        ));


                        if (!is_wp_error($response)) {

                            $api_response = json_decode(wp_remote_retrieve_body($response), true);

                            if (isset($api_response['monthlyPayment'])) {

                                $cache[(float)$row->meta_value] = $api_response['monthlyPayment'];

                                update_post_meta($row->post_id, '_price_api', $api_response['monthlyPayment']);
                            }
                        }
                    }
                } else {

                    update_post_meta($row->post_id, '_price_api', $cache[(float)$row->meta_value]);
                }
            }
        }


        add_action('admin_notices', 'kno_api_prices_notice');
    }


    if (is_admin() && isset($_GET['odstranit-produkty']) && current_user_can('manage_options')) {


        $product = new WP_Query(array(

            'posts_per_page' => -1,

            'post_type' => array('product'),

            'fields' => 'ids',

            'post_status' => array('any'),

            //'lang'           => 'any'

        ));


        if (!empty($product->posts)) {

            foreach ($product->posts as $post_id) {

                wp_delete_post($post_id, true);
            }
        }


        $product_variation = new WP_Query(array(

            'posts_per_page' => -1,

            'post_type' => array('product_variation'),

            'fields' => 'ids',

            'post_status' => array('any'),

            //'lang'           => 'any'

        ));


        if (!empty($product_variation->posts)) {

            foreach ($product_variation->posts as $post_id) {

                wp_delete_post($post_id, true);
            }
        }


        $wpdb->query("DELETE FROM $wpdb->term_relationships WHERE object_id IN (SELECT ID FROM wp_posts WHERE post_type = 'product_variation' AND post_parent = 0)");

        $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = 'product_variation' AND post_parent = 0)");

        $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = 'product_variation' AND post_parent = 0");

        $wpdb->query("DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL");


        if (function_exists('FWP')) {

            FWP()->indexer->index();
        }


        add_action('admin_notices', 'kno_reset_notice');
    }
}


add_action('admin_bar_menu', 'kno_admin_bar_menu', 999);

function kno_admin_bar_menu($wp_admin_bar)
{


    if (current_user_can('manage_options')) {

        $args = array(

            'id' => 'kno_product_reset',

            'title' => '<span class="ab-icon dashicons dashicons-trash"></span>Odstranit všechny produkty',

            'href' => add_query_arg('odstranit-produkty', '', admin_url()),

            'meta' => array(

                'title' => 'Odstranit všechny produkty',

                'onclick' => 'return confirm("Opravdu chcete odstranit všechny produkty?")',

            )

        );

        $wp_admin_bar->add_node($args);
    }

    /*
    $args = array(

        'id' => 'kno_api',

        'title' => '<span class="ab-icon dashicons dashicons-image-rotate"></span>Aktualizovat ceny',

        'href' => add_query_arg( 'aktualizace-cen', '', admin_url() ),

        'meta' => array(

            'title' => 'Aktualizovat ceny'

        )

    );

    $wp_admin_bar->add_node( $args );
*/
}


function kno_api_prices_notice()
{

    echo '<div class="notice notice-warning">

         <p>KNO API - ceny byly aktualizovány.</p>

     </div>';
}


function kno_reset_notice()
{

    echo '<div class="notice notice-warning">

        <p>KNO - produkty a jejich varianty byly odstraněny.</p>

    </div>';
}


function kno_woocommerce_product_get_price($price, $product)
{

    if ((int)$price > 0) {

        //wc_delete_product_transients( $product->get_id() );

        return round(kno_get_price_api($price, $product));
    }

    return $price;
}


function kno_woocommerce_variation_prices_price($price, $variation, $product)
{

    if ((int)$price > 0) {

        //wc_delete_product_transients( $variation->get_id() );

        return round(kno_get_price_api($price, $variation));
    }

    return $price;
}


function kno_woocommerce_variable_sale_price_html($price, $product)
{

    // Main prices

    $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));

    $price = $prices[0] !== $prices[1] ? sprintf(__('<span class="from">From </span>%1$s', 'show-only-lowest-prices-in-woocommerce-variable-products'), wc_price($prices[0])) : wc_price($prices[0]);

    // Sale price

    $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));

    sort($prices);

    $saleprice = $prices[0] !== $prices[1] ? sprintf(__('<span class="from">From </span>%1$s', 'show-only-lowest-prices-in-woocommerce-variable-products'), wc_price($prices[0])) : wc_price($prices[0]);

    if ($price !== $saleprice) {

        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }

    return $price;
}


function kno_woocommerce_get_price_html($price, $product)
{


    /*

        if ( !wc_tax_enabled() )



    */


    if ('' === $product->get_price())

        return apply_filters('woocommerce_empty_price_html', '', $product);


    //$regular_price = ( $product->is_type( 'variable' ) ) ? $product->get_variation_regular_price() : wc_get_price_excluding_tax( $product );

    //$regular_price_with_tax = wc_get_price_including_tax( $product, array( 'price' => $product->get_regular_price() ) );


    $regular_price = wc_get_price_excluding_tax($product);

    $regular_price_with_tax = wc_get_price_including_tax($product);


    $symbol = get_woocommerce_currency_symbol();

    $price = '';


    if (is_singular('product') && empty(wc_get_loop_prop('name')))

        $price .= '<div class="tooltip">?<span>' . __('Cena zahŕňa splátku a poistenie bicykla', 'kno') . '</span></div>';


    $price .= '<div class="price-item-perex">' . __('mesačná splátka na 24 mesiacov', 'kno') . '</div>';

    $price .= '<div class="price-item price-item-withoutvat">';


    if ($product->is_on_sale()) {


        if ($product->is_type('variable')) {

            $sale_price = $product->get_variation_sale_price();
        } else {

            $sale_price = $product->get_sale_price();
        }


        $price .= '<del>' . (is_numeric($regular_price) ? wc_price($regular_price, array('price_format' => '%2$s')) : $regular_price) . '</del> <ins>' . (is_numeric($sale_price) ? wc_price($sale_price, array('vat' => 'without')) : $sale_price) . '</ins>';
    } else {


        $price .= '<ins>' . (is_numeric($regular_price) ? wc_price($regular_price, array('vat' => 'without')) : $regular_price) . '</ins>';
    }


    $price .= '</div>';


    if (false) { //wc_tax_enabled()

        $price .= '<div class="price-item price-item-withvat">';


        if ($product->is_on_sale()) {

            $sale_price_with_tax = wc_get_price_including_tax($product, array('price' => $sale_price));


            $price .= '<del>' . (is_numeric($regular_price_with_tax) ? wc_price($regular_price_with_tax, array('price_format' => '%2$s')) : $regular_price_with_tax) . '</del> <ins>' . (is_numeric($sale_price_with_tax) ? wc_price($sale_price_with_tax, array('vat' => 'with')) : $sale_price_with_tax) . '</ins>';
        } else {

            $price .= '<ins>' . (is_numeric($regular_price_with_tax) ? wc_price($regular_price_with_tax, array('vat' => 'with')) : $regular_price_with_tax) . '</ins>';
        }


        $price .= '</div>';
    }


    return $price;
}


add_filter('register_taxonomy_args', 'kno_woocommerce_register_taxonomy_args', 11, 2);

function kno_woocommerce_register_taxonomy_args($args, $post_type)
{


    if ('product_brand' == $post_type) {

        $args['labels'] = array(

            'name' => __('Výrobci', 'kno'),

            'singular_name' => __('Výrobca', 'kno'),

            'search_items' => __('Vyhledat výrobce', 'kno'),

            'all_items' => __('Všichni výrobci', 'kno'),

            'parent_item' => __('Nadřazený výrobce', 'kno'),

            'parent_item_colon' => __('Nadřazený výrobce:', 'kno'),

            'edit_item' => __('Upravit výrobce', 'kno'),

            'update_item' => __('Aktualizovat výrobce', 'kno'),

            'add_new_item' => __('Přidat nového výrobce', 'kno'),

            'new_item_name' => __('Jméno nového výrobce', 'kno'),

            'not_found' => __('Žádný výrobce nebyl nalezen.', 'kno')

        );
    }


    return $args;
}


add_action('wp_enqueue_scripts', 'kno_woocommerce_wp_enqueue_scripts', 999);

function kno_woocommerce_wp_enqueue_scripts()
{

    if (!(wc_get_product() && wc_get_product()->is_type('bundle'))) {

        wp_deregister_script('wc-add-to-cart-variation');

        wp_register_script('wc-add-to-cart-variation', get_template_directory_uri() . '/js/add-to-cart-variation.js', array('jquery', 'wp-util'));
    }

    if (is_checkout())

        wp_enqueue_script('wc-cart');
}


//add_action( 'woocommerce_after_add_to_cart_button', 'kno_woocommerce_after_add_to_cart_button' );

function kno_woocommerce_after_add_to_cart_button()
{

?>
    <div class="bubble product-bubble flex middle-xs">
        <div class="flex middle-xs"><strong>
                <?php _e('Tento výrobok máme na skladem', 'kno'); ?>
            </strong>
            <?php _e('expedujeme do 24 hodín', 'kno'); ?>
        </div>
    </div>
<?php
}


add_filter('woocommerce_pagination_args', 'kno_woocommerce_pagination_args', 20);

function kno_woocommerce_pagination_args($args)
{

    $args['next_text'] = '<svg class="icon icon-arrow-right lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-right"></use></svg>';

    $args['prev_text'] = '<svg class="icon icon-arrow-left lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-left"></use></svg>';

    return $args;
}


add_filter('woocommerce_add_to_cart_fragments', 'kno_woocommerce_add_to_cart_fragments');

function kno_woocommerce_add_to_cart_fragments($fragments)
{


    /* nelze, je napevno v JS widget_shopping_cart_content

    $fragments['.header-mini-cart-form'] = $fragments['div.widget_shopping_cart_content'];

    unset( $fragments['div.widget_shopping_cart_content'] );

    */

    $cart_count = count(WC()->cart->get_cart());

    if ($cart_count > 0) {

        $fragments['.badge-placeholder'] = '<div class="badge-placeholder"><div class="badge badge--sm">' . $cart_count . '</div></div>';
    } else {

        $fragments['.badge-placeholder'] = '<div class="badge-placeholder' . (($cart_count < 1) ? ' badge-disable' : '') . '"><div class="badge badge--sm"></div></div>';
    }


    return $fragments;
}


/*

add_filter( 'woocommerce_catalog_orderby', 'kno_woocommerce_catalog_orderby' );

function kno_woocommerce_catalog_orderby( $orderby ) {

    $orderby['featured'] = __( 'Featured', 'woocommerce' );



    return $orderby;

}



add_action( 'woocommerce_product_query', 'kno_woocommerce_product_query' );

function kno_woocommerce_product_query( $q ) {

    if ( ! is_admin() && isset($_GET['orderby']) && 'featured' === esc_attr($_GET['orderby']) ) {

        $tax_query = $q->get('tax_query');

        $tax_query[] = array(

            'taxonomy' => 'product_visibility',

            'field'    => 'name',

            'terms'    => 'featured',

        );

        $q->set( 'tax_query', $tax_query );

        $q->set( 'order', 'DESC' );

    }

}

*/


function print_attribute_radio($checked_value, $value, $label, $attribute_name, $counter)
{

    global $product;


    $input_name = 'attribute_' . esc_attr($attribute_name);

    $esc_value = esc_attr($value);

    $id = esc_attr($attribute_name . '_v_' . $value . $product->get_id()); //added product ID at the end of the name to target single products


    if ($counter == 0)

        $checked_value = $value = 'yes';


    $checked = checked($checked_value, $value, false);


    $filtered_label = apply_filters('woocommerce_variation_option_name', $label, esc_attr($attribute_name));

    printf(
        '

        <div class="radio">

            <label>

                <input type="radio" name="%1$s" value="%2$s" id="%3$s" %4$s data-validate-required-message="' . __('Výber varianty je povinný.', 'kartonara') . '" required aria-label="' . __('Výber varianty', 'kartonara') . '" /><i class="helper">%5$s</i>

            </label>

        </div>',

        $input_name,
        $esc_value,
        $id,
        $checked,
        $filtered_label
    );
}


add_filter('gettext', 'kno_woocommerce_gettext', 20, 3);

function kno_woocommerce_gettext($translated_text, $text, $domain)
{

    switch ($translated_text) {

        case 'Aktualizovat košík':

            $translated_text = __('Aktualizovať dopyt', 'kno');

            break;

        case 'Related Products':

            $translated_text = __('Check out these related products', 'woocommerce');

            break;
    }

    return $translated_text;
}


add_action('woocommerce_before_checkout_form', 'kno_woocommerce_before_checkout_form', 5);

function kno_woocommerce_before_checkout_form()
{

    if (is_wc_endpoint_url('order-received')) return;

    echo do_shortcode('[woocommerce_cart]');
}


add_filter('woocommerce_cart_needs_payment', '__return_false');

add_filter('woocommerce_add_to_cart_redirect', function () {

    global $woocommerce;

    $checkout_url = wc_get_checkout_url();

    return $checkout_url;
});

remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);

add_filter('facetwp_sort_options', 'kno_facetwp_sort_options', 10, 2);

function kno_facetwp_sort_options($options, $params)
{

    unset($options['date_asc']);

    unset($options['date_desc']);

    unset($options['title_asc']);

    unset($options['title_desc']);

    $options['default']['label'] = __('Predvolené triedenie', 'kno');

    $options['popularity_new'] = [

        'label' => __('Zoradiť podľa obľúbenosti', 'kno'),

        'query_args' => [

            'orderby' => 'post_views',

            'order' => 'DESC',

        ]

    ];

    $options['price_asc'] = [

        'label' => __('Cena od najlacnejších', 'kno'),

        'query_args' => [

            'orderby' => 'meta_value_num',

            'meta_key' => '_price',

            'order' => 'ASC',

        ]

    ];

    $options['price_desc'] = [

        'label' => __('Cena od najdrahších', 'kno'),

        'query_args' => [

            'orderby' => 'meta_value_num',

            'meta_key' => '_price',

            'order' => 'DESC',

        ]

    ];

    return $options;
}


add_filter('loop_shop_per_page', 'kno_loop_shop_per_page', 20);

function kno_loop_shop_per_page($cols)
{

    return 23;
}


add_filter('facetwp_query_args', function ($query_args, $class) {

    if ($class->ajax_params['paged'] > 1)

        $query_args['posts_per_page'] = 23;

    else

        $query_args['posts_per_page'] = 23;


    return $query_args;
}, 10, 2);


add_filter('facetwp_filtered_post_ids', 'kno_facetwp_filtered_post_ids', 15, 2);

function kno_facetwp_filtered_post_ids($post_ids, $class)
{


    $args = array(

        'post_type' => 'product',

        'post_status' => 'publish',

        'tax_query' => array(

            'relation' => 'AND',

            array(

                'taxonomy' => 'product_visibility',

                'field' => 'name',

                'terms' => 'featured',

            ),

        ),

        'posts_per_page' => 1,

        'fields' => 'ids',

    );


    if (isset($class->ajax_params) && isset($class->ajax_params['facets']) && !empty($class->ajax_params['facets'])) {

        foreach ($class->ajax_params['facets'] as $facets) {

            if ($facets['facet_name'] === 'brand') {

                foreach ($facets['selected_values'] as $tax) {

                    $args['tax_query'][] = array(

                        'taxonomy' => 'product_brand',

                        'field' => 'slug',

                        'terms' => $tax,

                    );
                }
            }
        }
    }


    $featured_posts_query = new WP_Query($args);

    $featured_posts_array = $featured_posts_query->posts;


    if ($featured_posts_query->have_posts()) {

        $matches = array();

        foreach ($post_ids as $key => $post_id) {

            if (in_array($post_id, $featured_posts_array)) {

                $matches[] = $post_id;

                unset($post_ids[$key]);
            }
        }


        if (count($post_ids) > 1) {

            $duration = 60;

            $mins = date('i', strtotime('now'));

            $seed = $mins - ($mins % $duration);


            mt_srand($seed);

            $order = array_map(function () {
                return mt_rand();
            }, range(1, count($post_ids)));

            array_multisort($order, $post_ids);


            $post_ids = array_merge($matches, $post_ids);
        }
    }


    return $post_ids;
}


add_filter('facetwp_query_args', 'kno_facetwp_query_args', 10, 2);

function kno_facetwp_query_args($args, $class)
{


    $query_args['order'] = 'ASC';

    $query_args['orderby'] = 'post__in meta_value';


    if (isset($args['lang']) && !empty($args['lang']))

        return $args;


    if (!function_exists('pll_default_language'))

        return $args;


    $args['lang'] = pll_default_language();


    foreach (pll_languages_list() as $lang) {

        if ($class->http_params['uri'] === $lang) {

            $args['lang'] = $lang;

            $_POST['lang'] = $args['lang'];
        }
    }


    return $args;
}


if (!function_exists('woocommerce_filter')) {

    function woocommerce_filter()
    {

        wc_get_template(

            'loop/filter.php',

            array()

        );
    }
}


add_filter('woocommerce_billing_fields', 'kno_woocommerce_billing_fields');

function kno_woocommerce_billing_fields($fields = array())
{

    unset($fields['billing_address_2']);

    return $fields;
}


add_filter('facetwp_load_assets', function ($bool) {

    //if ( 'about' == FWP()->helper->get_uri() ) {

    $bool = true;

    //}

    return $bool;
});


add_filter('facetwp_indexer_row_data', function ($rows, $args) {


    if (0 === strpos($args['defaults']['facet_source'], 'cf/attribute_pa_')) {

        foreach ($rows as $row) {

            if ('product_variation' == get_post_type($row['post_id']) && '' == $row['facet_value']) {

                $parent = wp_get_post_parent_id($row['post_id']);

                if (0 === strpos($row['facet_source'], 'cf/attribute_pa_')) {

                    $taxonomy = str_replace('cf/attribute_', '', $row['facet_source']);

                    $terms = get_the_terms($parent, $taxonomy);

                    if (!is_wp_error($terms) && !empty($terms)) {

                        foreach ($terms as $term) {

                            $params = $row;

                            $params['term_id'] = $term->term_id;

                            $params['facet_display_value'] = $term->name;

                            $params['facet_value'] = $term->slug;

                            $params['variation_id'] = $row['post_id'];

                            $params['post_id'] = $parent;

                            $rows[] = $params;
                        }
                    }
                }
            }
        }
    }


    return $rows;
}, 11, 2);


add_filter('facetwp_assets', function ($assets) {

    //$assets['front.css'] = WP_PLUGIN_URL . '/facetwp/assets/css/front.css';

    //unset($assets['front.css']);

    //$assets['nouislider.css'] = WP_PLUGIN_URL . '/facetwp/assets/vendor/noUiSlider/nouislider.css';

    //unset($assets['front-deprecated.js']);


    $assets['front.css'] = WP_PLUGIN_URL . '/facetwp/assets/css/front.css';

    $assets['front.js'] = WP_PLUGIN_URL . '/facetwp/assets/js/dist/front.min.js';

    $assets['front-deprecated.js'] = WP_PLUGIN_URL . '/facetwp/assets/js/src/deprecated.js';


    //$assets['nouislider.css'] = WP_PLUGIN_URL . '/facetwp/assets/vendor/noUiSlider/nouislider.css';

    unset($assets['nouislider.css']);


    $assets['nouislider.js'] = WP_PLUGIN_URL . '/facetwp/assets/vendor/noUiSlider/nouislider.min.js';

    $assets['nummy.js'] = WP_PLUGIN_URL . '/facetwp/assets/vendor/nummy/nummy.min.js';

    $assets['facetwp-submit.js'] = WP_PLUGIN_URL . '/facetwp-submit/facetwp-submit.js';


    $assets['woocommerce.js'] = WP_PLUGIN_URL . '/facetwp/includes/integrations/woocommerce/woocommerce.js';

    //unset($assets['woocommerce.js']);


    return $assets;
}, PHP_INT_MAX);


add_filter('facetwp_template_html', function ($html) {

    return '';
});


add_filter('facetwp_pager_html', function ($output, $params) {

    $output = str_replace('&gt;&gt;', '<svg class="icon icon-arrow-right lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-right"></use></svg>', $output);

    $output = str_replace('&lt;&lt;', '<svg class="icon icon-arrow-left lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-left"></use></svg>', $output);

    return $output;
}, 10, 2);


add_action('wp_footer', 'kno_facetwp_add_id_to_script_start', 24);

function kno_facetwp_add_id_to_script_start()
{

    ob_start();
}


add_action('wp_footer', 'kno_facetwp_add_id_to_script_end', 26);

function kno_facetwp_add_id_to_script_end()
{

    $output = ob_get_contents();

    ob_end_clean();

    echo str_replace('<script>', '<script id="facetwp">', $output);
}


add_filter('woocommerce_attribute_taxonomies', 'kno_woocommerce_attribute_taxonomies', 10, 1);

function kno_woocommerce_attribute_taxonomies($attribute_taxonomies)
{

    foreach ($attribute_taxonomies as $key => $value) {

        $attribute_taxonomies[$key]->attribute_public = 0;
    }

    return $attribute_taxonomies;
};


add_filter('woocommerce_endpoint_order-received_title', 'kno_woocommerce_endpoint_order_received_title', 10, 3);

function kno_woocommerce_endpoint_order_received_title($title, $endpoint, $action)
{

    $title = __('Dopyt prijatý', 'kno');

    return $title;
}


//add_filter( 'pll_get_post_types', 'kno_pll_get_post_types', 12, 2 );

function kno_pll_get_post_types($post_types, $is_settings)
{


    if ($is_settings) {

        $post_types['product'] = 'product';
    } else {

        $post_types = array_flip($post_types);

        unset($post_types['product']);

        unset($post_types['product_variation']);

        $post_types = array_flip($post_types);
    }

    return $post_types;
}


add_filter('pll_get_taxonomies', 'kno_pll_get_taxonomies', 10, 2);

function kno_pll_get_taxonomies($taxonomies, $is_settings)
{

    if ($is_settings) {

        $taxonomies['product_brand'] = 'product_brand';
    } else {

        unset($taxonomies['product_brand']);
    }

    return $taxonomies;
}


add_filter('wc_product_has_unique_sku', '__return_false');


add_filter('pll_sync_post_fields', 'kno_pll_sync_post_fields', 10, 4);

function kno_pll_sync_post_fields($fields, $post_id, $lang, $save_group)
{

    unset($fields['post_content']);

    return $fields;
}


add_action('wp', function () {

    if (isset($_GET['eea1270112ea7e694945f5539e7d8ace5f6508e8b246eab8fb5f2c9dbf42c025'])) {

        global $wpdb;

        /*



                if( $wpdb->get_var( "SELECT id FROM " . PMXI_Plugin::getInstance()->getTablePrefix() . "imports WHERE executing = 1 OR triggered = 1 OR processing = 1 LIMIT 1" ) ) {

                    wp_die( 'Probíhá import' );

                }

        */

        $orphaned_variations = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type = 'product_variation' AND ( post_parent != 0 AND post_parent NOT IN (SELECT ID FROM $wpdb->posts) ) ");

        if (!empty($orphaned_variations)) {

            foreach ($orphaned_variations as $post_id) {

                wp_delete_post($post_id, true);
            }
        }


        $wpdb->query("DELETE FROM $wpdb->term_relationships WHERE object_id IN (SELECT ID FROM wp_posts WHERE post_type = 'product_variation' AND post_parent = 0)");

        $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = 'product_variation' AND post_parent = 0)");

        $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = 'product_variation' AND post_parent = 0");

        $wpdb->query("DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL");


        if (function_exists('FWP')) {

            FWP()->indexer->index();
        }
    }
});


add_action('pmxi_saved_post', 'kno_pmxi_saved_post', 10, 3);

function kno_pmxi_saved_post($post_id, $xml_node, $is_update)
{


    if (!function_exists('pll_default_language'))

        return;


    kno_pmxi_logger("<strong>POLYLANG SYNC</strong>");

    kno_pmxi_logger("- SAVED - Nastavuji jazyk " . strtoupper(pll_default_language()) . ' v ID ' . $post_id);


    /* hell yeah */

    wp_set_post_terms((int)$post_id, pll_default_language(), 'language');
}


add_action('wp_all_import_before_variable_product_import', 'kno_wp_all_import_before_variable_product_import');

function kno_wp_all_import_before_variable_product_import($pid)
{


    if (get_post_type($pid) !== 'product')

        return;


    if (!function_exists('pll_default_language'))

        return;


    if (!function_exists('wc_get_product'))

        return;


    foreach (pll_get_post_translations($pid) as $locale => $post_id) {

        if ($locale !== pll_default_language()) {


            kno_pmxi_logger("- SYNC - Odstraňuji jazyk s variantami " . strtoupper($locale) . ' v ID ' . $post_id);


            wp_delete_post($post_id, true);
        }
    }
}


add_action('wp_all_import_variable_product_imported', 'kno_wp_all_import_variable_product_imported');

function kno_wp_all_import_variable_product_imported($pid)
{


    if (get_post_type($pid) !== 'product')

        return;


    if (!function_exists('pll_default_language'))

        return;


    if (!function_exists('wc_get_product'))

        return;


    $langs = array_diff(pll_languages_list(), (array)pll_default_language());


    if (empty($langs))

        return;


    global $polylang;

    remove_filter('pll_sync_post_fields', 'kno_pll_sync_post_fields', 10);


    remove_action('transition_post_status', '_update_term_count_on_transition_post_status', 10);

    remove_action('transition_post_status', '_update_posts_count_on_transition_post_status', 10);

    remove_action('post_updated', 'wp_save_post_revision', 10);


    // nutnost, jelikož se jinak odstraní term na překlad "post_translations" kvůli sloupci count, který je 0 -- polylang / translated-object.php 235

    wp_defer_term_counting(false);


    kno_pmxi_logger("- SYNC - Produkt s variantami " . $pid);


    foreach ($langs as $lang) {

        $tr_pid = $polylang->sync_post_model->copy_post($pid, $lang, false);

        kno_pmxi_logger("- SYNC - Kopíruji do jazyka " . strtoupper($lang) . ' v ID ' . $pid . ". Vytvořen překlad s ID " . $tr_pid);
    }

    $polylang->sync_post_model->save_group($pid, $langs);


    wp_defer_term_counting(true);
}

add_action('pmxi_delete_post', 'kno_mxi_delete_pos', 10, 2);
function kno_mxi_delete_pos($ids = array(), $import)
{

    if (!function_exists('pll_get_post_translations'))
        return;

    foreach ($ids as $pid) {

        foreach (pll_get_post_translations($pid) as $locale => $post_id) {

            if ($locale !== pll_default_language()) {

                wp_delete_post($post_id, true);

                //kno_pmxi_logger( "- DELETE - Odstraňuji jazyk s variantami " . strtoupper( $locale ) . ' v ID ' . $post_id );

            }
        }
    }
}

add_action('pmxi_before_delete_post', 'kno_pmxi_before_delete_post', 10, 2);

function kno_pmxi_before_delete_post($pid, $import)
{


    if (!function_exists('pll_get_post_translations'))

        return;


    foreach (pll_get_post_translations($pid) as $locale => $post_id) {

        if ($locale !== pll_default_language()) {

            wp_delete_post($post_id, true);

            //kno_pmxi_logger( "- DELETE - Odstraňuji jazyk s variantami " . strtoupper( $locale ) . ' v ID ' . $post_id );

        }
    }
}


add_action('pmxi_after_xml_import', 'kno_pmxi_after_xml_import');

function kno_pmxi_after_xml_import($import_id)
{

    // spustit pouze přes cron hostingu

    if (str_contains($_SERVER['HTTP_USER_AGENT'], 'wcron/')) {

        if (function_exists('FWP')) {

            FWP()->indexer->index();
        }
    }
}


function kno_pmxi_logger($msg)
{


    if (PMXI_Plugin::is_ajax()) {

        $logger = function ($msg) {

            echo "<div class='progress-msg'>[" . date("H:i:s") . "] " . wp_all_import_filter_html_kses($msg) . "</div>\n";

            flush();
        };
    } else {

        $logger = function ($msg) {

            echo "<div class='progress-msg'>" . wp_all_import_filter_html_kses($msg) . "</div>\n";

            if ("" != strip_tags(wp_all_import_strip_tags_content(wp_all_import_filter_html_kses($msg)))) {

                //PMXI_Plugin::$session->log .= "<p>" . strip_tags( wp_all_import_strip_tags_content( wp_all_import_filter_html_kses( $msg ) ) ) . "</p>";

                flush();
            }
        };
    }


    $logger = apply_filters('wp_all_import_logger', $logger);


    call_user_func($logger, $msg);
}


add_filter('woocommerce_checkout_fields', 'kbnt_override_checkout_fields', 100, 1);

function kbnt_override_checkout_fields($fields)
{

    $fields['billing']['billing_ic']['required'] = true;
    $fields['billing']['billing_company']['required'] = true;
    $fields['billing']['billing_dic_dph']['required'] = false;
    $fields['billing']['billing_first_name']['required'] = false;
    $fields['billing']['billing_last_name']['required'] = false;
    return $fields;
}


add_action('woocommerce_product_options_pricing', 'kno_woocommerce_product_options_pricing');

function kno_woocommerce_product_options_pricing()
{
    echo '<div class="options_group">';
    woocommerce_wp_text_input(array(
        'id' => '_regular_price_czk',
        'label' => __('Normálna cena (CZK)', 'kno'),
        'placeholder' => '',
        //'desc_tip'          => 'true',
        //'description'       => __( 'Zadejte hodnotu v CZK.', 'woocommerce' ),
        'type' => 'number'
    ));
    echo '</div>';
}

add_action('woocommerce_process_product_meta', 'kno_woocommerce_process_product_meta', PHP_INT_MAX);

function kno_woocommerce_process_product_meta($post_id)
{

    if (isset($_POST['_regular_price_czk'])) {

        $czk = esc_attr($_POST['_regular_price_czk']);
        update_post_meta($post_id, '_regular_price_czk', $czk);

        if (!empty($_POST['_regular_price_czk'])) {
            $cnb_kurz = get_cnb_kurz('EUR');
            if (!empty($cnb_kurz) && is_numeric($cnb_kurz)) {

                wc_delete_product_transients($post_id);

                $new_price = round($czk / $cnb_kurz, 2);
                update_post_meta($post_id, '_regular_price', $new_price);
                update_post_meta($post_id, '_price', $new_price);
            }
        }
    }
}

/* VZDY NA DETAIL */
add_filter('woocommerce_loop_add_to_cart_link', 'wpt_custom_view_product_button', 10, 2);
function wpt_custom_view_product_button($button, $product)
{
    // Ignore for variable products
    if ($product->is_type('variable')) return $button;
    // Button text here
    $button_text = __("View product", "woocommerce");
    return '<a class="btn" href="' . $product->get_permalink() . '">' . $button_text . '</a>';
}

?>