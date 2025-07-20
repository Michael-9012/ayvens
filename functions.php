<?php
require_once( locate_template( '/functions/cpt_seller.php' ) );

require_once( locate_template( '/functions/woocommerce.php' ) );
require_once( locate_template( '/functions/functions.php' ) );
require_once( locate_template( '/functions/filters.php' ) );
require_once( locate_template( '/functions/actions.php' ) );
require_once( locate_template( '/functions/rest.php' ) );
require_once( locate_template( '/functions/walkers.php' ) );
require_once( locate_template( '/functions/shortcode.php' ) );


function acf_filter_rest_api_preload_paths( $preload_paths ) {
	global $post;
	$rest_path    = rest_get_route_for_post( $post );
	$remove_paths = array(
		add_query_arg( 'context', 'edit', $rest_path ),
		sprintf( '%s/autosaves?context=edit', $rest_path ),
	);

	return array_filter(
		$preload_paths,
		function( $url ) use ( $remove_paths ) {
			return ! in_array( $url, $remove_paths, true );
		}
	);
}
add_filter( 'block_editor_rest_api_preload_paths', 'acf_filter_rest_api_preload_paths', 10, 1 );

?>