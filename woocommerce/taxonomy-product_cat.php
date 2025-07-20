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
 * @version     4.7.0
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

$description = term_description();
$description_part = explode( '<hr />', $description );
?>

<div class="container">

	<?php do_action( 'woocommerce_output_all_notices', 10 ); ?>

	<?php core_get_breadcrumb(); ?>

	<h1><?php woocommerce_page_title(); ?></h1>

	<?php

	if ( woocommerce_product_loop() ) {

		$classes = 'filter toggle-content ns';

		if ( kno_is_filter() )
		    $classes .= ' is-visible';

		?>
		<div class="searching">
				<?php echo do_shortcode('[facetwp facet="hledani"]') ?>
	</div>
		<div class="<?php echo esc_attr( $classes ); ?>" id="filter">
			<div class="filter-inner flex">
	            <div class="filter-category">
	                <label><?php _e( 'Typ bicyklu', 'kno' ); ?></label>
	                <?php echo facetwp_display( 'facet', 'category' ); ?>
	            </div>
				<div class="filter-category">
	                <label><?php _e( 'Druh bicyklu', 'kno' ); ?></label>
	                <?php echo facetwp_display( 'facet', 'species' ); ?>
	            </div>
	            <div class="filter-brand">
	                <label><?php _e( 'Značka', 'kno' ); ?></label>
	                <?php echo facetwp_display( 'facet', 'brand' ); ?>
	            </div>
                <?php /*
                <div class="filter-year">
                    <label><?php _e( 'Rok výroby', 'kno' ); ?></label>
                    <?php echo facetwp_display( 'facet', 'year' ); ?>
                </div>
                */ ?>
	            <div class="filter-price">
	                <label><?php _e( 'Výška mesačnej splátky', 'kno' ); ?></label>
	                <?php echo facetwp_display( 'facet', 'price' ); ?>
	                <button class="btn-empty btn-reset" onclick="FWP.reset()"><?php _e( 'zrušiť filter' ); ?></button>
	            </div>
	        </div>
		</div>

		<div class="order-n-pagination flex middle-xs">

		<?php
		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

		add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 35 );
		add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 25 );
		add_action( 'woocommerce_before_shop_loop', 'woocommerce_filter', 30 );

		do_action( 'woocommerce_before_shop_loop' ); ?>

		</div>

		<?php woocommerce_product_loop_start();

		$has_featured = 0;

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
				?>
				<?php if ( $product->is_featured() && $wp_query->current_post == 0 ): $has_featured++; ?>
				<div class="list-product featured">
				<?php else :?>
				<div class="list-product">
				<?php endif; ?>

				<?php
				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' ); ?>
				</div>

			

			<?php }
		}

		woocommerce_product_loop_end(); ?>

		<div class="order-n-pagination order-n-pagination-bottom flex middle-xs">

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

	<?php if ( !empty( $description ) && isset( $description_part[0] ) ): ?>
	<div class="category-description">
		<div class="arrow-offset mb">
			<svg class="icon icon-arrow-line lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-line"></use></svg>

			<?php echo apply_filters( 'the_content', $description_part[0] ); ?>

		</div>
	</div>
	<?php endif; ?>

	<?php if ( !empty( $description_part ) && isset( $description_part[1] ) ): ?>
	<div class="category-description-bottom">

		<div class="format">
			<?php echo apply_filters( 'the_content', $description_part[1] ); ?>
		</div>

		<?php if ( isset( $description_part[2] ) ): ?>
		<button data-toggle="#category-description-hidden" data-toggle-more="<?php _e( 'čítať viac', 'kno' ); ?>" data-toggle-hide="<?php _e( 'skryť obsah', 'kno' ); ?>"><span><?php _e( 'čítať viac', 'kno' ); ?></span><svg class="icon icon-arrow-down lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-down"></use></svg></button>
		<div id="category-description-hidden" class="toggle-content">
			<div class="format">
				<?php echo apply_filters( 'the_content', $description_part[2] ); ?>
			</div>
		</div>
		<?php endif; ?>

	</div>
	<?php endif; ?>

</div>

<?php echo do_blocks( get_post( get_option( 'woocommerce_shop_page_id' ) )->post_content ); ?>

<?php get_footer( 'shop' ); ?>