<?php



class KNO_Walker_Nav_Menu extends Walker_Nav_Menu {



    private $is_visible;

    private $item_id;



    function start_lvl( &$output, $depth = 0, $args = array() ) {

        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent

        $display_depth = ( $depth + 1); // because it counts the first submenu as 0

        $classes = array(



            //( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),

            //( $display_depth >=2 ? 'sub-sub-menu' : '' ),

            //'menu-depth-' . $display_depth

        );



        if ( $args->position === 'mobile' )

            $classes[] = 'list-bare toggle-content';

        else

            $classes[] = 'sub-menu';



        if ( $this->is_visible ) {

            $classes[] = 'is-visible';

        }

        /*

        if ( isset( $args->walker->has_children ) && in_array( 'current', $classes ) ) {

            $atts['class'] .= ' is-visible';

        }

*/



        $class_names = implode( ' ', $classes );



        if ( $args->position === 'mobile' )

            $output .= "\n" . $indent . '<ul class="' . $class_names . '" id="mobile-sub-menu-' . $this->item_id . '">' . "\n";

        else

            $output .= "\n" . $indent . '<div class="' . $class_names . '" id="sub-menu-' . $this->item_id . '"><span class="sub-menu-arrow"></span><ul class="list-bare">' . "\n";



    }

    function end_lvl( &$output, $depth = 0, $args = null ) {

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {

            $t = '';

            $n = '';

        } else {

            $t = "\t";

            $n = "\n";

        }

        $indent  = str_repeat( $t, $depth );

        $output .= "$indent</ul></div>{$n}";

    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

      

        global $wp_query;

        $this->is_visible = false;

        $this->item_id = $item->ID;



        $atts = array();



        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );



        $depth_classes = array(

            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),

            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),

            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),

            'menu-item-depth-' . $depth

        );

        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );



        $classes = empty( $item->classes ) ? array() : (array) $item->classes;



        $icon = '';

        foreach( $classes as $key => $val ) {

            if ( 'jump-' == substr( $val, 0, 5 ) ) {

                $atts['data-jump'] = str_replace( 'jump-', '', $classes[$key] );

                unset( $classes[$key] );

            }

            if ( 'modal-' == substr( $val, 0, 6 ) ) {

                $atts['data-modal'] = str_replace( 'modal-', '', $classes[$key] );

                unset( $classes[$key] );

            }

            if ( 'not-force' == $val ) {

                unset( $classes[$key] );

                $not_force = true;

            }

            if ( 'icon-' == substr( $val, 0, 5 ) ) {

                $icon = '<svg class="icon ' . $classes[$key] . ' lazyload" aria-hidden="false" focusable="false" role="img"><use xlink:href="#' . $classes[$key] . '"></use></svg>';

                unset( $classes[$key] );

            }

        }



        global $wp_query;

/*

        if ( ( is_post_type_archive( 'advert' ) || is_singular( 'advert' ) || is_tax( 'advert_category' ) ) && $item->object === 'advert' )

            $classes[] = 'current';

*/



        if ( ( is_post_type_archive( 'event' ) || is_singular( 'event' ) || is_tax( 'event_category' ) ) && $item->object === 'event' && isset( $wp_query->query['past'] ) && $item->title === 'Future events' ) {

            $classes = array(

                'menu-item',

                'menu-item-type-post_type_archive',

                'menu-item-object-event'

            );

        }



        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes ) ) {

            $classes[] = 'current';

        }



        if ( in_array( 'current_post_ancestor', $classes) || in_array( 'current_page_ancestor', $classes) ) {

            $classes[] = 'current-ancestor';

        }



        if ( in_array( 'menu-item-has-children', $classes) ) {

            $classes[] = 'has-sub-menu';

        }



        if ( is_tax( 'product_cat' ) && $item->object === 'page' && $item->type === 'post_type' && pll_get_post( $item->object_id ) == 5 ) { //$item->title === 'Nabídka kol' //

            $classes = array();

        }



        $whitelist = array(

            'current',

            'current-ancestor',

            'has-sub-menu',

            'is-visible'

        );

        if ( $optional = array_filter( (array)get_post_meta( $item->ID, '_menu_item_classes', true ) ) ) {

            $whitelist = array_merge( $whitelist, $optional );

        }

        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_intersect( $classes, $whitelist ), $item ) ) );

        $class_names = trim( ( ( isset( $args->menu_class_add ) ) ? $args->menu_class_add . '-' : '' ) . 'menu-item menu-item ' . $class_names );



        $output .= $indent . '<li class="' . $class_names . '">';



        $atts['title']    = ! empty( $item->attr_title )  ? $item->attr_title  : '';

        $atts['target']   = ! empty( $item->target )      ? $item->target      : '';

        $atts['rel']      = ! empty( $item->xfn )         ? $item->xfn         : '';

        $atts['href']     = ! empty( $item->url )         ? $item->url         : '';

        if ( !isset( $atts['class'] ) )
            $atts['class'] = '';
/*

        $args->after = '';

        $args->link_after = '';

*/

        if( isset( $args->walker->has_children ) && isset( $args->position ) && $args->position === 'primary' ) {

            //$atts['class'] = 'toggle';

            $args->link_after = '<svg class="icon icon-caret-down lazyload" aria-hidden="false" focusable="false" role="img"><use xlink:href="#icon-caret-down"></use></svg>';



        }

        if ( isset( $args->walker->has_children ) && ( in_array( 'current', $classes ) || in_array( 'current-ancestor', $classes ) ) ) {

            $atts['class'] .= ' is-visible';

            $this->is_visible = true;

        }



        if ( !isset( $atts['class'] ) )

            $atts['class'] = '';

/*

        if( isset( $args->walker->has_children ) && $args->position === 'mobile' ) {

            $args->after = '<button type="button" aria-label="' . __( 'Zobrazit menu', 'kno' ) . '" aria-haspopup="true" aria-expanded="' . ( ( in_array( 'current', $classes ) || in_array( 'current-ancestor', $classes ) ) ? 'true' : 'false' ) . '" data-toggle="#mobile-sub-menu-' . $item->ID . '" class="toggle ' . $atts['class'] . '"><svg class="icon icon-caret-right lazyload" aria-hidden="false" focusable="false" role="img"><use xlink:href="#icon-caret-right"></use></svg></button>';

            //$atts['data-toggle'] = '#mobile-sub-menu-' . $item->ID;



            if ( $atts['href'] === '#' ) {

                $atts['data-toggle'] = '#mobile-sub-menu-' . $item->ID;

                $atts['class'] = 'toggle';

            }

        }

*/

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );



        $attributes = '';

        foreach ( $atts as $attr => $value ) {

            if ( ! empty( $value ) ) {

                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';

            }

        }



        $item_output = sprintf( '%1$s<a%2$s>%3$s</a>%4$s',

            $args->before,

            $attributes,

            apply_filters( 'the_title', $item->title, $item->ID ),

            $args->after

        );

/*

        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',

            $args->before,

            $attributes,

            $args->link_before,

            $icon . apply_filters( 'the_title', $item->title, $item->ID ),

            $args->link_after,

            $args->after

        );

*/

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }

}



class KNO_Walker_Category extends Walker_Category {



    function start_lvl(&$output, $depth=1, $args=array()) {

        $output .= "\n<ul class=\"product_cats\">\n";

    }



    function end_lvl(&$output, $depth=0, $args=array()) {

        $output .= "</ul>\n";

    }



    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

        $cat_name = apply_filters(

            'list_cats',

            esc_attr( $category->name ),

            $category

        );



        if ( ! $cat_name ) {

            return;

        }



        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';

        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {

            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';

        }



        $link .= '>';

        $link .= $cat_name . '</a>';



        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {

            $link .= ' ';



            if ( empty( $args['feed_image'] ) ) {

                $link .= '(';

            }



            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';



            if ( empty( $args['feed'] ) ) {

                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';

            } else {

                $alt = ' alt="' . $args['feed'] . '"';

                $name = $args['feed'];

                $link .= empty( $args['title'] ) ? '' : $args['title'];

            }



            $link .= '>';



            if ( empty( $args['feed_image'] ) ) {

                $link .= $name;

            } else {

                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';

            }

            $link .= '</a>';



            if ( empty( $args['feed_image'] ) ) {

                $link .= ')';

            }

        }



        if ( ! empty( $args['show_count'] ) ) {

            $link .= ' (' . number_format_i18n( $category->count ) . ')';

        }

        if ( 'list' == $args['style'] ) {

            $output .= "\t<li";

            $css_classes = array(

                'cat-item',

                'cat-item-' . $category->term_id,

            );



            if ( ! empty( $args['current_category'] ) ) {

                $_current_terms = get_terms( $category->taxonomy, array(

                    'include' => $args['current_category'],

                    'hide_empty' => false,

                ) );



                foreach ( $_current_terms as $_current_term ) {

                    if ( $category->term_id == $_current_term->term_id ) {

                        $css_classes[] = 'current-cat';

                    } elseif ( $category->term_id == $_current_term->parent ) {

                        $css_classes[] = 'current-cat-parent';

                    }

                    while ( $_current_term->parent ) {

                        if ( $category->term_id == $_current_term->parent ) {

                            $css_classes[] =  'current-cat-ancestor';

                            break;

                        }

                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );

                    }

                }

            }

            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );



            $output .=  ' class="' . $css_classes . '"';

            $output .= ">$link\n";

        } elseif ( isset( $args['separator'] ) ) {

            $output .= "\t$link" . $args['separator'] . "\n";

        } else {

            $output .= "\t$link<br />\n";

        }

    }



    function end_el(&$output, $item, $depth=0, $args=array()) {

        $output .= "</li>\n";

    }

}





class KNO_Walker_Page extends Walker_Page {



    public function start_lvl( &$output, $depth = 0, $args = array() ) {

        if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {

            $t = "\t";

            $n = "\n";

        } else {

            $t = '';

            $n = '';

        }

        $indent = str_repeat( $t, $depth );

        $output .= "{$n}{$indent}<div class='children'><ul>{$n}";

    }



    public function end_lvl( &$output, $depth = 0, $args = array() ) {

        if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {

            $t = "\t";

            $n = "\n";

        } else {

            $t = '';

            $n = '';

        }

        $indent = str_repeat( $t, $depth );

        $output .= "{$indent}</ul></div>{$n}";

    }



    public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {



        if ( get_post_meta( $page->ID, 'menu_disabled', true ) )

            return;



        if ( 'preserve' === $args['item_spacing'] ) {

            $t = "\t";

            $n = "\n";

        } else {

            $t = '';

            $n = '';

        }

        if ( $depth ) {

            $indent = str_repeat( $t, $depth );

        } else {

            $indent = '';

        }



        $css_class = array( 'middle-menu-item' ); //array( 'page_item', 'page-item-' . $page->ID );



        if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {

            $css_class[] = 'page_item_has_children';

        }



        if ( ! empty( $current_page ) ) {

            $_current_page = get_post( $current_page );

            if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {

                $css_class[] = 'current_page_ancestor';

            }

            if ( $page->ID == $current_page ) {

                $css_class[] = 'current';

            } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {

                $css_class[] = 'current current-ancestor';

            }

        } elseif ( $page->ID == get_option( 'page_for_posts' ) ) {

            $css_class[] = 'current current-ancestor';

        }



        $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );



        if ( '' === $page->post_title ) {

            $page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );

        }



        $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];

        $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];



        $can_view = members_can_current_user_view_post( $page->ID );

        $target = '';



        if ( !$can_view )

            $args['link_before'] .= '<svg class="icon icon-lock lazyload" aria-hidden="false" focusable="false" role="img"><use xlink:href="#icon-lock"></use></svg>';

        elseif ( get_post_meta( $page->ID, 'star', true ) )

            $args['link_before'] .= '<svg class="icon icon-star lazyload" aria-hidden="false" focusable="false" role="img"><use xlink:href="#icon-star"></use></svg>';



        $redirect = get_post_meta( $page->ID, 'redirect_to', true );



        if ( $redirect === 'url' ) {

            if ( $can_view ) {

                $target = ' target="_blank"';

                $redirect_url = get_post_meta( $page->ID, 'redirect_url', true );

                if ( isset( $redirect_url['internal'] ) && $redirect_url['internal'] === 1 )

                    $target = '';

            }

        }



        $title = array( $page->post_title );



        global $wpdb;

        $parent_count = $wpdb->get_var( $wpdb->prepare(

            "

                SELECT COUNT(*)

                FROM $wpdb->posts

                WHERE post_parent = %s

                AND post_type NOT IN ('revision', 'attachment')

                AND post_status = 'publish'

            ",

            $page->ID

        ) );



        if ( $parent_count > 0 ) {

            $title[] = sprintf( esc_html( _n( 'obsahuje 1 podstránku.', 'obsahuje %s podstránek.', $parent_count, 'kno' ) ), $parent_count );

            $args['link_after'] = '<span class="menu-item-counter">' . $parent_count . '</span>' . $args['link_after'];

            $css_classes .= ' menu-item-has-counter';

        }



        if ( $parent_count > 5 ) {

            $css_classes .= ' menu-item-has-children-more';

        }



        $menu_title = ( get_post_meta( $page->ID, 'menu_title', true ) ) ? get_post_meta( $page->ID, 'menu_title', true ) : $page->post_title;





        $parent = '';

        $output .= $indent . sprintf(

            '<li class="%s"><a href="%s"%s%s><span>%s%s%s</span></a>',

            trim( $css_classes ),

            get_permalink( $page->ID ),

            $target,

            $parent . ' title="' . implode( ' - ', $title ) . '"',

            $args['link_before'],

            /** This filter is documented in wp-includes/post-template.php */

            apply_filters( 'the_title', $menu_title, $page->ID ),

            $args['link_after']

        );



        if ( ! empty( $args['show_date'] ) ) {

            if ( 'modified' == $args['show_date'] ) {

                $time = $page->post_modified;

            } else {

                $time = $page->post_date;

            }



            $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];

            $output .= " " . mysql2date( $date_format, $time );

        }

    }

}



?>