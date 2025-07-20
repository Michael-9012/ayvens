<?php
/**
 * Block template file: template-parts/blocks/fleet.php
 *
 * Fleet Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'fleet';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>

<div class="<?php echo esc_attr( $classes ); ?>">

	<div class="list-icon list-icon-center mb+">
		<div class="hch-icon">
			<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 188 128'%3E%3C/svg%3E" data-src="<?php echo get_template_directory_uri(); ?>/img/icon-bike-multi@2x.png" width="188" height="128" alt="<?php _e( 'Bicykel', 'kno' ); ?>" class="lazyload">
		</div>
		<h2 class="ttu"><strong><?php _e( 'Flotila', 'kno' ); ?></strong><br><?php _e( 'Pre požičovne, hotely, penzióny', 'kno' ); ?></h2>
	</div>

	<div class="row row-gutter+ mb+">
		<div class="col-md-5 mb">
			<div class="">
				<span></span>
				<h3><?php the_field( 'text1' ); ?></h3>
			</div>
		</div>
		<div class="col-md-7 mb">
			<div class="">
				<span></span>
				<h3><?php the_field( 'text2' ); ?></h3>
			</div>
		</div>
	</div>

	<?php if ( have_rows( 'list' ) ) : ?>
	<div class="fleet-list mb+">
		<div class="row row-gutter+">
		<?php while ( have_rows( 'list' ) ) : the_row(); ?>
			<div class="col-md-6 mb+">
				<div class="icon-left icon-left-l">
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 36 36" style="enable-background:new 0 0 36 36;" xml:space="preserve">
<style type="text/css">
	.st0{fill:#00C0FB;}
</style>
<g>
	<path class="st0" d="M18.3,34.3c-9.1,0-16.5-7.4-16.5-16.5c0-9.1,7.4-16.5,16.5-16.5c3.1,0,6.2,0.9,8.8,2.5
		c0.5,0.3,0.6,0.9,0.3,1.4c-0.3,0.5-0.9,0.6-1.4,0.3c-2.3-1.5-5-2.2-7.7-2.2c-8,0-14.5,6.5-14.5,14.5c0,8,6.5,14.5,14.5,14.5
		c8,0,14.5-6.5,14.5-14.5c0-0.6,0.5-1,1-1s1,0.5,1,1C34.9,26.9,27.4,34.3,18.3,34.3z"></path>
</g>
<g>
	<path class="st0" d="M16.8,24.4c-0.7,0-1.5-0.3-2-0.8l-4.3-4.3c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l4.3,4.3c0.3,0.3,0.9,0.3,1.2,0
		l10-10c0.4-0.4,1-0.4,1.4,0c0.4,0.4,0.4,1,0,1.4l-10,10C18.2,24.2,17.5,24.4,16.8,24.4z"></path>
</g>
</svg>
					<p class="fleet-list-text"><?php the_sub_field( 'text' ); ?></p>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="tc">
		<button data-modal="modal-inquiry" class="btn btn-inline btn-gradient"><?php _e( 'Zadať nezáväzný dopyt', 'kno' ); ?></button>
		<div class="container container-nopad container-sm">
			<p><small><?php _e( 'Radi Vám pripravíme vzorovú kalkuláciu flotily podľa Vašich požiadaviek a&nbsp;vysvetlíme aj&nbsp;všetky detaily ponúkanej služby.', 'kno' ); ?></small></p>
		</div>
	</div>

</div>