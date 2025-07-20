<?php

$sellers = get_terms( array(
    'taxonomy' => 'seller',
    'hide_empty' => false,
) );

if ( $sellers && ! is_wp_error( $sellers ) ) : ?>
<div class="map mb" data-lat="49.85" data-lng="15.45" data-zoom="8">

	<label class="map-search">
		<svg class="icon icon-target lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-target"></use></svg>
	</label>

	<?php foreach( $sellers as $seller ):

		$location = get_field( 'location', 'seller_' . $seller->term_id );

		if ( empty( $location ) || ( !empty( $location ) && empty( $location['lat'] ) ) )
			continue;

		$street = get_field( 'street', 'seller_' . $seller->term_id );
		$postal = get_field( 'postal', 'seller_' . $seller->term_id );
		$city   = get_field( 'city', 'seller_' . $seller->term_id );
		$www    = get_field( 'www', 'seller_' . $seller->term_id );
		if ( !empty( $www ) ) {
			$parse = parse_url( $www );
			$www_domain  = $parse['host'];
		}

		?>

	<div class="marker format" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">

		<?php if ( $thumbnail = get_field( 'thumbnail', 'seller_' . $seller->term_id ) ) : ?>
		<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 <?php echo esc_url( $thumbnail['sizes']['medium-width'] ); ?> <?php echo esc_url( $thumbnail['sizes']['medium-height'] ); ?>'%3E%3C/svg%3E" data-src="<?php echo esc_url( $thumbnail['sizes']['medium'] ); ?>" width="<?php echo esc_url( $thumbnail['sizes']['medium-width'] ); ?>" height="<?php echo esc_url( $thumbnail['sizes']['medium-height'] ); ?>" class="lazyload" alt="<?php echo esc_attr( $thumbnail['alt'] ); ?>" />
		<?php endif; ?>

		<h2 class="mb0"><?php echo $seller->name; ?></h2>

		<?php if ( !empty( $street ) ): ?>
		<p><?php echo $street; ?><br><?php echo $postal; ?>, <?php echo $city; ?></p>
		<?php endif; ?>

		<?php if ( !empty( $www ) ): ?>
		<p><a href="<?php echo $www; ?>" target="_blank"><?php echo $www_domain; ?></a></p>
		<?php endif; ?>

	</div>
	<?php endforeach; ?>
</div>

<div class="list-sellers">
	<?php foreach( $sellers as $seller ):

		$street = get_field( 'street', 'seller_' . $seller->term_id );
		$postal = get_field( 'postal', 'seller_' . $seller->term_id );
		$city   = get_field( 'city', 'seller_' . $seller->term_id );
		$www    = get_field( 'www', 'seller_' . $seller->term_id );
		if ( !empty( $www ) ) {
			$parse = parse_url( $www );
			$www_domain  = $parse['host'];
		}

		?>
	<div class="list-seller">
		<div class="row row-gutter">
			<div class="col-md-4 flex middle-xs center-xs">
				<?php if ( $thumbnail = get_field( 'thumbnail', 'seller_' . $seller->term_id ) ) : ?>
				<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 <?php echo esc_url( $thumbnail['sizes']['medium-width'] ); ?> <?php echo esc_url( $thumbnail['sizes']['medium-height'] ); ?>'%3E%3C/svg%3E" data-src="<?php echo esc_url( $thumbnail['sizes']['medium'] ); ?>" width="<?php echo esc_url( $thumbnail['sizes']['medium-width'] ); ?>" height="<?php echo esc_url( $thumbnail['sizes']['medium-height'] ); ?>" class="lazyload" alt="<?php echo esc_attr( $thumbnail['alt'] ); ?>" />
				<?php endif; ?>
			</div>
			<div class="col-md-8">
				<p>
					<strong><?php echo $seller->name; ?></strong>
					<?php if ( !empty( $street ) ): ?>
					<br><?php echo $street; ?><br><?php echo $postal; ?>, <?php echo $city; ?>
					<?php endif; ?>
				</p>

				<?php if ( !empty( $www ) ): ?>
				<p><a href="<?php echo $www; ?>" target="_blank"><?php echo $www_domain; ?></a></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<?php endif; ?>

