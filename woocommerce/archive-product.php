<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
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

?>

<div class="container container-pad">

	<div class="format">
		<div class="h1 title"><?php woocommerce_page_title(); ?></div>
	</div>

</div>

<?php get_template_part( 'template-parts/components/banner-bundle' ); ?>

<?php get_template_part( 'template-parts/components/top-picks' ); ?>

<?php get_template_part( 'template-parts/components/banner-become' ); ?>

<?php

$default_category_id = absint( get_option( 'default_product_cat', 0 ) );
if ( function_exists( 'pll_get_term' ) )
	$default_category_id = pll_get_term( $default_category_id );

$product_cats = get_terms( 'product_cat', array(
	'hide_empty' => false,
	'exclude'    => $default_category_id
) );

if ( !empty( $product_cats ) && !is_wp_error( $product_cats ) ): ?>
<div class="shop-list-category mb++">
	<div class="container container-pad">
		<div class="row row-gutter">

		<?php foreach ( $product_cats as $product_cat ) :

			if ( $product_cat->parent === 0 )
				$children = get_term_children( $product_cat->term_id, 'product_cat' );

			if ( $product_cat->parent === 0 && count( $children ) > 0 )
				continue;

		    $title = explode( ' ', $product_cat->name );

			$image_id = get_term_meta( $product_cat->term_id, 'thumbnail_id', true );

		    ?>
		    <div class="col-md-3 mb">
				<a href="<?php echo get_term_link( $product_cat->term_id ); ?>" aria-label="<?php echo $product_cat->name; ?>">
			    	<?php if ( $image_id ):

			            $img_src = wp_get_attachment_image_src( $image_id, 'medium' );
			            $img_srcset = wp_get_attachment_image_srcset( $image_id, 'medium' );
			            $img_sizes = wp_get_attachment_image_sizes( $image_id, 'medium' );
			            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			    	?>
			    	<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 <?php echo $img_src[1]; ?> <?php echo $img_src[2]; ?>'%3E%3C/svg%3E" data-src="<?php echo $img_src[0]; ?>" data-srcset="<?php echo esc_attr( $img_srcset ); ?>" sizes="<?php echo esc_attr( $img_sizes ); ?>" alt="<?php echo $image_alt; ?>" width="<?php echo $img_src[1]; ?>" height="<?php echo $img_src[2]; ?>" class="lazyload">
			    	<?php endif; ?>
				    <div class="title">
				    	<?php if ( count( $title  ) > 1 ): ?>
				    	<?php echo $title[0]; ?><br>
				    	<span class="has-gold-color"><?php echo $title[1]; ?></span>
				    	<?php else: ?>
				    	<?php echo $product_cat->name; ?>
				    	<?php endif; ?>
				    </div>
				</a>
			</div>

		<?php endforeach; ?>

		</div>
	</div>
</div>
<?php endif; ?>

<?php get_footer( 'shop' ); ?>