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
$id = 'more-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'more';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

?>

<div class="<?php echo esc_attr( $classes ); ?>">

	<div class="container">

		<?php if ( is_page(13) ) : ?>
		<div class="has-text-align-center mb+">
		    <h2 class="section-title">
		    	<svg class="icon icon-pump lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-pump"></use></svg>
		        <?php _e( 'Potrebujete viac?', 'kno' ); ?>
		    </h2>

		    <h3><?php _e( 'Pre vašu flotilu ďalej zaistíme:', 'kno' ); ?></h3>

		    <div class="flex mt+ mb++ row middle-xs center-xs around-xs">

		    	<div class="icon-left">
		    		<svg class="icon icon-gps lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-gps"></use></svg>
					<?php _e( 'mobilnú aplikáciu<br>s GPS', 'kno' ); ?>
				</div>
		    	<div class="icon-left">
		    		<svg class="icon icon-service lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-service"></use></svg>
					<?php _e( 'výjazd technika<br>k riešeniu ťažkostí', 'kno' ); ?>
				</div>
		    	<div class="icon-left">
		    		<svg class="icon icon-charger lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-charger"></use></svg>
					<?php _e( 'dobíjacie stojany<br>na elektrobicykle', 'kno' ); ?>
		    	</div>
		    	<div class="icon-left">
		    		<svg class="icon icon-arrows-road lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrows-road"></use></svg>
					<?php _e( 'ďalšie služby<br>nadštandardné služby', 'kno' ); ?>
		    	</div>
		    </div>
		</div>
		<?php else: ?>
		<div class="row row-gutter+">
			<div class="col-md-12 has-text-align-center mb+">
			    <h2 class="section-title">
<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36.51 25.04">
  <defs>
    <style>
      .cls-1 {
        fill: #12364a;
      }
    </style>
  </defs>
  <path class="cls-1" d="m11.11,2.21c3.86,0,7.39,2.27,8.99,5.79l.3.65h16.11v-2.21h-14.71C19.72,2.5,15.6,0,11.11,0,6.36,0,1.72,3,.08,7.14c-.29.73.25,1.51,1.03,1.51h7.73c.11,0,.2.09.2.2v7.33c0,.11-.09.2-.2.2H1.11c-.78,0-1.32.79-1.03,1.52,1.64,4.14,6.28,7.14,11.03,7.14,4.49,0,8.61-2.5,10.69-6.44h14.71v-2.21h-16.11l-.3.65c-1.6,3.52-5.13,5.79-8.99,5.79-3.2,0-6.43-1.73-8.16-4.22h7.19c.61,0,1.11-.5,1.11-1.11V7.55c0-.61-.5-1.11-1.11-1.11H2.96c1.72-2.49,4.95-4.22,8.16-4.22"/>
</svg>

			        <?php _e( 'Potrebujete viac?', 'kno' ); ?>
			    </h2>

			    <h3><?php _e( 'Pre vašu flotilu ďalej zaistíme:', 'kno' ); ?></h3>

			    <div class="flex row middle-xs center-xs">

			    	<div class="icon-left">
			    		<svg class="icon icon-gps lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-gps"></use></svg>
						<?php _e( 'mobilnú aplikáciu<br>s GPS', 'kno' ); ?>
					</div>
			    	<div class="icon-left">
			    		<svg class="icon icon-service lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-service"></use></svg>
						<?php _e( 'výjazd technika<br>k riešeniu ťažkostí', 'kno' ); ?>
					</div>
			    	<div class="icon-left">
			    		<svg class="icon icon-charger lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-charger"></use></svg>
						<?php _e( 'dobíjacie stojany<br>na elektrobicykle', 'kno' ); ?>
			    	</div>
			    	<div class="icon-left">
			    		<svg class="icon icon-arrows-road lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-arrows-road"></use></svg>
						<?php _e( 'ďalšie služby<br>nadštandardné služby', 'kno' ); ?>
			    	</div>
			    </div>
			</div>
		</div>
		<?php endif; ?>

	</div>
</div>