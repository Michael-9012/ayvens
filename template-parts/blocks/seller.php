<?php
/**
 * Block template file: template-parts/blocks/seller.php
 *
 * Seller Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'seller list-stores';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>

<?php if ( have_rows( 'seller' ) ) : ?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<?php while ( have_rows( 'seller' ) ) : the_row(); ?>
	<div class="list-store">
		<div class="row sm-reverse row-gutter">
			<div class="col-sm-6">
				<?php if ( $image = get_sub_field( 'image' ) ) : ?>
					<img data-src="<?php echo esc_url( $image['sizes']['medium'] ); ?>" width="<?php echo esc_url( $image['sizes']['medium-width'] ); ?>" height="<?php echo esc_url( $image['sizes']['medium-height'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="lazyload" />
				<?php endif; ?>
			</div>
			<div class="col-sm-6">
				<div class="flex col">
					<h2><?php the_sub_field( 'title' ); ?></h2>
					<?php if ( $address = get_sub_field( 'address' ) ): ?>
	                <div class="icon-left icon-left-sm">
	                    <svg class="icon icon-pin lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-pin"></use></svg>
	                    <?php echo $address; ?>
	                </div>
					<?php endif; ?>
					<?php
					$seller = get_sub_field( 'seller' );
					if ( !empty( $seller ) ):
					if ( $seller = get_term_by( 'id', $seller, 'seller' ) ) : ?>
					<div class="list-store-btn">
						<a href="<?php echo esc_url( get_term_link( $seller ) ); ?>" class="btn btn-gray btn-inline"><?php _e( 'Zobrazit na mapě', 'kno' ); ?></a>
					</div>
					<?php endif; endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endwhile; ?>
</div>
<?php endif; ?>
