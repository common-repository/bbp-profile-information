<?php


/*******************************************
* bbp profile Information Display Functions
*******************************************/
//these show the profile
add_action ('bbp_theme_after_reply_author_details', 'rpi_profile_information') ;
add_action ('bbp_template_after_user_profile', 'rpi_user_profile_bbp_profile_information') ;


function rpi_profile_information () {
//This function adds the item and label if required to the author section of topics/replies
	global $rpi_options;
	$user_id = bbp_get_reply_author_id();
		
	echo '<div class = "profile-information">' ;
	echo '<ul>';
			
	$name="number_of_fields" ;
	$top = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '4') ;
	
	$i=1 ;
	//*************START OF LOOP************************  
	
	while($i<= $top)   {
		//show item if activated & show on topics
		if (!empty ($rpi_options['Activate_item'.$i]) && (!empty ($rpi_options['itemshow_item'.$i]) ) ){
			echo '<li>' ; 
			$label_id = 'rpi_label'.$i ;
			$usermeta = get_user_meta( $user_id, $label_id, true );
			$usermeta = apply_filters ('rpi_profile_information' , $usermeta, $label_id) ;
			//show label if required
			if(!empty ($rpi_options['labelshow_item'.$i] )) {
				$show_label = (!empty ($rpi_options['labelshow_label'.$i]) ? $rpi_options['labelshow_label'.$i] : '' ) ;
				if ($show_label && (empty($usermeta)) ) {
					//don't show
				}
				else {
					echo '<span class="user-topic-view-label">'.esc_html($rpi_options['item'.$i.'_label'].': ').'</span>' ;
				}
			}
			rpi_show_profile_information ($usermeta, $i, $user_id) ;
			echo '</li>' ;
		}
		
		//increments $i	
		$i++;	
	}
	echo '</ul></div>' ;
		
}


function rpi_user_profile_bbp_profile_information() {
//this function adds the items to the profile display menu, and if the user can edit other users display first, lastname and email
	global $rpi_options;
	global $rpi_settings_dropdown ;
			
	$name="number_of_fields" ;
	$top = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '4') ;
	
	$i=1 ;
	//*************START OF LOOP************************  
	
	while($i<= $top)   {
			
			if(!empty ($rpi_options['Activate_item'.$i] )) { 
				$label = (!empty($rpi_options['item'.$i.'_label']) ? $rpi_options['item'.$i.'_label']  : '') ;
				$label_id = 'rpi_label'.$i ;
				$usermeta = esc_attr( bbp_get_displayed_user_field( $label_id )) ;
				
				$usermeta = apply_filters ('rpi_user_profile_field' , $usermeta, $label_id) ;
				
				//show item if required
				$show_label = (!empty ($rpi_options['labelshow_label'.$i]) ? $rpi_options['labelshow_label'.$i] : '' ) ;
					if ($show_label && (empty($usermeta)) ) {
						//don't show as both are empty
					}
					else {
						//we will be showing something so add a para	
						echo "<p>" ;
						if (!empty ($rpi_options['labelshow_item'.$i])) {
							//so showing a label 
							echo '<span class="user-profile-label">'.esc_html($label.': ').'</span>' ;
							
						}
						if (!empty($usermeta)) {
							rpi_show_profile_information ($usermeta, $i, bbp_get_displayed_user_field( 'ID')) ;
						}
						//and then end para
						echo '</p>' ;	
					}
				
			}	
			
			
	//increments $i	
		$i++;	
	}	
					
	if ( current_user_can( 'edit_users' ) ) {
			$first_name = bbp_get_displayed_user_field( 'first_name') ;
			/* translators: %s - first name */
			printf (esc_html__( 'First name: %s', 'bbp-profile-information' ), esc_html($first_name));
			echo "</p>" ;
			$last_name = bbp_get_displayed_user_field( 'last_name') ;
			/* translators: %s - last name */
			printf (esc_html__( 'Last name: %s', 'bbp-profile-information' ), esc_html($last_name));
			echo "</p>" ;
			echo "<p>" ;
			printf (esc_html__( 'Email: ', 'bbp-profile-informaton' ));
			echo '<a href="mailto:'.esc_html(bbp_get_displayed_user_field( 'user_email' )).'">'.esc_html(bbp_get_displayed_user_field( 'user_email' )).'</a>' ;
			
			echo "</p>" ;
			}
			
			}
			

function rpi_show_profile_information ($usermeta, $i, $user_id) {
	global $rpi_settings_dropdown ;
	global $rpi_options ;

//now decide whether to show text/email, dropdown field, or website
							$name1 = 'field'.$i ;
							$item1='rpi_settings_dropdown['.$name1.']' ;
							$value = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : 0) ;
							//if zero or 1 then a text field
							if ($value==0 || $value==1 ) {
								echo esc_html($usermeta) ;
							}
							//if 2 then an email field
							if ($value==2) {
								echo '<a href="mailto:'.esc_html($usermeta).'">'.esc_html($usermeta).'</a>' ;
							}
							//if 3 then a wesbite field
							if ($value==3) {
								//display the website options
								$url_value = get_user_meta( $user_id, 'rpi_label'.$i.'url',  true);
								if(empty ($url_value)) echo esc_html($usermeta) ;
								elseif(wp_http_validate_url($url_value)) {
									//valid url so use link
									echo '<a href="'.esc_url($url_value).'">'.esc_html($usermeta).'</a>' ;
								}
								//or if not, just use text
								else echo esc_html($usermeta) ;



									
							}
return ;
				
}


?>
