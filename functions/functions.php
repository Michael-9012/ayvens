<?php


function core_is_ajax() {

    return ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ? true : ( !empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) == 'xmlhttprequest' );

}


function kno_cpt() {


}


function kno_action() {


    if ( isset( $_GET[ 'restricted-file' ] ) && '' != $_GET[ 'restricted-file' ] ) {

        kno_restricted_files( $_GET[ 'restricted-file' ] );

    }


    if ( !isset( $_REQUEST[ 'action' ] ) || empty( $_REQUEST[ 'action' ] ) )

        return;


    if ( core_is_ajax() && isset( $_POST[ 'form' ] ) )

        parse_str( $_POST[ 'form' ], $data );

    else

        $data = $_POST;


}


function kno_forms() {


}


function kno_form_get_table( $data, $html = '', $html_after = '' ) {


    if ( $data ) {

        $i = 0;


        if ( !function_exists( 'mailster' ) )

            $html .= '<h3>' . $data[ 'subject' ] . '</h3>';


        $html .= '<table border="0" cellspacing="0" cellpadding="0" style="background:white; width: 100%"><tbody>';


        foreach ( $data as $field => $value ) {


            if ( empty( kno_form_get_label( $field ) ) )

                continue;


            if ( in_array( $field, array( 'secure', 'subject', 'g-recaptcha-response', 'captcha', 'postid', 'action' ) ) )

                continue;


            $html .= '<tr>';


            $data[ $field ] = ( $field == 'email' ) ? trim( sanitize_email( $value ) ) : trim( sanitize_text_field( $value ) );


            $data[ $field ] = array( 'label' => kno_form_get_label( $field ), 'value' => $value );


            if ( strpos( $field, 'files' ) !== false || $field === 'files' ) {

                foreach ( $value as $d ) {

                    $filename = basename( get_attached_file( $d[ 'ID' ] ) );

                    $data[ $field ][ 'tmp' ][] = '<a href="' . $d[ 'guid' ] . '" target="_blank">' . $d[ 'title' ] . ' (' . $filename . ')</a>';

                }

                $data[ $field ][ 'value' ] = ( isset( $data[ $field ][ 'tmp' ] ) ) ? implode( '<br>', $data[ $field ][ 'tmp' ] ) : '';

            }


            if ( $field === 'product' && ( bool )strtotime( $value ) )

                $data[ $field ][ 'value' ] = date_i18n( 'j. F Y', strtotime( $value ) );


            if ( $field === 'product' && intval( $value ) ) {

                $product = get_post( ( int )$value );

                if ( $product->post_type === 'product' ) {

                    $data[ $field ][ 'value' ] = sprintf( '<a href="%s" target="_blank">%s</a>', get_the_permalink( $product->ID ), auction_get_car_title( $product->ID ) );

                }

            }


            if ( $field === 'bike' && intval( $value ) ) {

                switch ( $field ) {

                    case '1':

                        $data[ $field ][ 'value' ] = __( 'Horské', 'kno' );

                        break;

                    case '2':

                        $data[ $field ][ 'value' ] = __( 'Silniční', 'kno' );

                        break;

                    case '3':

                        $data[ $field ][ 'value' ] = __( 'Městské', 'kno' );

                        break;

                    case '4':

                        $data[ $field ][ 'value' ] = __( 'Skládací', 'kno' );

                        break;

                    case '5':

                        $data[ $field ][ 'value' ] = __( 'Speciální', 'kno' );

                        break;

                    default:

                        break;

                }

            }


            if ( $field === 'date' && ( bool )strtotime( $value ) )

                $data[ $field ][ 'value' ] = date_i18n( 'j. F Y', strtotime( $value ) );


            if ( strpos( $field, 'phone' ) !== false || strpos( $field, 'tel' ) !== false )

                $data[ $field ][ 'value' ] = '<a href="tel:' . $data[ $field ][ 'value' ] . '">' . $data[ $field ][ 'value' ] . '</a>';


            if ( strpos( $field, 'mail' ) !== false )

                $data[ $field ][ 'value' ] = '<a href="mailto:' . $data[ $field ][ 'value' ] . '">' . $data[ $field ][ 'value' ] . '</a>';


            if ( $data[ $field ][ 'value' ] === 'on' )

                $data[ $field ][ 'value' ] = __( 'Ano', 'kno' );


            if ( $data[ $field ][ 'value' ] === 'off' )

                $data[ $field ][ 'value' ] = __( 'Ne', 'kno' );


            if ( is_array( $data[ $field ][ 'value' ] ) )

                $data[ $field ][ 'value' ] = implode( ', ', $data[ $field ][ 'value' ] );


            $html .= '<td valign="top" style="' . ( $i % 2 ? 'border:none;border-bottom:solid #e1e1e1 1.0pt;padding:3.0pt 3.0pt 3.0pt 3.0pt' : 'border:none;border-bottom:solid #e1e1e1 1.0pt;background:whitesmoke;padding:3.0pt 3.0pt 3.0pt 3.0pt' ) . '"><p>' . $data[ $field ][ 'label' ] . ':</p></td>';

            $html .= '<td valign="top" style="' . ( $i % 2 ? 'border:none;border-bottom:solid #e1e1e1 1.0pt;padding:3.0pt 3.0pt 3.0pt 3.0pt' : 'border:none;border-bottom:solid #e1e1e1 1.0pt;background:whitesmoke;padding:3.0pt 3.0pt 3.0pt 3.0pt' ) . '"><p>' . $data[ $field ][ 'value' ] . '</p></td>';


            $html .= '</tr>';


            $i++;

        }


        $html .= '</tbody></table>';

        $html .= $html_after;

    }


    return $html;

}


function kno_form_get_label( $field ) {

    $labels = array(

        'title-before' => __( 'Titul před', 'kno' ),

        'title-after' => __( 'Titul za', 'kno' ),

        'first_name' => __( 'Jméno', 'kno' ),

        'first-name' => __( 'Jméno', 'kno' ),

        'last_name' => __( 'Přímení', 'kno' ),

        'last-name' => __( 'Přímení', 'kno' ),

        'fullname' => __( 'Celé jméno', 'kno' ),

        'birthday' => __( 'Datum narození', 'kno' ),

        'email' => __( 'E-mail', 'kno' ),

        'address' => __( 'Adresa', 'kno' ),

        'street' => __( 'Ulice', 'kno' ),

        'zip' => __( 'PSČ', 'kno' ),

        'phone-code' => __( 'Telefon (předvolba)', 'kno' ),

        'phone' => __( 'Telefon', 'kno' ),

        'fax' => __( 'Fax', 'kno' ),

        'tel' => __( 'Telefon', 'kno' ),

        'message' => __( 'Zpráva', 'kno' ),

        'note' => __( 'Doplnění', 'kno' ),

        'newsletter' => __( 'Souhlasím se zasíláním informací e-mailem (Zákon č.480/2004 Sb.)', 'kno' ),

        'terms' => __( 'Seznámil/a jsem se se "Zásadami ochrany osobních údajů".', 'kno' ),

        'category' => __( 'Kategorie', 'kno' ),

        'lang' => __( 'Jazyk', 'kno' ),

        'interest' => __( 'Mám zájem o', 'kno' ),

        'www' => __( 'WWW', 'kno' ),

        'address-street' => __( 'Ulice', 'kno' ),

        'address-city' => __( 'Město', 'kno' ),

        'address-postal' => __( 'PSČ', 'kno' ),

        'address-country' => __( 'Stát', 'kno' ),

        'date' => __( 'Termín', 'kno' ),

        'files' => __( 'Soubory', 'kno' ),

        'file' => __( 'Soubor', 'kno' ),

        'product' => __( 'Produkt', 'kno' ),

        'company' => __( 'Název firmy', 'kno' ),

        'ico' => __( 'IČO', 'kno' ),

        'type' => __( 'Typ poptávky', 'kno' ),

        'brand' => __( 'Preferovaná značka', 'kno' ),

        'bike' => __( 'Mám zájem o kolo', 'kno' ),

        'note' => __( 'Poznámka', 'kno' )

    );


    return ( isset( $labels[ $field ] ) ) ? $labels[ $field ] : '';


}


function kno_is_valid_captcha( $captcha, $action ) {

    require_once( trailingslashit( get_template_directory() ) . 'lib/recaptcha/autoload.php' );


    $recaptcha = new\ ReCaptcha\ ReCaptcha( '6Lc9YsoaAAAAAFcwKTsYxWEnkHpEcGrI4LQ7etHs', new\ ReCaptcha\ RequestMethod\ CurlPost() );

    $resp = $recaptcha->setExpectedHostname( $_SERVER[ 'HTTP_HOST' ] )->setExpectedAction( $action )->verify( $captcha, $_SERVER[ 'REMOTE_ADDR' ] );

    if ( $resp->isSuccess() ) {

        return true;


    } else {


        $error = $resp->getErrorCodes();

        if ( is_array( $error ) )

            $error = $error[ 0 ];


        return false;


        wp_send_json_error( array( 'msg' => __( 'reCaptcha:', 'ibd' ) . ' ' . maybe_serialize( $error ) ) );

        die();

    }

}


function kno_email_set_html_content_type( $content_type ) {

    return 'text/html';

}


function kno_send_msg( $type = 'error', $msg = '', $data = array() ) {


    if ( core_is_ajax() ) {

        if ( $type === 'success' )

            wp_send_json_success( array_merge( $data, array( 'msg' => '<p>' . $msg . '</p>' ) ) );

        else if ( $type === 'error' )

            wp_send_json_error( array_merge( $data, array( 'msg' => '<p>' . $msg . '</p>' ) ) );

        elseif ( !empty( $msg ) )

        wp_send_json( array( 'type' => $type, 'data' => array_merge( $data, array( 'msg' => '<p>' . $msg . '</p>' ) ) ) );

        else

            wp_send_json( array( 'type' => $type, 'data' => $data ) );


    } else {


        wp_cache_add( 'kno_notice', $msg );


        die();

    }

}


function kno_form_attachment( $files, $body, $folder = '', $own_root_folder = false ) {


    $post_id = 0;

    if ( isset( $body[ 'postid' ] ) && is_numeric( $body[ 'postid' ] ) )

        $post_id = $body[ 'postid' ];


    if ( $files ) {


        foreach ( $files[ 'name' ] as $key => $value ) {


            if ( $files[ 'name' ][ $key ] ) {


                $file = array(

                    'name' => $files[ 'name' ][ $key ],

                    'type' => $files[ 'type' ][ $key ],

                    'tmp_name' => $files[ 'tmp_name' ][ $key ],

                    'error' => $files[ 'error' ][ $key ],

                    'size' => $files[ 'size' ][ $key ]

                );


                $files = array( "attachments" => $file );


                foreach ( $files as $file => $array ) {

                    $newupload = kno_handle_attachment( $file, $post_id );


                    if ( $newupload ) {

                        $file = get_post( $newupload );

                        $data[ 'files' ][] = array( 'ID' => $newupload, 'title' => $file->post_title, 'guid' => $file->guid );

                    }


                }

            }

        }


        if ( !empty( $data[ 'files' ] ) && function_exists( 'wp_rml_create_or_return_existing_id' ) ) {


            $folder_root = wp_rml_create_or_return_existing_id( ( !empty( $own_root_folder ) ) ? $own_root_folder : 'Z webu', _wp_rml_root(), 0 );


            if ( !empty( $folder ) )

                $folder = wp_rml_create_or_return_existing_id( $folder, $folder_root, 0 );


            if ( is_numeric( $folder ) ) {

                foreach ( $data[ 'files' ] as $file ) {

                    wp_rml_move( $folder, array( $file[ 'ID' ] ) );

                }

            }

        }

    }


    return $data;

}


function kno_handle_attachment( $file_handler, $post_id = 0 ) {


    if ( $_FILES[ $file_handler ][ 'error' ] !== UPLOAD_ERR_OK ) return false;


    require_once( ABSPATH . "wp-admin" . '/includes/image.php' );

    require_once( ABSPATH . "wp-admin" . '/includes/file.php' );

    require_once( ABSPATH . "wp-admin" . '/includes/media.php' );


    $attach_id = media_handle_upload( $file_handler, $post_id );


    if ( is_wp_error( $attach_id ) ) {

        return false;

    } else {

        return $attach_id;

    }


}


function kno_get_filesize( $file ) {

    $bytes = filesize( $file );

    $s = array( 'b', 'KB', 'MB', 'GB' );

    $e = floor( log( $bytes ) / log( 1024 ) );

    return sprintf( '%.2f' . $s[ $e ], ( $bytes / pow( 1024, floor( $e ) ) ) );

}


function kno_restricted_files( $file ) {


    $upload = wp_upload_dir();

    $filename = pathinfo( $file );

    $file = $upload[ 'basedir' ] . '/' . $file;

    $target_file = $filename[ 'dirname' ] . '/' . $filename[ 'basename' ];


    if ( !is_file( $file ) ) {

        status_header( 404 );

        nocache_headers();

        include( get_query_template( '404' ) );

        die();

        /*

        status_header( 404 );

        die( '404 &#8212; File not found.' );

        */

    } else {


        $status = wp_cache_get( md5( $target_file ), 'restricted_file' );

        /*

        write_log( '---------');

        write_log( 'reading from cache - ' . $target_file);

        write_log( $status );

        write_log( '---------');

        */

        if ( $status === false ) {


            add_filter( 'posts_fields', function ( $field ) {

                remove_filter( current_filter(), __FUNCTION__ );

                global $wpdb;

                return $field . ", {$wpdb->postmeta}.meta_value";

            } );


            global $wpdb;

            /*

                        $image = new WP_Query( array(

                            'post_type'   => 'attachment',

                            'post_status' => 'inherit',

                            'meta_query'  => array(

                                'relation' => 'OR',

                                array(

                                    'key' => '_wp_attached_file',

                                    'value' => $target_file

                                ),

                                array(

                                    'key' => '_wp_attachment_metadata',

                                    'compare' => 'REGEXP', // LIKE NOT WORKING IN 4.9.1 because of $wpdb->remove_placeholder_escape( $image->request )

                                    'value' => $filename[ 'filename' ] . '.' . $filename[ 'extension' ]

                                )

                            ),

                            //'fields'         => 'ids',

                            'no_found_rows'  => true,

                            'nopaging'       => true

                        ) );

            */


            $image = $wpdb->get_row( $wpdb->prepare( "

                SELECT

                    p.ID,

                    MAX(CASE WHEN pm1.meta_key = '_wp_attached_file' then pm1.meta_value ELSE NULL END) as attached_file,

                    MAX(CASE WHEN pm2.meta_key = '_wp_attachment_metadata' then pm2.meta_value ELSE NULL END) as metadata,

                    MAX(CASE WHEN pm3.meta_key = 'restricted' then pm3.meta_value ELSE NULL END) as restricted,

                    p.post_parent,

                    MAX(CASE WHEN p2.post_password != '' then p2.post_password ELSE NULL END) as post_password,

                    MAX(CASE WHEN pm4.meta_key = 'restricted' then pm4.meta_value ELSE NULL END) as post_restricted



                FROM {$wpdb->posts} p

                    LEFT JOIN {$wpdb->postmeta} pm1 ON ( pm1.post_id = p.ID)

                    LEFT JOIN {$wpdb->postmeta} pm2 ON ( pm2.post_id = p.ID)

                    LEFT JOIN {$wpdb->postmeta} pm3 ON ( pm3.post_id = p.ID)

                    LEFT JOIN {$wpdb->posts} p2 ON ( p.post_parent = p2.ID)

                    LEFT JOIN {$wpdb->postmeta} pm4 ON ( pm3.post_id = p2.ID)



                WHERE

                    (pm1.meta_key = '_wp_attached_file' AND pm1.meta_value = %s)

                    OR (pm1.meta_key = '_wp_attachment_metadata' AND pm1.meta_value LIKE %s)



                    AND p.post_type = 'attachment'

                    AND p.post_status = 'inherit'



                GROUP BY p.ID",

                $target_file,

                '%' . $filename[ 'filename' ] . '.' . $filename[ 'extension' ] . '%' ) );


            $cache = array();

            if ( !empty( $image ) ) {


                $attachment_restricted = apply_filters( 'restricted_file', $image->restricted, $image->ID, $image->post_parent, $image->metadata, $image->post_password );


                if ( 1 == $attachment_restricted ) {

                    $status = array( 'status' => 'redirect' );


                } else if ( 0 < $image->post_parent ) {

                    if ( $image->post_password !== '' && post_password_required( $status[ 'post_parent' ] ) ) {

                        $status = array( 'status' => 'password_form' );

                    }

                    if ( 1 == $image->post_restricted ) {

                        $status = array( 'status' => 'redirect' );

                    }

                }

                $cache[] = $image->attached_file;

            }


            if ( !empty( $image->metadata ) ) {

                $sizes = maybe_unserialize( $image->metadata );

                foreach ( $sizes[ 'sizes' ] as $size ) {

                    if ( $size[ 'file' ] !== $target_file )

                        $cache[] = $filename[ 'dirname' ] . '/' . $size[ 'file' ];

                }

            }


            foreach ( $cache as $name ) {

                /*

                                write_log( '---------');

                                write_log( 'writing to cache - ' . $name);

                                write_log( $status );

                                write_log( '---------');

                */

                wp_cache_add( md5( $name ), $status, 'restricted_file' );

            }

        }


        if ( !empty( $status[ 'status' ] ) ) {


            if ( preg_match( '/' . str_replace( array( 'https://', 'http://' ), '', wp_unslash( home_url( '/' ) ) ) . '/', wp_get_referer() ) && in_array( $filename[ 'extension' ], array( 'jpg', 'jpeg', 'jpe', 'gif', 'png' ) ) && apply_filters( 'restricted_file_placeholder_allow', true ) ) {


                $file = apply_filters( 'restricted_file_placeholder_src', get_template_directory() . '/img/placeholder.png' );


                if ( !is_file( $file ) ) {

                    status_header( 404 );

                    nocache_headers();

                    include( get_query_template( '404' ) );

                    die();

                }


            } else if ( $status[ 'status' ] == 'redirect' ) {

                wp_redirect( wp_login_url( $upload[ 'baseurl' ] . '/' . $target_file ) );

                die();


            } else if ( $status[ 'status' ] == 'password_form' ) {

                wp_die( get_the_password_form() );


            }

        }

    }


    $mime = wp_check_filetype( $file );


    if ( false === $mime[ 'type' ] && function_exists( 'mime_content_type' ) )

        $mime[ 'type' ] = mime_content_type( $file );


    if ( $mime[ 'type' ] )

        $mimetype = $mime[ 'type' ];

    else

        $mimetype = 'image/' . substr( $file, strrpos( $file, '.' ) + 1 );


    header( 'Content-type: ' . $mimetype ); // always send this

    if ( false === strpos( $_SERVER[ 'SERVER_SOFTWARE' ], 'Microsoft-IIS' ) )

        header( 'Content-Length: ' . filesize( $file ) );


    $last_modified = gmdate( 'D, d M Y H:i:s', filemtime( $file ) );

    $etag = '"' . md5( $last_modified ) . '"';

    header( "Last-Modified: $last_modified GMT" );

    header( 'ETag: ' . $etag );

    header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 100000000 ) . ' GMT' );


    // Support for Conditional GET

    $client_etag = isset( $_SERVER[ 'HTTP_IF_NONE_MATCH' ] ) ? stripslashes( $_SERVER[ 'HTTP_IF_NONE_MATCH' ] ) : false;


    if ( !isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) )

        $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] = false;


    $client_last_modified = trim( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] );

    // If string is empty, return 0. If not, attempt to parse into a timestamp

    $client_modified_timestamp = $client_last_modified ? strtotime( $client_last_modified ) : 0;


    // Make a timestamp for our most recent modification...

    $modified_timestamp = strtotime( $last_modified );


    if ( ( $client_last_modified && $client_etag )

        ?
        ( ( $client_modified_timestamp >= $modified_timestamp ) && ( $client_etag == $etag ) )

        :
        ( ( $client_modified_timestamp >= $modified_timestamp ) || ( $client_etag == $etag ) )

    ) {

        status_header( 304 );

        exit;

    }


    // If we made it this far, just serve the file

    readfile( $file );

    die();

}


add_filter( 'restricted_file', 'kno_restricted_file', 10, 5 );

function kno_restricted_file( $restricted, $attachment_id, $post_parent, $metadata, $post_password ) {


    $user = wp_get_current_user();

    if ( !array_intersect( array( 'administrator', 'shop_manager' ), $user->roles ) )

        return true;


    if ( function_exists( 'wp_attachment_folder' ) ) {

        $folder = wp_attachment_folder( $attachment_id );


        if ( $folder == 6 )

            return true;


        //$meta_folder = get_media_folder_meta( $folder, 'restricted' );


    }

}


function kno_is_filter() {

    foreach ( $_GET as $key => $value ) {

        $pos = strpos( $key, '_' );

        if ( $pos == 0 ) {

            return true;

        }

    }

    return false;

}

function get_shop_accessories_id() {

    return 683628;

}

function is_shop_accessories() {

    return is_tax() && pll_get_term( get_queried_object_id(), pll_default_language() ) == get_shop_accessories_id();

}

function is_product_shop_accessories() {

    if ( is_singular( 'product' ) ) {
		
		return is_product_id_shop_accessories( get_the_ID() );

    }

    return false;

}

function is_product_id_shop_accessories( $product_id = null ) {

	$terms = get_the_terms( $product_id, 'product_cat' );

	if ( !empty( $terms ) ) {

		$accessories_term_id = get_shop_accessories_id();

		if ( function_exists( 'pll_get_term' ) ) {

			$accessories_term_id = pll_get_term( $accessories_term_id, pll_current_language() );

		}


		foreach ( $terms as $term ) {

			if ( $term->parent === $accessories_term_id || $term->term_id === $accessories_term_id ) {

				$accessories_term = get_term( $accessories_term_id, 'product_cat' );

				if ( empty( $accessories_term ) )

					return false;


				return $accessories_term;

			}

		}

	}
}

function get_shop_scooter_id() {

    return 713873;

}

function is_shop_scooter() {

    return is_tax() && pll_get_term( get_queried_object_id(), pll_default_language() ) == get_shop_scooter_id();

}

function is_product_shop_scooter() {


    if ( is_singular( 'product' ) ) {

        $terms = get_the_terms( get_the_ID(), 'product_cat' );

        if ( !empty( $terms ) ) {


            $scooter_term_id = get_shop_scooter_id();

            if ( function_exists( 'pll_get_term' ) ) {

                $scooter_term_id = pll_get_term( $scooter_term_id, pll_current_language() );

            }


            foreach ( $terms as $term ) {

                if ( $term->parent === $scooter_term_id || $term->term_id === $scooter_term_id ) {


                    $scooter_term = get_term( $scooter_term_id, 'product_cat' );

                    if ( empty( $scooter_term ) )

                        return false;


                    return $scooter_term;

                }

            }

        }

    }

    return false;

}

// Remove unwanted checkout fields
add_filter('woocommerce_checkout_fields', 'remove_unwanted_checkout_fields');

function remove_unwanted_checkout_fields($fields) {
    // Remove billing fields
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    
    // Also remove shipping fields if you have them
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_state']);
    unset($fields['shipping']['shipping_postcode']);
    
    return $fields;
}

add_action('woocommerce_email_order_meta', 'add_custom_fields_to_order_email', 10, 3);

function add_custom_fields_to_order_email($order, $sent_to_admin, $plain_text)
{
    // Get the custom field values
    $billing_ic = $order->get_meta('_billing_ic');
    $billing_dic = $order->get_meta('_billing_dic');

    if ($plain_text) {
        // Plain text email format
        if (!empty($billing_ic)) {
            echo "IČ: " . $billing_ic . "\n";
        }
        if (!empty($billing_dic)) {
            echo "DIČ: " . $billing_dic . "\n";
        }
    } else {
        // HTML email format
        if (!empty($billing_ic) || !empty($billing_dic)) {
            echo '<p>';
            if (!empty($billing_ic)) {
                echo '<strong>IČ:</strong> ' . esc_html($billing_ic) . '<br>';
            }
            if (!empty($billing_dic)) {
                echo '<strong>DIČ:</strong> ' . esc_html($billing_dic) . '<br>';
            }
            echo '</p>';
        }
    }
}

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .thumb.column-thumb img {
      max-width: 250px !important;
    max-height: 120px !important;
    } 
  </style>';
}



?>