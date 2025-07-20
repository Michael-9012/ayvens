<?php



function kno_newsletter( $request ) {



    //$list = ( isset( $request['list'] ) && is_numeric( $request['list'] ) ) ? $request['list'] : 1;

    //$form = ( isset( $request['form'] ) && is_numeric( $request['form'] ) ) ? $request['form'] : 1;



    $list = 1;

    $form = 1;

    $success = false;



    if ( class_exists( 'mailster' ) ) {



        $subscriber = mailster( 'subscribers' )->get_by_mail( $request['email'] );



        if ( empty( $subscriber ) ) {



            $verify = mailster( 'subscribers' )->verify( array( 'email' => $request['email'] ) );



            if ( !is_wp_error( $verify ) ) {



                $first_name = '';

                $last_name = '';



                if ( isset( $request['fullname'] ) ) {

                    $fullname = sanitize_text_field( $request['fullname'] );

                    $parts = explode( " ", $fullname );

                    $last_name = array_pop( $parts );

                    $first_name = implode( " ", $parts );

                }



                $subscriber_id = mailster( 'subscribers' )->add( array(

                    'firstname' => $first_name,

                    'lastname'  => $last_name,

                    'email'     => $request['email'],

                    'status'    => 0,

                    'referer'   => wp_get_referer(),

                    'lang'      => ( function_exists( 'mailster_get_lang' ) ) ? mailster_get_lang() : '',

                    'ip'        => ( function_exists( 'geoip_detect2_get_client_ip' ) ) ? geoip_detect2_get_client_ip() : ( ( function_exists( 'mailster_get_ip' ) ) ? mailster_get_ip() : '' ),

                    'form'      => $form

                ), true );



                if ( $subscriber_id > 0 ) {

                    mailster( 'subscribers' )->assign_lists( $subscriber_id, array( $list ), $remove_old = false );

                    $success = true;

                }

            }



        } else if ( isset( $subscriber->ID ) ) {

            mailster( 'subscribers' )->assign_lists( $subscriber->ID, array( $list ), $remove_old = false );

            $success = true;

        }

    }



    if ( $success )

        return new WP_REST_Response( array(

            'success' => true,

            'message' => __( 'Ďakujeme vám za registráciu.<br>Pozrite sa prosím do Vášho e-mailu, v ktorom potvrďte prostredníctvom aktivačného odkazu pridanie do newslettera.', 'kno' )

        ), 200 );

    else

        return new WP_Error( 'rest_error', __( 'Niečo sa pokazilo.', 'kno' ), array( 'status' => 400 ) );

}



?>