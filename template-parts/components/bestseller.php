<?php

global $wpdb;
$limit = 4;

$month_sales_enable = true;
$month_sales = null;

if ( $month_sales_enable ) {
    $limit_clause = intval( $limit ) <= 0 ? '' : 'LIMIT '. intval( $limit );
    $curent_month = date('Y-m-01 00:00:00');
    $month_sales = (array) $wpdb->get_results("
        SELECT p.ID as id, COUNT(oim2.meta_value) as count
        FROM {$wpdb->prefix}posts p
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim
            ON p.ID = oim.meta_value
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim2
            ON oim.order_item_id = oim2.order_item_id
        INNER JOIN {$wpdb->prefix}woocommerce_order_items oi
            ON oim.order_item_id = oi.order_item_id
        INNER JOIN {$wpdb->prefix}posts as o
            ON o.ID = oi.order_id
        WHERE p.post_type = 'product'
        AND p.post_status = 'publish'
        AND o.post_status IN ('wc-processing','wc-completed')
        /*AND o.post_date >= '$curent_month'*/
        AND oim.meta_key = '_product_id'
        AND oim2.meta_key = '_qty'
        GROUP BY p.ID
        ORDER BY COUNT(oim2.meta_value) + 0 DESC
        $limit_clause
    ");
}

if ( !empty( $month_sales ) ) {

/*
    $args = array(
        'post_type'      => 'product',
        'post_status'    => array( 'publish' ),
        'orderby'        => 'meta_value_num',
        'posts_per_page' => $limit,
        'post__in'       => wp_list_pluck( $month_sales, 'id' )
    );
*/

    $ids = wp_list_pluck( $month_sales, 'id' );
    if ( count( $ids ) < 4 ) {
        $rest = wc_get_products( array(
            'status'         => array( 'publish' ),
            'limit'          => $limit,
            'meta_key'       => 'total_sales',
            'orderby'        => array( 'meta_value_num' => 'DESC', 'title' => 'ASC' ),
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key' => '_thumbnail_id'
                ),
            )
        ) );
        $rest_ids = wp_list_pluck( $rest, 'id' );

        $ids = array_slice( array_merge( $ids, $rest_ids ), 0, $limit * 2);
    }
    $args = array(
        //'post_type'      => 'product',
        'status'         => array( 'publish' ),
        //'orderby'        => 'meta_value_num',
        'include'        => $ids,
        'limit'          => $limit,
        //'return'         => 'ids',
    );

} else {

    /*
    $args = array(
        'post_type'      => 'product',
        'post_status'    => array( 'publish' ),
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key' => '_thumbnail_id'
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
            ),
        )
    );
    */

    $args = array(
        'status'         => array( 'publish' ),
        'limit'          => $limit,
        //'featured'       => true,
        'meta_key'       => 'total_sales',
        'orderby'        => array( 'meta_value_num' => 'DESC', 'title' => 'ASC' ),
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key' => '_thumbnail_id'
            ),
        ),
    );

}

//$bestseller = new WP_Query( $args );
$bestseller = wc_get_products( $args );

if ( is_admin() )
    $bestseller = array();

if ( !empty( $bestseller ) ): ?>
<div class="bestseller">
    <div class="container">

        <h2 class="section-title has-text-align-center">
<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.52 27.57">
  <defs>
    <style>
      .cls-1 {
        fill: #12364a;
      }
    </style>
  </defs>
  <path class="cls-1" d="m26.3,9.96l4.58,8.97c.25.47.6.7,1.06.71.96.02,1.66-1.08,1.18-1.92L24.84,1.17C24.47.45,23.73,0,22.91,0h-2.65s0,2.42,0,2.42l2.12-.02s.06.04.09.06c0,0,1.91,3.73,2.53,4.94.02.04.02.09-.02.13-1.49,1.75-4.16,4.93-5.57,6.59-.05.06-.14.05-.18-.02-.75-1.38-2.25-4.17-2.97-5.5-.06-.11-.01-.17.08-.17h.83v-2.44h-5.84v2.44h2.27s.06.01.07.04c1.1,1.98,4.68,8.41,4.68,8.41.29.46,1.43.5,1.91-.04l5.84-6.9c.05-.06.14-.04.17.02m6.19.49v2.38c3.09.04,5.65,2.54,5.66,5.71.07,3.12-2.7,5.78-5.82,5.75-3.17-.03-5.75-2.51-5.82-5.61h-2.38c.05,3.55,2.45,6.55,5.71,7.59,1.57.51,3.41.5,5,0,3.3-1.03,5.76-4.27,5.7-7.74-.01-4.5-3.6-8.03-8.03-8.08m-24.29,13.84c-3.19-.03-5.77-2.56-5.82-5.7-.05-3.07,2.62-5.75,5.68-5.76v-2.38C3.71,10.44-.07,14.26,0,18.61c.06,3.56,2.39,6.56,5.62,7.64,1.62.54,3.53.53,5.17,0,3.2-1.04,5.61-4.18,5.6-7.56h-2.38c-.01,3.07-2.74,5.63-5.82,5.61"/>
</svg>

            <?php _e( 'Najviac máte záujem o', 'kno' ); ?>
        </h2>

        <div class="bestseller-product">
            <?php woocommerce_product_loop_start(); ?>

                <?php foreach( $bestseller as $product ):

                    $post_object = get_post( $product->get_id() );
                    setup_postdata( $GLOBALS['post'] =& $post_object );

                    ?>
                    <div class="list-product">
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    </div>
                <?php endforeach; wp_reset_postdata(); ?>

            <?php woocommerce_product_loop_end(); ?>
        </div>
    </div>
</div>
<?php endif; ?>