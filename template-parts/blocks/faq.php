<?php
/**
 * Block template file: template-parts/blocks/faq.php
 *
 * faq Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'faq';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

if ( have_rows( 'faq' ) ) : ?>
<div class="<?php echo esc_attr( $classes ); ?>">
<?php while ( have_rows( 'faq' ) ) : the_row(); ?>
	<div class="icon-left">
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
		<h2 class="faq-question"><?php the_sub_field( 'title' ); ?></h2>
		<div class="faq-answer"><?php the_sub_field( 'content' ); ?></div>
	</div>
	<hr>
<?php endwhile; ?>
</div>
<?php endif; ?>
