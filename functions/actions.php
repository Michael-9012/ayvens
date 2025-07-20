<?php


show_admin_bar(false);


add_action('after_setup_theme', 'kno_setup');

function kno_setup()
{


  load_theme_textdomain('kno', get_template_directory() . '/lang');


  show_admin_bar(false);


  add_post_type_support('page', 'excerpt');


  add_theme_support('automatic-feed-links');

  add_theme_support('title-tag');

  add_theme_support('post-thumbnails');


  register_nav_menus(array(

    'primary' => __('Hlavní menu', 'kno'),

    'primary-mobile' => __('Hlavní menu - telefon', 'kno'),

    'footer' => __('Patička', 'kno'),

    'footer-info' => __('Patička - důležité informace', 'kno'),

    'footer-link' => __('Patička - rychlé odkazy', 'kno'),

  ));


  add_theme_support('editor-styles');

  add_editor_style('css/style-editor.css');


  add_theme_support('align-wide');

  add_theme_support('editor-gradient-presets', []);

  add_theme_support('disable-custom-gradients', true);

  add_theme_support('disable-custom-font-sizes');

  add_theme_support('disable-custom-colors');

  add_theme_support('custom-line-height');

  add_theme_support('custom-units', 'rem', 'em');

  remove_theme_support('core-block-patterns');

  add_theme_support(
    'editor-color-palette',
    array(

      array(

        'name' => esc_html__('Bílá', 'kno'),

        'slug' => 'white',

        'color' => '#fff',

      ),

      array(

        'name' => esc_html__('Černá', 'kno'),

        'slug' => 'black',

        'color' => '#000',

      ),

      array(

        'name' => esc_html__('Modrá', 'kno'),

        'slug' => 'blue',

        'color' => '#5dd3d5',

      ),

      array(

        'name' => esc_html__('Fialová', 'kno'),

        'slug' => 'purple',

        'color' => '#7d57d3',

      ),

    )

  );
}


add_action('wp_head', 'kno_wp_head', 100);

function kno_wp_head()
{

  if (!isset($_COOKIE['CookieDenied'])):

?>


    <!-- Google Tag Manager -->
    <script>
      (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
          'gtm.start': new Date().getTime(),
          event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s),
          dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-N77CS9SB');
    </script>
    <!-- End Google Tag Manager -->

<?php
  endif;
}


/* rmeove wp-post-image class */

remove_action('begin_fetch_post_thumbnail_html', '_wp_post_thumbnail_class_filter_add');


add_action('wp_print_styles', 'kno_deregister_styles', 100);

function kno_deregister_styles()
{

  if (!is_admin()) {

    wp_dequeue_style('wp-block-library');

    wp_deregister_style('wp-block-library');

    wp_deregister_style('wc-aelia-cs-frontend');

    wp_deregister_style('sb_instagram_styles');

    wp_deregister_style('wc-block-vendors-style');

    wp_deregister_style('wc-block-style');

    wp_deregister_script('wp-embed');
  }
}


add_action('wp_enqueue_scripts', 'kno_wp_enqueu_scripts', PHP_INT_MAX);

function kno_wp_enqueu_scripts()
{

  if (!is_admin()) {


    wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), null);
    wp_enqueue_style('flex', get_template_directory_uri() . '/css/flex.css', array(), null);
    wp_enqueue_style('core', get_template_directory_uri() . '/css/core.css', array(), null);
    wp_enqueue_style('print', get_template_directory_uri() . '/css/print.css', array(), null, 'print');
    wp_enqueue_style('blocks-preload', get_template_directory_uri() . '/css/blocks.css', array(), null);
    wp_enqueue_style('slider-preload', get_template_directory_uri() . '/css/slider.min.css', array(), null);
    wp_enqueue_style('typography', get_template_directory_uri() . '/css/typography.css', array(), filemtime(get_template_directory() .  '/css/typography.css'));
    wp_enqueue_style('micromodal-preload', get_template_directory_uri() . '/css/micromodal.css', array(), null);
    wp_enqueue_style('font-antenna-preload', get_template_directory_uri() . '/css/fonts.css', array(), null);
    wp_enqueue_style('glightbox', get_template_directory_uri() . '/css/glightbox.min.css', array(), null);


    //wp_enqueue_style( 'leaflet-gesture', '//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css', array(), null );

    //wp_enqueue_style( 'leaflet', '//unpkg.com/leaflet@1.4.0/dist/leaflet.css', array(), null );

    //wp_enqueue_script( 'leaflet', '//unpkg.com/leaflet@1.4.0/dist/leaflet.js', array(), null, true);

    /*

            wp_enqueue_style( 'leaflet-gesture', get_template_directory_uri() . '/css/leaflet-gesture-handling.min.css', array(), null );

            wp_enqueue_style( 'leaflet', get_template_directory_uri() . '/css/leaflet.min.css', array(), null );

            wp_enqueue_script( 'leaflet-gesture', get_template_directory_uri() . '/js/leaflet-gesture-handling.min.js', array( 'leaflet' ), null, true);

            wp_enqueue_script( 'leaflet', get_template_directory_uri() . '/js/leaflet.min.js', array(), null, true);

    */

    wp_deregister_style('forms');


    wp_enqueue_style('forms', get_template_directory_uri() . '/css/forms.css', array(), filemtime(get_template_directory() . '/css/forms.css'));


    wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', array(), filemtime(get_template_directory() . '/css/style.css'));


    wp_enqueue_script('slider-defer', get_template_directory_uri() . '/js/slider.min.js', array(), null, true);

    //wp_enqueue_script( 'parallax', get_template_directory_uri() . '/js/parallax.min.js', array( 'jquery' ), null, true );

    wp_enqueue_script('lazysizes-async-defer', get_template_directory_uri() . '/js/lazysizes.min.js', array(), null, true);

    //wp_enqueue_script( 'highway', get_template_directory_uri() . '/js/highway.min.js', array(), null, true );

    wp_enqueue_script('glightbox-async', get_template_directory_uri() . '/js/glightbox.min.js', array(), null, true);


    wp_enqueue_script('barba-defer', get_template_directory_uri() . '/js/barba.min.js', array(), null, true);

    wp_enqueue_script('barba-css-defer', get_template_directory_uri() . '/js/barba-css.min.js', array('barba-defer'), null, true);

    wp_enqueue_script('polyfill-defer', '//polyfill.io/v3/polyfill.min.js?features=default%2CArray.prototype.find%2CIntersectionObserver%2CURL', array('barba-defer'), null, true);

    wp_script_add_data('polyfill', array('crossorigin'), array('anonymous'));


    wp_enqueue_script('smoothscroll-defer', get_template_directory_uri() . '/js/smoothscroll.min.js', array(), null, true);

    wp_enqueue_script('focus-visible-async', get_template_directory_uri() . '/js/focus-visible.min.js', array(), null, true);

    wp_enqueue_script('pristine-defer', get_template_directory_uri() . '/js/pristine.min.js', array(), null, true);

    wp_enqueue_script('micromodal-defer', get_template_directory_uri() . '/js/micromodal.min.js', array(), null, true);


    if (!is_page() && !is_front_page())

      wp_enqueue_script('add-to-cart-ajax-async', get_template_directory_uri() . '/js/add-to-cart-ajax.min.js', array('jquery'), null, true);


    //wp_enqueue_script( 'cookiebar-async-defer', get_template_directory_uri() . '/js/cookiebar-latest.min.js', array(), null, true );


    //wp_enqueue_script( 'grecaptcha-async', '//www.google.com/recaptcha/api.js?render=6LfawbAUAAAAAEFx1OmH47EwnWY4WuGWF2LbaUsm', array(), null, true );


    //wp_enqueue_script( 'gsap', '//unpkg.com/gsap@latest/dist/gsap.min.js', array( 'barba' ), null, true);


    //wp_enqueue_script( 'scrollreveal', get_template_directory_uri() . '/js/scrollreveal.min.js', array( 'jquery' ), null, true );


    wp_enqueue_script('init-defer', get_template_directory_uri() . '/js/init.combined.js', array('jquery'), filemtime(get_template_directory() . '/js/init.combined.js'), true);


    wp_deregister_style(array(

      'wp-core-blocks',

      'dashicons',

      'post-views-counter-frontend',

      'editorskit-frontend'

    ));


    wp_deregister_script(array(

      'react',

      'react-dom',

      'jquery-placeholder'

    ));
  }
}


if (class_exists('Core'))

  remove_action('wp_footer', array(Core::getInstance(), 'wp_footer'), 9999);


add_action('init', 'kno_run_before_default_cpt', -1);

function kno_run_before_default_cpt()
{


  global $wp_rewrite, $wp_query;


  //remove_action( 'wp_head', array( VAA_View_Admin_As_UI, 'remove_query_args' ) );

  //remove_filters_for_anonymous_class( 'wp_head', 'VAA_View_Admin_As_UI', 'remove_query_args' , 10 );


  $wp_rewrite->author_base = _x('autor', 'url na autora', 'kno');

  $wp_rewrite->pagination_base = _x('strana', 'url stránkování', 'kno');

  $wp_rewrite->search_base = _x('vyhledavani', 'url vyhledávání', 'kno');


  add_rewrite_rule("^vyhledavani$/?", 'index.php?template=search', 'top');


  if (function_exists('acf_add_options_page')) {


    $acf_template = acf_add_options_page(array(

      'page_title' => __('Hlavní nastavení', 'kno'),

      'menu_title' => __('Hlavní nastavení', 'kno'),

      'menu_slug' => 'template',

      'capability' => 'edit_posts',

      'icon_url' => 'dashicons-schedule',

      'redirect' => false,

      'autoload' => true

    ));


    /*



    acf_add_options_sub_page(array(

        'page_title'  => __( 'Discount', 'kno' ),

        'menu_title'  => __( 'Discount', 'kno' ),

        'menu_slug'   => 'discount',

        'capability'  => 'view_woocommerce_reports',

        'parent_slug' =>'woocommerce',

        'autoload'    => false,

        'update_button'   => __( 'Update Discount', 'kno' ),

        'updated_message' => __( 'Discount Updated', 'kno' ),



    ));

    */
  }


  add_rewrite_rule('^blog/strana/?([0-9]{1,})/?', 'index.php?template=archive-post&post_type=post&paged=$matches[1]', 'top');

  add_rewrite_rule('^blog$/?', 'index.php?template=archive-post&post_type=post', 'top');


  add_rewrite_rule('^en/blog/page/?([0-9]{1,})/?', 'index.php?template=archive-post&post_type=post&paged=$matches[1]', 'top');

  add_rewrite_rule('^en/blog$/?', 'index.php?template=archive-post&post_type=post', 'top');


  add_rewrite_rule('^de/blog/seite/?([0-9]{1,})/?', 'index.php?template=archive-post&post_type=post&paged=$matches[1]', 'top');

  add_rewrite_rule('^de/blog/page/?([0-9]{1,})/?', 'index.php?template=archive-post&post_type=post&paged=$matches[1]', 'top');

  add_rewrite_rule('^de/blog$/?', 'index.php?template=archive-post&post_type=post', 'top');


  //$wp_rewrite->flush_rules();

}


add_action('init', 'kno_run', 1);

function kno_run()
{

  //kno_change_post_object_label();

}


add_action('init', 'kno_run_after', 100);

function kno_run_after()
{

  kno_cpt();

  kno_action();

  kno_forms();
}


add_action('wp_enqueue_scripts', 'kno_wp_enqueue_scripts', PHP_INT_MAX);

function kno_wp_enqueue_scripts()
{

  wp_deregister_style('wp-core-blocks');

  wp_deregister_script('react');

  wp_deregister_script('react-dom');
}


if (function_exists('acf_register_block_type')) {

  add_action('acf/init', 'kno_register_acf_block_types');
}


function kno_register_acf_block_types()
{


  acf_register_block_type(array(

    'name' => 'slider',

    'title' => 'Slider',

    'description' => 'Slider blok.',

    'category' => 'formatting',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/slider.php',

  ));


  acf_register_block_type(array(

    'name' => 'faq',

    'title' => 'FAQ',

    'description' => 'FAQ blok.',

    'category' => 'formatting',

    'mode' => 'edit',

    'supports' => array(

      //'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/faq.php',

  ));


  acf_register_block_type(array(

    'name' => 'accordion',

    'title' => 'Harmonika',

    'description' => 'Harmonika blok.',

    'category' => 'formatting',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/accordion.php',

  ));


  acf_register_block_type(array(

    'name' => 'benefit',

    'title' => 'Výhody operativního leasingu',

    'description' => 'Výhody operativního leasingu blok.',

    'category' => 'formatting',

    'icon' => 'book-alt',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/benefit.php',

  ));


  acf_register_block_type(array(

    'name' => 'store',

    'title' => 'Kamenná základna',

    'description' => 'Kamenná základna blok.',

    'category' => 'formatting',

    'icon' => 'book-alt',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/store.php',

  ));


  acf_register_block_type(array(

    'name' => 'more',

    'title' => 'Kde si kolo vyzvednu / Potřebujete více',

    'description' => 'Kde si kolo vyzvednu / Potřebujete více blok.',

    'category' => 'formatting',

    'icon' => 'book-alt',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/more.php',

  ));


  acf_register_block_type(array(

    'name' => 'seller',

    'title' => 'Prodejci',

    'description' => 'Prodejci blok.',

    'category' => 'formatting',

    'icon' => 'book-alt',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/seller.php',

  ));


  acf_register_block_type(array(

    'name' => 'fleet',

    'title' => 'Flotila',

    'description' => 'Flotila blok.',

    'category' => 'formatting',

    'icon' => 'book-alt',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/fleet.php',

  ));


  acf_register_block_type(array(

    'name' => 'list-icon',

    'title' => 'Seznam s ikonou',

    'description' => 'Seznam s ikonou blok.',

    'category' => 'formatting',

    'icon' => 'book-alt',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/list-icon.php',

  ));


  acf_register_block_type(array(

    'name' => 'box',

    'title' => 'Box',

    'description' => 'Box blok.',

    'category' => 'formatting',

    'icon' => 'book-alt',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/box.php',

  ));


  acf_register_block_type(array(

    'name' => 'finance',

    'title' => 'Splátka vždy obsahuje',

    'description' => 'Splátka vždy obsahuje blok.',

    'category' => 'formatting',

    'icon' => '<svg viewBox="0 0 81 32" xmlns="http://www.w3.org/2000/svg"><path fill="#5dd3d5" style="fill: var(--color1, #5dd3d5)" d="M78.085 14.056c-1.845-3.025-6.781-3.608-14.344-3.608-3.213 0-20.423 4.552-20.423 4.552h-6.065s-17.21-4.552-20.423-4.552c-7.563 0-12.506 0.583-14.344 3.608-3.007 4.947 1.45 8.773 4.936 10.986 10.555 6.707 19.162 7.707 24.323 6.537 1.575-2.612 3.277-5.829 4.82-9.136l0.282-0.674c0.608-1.317 1.918-2.214 3.436-2.214s2.828 0.897 3.427 2.191l0.010 0.023c1.826 3.984 3.53 7.203 5.384 10.322l-0.278-0.505c5.165 1.169 13.768 0.17 24.323-6.537 3.486-2.221 7.939-6.047 4.936-10.994zM16.476 13.783c-0.040 0.276-0.275 0.485-0.559 0.485-0.027 0-0.053-0.002-0.079-0.005l0.003 0c-2.793-0.391-8.061-0.612-11.957 2.291-0.094 0.069-0.212 0.11-0.339 0.111h-0c-0.31-0.003-0.56-0.254-0.56-0.564 0-0.183 0.087-0.346 0.222-0.449l0.001-0.001c4.22-3.143 9.824-2.918 12.787-2.505 0.284 0.032 0.503 0.271 0.503 0.561 0 0.027-0.002 0.054-0.006 0.080l0-0.003zM20.209 14.76c-0.084 0.216-0.29 0.367-0.531 0.369h-0c-0.001 0-0.001 0-0.002 0-0.068 0-0.133-0.014-0.193-0.038l0.003 0.001c-0.403-0.148-0.919-0.299-1.446-0.42l-0.096-0.019c-0.254-0.061-0.439-0.285-0.439-0.553 0-0.314 0.254-0.568 0.568-0.568 0.046 0 0.090 0.005 0.133 0.016l-0.004-0.001c0.673 0.153 1.231 0.319 1.775 0.516l-0.104-0.033c0.228 0.076 0.389 0.287 0.389 0.536 0 0.070-0.013 0.136-0.036 0.198l0.001-0.004zM55.906 16.867c-1.904 0.417-3.752 1.018-5.534 1.601-1.417 0.461-2.76 0.896-4.099 1.236-0.021 0.003-0.045 0.004-0.070 0.004s-0.049-0.001-0.073-0.004l0.003 0c-0.303-0.011-0.546-0.259-0.546-0.564 0-0.256 0.171-0.473 0.405-0.542l0.004-0.001c1.302-0.328 2.627-0.76 4.029-1.217 1.436-0.523 3.324-1.082 5.249-1.546l0.399-0.081c0.036-0.008 0.077-0.013 0.12-0.013 0.313 0 0.566 0.254 0.566 0.566 0 0.27-0.189 0.496-0.443 0.553l-0.004 0.001zM59.503 16.358c-0.587 0.033-1.195 0.096-1.815 0.184h-0.081c-0.284-0.033-0.502-0.271-0.502-0.561 0-0.261 0.177-0.48 0.417-0.545l0.004-0.001c0.653-0.096 1.295-0.162 1.915-0.196 0.278 0.038 0.489 0.274 0.489 0.559 0 0.263-0.18 0.484-0.423 0.546l-0.004 0.001z"></path><path fill="#7d57d3" style="fill: var(--color2, #7d57d3)" d="M80.044 7.515c-1.21-2.306-4.877-7.039-14.757-7.515-2.213 0.314-1.778 1.774-0.24 1.955s11.256 1.361 11.728 4.383-1.476 3.32-1.476 3.32-11.551-0.236-16.823 0.889-12.506 2.723-18.191 2.723-12.912-1.597-18.191-2.723-16.823-0.889-16.823-0.889-1.955-0.295-1.476-3.32 10.19-4.206 11.728-4.383 1.977-1.642-0.236-1.955c-9.876 0.476-13.547 5.209-14.757 7.515-0.332 0.627-0.528 1.371-0.528 2.161 0 0.004 0 0.008 0 0.013v-0.001 2.166c0.002 1.456 0.725 2.742 1.831 3.521l0.014 0.009s3.73-4.486 11.905-3.656 21.213 6.397 26.544 6.397 18.368-5.567 26.562-6.397 11.905 3.656 11.905 3.656c1.12-0.789 1.842-2.075 1.845-3.53v-2.166c-0.010-0.798-0.218-1.545-0.577-2.197l0.012 0.024z"></path></svg>',

    'mode' => 'edit',

    'supports' => array(

      'align' => false,

      'mode' => false,

      //'jsx' => true

    ),

    'render_template' => 'template-parts/blocks/finance.php',

  ));
}


add_action('wp', 'kno_wp');

function kno_wp()
{

  global $wp_query;

  if (isset($wp_query->query['template'])) {

    status_header(200);

    $wp_query->is_404 = false;

    $wp_query->is_home = false;

    $wp_query->is_front_page = false;
  }
}


add_action('init', 'kno_feed_schindler_prepare');

function kno_feed_schindler_prepare()
{


  if (!isset($_GET['schindler-prepare']))

    return;


  $upload_dir = wp_upload_dir();

  $response = wp_remote_get('https://b2b.schindler.cz/api/export/product/cz/cs/czk/?key=RjI3WUErU0RVSW5kUTFPbENUZVp4QT09');


  preg_match("/\w+\.\w+/", $response['headers']['content-disposition'], $match);


  $file = $upload_dir['basedir'] . '/' . $match[0] . '.gz';

  $fp = fopen($file, "w");

  fwrite($fp, $response['body']);

  fclose($fp);


  global $wp_filesystem;

  if (is_null($wp_filesystem)) {

    require_once ABSPATH . '/wp-admin/includes/file.php';

    WP_Filesystem();
  }


  $gz = gzopen($file, 'rb');

  $dest = fopen($upload_dir['basedir'] . '/schindler.xml', 'wb');

  if (!$dest) {

    gzclose($gz);
  }

  while (!gzeof($gz)) {

    fwrite($dest, gzread($gz, 4096));
  }

  gzclose($gz);

  fclose($dest);

  unlink($file);

  die();
}


?>