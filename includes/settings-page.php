<?php

/*******************************************
* bbp profile information Settings Page
*******************************************/


function rpi_settings_page()
{
	global $rpi_options;
	
		
	?>
	<div class="wrap">
		<div id="upb-wrap" class="upb-help">
			<h2>
				<?php esc_html_e('profile information Settings', 'bbp-profile-information'); ?>
			</h2>
			<?php
			wp_nonce_field( 'profile_information_settings_page', 'profile_settings_nonce' );
			if ( !empty( $_POST['profile_settings_nonce'] )) wp_verify_nonce(sanitize_text_field( wp_unslash( $_POST['profile_settings_nonce'])), 'profile_information_settings_page' ) ;
			
			if ( ! isset( $_REQUEST['updated'] ) )
				$_REQUEST['updated'] = false;
			?>
			<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php esc_html_e( 'Options saved', 'bbp-profile-information'); ?> ); ?></strong></p></div>
			<?php endif; ?>
			
	
	<form method="post" action="options.php">
		<?php settings_fields( 'rpi_settings_group' ); ?>
								
	<table class="form-table">
					
	<tr valign="top">
		<th colspan="2">
			<font size="2" color="grey" >This plugin allows you to set up user profile fields and add these to the profile display.
			<br> Users can populate these fields using their profile edit. 
			<br>Additionally you can set these fields to display under the authors name and avatar in topics and replies.
			<br> So for Instance you can set a label with a name of City.  Users can then add their city in their profile, and other users will then see their location on accessing their profile.  
			<br>If show item is set, then this also displays under the authors name on topics and replies eg 'Atlanta'
			<br> If show label is also set them both the label and content will display under the authors name on topics and replies eg 'City ; Atlanta' 
		</th>
						
	</tr>
					
	<tr valign="top">
		<th colspan="2">
			Name : Name the field
			<br> Activate : check this to add the item to profile, un-check to hide (user data is not lost)  
			<br>Show label : check to display the label under the authors name and avatar in topics and replies.
			<br>Show Item : check to display the user set data under the authors name and avatar in topics and replies.</font>
		</th>
						
	</tr>
	
<?php if ( get_option( 'users_can_register' ) ) { ?>

   	<tr valign="top">
		<th colspan="2">
			Since you allow users to register, you can opt to include fields on the wordpress registration form and let users complete these, either as optional or a required field.
			<br> Add To Registration form : :The field will show on the registration form
			<br>Required field : The field needs data entered before registration will be accepted
		</th>
						
	</tr>
<?php } ?>

<?php 	if ( !get_option( 'users_can_register' ) ) { ?>

	<tr valign="top">
		<th colspan="2">
			Additional options for the wordpress registration form will show if you allow anyone to register. 
			<br>  At the moment you have 'anyone can register' turned off.
		</th>
	</tr>
<?php } ?>		
	<tr>
		<td> 
			<?php esc_html_e ('Number of fields' , 'bbp-profile-information' ) ; ?>
		</td>
		<?php
		$name="number_of_fields" ;
		$item1="rpi_settings[".$name."]" ;
		$top = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '4') ;
		?>
	
		<td colspan = "4" style="vertical-align:top">
			<?php echo '<input id="'.esc_html($item1).'" class="small-text" name="'.esc_html($item1).'" type="text" value="'.esc_html( $top ).'"' ; ?> 
			<label class="description"><?php esc_html_e( 'Enter the no. fields you wish to have and press "Save changes" to generate', 'bbp-profile-information' ); ?></label>
		</td>
	</tr>
	
	<?php $i=1 ; ?>
	<?php //*************START OF FIELD LOOP************************  
	
	
	while($i<= $top)   {
			
			
	?>
				
					<!-------------------------------Label ---------------------------------------->
	<tr valign="top">
		<th colspan="2"><h4>
			<?php esc_html_e('Field ', 'bbp-profile-information') ;
			echo esc_html($i) ; 
			?></h4>
		</th>
	</tr>
					
					
					
	<tr valign="top">
		<?php 
		$name = 'item'.$i.'_label' ;
		$item='rpi_settings['.$name.']' ;
		$value = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '') ;
		?>
		<th>
			<?php esc_html_e('Name', 'bbp-profile-information'); ?>
		</th>
		<td>
			<?php echo '<input id="'.esc_html($item).'" class="large-text" name="'.esc_html($item).'" type="text" value="'.esc_html( $value ).'"' ; ?> 
			<label class="description" for="rpi_settings[item1_label]"><?php esc_html_e( 'Enter label eg Town, City, State, Twitter Account, Website etc.', 'bbp-profile-information' ); ?></label><br/>
		</td>
	</tr>
					
					<!-- checkbox to activate -->
	<tr valign="top">  
		<th>
			<?php esc_html_e('Activate', 'bbp-profile-information'); ?>
		</th>
		<td>
		<?php
		$name = 'Activate_item'.$i ;
		$item='rpi_settings['.$name.']' ;
		$value = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '') ;
		echo '<input name="'.esc_html($item).'" id="'.esc_html($item1).'" type="checkbox" value="1" class="code" ' . checked( 1,$value, false ) . ' /> Add this item';
		?>
		</td>
	</tr>
							
	<!-- checkbox to display label in topics/replies -->
	<tr valign="top">  
		<th>
			<?php esc_html_e('Show label', 'bbp-profile-information'); ?>
		</th>
		<td>
			<?php
			$name = 'labelshow_item'.$i ;
			$item='rpi_settings['.$name.']' ;
			$value = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '') ;
			echo '<input name="'.esc_html($item).'" id="'.esc_html($item1).'" type="checkbox" value="1" class="code" ' . checked( 1,$value, false ) . ' /> Show the label for this item on topics/replies';
			?>
		</td>
	</tr>
					
	<!-- checkbox to hide label in topics/replies -->
	<tr valign="top">  
		<th>
			<?php esc_html_e('Hide Label if no data', 'bbp-profile-information'); ?>
		</th>
		<td>
			<?php
			$name = 'labelshow_label'.$i ;
			$item='rpi_settings['.$name.']' ;
			$value = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '') ;
			echo '<input name="'.esc_html($item).'" id="'.esc_html($item1).'" type="checkbox" value="1" class="code" ' . checked( 1,$value, false ) . ' /> You can opt to hide the label if a user has not entered data, so that the label only shows if the user has entered information ';
			?>
		</td>
	</tr>
					
					
	<!-- checkbox to display item in topics/replies -->
	<tr valign="top">  
		<th>
			<?php esc_html_e('Show Item', 'bbp-profile-information'); ?></th>
		<td>
			<?php
			$name = 'itemshow_item'.$i ;
			$item='rpi_settings['.$name.']' ;
			$value = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '') ;
			echo '<input name="'.esc_html($item).'" id="'.esc_html($item1).'" type="checkbox" value="1" class="code" ' . checked( 1,$value, false ) . ' /> Show this item on topics/replies';
			?>
		</td>
	</tr>
		
		
<?php 	if ( get_option( 'users_can_register' ) ) { ?>
	<!-- checkbox to display item registration -->
	<tr valign="top">  
		<th>
			<?php esc_html_e('Show Item on registration form', 'bbp-profile-information'); ?>
		</th>
		<td>
			<?php
			$name = 'itemregister_item'.$i ;
			$item='rpi_settings['.$name.']' ;
			$value = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '') ;
			echo '<input name="'.esc_html($item).'" id="'.esc_html($item1).'" type="checkbox" value="1" class="code" ' . checked( 1,$value, false ) . ' /> Show this item on the wordpress registration form';
			?>
		</td>
	</tr>
					
	<!-- checkbox to make required -->
	<tr valign="top">  
		<th>
			<?php esc_html_e('Make completion of this item required on the registration form', 'bbp-profile-information'); ?></th>
		<td>
			<?php 
			$name = 'itemrequired_item'.$i ;
			$item='rpi_settings['.$name.']' ;
			$value = (!empty($rpi_options[$name]) ? $rpi_options[$name] : '') ;
			echo '<input name="'.esc_html($item).'" id="'.esc_html($item1).'" type="checkbox" value="1" class="code" ' . checked( 1,$value, false ) . ' /> Make this a required field on the Wordpress registration form';
			?>
		</td>
	</tr>
<?php } ?>	
					
	<tr>
		<td colspan=2>
			<hr>
		</td>
	</tr>
					
					
<?php
	//increments $i	
		$i++;	
	} ?>
	<?php //*************END OF LEVEL LOOP************************  ?>
						
					
</table>
				
	<!-- save the options -->
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Options', 'bbp-profile-information' ); ?>" />
	</p>
								
	</form>
	</div><!--end sf-wrap-->
	</div><!--end wrap-->
		
	<?php
}

