<?php


/*******************************************
* bbp profile Information registration Functions
*******************************************/

add_action( 'register_form', 'bbp_profile_information_registration' );
add_filter( 'registration_errors', 'bbp_profile_information_registration_errors', 10, 3 );
add_action( 'user_register', 'bbp_profile_information_user_register' );

function bbp_profile_information_registration () {
	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['_wpnonce'] ))) ) {
		return;
	}
	global $rpi_options ;
	$fields_number = rpi_get_fields_number() ;
	
	$i=1 ;
	//*************START OF LOOP************************  
	
	while($i<= $fields_number)   {
		
		if (!empty($rpi_options['Activate_item'.$i])&& !empty ($rpi_options['itemregister_item'.$i]) ) {
			$label = $rpi_options['item'.$i.'_label'] ;
			$item = 'rpi_label'.$i ;
			$current_value = ( ! empty( $_POST[$item] ) ) ? sanitize_text_field(  wp_unslash($_POST[$item]) ) : '';
			echo '<div class="rpi_label"><label for="'.esc_html($item).'">'.esc_html($label).'</label>' ;
			echo esc_html(rpi_get_amend_field_input($i, $current_value)) ;
			echo '</div>' ;
					}
		//increments $i	
		$i++;	
	}
}

function bbp_profile_information_registration_errors( $errors, $sanitized_user_login, $user_email ) {
	 if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['_wpnonce'] ))) ) {
		return;
	 }
        global $rpi_options ;
		$fields_number = rpi_get_fields_number() ;
	
	$i=1 ;
	//*************START OF LOOP************************  
	
	while($i<= $fields_number)   {
		if (!empty($rpi_options['Activate_item'.$i]) && !empty ($rpi_options['itemregister_item'.$i]) && !empty ($rpi_options['itemrequired_item'.$i])) {
			if (isset($_POST['rpi_label'.$i] ))	$entry = sanitize_text_field( wp_unslash($_POST['rpi_label'.$i] )) ;
			if ( empty( $entry )|| ! empty($entry) && trim( $entry) == '' ) {
			$error = 'You must complete '.$rpi_options['item'.$i.'_label'] ;
			$errors->add( 'rpi_label'.$i.'_error', sprintf('<strong>%s</strong>: %s',__( 'ERROR', 'bbp-profile-information' ),$error ) );
			}
		}
		
		//increments $i	
		$i++;	
	}
		
    return $errors;
}

    
function bbp_profile_information_user_register( $user_id ) {
	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['_wpnonce'] ))) ) {
		return;
	}
	
	global $rpi_options ;
	$fields_number = rpi_get_fields_number() ;
	
	$i=1 ;
	//*************START OF LOOP************************  
	
	while($i<= $fields_number)   {
        if ( ! empty( $_POST['rpi_label'.$i] ) ) {
		    update_user_meta( $user_id, 'rpi_label'.$i, sanitize_text_field( wp_unslash($_POST['rpi_label'.$i] )) );
        }
	//increments $i	
		$i++;	
	}	
}

