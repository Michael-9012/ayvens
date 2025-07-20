<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$gallery_images    = $product->get_gallery_image_ids();

$img_src = wp_get_attachment_image_src( $post_thumbnail_id, 'woocommerce_single' );
$img_srcset = wp_get_attachment_image_srcset( $post_thumbnail_id, 'woocommerce_single' );
$img_sizes = wp_get_attachment_image_sizes( $post_thumbnail_id, 'woocommerce_single' );
$img_full_size = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
$img_alt_text = trim( wp_strip_all_tags( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) );
//$img_thumbnail_src = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );

//$test = wc_get_gallery_image_html( $post_thumbnail_id, true );

?>
<div class="product-image-wrapper">
	<span></span>
	<div class="product-image">
		<a href="<?php echo $img_full_size[0]; ?>" class="glightbox" data-gallery="gallery-<?php echo $product->get_id(); ?>">
	        <?php if ( $product->is_on_sale() /*has_term( 'sleva', 'product_tag', $product->get_id() ) */ ): ?>
	        <div class="badge badge-product">%</div>
	        <?php endif; ?>
	        <div class="product-image loading-placeholder">
				<img data-src="<?php echo $img_src[0]; ?>" data-srcset="<?php echo esc_attr( $img_srcset ); ?>" sizes="<?php echo esc_attr( $img_sizes ); ?>" alt="<?php echo $img_alt_text; ?>" width="<?php echo $img_src[1]; ?>" height="<?php echo $img_src[2]; ?>" class="lazyload" title="<?php echo $img_alt_text; ?>">
			</div>
			<div class="badge badge-gray badge-zoom"><svg class="icon icon-search lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-search"></use></svg></div>
		</a>
	</div>
</div>
<?php if ( count( $gallery_images ) > 0 ): ?>
<div class="product-gallery flex middle-xs">
	<div class="slider ns" data-slider='{ "type": "slide", "perPage": 3, "autoWidth": true, "lazyLoad": "nearby", "arrows": <?php echo ( count( $gallery_images ) > 4 ) ? 'true' : 'false'; ?>, "drag": true, "pagination": false, "gap": "1rem", "padding": "<?php echo ( count( $gallery_images ) > 4 ) ? '4rem' : '0'; ?>"}'>
	    <div class="slider__track">
	        <div class="slider__list">
				<?php do_action( 'woocommerce_product_thumbnails' ); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>