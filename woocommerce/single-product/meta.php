<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product-meta flex middle-xs">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<div class="product-meta-brand">
		<?php //echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted-in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

		<?php //echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged-as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
		<?php
		global $post;

		if ( function_exists( 'get_brands' ) ):
		$terms       = get_the_terms( $post->ID, 'product_brand' );
		$brand_count = is_array( $terms ) ? sizeof( $terms ) : 0;

		$taxonomy = get_taxonomy( 'product_brand' );
		$labels   = $taxonomy->labels;

		//echo preg_replace("/<a\s(.+?)>(.+?)<\/a>/is", "<strong>$2</strong>", get_brands( $post->ID, ', ', ' <span class="posted_in">' . sprintf( _n( '%1$s: ', '%2$s: ', $brand_count ), $labels->singular_name, $labels->name ), '</span>' ) );

		//echo preg_replace("/<a\s(.+?)>(.+?)<\/a>/is", "<strong>$2</strong>", get_brands( $post->ID, ', ', ' <span class="posted_in">' . sprintf( _n( '%1$s: ', '%2$s: ', $brand_count ), $labels->singular_name, $labels->name ), '</span>' );

		echo $labels->singular_name . ': ';
		foreach ( $terms as $term ) {
			echo '<a href="' . add_query_arg( '?_brand', $term->slug, get_permalink( wc_get_page_id( 'shop' ) ) ) . '">' . $term->name . '</a>';
		}

		endif; ?>
	</div>

	<?php if ( $subjects = get_field( 'subject' ) ): ?>
	<div class="product-meta-kno">
		<?php _e( 'Určené pre:', 'kno' ); ?> <strong><?php echo implode( ', ', array_map( function($x){ return $x['label']; }, $subjects ) ); ?></strong>
	</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
