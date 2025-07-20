<?php
/**
 * Block template file: template-parts/blocks/finance.php
 *
 * Finance Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'finance-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'finance';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

$finance_t = 12 / count( get_field( 'finance' ) );
$finance_i = 1;

?>

<?php if ( !isset( $block['only_modal'] ) && have_rows( 'finance' ) ) : ?>
<div class="<?php echo esc_attr( $classes ); ?>">

    <h2 class="section-title has-text-align-center">
 <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.28 24.58">
  <defs>
    <style>
      .cls-1 {
        fill: #12364a;
      }
    </style>
  </defs>
  <path class="cls-1" d="m8.98,3.44c-.42.59-1.11.62-1.11.62-.3,0-.55.26-.55.56v1.7h0s2.12,1.98,2.12,1.98l2.11-1.97v-1.72c0-.15-.06-.3-.17-.4-.08-.08-.19-.13-.31-.15-.02,0-.03,0-.05,0-.02,0-.03,0-.06,0-.03,0-.65-.02-1.07-.62-.1-.15-.27-.24-.46-.24-.18,0-.35.09-.45.23m6.28,21.15h10.82v-2.12h-10.82v2.12Zm0-3.57h10.82v-2.12h-10.82v2.12Zm0-3.57h10.82v-2.12h-10.82v2.12Zm11.59-11.07l-1.4.98-1.65-1.25c-.48-.37-1.15-.37-1.64-.02l-1.52,1.1-1.92-.95c.34-.85-.07-1.9-.9-2.3L10.29.19c-.5-.25-1.13-.25-1.64,0L1.02,3.96c-.99.46-1.34,1.81-.7,2.7l2.43,3.5v2.19c0,.45.27.86.69,1.03l5.33,2.18c.44.18.95.18,1.4,0l.84-.34v9.38h2.12s0-5.18,0-10.24l2.55-1.04c.42-.17.69-.57.69-1.02v-2.07s1.23-2.04,1.23-2.04c.18.09.86.43,2.22,1.11.53.26,1.15.34,1.63-.01l1.54-1.11,1.6,1.22c.5.38,1.2.37,1.69-.02,0,0,1.4-.99,1.82-1.28.04-.03.1,0,.1.05,0,4.56,0,16.46,0,16.46h2.08V7.96c0-2.14-1.8-2.74-3.44-1.59m-12.59,5.22l-4.77,1.96-4.61-1.89v-.8h9.38v.73Zm.44-2.7H4.43l-2.18-3.18,7.22-3.57,7.14,3.55-1.92,3.19Z"/>
</svg>
        <?php _e( 'Splátka vždy obsahuje:', 'kno' ); ?>
    </h2>

    <div class="row center-xs">
		<?php while ( have_rows( 'finance' ) ) : the_row(); ?>
		<div class="finance-item">
<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.36 25.06">
  <defs>
    <style>
      .cls-1 {
        fill: #12364a;
      }
    </style>
  </defs>
  <path class="cls-1" d="m12.6,13.35l-5.07-5-1.67,1.69s3.85,3.8,5.14,5.06c.87.89,2.54.95,3.37,0,2.04-2.48,10.85-13.19,10.85-13.19l-1.84-1.51-10.64,12.94s-.11.05-.15,0m11.65-5.92h0s-.2.25-.2.25l-1.52,1.85h0c.31.97.46,1.98.46,3,0,5.6-4.62,10.15-10.31,10.15S2.38,18.13,2.38,12.53,7,2.38,12.68,2.38c1.61,0,3.17.37,4.62,1.09l1.54-1.87c-1.89-1.04-4.02-1.59-6.16-1.59C5.69,0,0,5.62,0,12.53s5.69,12.53,12.68,12.53,12.68-5.62,12.68-12.53c0-1.76-.37-3.47-1.11-5.1"/>
</svg>

			<h3><?php the_sub_field( 'title' ); ?></h3>

			<p><?php the_sub_field( 'content' ); ?></p>

            <?php if ( !isset( $block['not_btn'] ) ): ?>
			<button data-modal="modal-finance<?php echo $finance_i; ?>" class="btn btn-gray btn-full finance-btn"><?php _e( 'Viac informácií', 'kno' ) ?></button>
            <?php endif; ?>

		</div>
		<?php $finance_i++; endwhile; ?>
	</div>

</div>
<?php endif; ?>

<?php $finance_i = 1; if ( isset( $block['only_modal'] ) && have_rows( 'finance' ) ) : while ( have_rows( 'finance' ) ) : the_row(); ?>
<div class="modal modal-slide ns" id="modal-finance<?php echo $finance_i; ?>" aria-hidden="true">
    <div class="modal-overlay" tabindex="-1" data-modal-close>
        <div class="modal-container" role="dialog" aria-modal="true" aria-labelledby="modal-finance-title">
            <button class="modal-close" aria-label="<?php _e( 'Zavrieť', 'kno' ); ?>" data-modal-close></button>
            <div class="modal-container-scroll">
                <div class="modal-title" id="modal-finance-title"><?php the_sub_field( 'title' ); ?></div>
                <?php the_sub_field( 'content_modal' ); ?>
            </div>
        </div>
    </div>
</div>
<?php $finance_i++; endwhile; endif; ?>