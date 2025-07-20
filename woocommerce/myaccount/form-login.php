<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="row row-gutter">

	<div class="col-md-6 mb+">

		<div class="format">

			<h2 class="h2 title"><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

			<form class="form-login form-validate form-border" method="post">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

	            <div class="form-group required">
	                <input type="text" name="username" id="username" data-validate-required-message="<?php _e( 'Uživatelské jméno je povinné.', 'kno' ); ?>" required aria-label="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
	                <label for="username" class="control-label"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?></label><i class="bar"></i>
	            </div>

	            <div class="form-group required">
	                <input type="text" name="password" id="password" data-validate-required-message="<?php _e( 'Password je povinné.', 'kno' ); ?>" required aria-label="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" autocomplete="current-password" />
	                <label for="password" class="control-label"><?php esc_html_e( 'Password', 'woocommerce' ); ?></label><i class="bar"></i>
	            </div>

				<?php do_action( 'woocommerce_login_form' ); ?>

	            <div class="form-group">
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="rememberme" value="rememberme" /><i class="helper"></i><?php esc_html_e( 'Remember me', 'woocommerce' ); ?>
	                    </label>
	                </div>
	            </div>
	            <div class="form-group">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<button type="submit" class="btn" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
				</div>

				<div class="mt"><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a></div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>

		</div>

	</div>

	<div class="col-md-6 mb+">
<?php /* ?>
		<div class="format">

			<h2 class="h2 title"><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

			<div class="form-border mt">
				<button data-modal="modal-register" class="btn"><?php _e( 'Register', 'woocommerce' ); ?></button>
			</div>
		</div>
<?php */ ?>
	</div>


</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
