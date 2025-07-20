<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<div class="row row-gutter">
	<div class="col-md-3">
		<nav class="woocommerce-MyAccount-navigation">
			<ul class="left-menu list-bare">
				<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" data-ajax-prevent="self" class="flex middle-xs">
							<?php echo esc_html( $label ); ?>
							<svg class="icon icon-arrow-right lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-right"></use></svg>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
