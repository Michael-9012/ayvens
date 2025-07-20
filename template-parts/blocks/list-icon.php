<?php
/**
 * Block template file: template-parts/blocks/list-icon.php
 *
 * List Icon Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create class attribute allowing for custom "className" and "align" values.
$classes = 'list-icons';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

if ( have_rows( 'list_icon' ) ) : $list_i = 1; ?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<?php while ( have_rows( 'list_icon' ) ) : the_row(); ?>
	<div class="list-icon list-icon-sm mb">
		<div class="hch-icon">
			<div class="badge"><?php echo $list_i; ?></div>
			<?php
			if ( $icon = get_sub_field( 'icon' ) ):
			if ( $icon === 'bike' ): ?>
			<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 134 128'%3E%3C/svg%3E" data-src="<?php echo get_template_directory_uri(); ?>/img/icon-bike@2x.png" width="134" height="128" alt="<?php _e( 'Bicykel', 'kno' ); ?>" class="lazyload">
			<?php else: ?>
			<svg class="icon icon-<?php echo $icon; ?> lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-<?php echo $icon; ?>"></use></svg>
			<?php endif; endif; ?>
		</div>
		<div class="list-icon-content"><?php the_sub_field( 'content' ); ?></div>
	</div>
	<?php $list_i++; endwhile; ?>
</div>
<?php endif; ?>