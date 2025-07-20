<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

$object = get_queried_object();

?>

<div class="container">

    <?php do_action( 'woocommerce_output_all_notices', 10 ); ?>

    <?php if ( function_exists('bcn_display') ): ?>
    <div class="breadcrumbs" vocab="http://schema.org/" typeof="BreadcrumbList">
        <?php bcn_display(); ?>
    </div>
    <?php endif; ?>

    <div class="format">
        <h1 class="h1 title"><?php woocommerce_page_title(); ?></h1>
    </div>

    <?php

    if ( woocommerce_product_loop() ) {

        woocommerce_product_loop_start();

            while ( have_posts() ) {
                the_post(); ?>

                <div class="col-xs-6 col-lg-4 mb">
                <?php
                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product' ); ?>
                </div>
            <?php }

        woocommerce_product_loop_end(); ?>

        <div class="category-bar category-bar-bottom flex middle-xs">

        <?php
        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 5 );
        do_action( 'woocommerce_after_shop_loop' ); ?>

        </div>

        <?php
    }
    ?>
</div>

<?php get_template_part( 'template-parts/components/banner-thimm' ); ?>

<?php get_footer( 'shop' ); ?>