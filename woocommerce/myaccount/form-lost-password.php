<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="row row-gutter" id="customer_login">

	<div class="col-md-6">

		<div class="format">

			<h2 class="h2 title"><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

			<form class="form-lost-password form-validate form-border" method="post">

				<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

				<div class="form-group required">
					<input type="text" name="user_login" id="user_login" autocomplete="username" data-validate-required-message="<?php _e( 'Uživatelské jméno / e-mail je povinné.', 'kno' ); ?>" required aria-label="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" />
					<label for="user_login" class="control-label"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label><i class="bar"></i>
				</div>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

				<div class="form-group">
					<input type="hidden" name="wc_reset_password" value="true" />
					<button type="submit" class="btn" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
				</div>

				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

				<div class="mt"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e( 'Back to Login', 'woocommerce' ); ?></a></div>

			</form>

			<?php do_action( 'woocommerce_after_lost_password_form' ); ?>

		</div>
	</div>
</div>
