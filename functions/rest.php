<?php



require_once( locate_template( '/functions/rest_newsletter.php' ) );

require_once( locate_template( '/functions/rest_form.php' ) );



add_filter( 'rest_post_dispatch', function( WP_REST_Response $response, WP_REST_Server $rest, WP_REST_Request $request) {

    $response->header('X-Nonce', wp_create_nonce( 'wp_rest' ) );

    return $response;

}, PHP_INT_MAX, 3);



add_filter( 'core_rest_whitelist', function( $route ) {



    $route[] = '/newsletter/v1/add';

    $route[] = '/form/v1/(?P<action>[^&]+)';



    return $route;



} );



add_filter( 'rest_authentication_errors', 'kno_rest_authentication_errors', 99 );

function kno_rest_authentication_errors( $result ) {



    $rest_route = $GLOBALS['wp']->query_vars['rest_route'];

    $current_route = ( empty( $rest_route ) || '/' == $rest_route ) ? $rest_route : untrailingslashit( $rest_route );



    if ( $current_route === '/user/v1/check' )

        remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );



    if ( isset( $_REQUEST['_nonce'] ) ) {

        $_REQUEST['_wpnonce'] = $_REQUEST['_nonce'];

        unset( $_REQUEST['_nonce'] );

    }



    return $result;

}



add_action( 'rest_api_init', function () {



    register_rest_route( 'newsletter/v1', 'add', array(

        'methods'  => 'POST',

        'callback' => 'kno_newsletter',

        'args' => array(

            'email' => array(

                'required' => true,

                'type'     => 'string',

                'format'   => 'email'

            ),

        ),

        'permission_callback' => function( WP_REST_Request $request ) {

/*

            if ( 'on' !== $request->get_param( 'newsletter-terms' ) )

                return false;

*/

            if ( !is_user_logged_in() && !kno_is_valid_captcha( $request->get_param( 'token' ), 'newsletter' ) )

                return new WP_Error( 'rest_captcha', __( 'Kontrola formuláře selhala.', 'kno' ), array( 'status' => 429 ) );



            return true;

        },

    ) );



    register_rest_route( 'form/v1', '(?P<action>[^&]+)', array(

        'methods'  => 'POST',

        'callback' => 'kno_form',

        'args' => array(

            'action' => array(

                'required'          => true,

                'type'              => 'string',

                'sanitize_callback' => 'sanitize_text_field',

            ),

        ),

        'permission_callback' => function( WP_REST_Request $request ) {
    
            if ( !is_user_logged_in() && !kno_is_valid_captcha( $request->get_param( 'token' ), $request->get_url_params()['action'] ) )
                return new WP_Error( 'rest_captcha', __( 'Kontrola formuláře selhala.', 'kno' ), array( 'status' => 429 ) );

        
            return true;

        },

    ) );



} );



?>