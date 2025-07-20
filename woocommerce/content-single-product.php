<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<?php core_get_breadcrumb(); ?>

<?php edit_post_link( __( 'Upravit produkt', 'kno' ), '<p>', '</p>', null, 'btn btn-sm' ); ?>

<div id="product-<?php echo $product->get_id(); ?>" <?php wc_product_class( '', $product ); ?>>

	<div class="product-grid<?php if ( count( $product->get_gallery_image_ids() ) == 0 ) echo ' product-grid-no-gallery'; ?>">

		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
		do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="product-info">

			<?php woocommerce_template_single_title(); ?>

			<?php if ( wc_product_sku_enabled() && $product->get_sku() ) : ?>

				<div class="product-sku">SKU: <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></div>

			<?php endif; ?>

			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

			add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 8);
/*
			if ( $product->is_type( 'simple' ) )
				add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 45);
*/
			//add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 55);

			do_action( 'woocommerce_single_product_summary' );

			?>

			<?php woocommerce_template_single_add_to_cart(); ?>

		</div>

	</div>

	<div class="product-icons flex middle-xs">
		<div class="product-icon">
			<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'%3E%3C/svg%3E" data-srcset="<?php echo get_template_directory_uri(); ?>/img/servis.png 1x, <?php echo get_template_directory_uri(); ?>/img/servis@2x.png 2x" width="50" height="50" alt="servis" class="lazyload">
			<?php _e( 'Voliteľný servis na&nbsp;4.500 km', 'kno' ); ?>
		</div>
		<div class="product-icon">
			<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'%3E%3C/svg%3E" data-srcset="<?php echo get_template_directory_uri(); ?>/img/zaruka.png 1x, <?php echo get_template_directory_uri(); ?>/img/zaruka@2x.png 2x" width="50" height="50" alt="záruka" class="lazyload">
			<?php _e( '2-ročnú záruku', 'kno' ); ?>
		</div>
		<div class="product-icon">
			<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'%3E%3C/svg%3E" data-srcset="<?php echo get_template_directory_uri(); ?>/img/pojisteni.png 1x, <?php echo get_template_directory_uri(); ?>/img/pojisteni@2x.png 2x" width="50" height="50" alt="pojištění" class="lazyload">
			<?php _e( 'Poistenie po celú dobu nájmu', 'kno' ); ?>
		</div>
		<div class="product-icon">
			<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'%3E%3C/svg%3E" data-srcset="<?php echo get_template_directory_uri(); ?>/img/dph.png 1x, <?php echo get_template_directory_uri(); ?>/img/dph@2x.png 2x" width="50" height="50" alt="dph" class="lazyload">
			<?php _e( 'Všetky ceny sú bez&nbsp;DPH', 'kno' ); ?>
		</div>
		<div class="product-icon">
			<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'%3E%3C/svg%3E" data-srcset="<?php echo get_template_directory_uri(); ?>/img/odkup.png 1x, <?php echo get_template_directory_uri(); ?>/img/odkup@2x.png 2x" width="50" height="50" alt="odkup" class="lazyload">
			<?php _e( 'Možnosť odkúpenia za zostatkovú cenu 10%&nbsp;z&nbsp;obstarávacej ceny', 'kno' ); ?>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	do_action( 'woocommerce_after_single_product_summary' );
	?>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
