<button aria-expanded="false" data-toggle="#filter" class="toggle<?php if ( kno_is_filter() ) echo ' is-visible'; ?>" data-toggle-more="<?php _e( 'otvoriť filter', 'kno' ); ?>" data-toggle-hide="<?php _e( 'zavrieť filter', 'kno' ); ?>">
	<svg class="icon icon-filter lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-filter"></use></svg>
	<svg class="icon icon-cross lazyload" aria-hidden="true" role="img"><use xlink:href="#icon-cross"></use></svg>
	<span><?php echo ( kno_is_filter() ) ? __( 'zavrieť filter', 'kno' ) : __( 'otvoriť filter', 'kno' ); ?></span>
</button>