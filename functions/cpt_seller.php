<?php

add_action( 'init', 'seller_run', 11 );
function seller_run() {
/*

    register_post_type( 'seller', array(
        'description'         => __( 'Síť prodejen', 'ibd' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_in_nav_menus'   => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-layout',
        'can_export'          => true,
        'delete_with_user'    => false,
        'hierarchical'        => false,
        'has_archive'         => 'sit-prodejen',
        'query_var'           => true,
        'capability_type'     => 'seller',
        'map_meta_cap'        => true,
        'show_in_rest'        => true,
        'rewrite'             => array(
            'slug'       => 'prodejna',
            'with_front' => false
        ),
        'supports' => array(
            'title',
            //'editor',
            //'excerpt',
            //'author',
            'thumbnail',
            //'comments',
            //'trackbacks',
            //'custom-fields',
            'revisions',
            //'page-attributes',
            //'post-formats'
        ),
        'labels'   => array(
            'name'                      => __( 'Síť prodejen', 'ibd' ),
            'singular_name'             => __( 'Prodejna', 'ibd' ),
            'menu_name'                 => __( 'Síť prodejen', 'ibd' ),
            'name_admin_bar'            => __( 'Síť prodejen', 'ibd' ),
            'add_new'                   => __( 'Přidat novou', 'ibd' ),
            'add_new_item'              => __( 'Přidat novou prodejnu', 'ibd' ),
            'edit_item'                 => __( 'Upravit prodejnu', 'ibd' ),
            'new_item'                  => __( 'Nová prodejna', 'ibd' ),
            'view_item'                 => __( 'Zobrazit prodejnu', 'ibd' ),
            'search_items'              => __( 'Vyhledat prodejnu', 'ibd' ),
            'not_found'                 => __( 'Nebyly nalezeny žádné prodejny.', 'ibd' ),
            'not_found_in_trash'        => __( 'V koši nebyly nalezeny žádné prodejny.', 'ibd' ),
            'all_items'                 => __( 'Všechny prodejny', 'ibd' ),
            'featured_image'            => __( 'Náhled prodejny', 'ibd' ),
            'set_featured_image'        => __( 'Nastavit náhled prodejny', 'ibd' ),
            'remove_featured_image'     => __( 'Odstranit náhled prodejny', 'ibd' ),
            'use_featured_image'        => __( 'Použít jako náhled prodejny', 'ibd' ),
            'insert_into_item'          => __( 'Vložit k prodejně', 'ibd' ),
            'uploaded_to_this_item'     => __( 'Nahráno k prodejně', 'ibd' ),
            'views'                     => __( 'Třídit seznam prodejen', 'ibd' ),
            'pagination'                => __( 'Navigace prodejen', 'ibd' ),
            'list'                      => __( 'Seznam prodejen', 'ibd' ),
            'parent_item'               => __( 'Nadřazená prodejna', 'ibd' ),
            'parent_item_colon'         => __( 'Nadřazená prodejna:', 'ibd' ),
            'attributes'                => __( 'Atributy prodejny:', 'ibd' ),
        ),
        'extras' => array(
            'enter_title_here' => __( 'Zadejte název prodejny', 'ibd' ),
        )
    ));

*/

    register_taxonomy( 'seller', array( 'product' ), array(
        'labels'                     =>  array(
            'name'                      => __( 'Prodejci', 'ibd' ),
            'singular_name'             => __( 'Prodejce', 'ibd' ),
            'menu_name'                 => __( 'Prodejci', 'ibd' ),
            'all_items'                 => __( 'Všichni prodejci', 'ibd' ),
            'parent_item'               => __( 'Nadřazení prodejci', 'ibd' ),
            'parent_item_colon'         => __( 'Nadřazení prodejci:', 'ibd' ),
            'new_item_name'             => __( 'Nový prodejce', 'ibd' ),
            'add_new_item'              => __( 'Přidat nového prodejce', 'ibd' ),
            'edit_item'                 => __( 'Upravit prodejce', 'ibd' ),
            'update_item'               => __( 'Aktualizovat prodejce', 'ibd' ),
            'view_item'                 => __( 'Zobrazit', 'ibd' ),
            'separate_items_with_commas'=> __( 'Oddělte prodejce čárkami', 'ibd' ),
            'add_or_remove_items'       => __( 'Přidat či odebrat prodejce', 'ibd' ),
            'choose_from_most_used'     => __( 'Vyberte z nejpoužívanějších prodejců', 'ibd' ),
            'popular_items'             => __( 'Populární prodejci', 'ibd' ),
            'search_items'              => __( 'Vyhledat prodejce', 'ibd' ),
            'not_found'                 => __( 'Nebyly nalezeni žádní prodejci.', 'ibd' ),
            'items_list'                => __( 'Seznam prodejců', 'ibd' ),
            'items_list_navigation'     => __( 'Seznam prodejců', 'ibd' )
        ),
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'meta_box_cb'                => 'post_categories_meta_box',
        'show_in_menu'               => true,
        'show_in_quick_edit'         => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_in_rest'               => true,
        'show_tagcloud'              => false,
        'query_var'                  => 'seller',
        'rewrite'                    => array(
            'slug'       => 'prodejci',
            'with_front' => false,
        ),
        'capabilities' => array(
            'manage_terms'  => 'manage_product_terms',
            'edit_terms'    => 'edit_product_terms',
            'delete_terms'  => 'delete_product_terms',
            'assign_terms'  => 'assign_product_terms'
        )
    ) );

}

?>