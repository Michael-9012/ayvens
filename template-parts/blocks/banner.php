<?php
/**
 * Block template file:
 *
 * All Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.

$class = get_field( 'imageleft' ) ? 'banner-left' : 'banner-right';

$arrows = get_field( 'arrow' );

if ( !empty( $arrows ) )
    $arrows = preg_split( '/\r\n|[\r\n]/', $arrows );

?>

<div class="<?php echo esc_attr( $class ); ?> mb">
	<div class="row">

		<div class="col-sm-7 col-md-6">

			<div class="banner-back">
		        <h2 class="banner-title"><?php the_field( 'title' ); ?><span><?php the_field( 'subtitle' ); ?></span></h2>

	            <?php if ( is_array( $arrows ) ): $classes = ''; ?>
	                <div class="arrows flex middle-xs">
	                    <?php foreach( $arrows as $i => $arrow ):
	                        if ( $i == 0 )
	                            $classes = ' class="flex middle-xs"';
	                        if ( $i == 1 )
	                            $classes = ' class="flex middle-xs green"';
	                        elseif ( $i == 2 )
	                            $classes = ' class="flex middle-xs orange"';

	                        ?>
	                    <span<?php echo $classes; ?>><?php echo trim( $arrow ); ?><svg height="100%" viewBox="0 0 2 5"><polygon fill="inherit" points="0,0 0.5,0 2,2.5 0.5,5 0,5"></polygon></svg></span>
	                    <?php endforeach; ?>
	                </div>
	            <?php endif; ?>

			</div>
			<div class="banner-content">

				<svg class="icon icon-arrow-line lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrow-line"></use></svg>

				<?php the_field( 'content' ); ?>

			</div>
		</div>

		<div class="col-sm-5 col-md-6<?php if ( $class == 'banner-left' ) echo ' first-sm'; ?>">
			<?php if ( $image = get_field( 'image' ) ) : ?>
			<div class="banner-img">
				<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 <?php echo esc_url( $image['sizes']['medium_large-width'] ); ?> <?php echo esc_url( $image['sizes']['medium_large-height'] ); ?>'%3E%3C/svg%3E" data-src="<?php echo esc_url( $image['sizes']['medium_large'] ); ?>" width="<?php echo $image['sizes']['medium_large-width']; ?>" height="<?php echo $image['sizes']['medium_large-height']; ?>" alt="<?php the_field( 'title' ); ?> <?php the_field( 'subtitle' ); ?>" class="lazyload">
			</div>
			<?php endif; ?>
		</div>

	</div>
</div>