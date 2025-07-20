<?php

if ( false == $allposts = get_transient( 'kno_kolotipy_cache' ) ) {

	$allposts = array();

	$kolotipy = wp_remote_get( 'https://www.kolotipy.cz/wp-json/wp/v2/posts?per_page=4&_embed' );

	if ( !is_wp_error( $kolotipy ) && $kolotipy['response']['code'] == 200 ) {
		$remote_posts = json_decode( wp_remote_retrieve_body( $kolotipy ) );
		foreach( $remote_posts as $remote_post ) {
 			$allposts[ strtotime( $remote_post->date_gmt ) ] = $remote_post;
		}
	}

	krsort( $allposts );

	set_transient( 'kno_kolotipy_cache', $allposts, 3600 );
}

?>

<div class="kolotipy">

	<div class="container">

	    <h2 class="section-title has-text-align-center">
	    	<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3C/svg%3E" data-src="<?php echo get_template_directory_uri(); ?>/img/kolotipy-icon.png" width="200" height="200" alt="<?php _e( 'Kolotipy.cz', 'kno' ); ?>" class="lazyload">
	        <?php _e( 'Čtěte také na webu kolotipy.cz', 'kno' ); ?>
	    </h2>

	    <div class="kolotipy-items has-corner has-corner--side">
	    	<span></span>

		    <div class="row row-gutter+">

				<?php foreach( $allposts as $remote_post ):

				    //$thumb_full_url = '';
				    $thumb_url = '';

				    if ( ! empty( $remote_post->featured_media ) && isset( $remote_post->_embedded ) ) {
				        //$thumb_full_url = $remote_post->_embedded->{'wp:featuredmedia'}[0]->source_url;
				        $thumb_url = $remote_post->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->medium_large->source_url;
				    }

					?>
				<div class="col-md-3 mb kolotipy-item">

					<a href="<?php echo $remote_post->link; ?>" target="_blank">

						<?php if ( !empty( $thumb_url ) ): ?>
						<div class="kolotipy-item-image loading-placeholder">
							<img data-src="<?php echo $thumb_url; ?>" alt="<?php echo $remote_post->title->rendered; ?>" class="lazyload">
						</div>
						<?php endif; ?>

						<h3><?php echo $remote_post->title->rendered; ?></h3>

						<?php /* ?>
						<p><?php echo $remote_post->excerpt->rendered ?></p>
						<?php */ ?>

					</a>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="has-text-align-right">
				<a href="https://www.kolotipy.cz" target="_blank" class="link"><?php _e( 'více článků', 'kno' ); ?></a>
			</div>
		</div>
	</div>
</div>