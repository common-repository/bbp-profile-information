<?php


/*******************************************
* bbp profile Information Functions
*******************************************/


//these add to the wordpress profile pages, and shown at the end of bbp profile pages
//does the show/edit if viewing own profile
add_action( 'show_user_profile', 'rpi_user_profile_field', 50,2 )  ;
//does the display/edit if viewing another's profile
add_action( 'edit_user_profile', 'rpi_user_profile_field', 50,2 )  ;
//does the save if viewing own profile
add_action( 'personal_options_update',         'rpi_edit_user_bbp_profile_information' );
//does the save if viewing another's profile
add_action( 'edit_user_profile_update',        'rpi_edit_user_bbp_profile_information' );


 
//this function adds the updated items info to the usermeta database
function rpi_edit_user_bbp_profile_information( $user_id ) {
	 if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['_wpnonce'])), 'update-user_' . $user_id ) ) {
    return;
  }
	
	global $rpi_options;
	global $rpi_settings_dropdown ;
	$fields_number = rpi_get_fields_number() ;
	
	$i=1 ;
	//START OF LOOP
	while($i<= $fields_number)   {
	
	// Update rpi_label user meta
	if ( !empty( $_POST['rpi_label'.$i] ) ) {
		$string = sanitize_text_field(wp_unslash($_POST['rpi_label'.$i])) ;
		update_user_meta( $user_id, 'rpi_label'.$i,  $string);
		//is field a url field - if so we need to capture the url as well?
		$name1 = 'field'.$i ;
		$item1='rpi_settings_dropdown['.$name1.']' ;
		$value = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : 0) ;
			//if 3 then a website
			if ($value==3 && !empty($_POST['rpi_label'.$i.'url'])) {
				update_user_meta( $user_id, 'rpi_label'.$i.'url',  sanitize_text_field( wp_unslash($_POST['rpi_label'.$i.'url'])));
				
			}
	}

	// Delete rpi_label user meta
	else {
		delete_user_meta( $user_id, 'rpi_label'.$i );
		//and delete website url in case that is also there
		delete_user_meta( $user_id, 'rpi_label'.$i.'url' );
	}
	
	//increments $i	
		$i++;	
	}	
			
}

function rpi_user_profile_field( $profileuser ) {
	global $rpi_options;
	global $rpi_settings_dropdown ;
	$user_id =  $profileuser->ID  ;
	$fields_number = rpi_get_fields_number() ;
	$i=1 ;
	if (isset ($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/wp-admin/profile.php' ) {
		//we are in wp profile, so use a table
		?>
		<h2><?php esc_html_e( 'Profile Information', 'bbp-profile-information' ); ?></h2>
		<table class="form-table" id="fieldset-profile-information">
			<tbody>
			
			<?php
			//START OF LOOP
			while($i<= $fields_number)   {
			?>
				<tr>
					<th>
						<?php
						//item
						if(!empty ($rpi_options['Activate_item'.$i] )) {
							$label =  esc_html($rpi_options['item'.$i.'_label']) ;
							echo '<div id= "rpi-profile-item'.esc_html($i).'">' ;			
							echo '<label for="rpi_label'.esc_html($i).'">'.esc_html($label) ;
							echo '</label>' ;
						}
							?>
					</th>
					<td>
						<?php
						$current_value = get_user_meta( $user_id, 'rpi_label'.$i,true);
							//maybe esc this, but care re using esc_html as that caused the lines to not display !!
							echo rpi_get_amend_field_input($i, $current_value, $user_id);
						?>
					</td>
				</tr>
					<?php
			
					//increments $i	
					$i++;	
			}		
			?>
			</tbody>
		</table>
		
<?php		
		
	}
else {
	//we are in bbp profile edit
	?>
	<fieldset class="bbp-form">
			<h2 class="entry-title">
						<?php esc_html_e( 'Profile Information', 'bbp-profile-information' ); ?>
			</h2>
				
	<?php
	//START OF LOOP
	while($i<= $fields_number)   {
	?>
	
								
			
				<?php
				//item
				if(!empty ($rpi_options['Activate_item'.$i] )) {
					$label =  esc_html($rpi_options['item'.$i.'_label']) ;
					echo '<div id= "rpi-profile-item'.esc_html($i).'">' ;			
					echo '<label for="rpi_label'.esc_html($i).'">'.esc_html($label) ;
					echo '</label>' ;
					$current_value = get_user_meta( $user_id, 'rpi_label'.$i,true);
					//maybe esc this, but care re using esc_html as that caused the lines to not display !!
					echo rpi_get_amend_field_input($i, $current_value, $user_id);
					
					
					
					echo '</div>' ;
					?>
				
				<?php 
				}
				?>
			
			
	<?php
			
		//increments $i	
		$i++;	
	}		
	?>
	</fieldset>
		
	<?php
	} //END of bbp profile edit
		
}


?>
