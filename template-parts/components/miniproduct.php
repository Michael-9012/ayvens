<?php

//global $product;

$product = wc_get_product( get_the_ID() );

global $woocommerce_loop;
global $wp_query;

$image_id   = get_post_thumbnail_id();
$img_src    = wp_get_attachment_image_src( $image_id, 'medium_large' );
$img_srcset = wp_get_attachment_image_srcset( $image_id, 'medium_large' );
$img_sizes  = wp_get_attachment_image_sizes( $image_id, 'medium_large' );
$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

?>
<div class="miniproduct">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" data-ajax-prevent="self">

    <?php if ( !is_front_page() && $product->is_featured() ): ?>
        <div class="badge badge-product"><?php _e( 'Náš tip', 'kno' ); ?></div>
        <?php elseif ( $product->is_on_sale() ): ?>
        <div class="badge badge-product">%</div>
        <?php endif; ?>


        <div class="product-image loading-placeholder">
            <?php if ( $image_id ): ?>
            <img data-src="<?php echo $img_src[0]; ?>" data-srcset="<?php echo esc_attr( $img_srcset ); ?>" sizes="<?php echo esc_attr( $img_sizes ); ?>" alt="<?php echo $image_alt; ?>" width="<?php echo $img_src[1]; ?>" height="<?php echo $img_src[2]; ?>" class="lazyload">
            <?php else: ?>
            <img data-src="<?php echo get_template_directory_uri(); ?>/img/icon-bike.png" alt="<?php echo $image_alt; ?>" width="67" height="64" class="image-is-empty lazyload">
            <?php endif; ?>
        </div>
    </a>

    <div class="miniproduct-pad">
        <div class="miniproduct-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" data-ajax-prevent="self"><?php the_title(); ?></a></div>
        <div class="miniproduct-price price"><?php echo $product->get_price_html(); ?></div>
    </div>

    <?php if ( $product->is_purchasable() ): // && is_singular( 'product' )  $woocommerce_loop['name'] === 'up-sells' ?>
    <div class="miniproduct-add-to-cart">
        <div class="miniproduct-pad">
            <?php get_template_part( 'woocommerce/loop/add-to-cart' ); ?>
        </div>
    </div>
    <?php endif; ?>

</div>
