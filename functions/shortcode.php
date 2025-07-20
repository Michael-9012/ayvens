<?php



add_shortcode( 'bestseller', 'kno_shortcode' );

add_shortcode( 'newsletter', 'kno_shortcode' );

add_shortcode( 'asistent', 'kno_shortcode' );

add_shortcode( 'kolotipy', 'kno_shortcode' );

add_shortcode( 'kontakt', 'kno_shortcode' );

add_shortcode( 'poptavka', 'kno_shortcode' );

add_shortcode( 'odberna-mista', 'kno_shortcode' );



function kno_shortcode( $atts = array(), string $content = null, $tag ) {



    ob_start();



    if ( ob_get_level() ) {

        include( locate_template( 'template-parts/components/' . $tag . '.php' ) );

        $output = ob_get_contents();

        ob_end_clean();

    }



    return $output;

}





?>