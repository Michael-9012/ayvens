<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<div class="checkout-wrapper">
	<form name="checkout" method="post" class="checkout shop-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div id="customer_details">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>

				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

		<?php /*
		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
		<?php */ ?>

		<div id="order_review" class="shop-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>


		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	</form>
	<div class="checkout-info">
		<h2><?php _e( 'Máte otázky?', 'kno' ); ?></h2>
		<p><?php _e( 'Máte záujem o bližšie informácie, alebo sa zaujímate o ďalšie možnosti nákupu?', 'kno' ); ?></p>
		<?php echo do_shortcode( '[kontakt]' ); ?>

        <?php
            $block = parse_blocks( get_post( pll_get_post( 7016 ) )->post_content )[0];
            $block['attrs']['not_btn'] = true;
            echo render_block( $block );
        ?>

	</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
