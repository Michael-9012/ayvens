<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="mini-cart-wrapper">

<?php if ( ! WC()->cart->is_empty() ) :

	add_filter( 'woocommerce_cart_display_prices_including_tax', '__return_false' );

?>
    <form class="mini-cart-form">
        <ul class="mini-cart-list list-bare <?php echo esc_attr( $args['list_class'] ); ?>">

			<?php

			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      =  $_product->get_name();
					$thumbnail         = str_replace( 'wp-post-image', 'wp-post-image mini-cart-item-image', apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ) );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
		            <li class="mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">

						<?php if ( empty( $product_permalink ) ) : ?>
							<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>" class="mini-cart-item-image-link" data-ajax-prevent="self">
								<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endif; ?>

	                    <div class="mini-cart-item-info">

	                        <div class="mini-cart-product-name">
	                        	<a href="<?php echo esc_url( $product_permalink ); ?>" data-ajax-prevent="self">
	                            	<?php echo $product_name; ?>
	                        	</a>
	                        </div>
	                        <div class="mini-cart-product-count">
	                            <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	                        </div>

							<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

							<?php
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="btn-empty remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" data-ajax-prevent="self">
										<svg class="icon icon-trash lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-trash"></use></svg>
									</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_attr__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $cart_item_key ),
									esc_attr( $_product->get_sku() )
								),
								$cart_item_key
							);
							?>
						</div>
		            </li>

					<?php
				}
			}

			do_action( 'woocommerce_mini_cart_contents' );
			?>
		</ul>

	</form>

    <div class="mini-cart-footer" >
        <div class="mini-cart-subtotal">
			<?php
			/**
			 * Hook: woocommerce_widget_shopping_cart_total.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			//do_action( 'woocommerce_widget_shopping_cart_total' );
			?>
			<?php _e( 'Subtotal', 'woocommerce' ); ?>
			<div class="mini-cart-subtotal-value"><?php echo WC()->cart->get_cart_subtotal(false); ?></div>
        </div>

        <div class="mini-cart-actions">
			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
	        <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-sm btn-gradient" data-ajax-prevent="false"><?php _e( 'Zobraziť dopyt', 'kno' ); ?></a>
			<?php /*?>
			<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>
			<?php */ ?>
			<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
        </div>

    </div>

<?php else : ?>

    <div class="mini-cart-empty">
        <div class="mini-cart-empty-message">
            <?php esc_html_e( 'Dopyt je prázdny.', 'kno' ); ?>
        </div>
    </div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); remove_filter( 'woocommerce_cart_display_prices_including_tax', '__return_true' ); ?>

</div>