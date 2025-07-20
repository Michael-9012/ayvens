<?php

add_filter( 'wp_get_attachment_link', 'kno_wp_get_attachment_link', 10, 4 );
function kno_wp_get_attachment_link( $content, $post_id, $size, $permalink ) {

    // Only do this if we're getting the file URL
    if (! $permalink) {
        // This returns an array of (url, width, height)
        $image = wp_get_attachment_image_src( $post_id, 'large' );
        $new_content = preg_replace('/href=\'(.*?)\'/', 'href=\'' . $image[0] . '\'', $content );
        return $new_content;
    } else {
        return $content;
    }
}

add_filter( 'post_gallery', 'kno_better_gallery', 10, 2 );
function kno_better_gallery( $output, $attr) {

    $post = get_post();

    static $instance = 0;
    $instance ++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );

        if ( ! $attr['orderby'] )
            unset( $attr['orderby'] );
    }

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = shortcode_atts(
        array(
            'order'           => 'ASC',
            'orderby'         => 'menu_order ID',
            'id'              => $post ? $post->ID : 0,
            'itemtag'         => $html5 ? 'figure'     : 'dl',
            'icontag'         => $html5 ? 'div'        : 'dt',
            'captiontag'      => $html5 ? 'figcaption' : 'dd',
            'content_columns' => 9,
            'columns'         => 3,
            'size'            => 'thumbnail',
            'include'         => '',
            'exclude'         => '',
            'link'            => false,
            'slide'           => false
        ),
        $attr
    );

    $id = intval( $atts['id'] );

    $get_args = array(
        'post_status'    => 'inherit',
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'order'          => $atts['order'],
        'orderby'        => $atts['orderby'],
    );

    if ( ! empty( $atts['include'] ) ) {
        $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => array( 'image', 'application/pdf' ), 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( ! empty( $atts['exclude'] ) ) {
        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => array( 'image', 'application/pdf' ), 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    } else {
        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => array( 'image', 'application/pdf' ), 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    }

    if ( empty( $attachments ) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
        }
        return $output;
    }

    $itemtag = tag_escape( $atts['itemtag'] );
    $captiontag = tag_escape( $atts['captiontag'] );
    $icontag = tag_escape( $atts['icontag'] );
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
        $itemtag = 'li';
    }
    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
        $captiontag = 'figcaption';
    }
    if ( ! isset( $valid_tags[ $icontag ] ) ) {
        $icontag = 'figure';
    }

    $columns      = intval( $atts['columns'] );
    if ( $atts['slide'] ) {
        $columns_wide = (int) 1;
    } else {
        /*
        $columns      = intval( $atts['columns'] );
        $columns_wide = floor( 12 / $columns );
        if ( 2 > $columns_wide ) {
            $columns_wide = 1;
            $captiontag   = false;
        }
        */
        $columns_wide = $columns;
    }

    $selector = "gallery-{$instance}";

    if ( !empty( $atts['size'] ) ) {

        $size       = $atts['size'];
        $size_class = 'gallery-size-' . sanitize_html_class( $atts['size'] );

    } else {

        $column_width  = 60;
        $column_gutter = 20;
        $ratio         = 'golden';
        $width = $columns_wide * $column_width + ( $columns_wide - 1 ) * $column_gutter - 10;
        switch ( $ratio ) {
            case 'golden':
                $height = round( $width / 1.6 );
                break;
            default:
                $height = $width;
        }

        $size       = array( $width, $height );
        $size_class = '';
    }

    $item_class = ( $atts['slide'] ) ? 'slide' : 'blocks-gallery-item'; //'grid-item 1/2 mt- mb- md-1/' . $columns_wide;

    $images = array();

    $md5 = md5( serialize( $attachments ) );
    $image_i = 0;

    foreach ( $attachments as $id => $attachment ) {

        $image = '';
        $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : array();
        $attr['class'] = 'lazyload';
        if( $attachment_meta = get_post_meta( $id, '_gallery_link_url', true ) ) {
            $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
        } else if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
            $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
        } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
            $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
        } else {
            $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
        }

        $image_meta  = wp_get_attachment_metadata( $id );

        $image_output  = str_replace( '<a href=', '<a rel="gallery-' . $md5 . '" href=', $image_output );
        $image_output  = str_replace( 'itemprop="image"', 'itemprop="thumbnail"', $image_output );
/*
        if ( $attachment->post_mime_type === 'application/pdf' );
           $image_output  = str_replace( '<a ', '<a ', $image_output );
*/
        $orientation = '';

        if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
        }

        if ( isset( $image_meta['sizes']['large'] ) )
            $image_output  = str_replace( '<a rel=', '<a title="' . $attachment->post_content . '" data-i="' . $image_i . '" data-size="' . $image_meta['sizes']['large']['width'] . 'x' . $image_meta['sizes']['large']['height'] . '" rel=', $image_output );
        else
            $image_output  = str_replace( '<a rel=', '<a title="' . $attachment->post_content . '" data-i="' . $image_i . '" data-size="' . $image_meta['width'] . 'x' . $image_meta['height'] . '" rel=', $image_output );

        $image .= "<li class='{$item_class}'><{$itemtag} itemprop='associatedMedia' itemscope itemtype='http://schema.org/ImageObject'>";
        $image .= $image_output;

        if ( $captiontag && trim( $attachment->post_excerpt) ) {
            $image .= "
                <{$captiontag} class='caption-text gallery-caption' id='$selector-$id' itemprop='caption description'>
                " . wptexturize( $attachment->post_excerpt);

            if ( !empty( $attachment->post_content ) )
                $image .= '<div class="caption-content">' . $attachment->post_content . '</div>';

            $image .= "</{$captiontag}>";
        }
        $image .= "</{$itemtag}></li>\n";
        $images[] = $image;
        $image_i++;
    }

    $output = "<ul class='blocks-gallery-grid' itemscope itemtype='http://schema.org/ImageGallery'>\n";
    $output .= ( $atts['slide'] ) ? '<div class="slider" data-slide-to-show="' . $columns . '" data-slide=\'{"slidesToShow": ' . $columns . '}\'>' : '';
    $output .= "\n" . implode( "\n", $images )  ."</ul>\n";

    return $output;
}

if ( ! is_admin() ) {
    add_filter( 'the_content', function($content) {
        if ( ! is_main_query() || ! strpos($content, 'blocks-gallery-grid') ) {
            return $content;
        }

        // Find gallery blocks
        $regexp = "<ul\s[^>]*blocks-gallery-grid[^>]*>(.*)<\/ul>";
        if (preg_match_all("/$regexp/imsU", $content, $matches, PREG_PATTERN_ORDER)) {

            foreach($matches as $key => $match) {
                // Find images ids
                if ( preg_match_all('/data-id="(.*)"/imsU', $match[0], $match_ids, PREG_PATTERN_ORDER) ) {
                    $matches[1][$key] = do_shortcode( '[gallery ids="'. implode(',', $match_ids[1]) .'" size="thumbnail" link="file"]' );
                }
            }
            $content = str_replace($matches[0], $matches[1], $content);
        }
        return $content;
    }, 9);
}

add_filter( 'send_password_change_email', '__return_false' );
add_filter( 'send_email_change_email', '__return_false' );
add_filter( 'searchwp_show_conflict_notices', '__return_false' );

add_filter( 'members_can_user_view_post', 'kno_members_can_user_view_post', 10, 3 );
function kno_members_can_user_view_post( $can_view, $user_id, $post_id ) {

    if ( get_field( 'locked', $post_id ) && !is_user_logged_in() )
        return false;

    return $can_view;
}

add_filter( 'image_send_to_editor', 'lazyloading', 10, 8 );
function lazyloading( $html ) {
    $html = str_replace( ' />', ' loading="lazy" />', $html );
    return $html;
}

add_filter( 'wp_get_attachment_image_attributes', 'add_lazy_load', 10, 3 );
function add_lazy_load( $attr, $attachment, $size ) {
    if ( ! array_key_exists( 'loading', $attr ) && strpos( $attr['class'], 'lazyload') === false ) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}

add_filter( 'searchwp_xpdf_path', 'kno_xpdf_path' );
function kno_xpdf_path() {
    return '/usr/bin/pdftotext';
}

add_filter( 'pre_get_posts', 'kno_pre_get_posts', 10, 2 );
function kno_pre_get_posts( $query ) {

    if ( is_admin() )
        return;

    if ( !$query->is_main_query() )
        return;

    if ( is_tax( 'product_cat' ) ) {
        $query->is_archive = false;
        $query->is_post_type_archive = false;
    }

    if ( is_shop() ) {
        $tax_query = $query->get( 'tax_query' );

        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'terms' => array( get_shop_accessories_id(), get_shop_scooter_id(), 676990, 676992 ),
            'operator' => 'NOT IN'
        );

        $query->set( 'tax_query', $tax_query );

    }

/*
    if ( is_search() )
        $query->set( 'post_type', array( 'product' ) );
*/
    return $query;

}

add_filter( 'html_class', 'kno_html_class' );
function kno_html_class( $html_class ) {

    //$html_class = ( isset( $_COOKIE['wfont'] ) ) ? ' wf-active' : '';

    $html_class .= '';
/*
    if ( is_ios() )
        $html_class .= ' os-ios';

    if ( is_tablet() )
        $html_class .= ' tablet';

    if ( is_mobile() )
        $html_class .= ' mobile';
*/

    return $html_class;
}

add_filter( 'body_class', 'kno_body_class', PHP_INT_MAX, 1 );
function kno_body_class( $wp_classes ) {

    $extra_classes = array();
    $whitelist = array( 'home', 'error404', 'logged-in' );

    $extra_classes[] = 'kno';
    $extra_classes[] = 'notranslate';
/*
    if ( is_page_template( 'template-about.php' ) )
        $extra_classes[] = 'wide';
*/

    if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() )
        $extra_classes[] = 'shop';

    if ( is_account_page() )
        $extra_classes[] = 'woocommerce-account';

    if ( is_page() ) {
        $template = str_replace( array( 'template-', '.php' ), array( 'page-', '' ), get_page_template_slug( get_queried_object_id() ) );
        if ( !empty( $template ) )
            $extra_classes[] = $template;
    }

    $wp_classes = array_intersect( $wp_classes, $whitelist );

    return array_merge( $wp_classes, (array) $extra_classes );
}

add_filter( 'enable_post_by_email_configuration', '__return_false');

add_filter( 'excerpt_length', 'kno_custom_excerpt_length', 999 );
function kno_custom_excerpt_length( $length ) {
    return 100;
}

add_filter( 'excerpt_more', 'kno_excerpt_more' );
function kno_excerpt_more( $more ) {
    return '...';
}

add_filter( 'embed_oembed_html', 'kno_embed_oembed_html', 99, 4 );
function kno_embed_oembed_html( $html, $url, $attr, $post_ID ) {

    $classes = array();
    $classes_all = array(
        'video-container',
    );
    if ( false !== strpos( $url, 'vimeo.com' ) )
        $classes[] = 'vimeo';

    if ( false !== strpos( $url, 'youtube.com' ) )
        $classes[] = 'youtube';

    $html = str_replace( '<iframe', '<iframe loading="lazy"', $html );

    $classes = array_merge( $classes, $classes_all );
    return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $html . '</div>';
}

add_filter( 'the_seo_framework_title_from_generation', 'kno_the_seo_framework_pre_add_title', 10, 3 );
function kno_the_seo_framework_pre_add_title( $title = '', $args = array(), $escape = true ) {
/*
    if ( is_shop_accessories() ) 
    return single_term_title( '', false );
*/
    if ( get_query_var( 'template' ) === 'search' )
        return __( 'Vyhľadávanie', 'kno' );

    if ( get_query_var( 'template' ) === 'archive-post' )
        $title = __( 'Blog', 'kno' );

    return $title;
}

add_filter( 'single_term_title', 'kno_single_term_title', 10, 1 );
function kno_single_term_title( $title ) {
    if ( is_shop_accessories() ) 
        return __( 'Ponuka príslušenstva', 'kno' );
    
    if ( is_shop_scooter() ) 
        return __( 'Ponuka skútrov', 'kno' );
}

add_filter( 'redirect_canonical', 'kno_template_redirect_canonical', 10, 2 );
function kno_template_redirect_canonical( $redirect_url, $requested_url ) {
    if ( ! empty( get_query_var( 'template' ) ) )
        return '';
}

add_filter( 'query_vars', 'kno_query_vars', 10, 1 );
function kno_query_vars( $query_vars ) {
    $new_vars = array( 'action', 'template', 'currency' );
    return array_merge( $new_vars, $query_vars );
}

add_filter( 'template_include', 'kno_template_include', PHP_INT_MAX, 1 );
function kno_template_include( $path ) {
    global $wp;
    global $wp_query;

    $template = get_query_var( 'template' );

    if ( !empty( $template ) && in_array( $template, array( 'archive-post' ) ) )
        $newpath = locate_template( $template . '.php' );

/*
    if ( is_search() || ( !empty( $template ) && in_array( $template, array( 'search' ) ) ) )
        $newpath = locate_template( 'search.php' );
*/

/*
    if ( !empty( $template ) && in_array( $template, array( 'archive-post', 'search' ) ) )
        $newpath = locate_template( $template . '.php' );
*/
/*
    if ( is_shop() )
        $newpath = locate_template( 'archive-product.php' );

    if ( is_tax( 'product_cat' ) )
        $newpath = locate_template( 'taxonomy-product_cat-term.php' );
*/

    if ( !empty( $template ) && $template === 'accessories' )
        $newpath = locate_template( 'woocommerce/taxonomy-product_cat.php' );
    
        if ( !empty( $template ) && $template === 'scooter' )
        $newpath = locate_template( 'woocommerce/taxonomy-product_cat.php' );

    if ( is_tax( 'product_cat' ) || is_shop() )
        $newpath = locate_template( 'woocommerce/taxonomy-product_cat.php' );

    if ( isset( $newpath ) )
        return $newpath;

    return $path;
};

add_filter( 'render_block', 'kno_render_block', 10, 2 );
function kno_render_block( $block_content, $block ) {

    $output = '';

    if ( !empty( $block['blockName'] ) && $block['blockName'] === 'core/table' ) {
        $output .= '<div class="table-wrapper">';
        $output .= $block_content;
        $output .= '</div>';
    }

    if ( !empty( $block['blockName'] ) && $block['blockName'] === 'core/buttons' ) {
        $block_content = str_replace( array( 'wp-block-buttons' ), array( 'btns-wrapper' ), $block_content );
    }

    if ( !empty( $block['blockName'] ) && $block['blockName'] === 'core/button' ) {

        if  ( isset( $block['attrs']['className'] ) ) {

            if ( strpos( $block['attrs']['className'], 'jump-' ) !== false ) {
                $class_names = explode( ' ', $block['attrs']['className'] );
                foreach ( $class_names as $class_name ) {
                    if ( strpos( $class_name, 'jump-' ) !== false ) {
                        $jump = str_replace( 'jump-', '', $class_name );
                        $output = preg_replace('/<a([^>]*)>(.*?)<\/a>/i', '<a$1 data-jump="' . $jump . '">$2</a>', $block_content);
                    }
                }
            }

            if ( strpos( $block['attrs']['className'], 'is-style-fill' ) !== false )
                $output = str_replace( array( ' is-style-fill', 'wp-block-button__link', 'wp-block-button' ), array( '', 'btn btn-gradient', 'btn-wrapper' ), $block_content );

            if ( strpos( $block['attrs']['className'], 'is-style-outline' ) !== false )
                $output = str_replace( array( ' is-style-outline', 'wp-block-button__link', 'wp-block-button' ), array( '', 'btn-border', 'btn-wrapper' ), $block_content );

        } else {
            $output = str_replace( array( 'wp-block-button ', 'wp-block-button', 'btn-wrapper__link' ), array( 'btn-wrapper', 'btn-wrapper', 'btn btn-gradient' ), $block_content );
        }
    }

/*
    if ( !empty( $block['blockName'] ) && $block['blockName'] === 'core/columns' ) {
        $output .= '<div data-sr=\'{ "distance": "0px", "delay": 0, "opacity": 0, "duration": 400, "viewFactor": 0.2 }\' data-sr-chain=".block-column" data-sr-chain-delay="50">';
        $output .= $block_content;
        $output .= '</div>';
    }
*/
/*
    if ( !empty( $block['blockName'] ) && $block['blockName'] === 'core/heading' ) {
        $output = preg_replace('/<h2([^>]*)>(.*?)<\/h2>/i', '<div class="headline-title-animation"><div class="title-overflow"><div data-sr=\'{ "origin": "bottom", "distance": "120%", "delay": 500, "opacity": 1, "duration": 1300, "viewFactor": 0.1 }\'><h2 class="headline-title headline-content-title">$2</h2></div></div></div><div class="headline-title-underline headline-content-underline gradient-horizontal" data-sr=\'{ "origin": "left", "rotate": { "x": "0", "y": "90", "z": "0" }, "distance": "0px", "delay": 0, "opacity": 1, "duration": 1000, "viewFactor": 0.9 }\'></div>', $block_content);

    }
*/
    return !empty( $output ) ? $output : $block_content;
}

add_filter( 'the_content', 'kno_the_content_after', PHP_INT_MAX );
function kno_the_content_after( $content ) {

    global $post;
/*
    $content = preg_replace( "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png|webp)('|\")(.*?)>/i", '<a$1href=$2$3.$4$5 rel="lightbox"$6>', $content ); // title="' . $post->post_title . '"

    $content = preg_replace_callback(
        '/(<a.[^>]*href=["\'])(.[^"^\']*?)(["\'])([^>]*)(>)/sU',
        'kno_parse_photoswipe',
        $content
    );
*/

    $content = preg_replace( "/<ol start=('|\")(.*?)('|\")/i", '<ol start=$1$2$3  style="--format-counter:$2"', $content );

    $content = str_replace( array(
            'wp-block-',
            'wp-embed-',
            'tribe-',
            'ek-link',
            'class=""'
            //'<h3>',
            //'</span></h3>',
            //'</h3>',
        ), array(
            'block-',
            'embed-',
            '',
            '',
            '',
            //'<h3><span class="text-gradient">',
            //'</h3>',
            //'</span></h3>'
        ), $content );

    return $content;
}

add_filter( 'ajax_query_attachments_args', 'kno_set_pdf_as_thumbnail', 10, 1 );
function kno_set_pdf_as_thumbnail( $query = array() ) {

    if ( isset( $query['post_mime_type'] ) && $query['post_mime_type'] === 'image' ) {
        $query['post_mime_type'] = array( 'image', 'application/pdf' );
    }

    return $query;
}

add_filter( 'post_thumbnail_html', 'kno_post_thumbnail_html', 20, 5 );
function kno_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    if ( empty( $html ) ) {
        return sprintf(
            '<img src="%s" height="%s" width="%s" class="%s" />',
            get_template_directory_uri() . '/img/placeholder.svg',
            768,
            452,
            $attr['class']
        );
    } else {
        return str_replace( '<img', '<img loading="lazy"', $html );
    }
}

/*
add_filter( 'get_the_excerpt', 'kno_get_the_excerpt' );
function kno_get_the_excerpt( $excerpt ) {
    global $post;
    if ( ! function_exists( 'searchwp_term_highlight_get_the_excerpt_global' ) || 'attachment' !== get_post_type( $post ) || is_admin() )
        return $excerpt;

    remove_filter( current_filter(), __FUNCTION__ );

    if ( is_search() )
        $excerpt = searchwp_term_highlight_get_the_excerpt_global( $post->ID, null, get_search_query() );
    else if ( get_post_field( 'post_content', get_the_ID() ) === '' && get_post_mime_type( get_the_ID() ) === 'application/pdf' )
        $excerpt = wp_trim_words( get_post_meta( get_the_ID(), 'searchwp_content', true ), 20, '' );

    add_filter( current_filter(), __FUNCTION__ );
    return $excerpt;
}
*/

add_filter( 'apf', 'kno_apf', 10, 3 );
function kno_apf( $data, $form, $user_id ) {
    //unset( $data['tabs']['Contact Info'] );
    unset( $data['tabs']['Other settings'] );
    unset( $data['tabs']['Mailster'] );
    //unset( $data['tabs']['Personal Options'] );
    //unset( $data['tabs']['Customer shipping address'] );
    return $data;
}

add_filter( 'core_breadcrumb_trail_items', 'kno_core_breadcrumb_trail_items', 10, 2 );
function kno_core_breadcrumb_trail_items( $items, $args ) {

    if ( is_tax( 'product_cat')) { // && pll_get_term( get_queried_object_id(), pll_default_language() ) == get_shop_accessories_id() 
        unset( $items[1] );
        $items[] = single_term_title( '', false );
    }

    if ( $accessories_term = is_product_shop_accessories() ) {

        unset( $items[1] );
        array_splice( $items, 1, 0, sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $accessories_term->term_id ) ), __( 'Ponuka príslušenstva', 'kno' ) ) );
        
    }
    
    if ( $scooter_term = is_product_shop_scooter() ) {

        unset( $items[1] );
        array_splice( $items, 1, 0, sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $scooter_term->term_id ) ), __( 'Ponuka skútrov', 'kno' ) ) );
        
    }

    return $items;
}

add_filter( 'core_breadcrumb_trail_labels', 'kno_core_breadcrumb_trail_labels', 10, 1 );
function kno_core_breadcrumb_trail_labels( $labels ) {
    $labels['home'] = '<svg class="icon icon-home lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-home"></use></svg>';
    return $labels;
}

add_filter( 'term_link', 'kno_term_link', 10, 3 );
function kno_term_link( $url, $term, $taxonomy ) {
    if ( 'product_cat' === $taxonomy ) {
        if ( function_exists( 'pll_get_term' ) ) {
            if ( pll_get_term( $term->term_id, pll_default_language() ) == get_shop_accessories_id() ) { // Příslušenství, mělo by fungovat i pro EN a DE
                return home_url( trailingslashit( $term->slug ) );
            }
        }
        if ( function_exists( 'pll_get_term' ) ) {
            if ( pll_get_term( $term->term_id, pll_default_language() ) == get_shop_scooter_id() ) { // Skútry, mělo by fungovat i pro EN a DE
                return home_url( trailingslashit( $term->slug ) );
            }
        }
        if ( function_exists( 'pll_home_url' ) )
            $url = pll_home_url( 'ponuka-bicyklov/?_category=' . $term->slug );
        else
            $url = home_url( 'ponuka-bicyklov/?_category=' . $term->slug );
    }

    return $url;
}

add_filter( 'pll_translation_url', 'kno_pll_translation_url', -1, 2 );
function kno_pll_translation_url( $url, $language ) {
    remove_all_filters( 'pll_translation_url' );
    return $url;
}

add_filter( 'pre_option_alg_checkout_files_upload_hook_1', 'kno_alg_checkout_files_upload_hook_1', 10, 3 );
function kno_alg_checkout_files_upload_hook_1( $pre_option, $option, $default ) {
    return 'woocommerce_checkout_shipping';
}

?>