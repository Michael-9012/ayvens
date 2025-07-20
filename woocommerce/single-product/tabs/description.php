<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

?>
<?php if ( get_locale() !== 'cs_CZ' ) : ?>
<style type="text/css">
body {
	top: 0 !important;
}
.goog-te-banner-frame {
	display: none !important;
	visibility: hidden !important;
}
.goog-tooltip,
.goog-tooltip:hover {
	display: none !important;
}
.goog-text-highlight {
	background-color: transparent !important;
	border: none !important;
	box-shadow: none !important;
}
</style>
<div id="google_translate_element"></div>
<script type="text/javascript">
/*<![CDATA[*/
function initializeGoogleTranslateElement() {
	new google.translate.TranslateElement({
		pageLanguage: 'cs',
		//autoDisplay: false,
		//multilanguagePage: true,
		includedLanguages: language
	}, "google_translate_element");
	setTimeout(function(){
		var a = document.querySelector("#google_translate_element select");
		a.val = language;
		a.dispatchEvent(new Event('change'));
		a.dispatchEvent(new Event('change'));
	},10);
}
/*]]>*/
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=initializeGoogleTranslateElement"></script>
<?php endif; ?>

<?php if ( $heading ) : ?>
	<div class="tab-section-title"><?php echo esc_html( $heading ); ?></div>
<?php endif; ?>
<div class="format translate">
<?php the_content(); ?>
</div>
