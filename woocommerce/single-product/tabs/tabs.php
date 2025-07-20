<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs">
		<div class="left-content-wrapper cf">

			<div class="left-content mb">
				<ul class="tabs left-menu list-bare" role="tablist">
					<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
						<li class="left-menu-item <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
							<a href="#tab-<?php echo esc_attr( $key ); ?>" class="flex middle-xs">
								<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
								<svg class="icon icon-arrow-right lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-right"></use></svg>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php get_template_part( 'template-parts/components/banner2' ); ?>

			</div>

			<?php $product_tabs_i = 0; foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="wc-tab mb" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>"<?php if ( $product_tabs_i > 0 ) echo ' style="display: none;"'; ?>>
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
			<?php $product_tabs_i++; endforeach; ?>

			<?php

			add_action( 'woocommerce_product_after_tabs', 'woocommerce_upsell_display', 20 );

			do_action( 'woocommerce_product_after_tabs' ); ?>

		</div>
	</div>

<?php endif; ?>

