<?php



function kno_form( $request ) {



    $action = $request->get_url_params()['action'];



    $subject = ( isset( $request['subject'] ) ) ? sanitize_text_field( $request['subject'] ) : '';



    if ( $action === 'inquiry' )

        $subject = __( 'Poptávkový formulář SK', 'kno' );



    $subject_allowed = array(

        __( 'Poptávkový formulář SK', 'kno' ),

    );

    if ( !in_array( $subject, $subject_allowed ) )

        return;



    if ( $action === 'request-files' && isset( $_FILES['files'] ) && isset( $_FILES['files']['tmp_name'][0] ) && empty( $_FILES['files']['tmp_name'][0] ) ) {

        return new WP_Error( 'login_error', __( 'Prílohy sú povinné.', 'kno' ), array( 'status' => 401 ) );

    }



    $who = get_option( 'admin_email' );



    $headers = array();

    // $headers[] = '';



    add_filter( 'wp_mail_content_type', 'kno_email_set_html_content_type' );



    $body = kno_form_get_table( $request->get_body_params() );



    //$files = kno_form_attachment( $request->get_file_params(), $body, $folder = 'Z webu', $root_folder = false );





    if ( isset( $request['email'] ) ) {

        $email = sanitize_email( $request['email'] );

        if ( is_email( $email ) ) {



            $first_name = '';

            $last_name  = '';



            if ( isset( $request['first_name'] ) )

                $first_name = sanitize_text_field( $request['first_name'] );



            if ( isset( $request['first-name'] ) )

                $first_name = sanitize_text_field( $request['first-name'] );



            if ( isset( $request['firstname'] ) )

                $first_name = sanitize_text_field( $request['firstname'] );



            if ( isset( $request['last_name'] ) )

                $last_name = sanitize_text_field( $request['last_name'] );



            if ( isset( $request['last-name'] ) )

                $last_name = sanitize_text_field( $request['last-name'] );



            if ( isset( $request['lastname'] ) )

                $last_name = sanitize_text_field( $request['lastname'] );



            if ( isset( $request['fullname'] ) ) {

                $fullname = sanitize_text_field( $request['fullname'] );

                $parts = explode( " ", $fullname );

                $last_name = array_pop( $parts );

                $first_name = implode( " ", $parts );

            }



            if ( function_exists( 'mailster' ) ) {

                //$ip = mailster_option( 'track_users' ) ? mailster_get_ip() : null;



                $subscriber_id = mailster( 'subscribers' )->add( array(

                    'firstname' => $first_name,

                    'lastname'  => $last_name,

                    'email'     => $email,

                    'status'    => 1, //1 = subscribed (default) , 0 = pending, 2 = unsubscribed, 3 = hardbounced

                    'referer'   => wp_get_referer(),

                    'lang'      => ( function_exists( 'mailster_get_lang' ) ) ? mailster_get_lang() : '',

                    'ip'        => ( function_exists( 'mailster_get_ip' ) ) ? mailster_get_ip() : ''

                ), true );



                if ( !is_wp_error( $subscriber_id ) && isset( $action ) ) {



                    if ( $action === 'contact' ) {

                        mailster( 'subscribers' )->assign_lists( $subscriber_id, array( 1 ), $remove_old = false );

                    }



                }

            }

            $headers = array( 'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>' );

        }

    }



    if ( wp_mail( $who, $subject, $body, $headers ) ) {



        return new WP_REST_Response( array(

            'success'      => true,

            'message' => __( 'Ďakujeme. Vašu správu budeme riešiť do 24h.', 'kno' )

        ), 200 );



    }

}



?>