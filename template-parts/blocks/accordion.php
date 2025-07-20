<?php
/**
 * Block template file: template-parts/blocks/accordion.php
 *
 * Accordion Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'accordion';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

$accordion_i = 0;

if ( have_rows( 'accordion' ) ) : ?>
<div class="<?php echo esc_attr( $classes ); ?>">
<?php while ( have_rows( 'accordion' ) ) : the_row(); ?>
	<h2 data-toggle="#<?php echo $block['id'] . '-' . $accordion_i; ?>" class="toggle"><?php the_sub_field( 'title' ); ?></h2>
	<div id="<?php echo $block['id'] . '-' . $accordion_i; ?>" class="toggle-content ns"><?php the_sub_field( 'content' ); ?></div>
<?php $accordion_i++; endwhile; ?>
</div>
<?php endif; ?>
