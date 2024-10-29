<?php

/*******************************************
* bbp profile information type Page
*******************************************/




function rpi_settings_fieldtype()
{
	global $rpi_options;
	global $rpi_settings_dropdown;
	
		
	?>
	<div class="wrap">
		<div id="upb-wrap" class="upb-help">
			<h2>
				<?php esc_html_e('Field Type Settings', 'bbp-profile-information'); ?>
			</h2>
			<?php
			wp_nonce_field( 'profile_information_settings_fieldtype', 'profile_settings_nonce' );
			if ( !empty( $_POST['profile_settings_nonce'] )) wp_verify_nonce(sanitize_text_field( wp_unslash( $_POST['profile_settings_nonce'])), 'profile_information_settings_fieldtype' ) ;
			
			if ( ! isset( $_REQUEST['updated'] ) )
				$_REQUEST['updated'] = false;
			?>
			<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php esc_html_e( 'Options saved', 'bbp-profile-information'); ?></strong></p></div>
			<?php endif; ?>
			
	
	<form method="post" action="options.php">
	<!-- save the options -->
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Options', 'bbp-profile-information' ); ?>" />
	</p>

		<?php settings_fields( 'rpi_settings_dropdown' ); ?>
		<p>
		<?php esc_html_e('By default all fields are Text.' ,'bbp-profile-information'); ?> 
		<br/>
		<?php esc_html_e('In this tab, you can set a field to be a dropdown list and add items to the list' ,'bbp-profile-information'); ?> 
		<br/>
		<br/>
		<i>
		<?php esc_html_e('If you change a text field to a dropdown field','bbp-profile-information'); ?> 
		</i>
		<?php esc_html_e('any pre-existing user data against this field will continue to show.  Only when the user or an admin makes a change will they be forced to user the dropdown list.' ,'bbp-profile-information'); ?> 
		</p>
			
	<table class="form-table">
					
	<?php 
	$i=1 ;
	$fields_number = rpi_get_fields_number() ;	
	//START OF FIELD LOOP
	while($i<= $fields_number)   {
	//-------------------------------Label ---------------------------------------->
		$name2 = 'item'.$i.'_label' ;
		$value2 = (!empty($rpi_options[$name2]) ? $rpi_options[$name2] : '') ;
		?>
	<tr valign="top">
		<th><h4>
			<?php esc_html_e('Field ', 'bbp-profile-information') ;
			echo esc_html($i).' '.esc_html($value2) ; ?>
			</h4>
		</th>
	</tr>
	<?php
	$name = 'field'.$i ;
	$item="rpi_settings_dropdown[".$name."]" ;
	$value = (!empty($rpi_settings_dropdown[$name]) ? $rpi_settings_dropdown[$name] : 0) ;
	?>
					
	<tr>
			<td>
				<?php esc_html_e('Text field' , 'bbp-profile-information' ) ;?>
			</td>
			<td colspan=2>
				<?php echo '<input name="'.esc_html($item).'" id="'.esc_html($item).'" type="radio" value="0" class="code"  ' . checked( 0,$value, false ) . ' />' ; ?>
				<label class="description"><?php esc_html_e( 'The user can enter any text', 'bbp-profile-information' ); ?></label>
			</td>
	</tr>
	<tr>
			<td>
				<?php esc_html_e('Dropdown field' , 'bbp-profile-information' ) ; ?>
			</td>
			<td colspan=2>
				<?php echo '<input name="'.esc_html($item).'" id="'.esc_html($item).'" type="radio" value="1" class="code"  ' . checked( 1,$value, false ) . ' />' ; ?>
				<label class="description"><?php esc_html_e( 'The user can only select from a list', 'bbp-profile-information' ); ?></label>
				</td>
	</tr>
	
	<tr>
			<td></td>
			<td><?php esc_html_e('One item per line' , 'bbp-profile-information' ) ; ?></td>
			<td>			
				<?php 
				
				$name1 = 'fieldlist'.$i ;
				$item1="rpi_settings_dropdown[".$name1."]" ;
				$value1 = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : '');
				if ($value1==' ') $value1 = '' ;
				echo '<textarea id="'.esc_html($item1).'" class="medium-text" name="'.esc_html($item1).'" rows="10" cols="35" >'.esc_html($value1).'</textarea>' ; ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php esc_html_e('Email field' , 'bbp-profile-information' ) ; ?>
			</td>
			<td colspan=2>
				<?php echo '<input name="'.esc_html($item).'" id="'.esc_html($item).'" type="radio" value="2" class="code"  ' . checked( 2,$value, false ) . ' />' ; ?>
				<label class="description"><?php esc_html_e( 'Make a clickable email field', 'bbp-profile-information' ); ?></label>
				</td>
		</tr>
		
		<tr>
			<td>
				<?php esc_html_e('Website Field' , 'bbp-profile-information' ) ; ?>
			</td>
			<td colspan=2>
				<?php echo '<input name="'.esc_html($item).'" id="'.esc_html($item).'" type="radio" value="3" class="code"  ' . checked( 3,$value, false ) . ' />' ; ?>
				<label class="description"><?php esc_html_e( 'Make a clickable website field', 'bbp-profile-information' ); ?></label>
				</td>
	</tr>
	<tr>
			<td></td>
			<td><?php esc_html_e('An additional URL field is added' , 'bbp-profile-information' ) ; ?></td>
		<?php 
		$name1 = 'item'.$i.'_website_label' ;
		$item1='rpi_settings_dropdown['.$name1.']' ;
		$value1 = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : '') ;
		?>
		<td>
			<?php echo '<input id="'.esc_html($item1).'" class="large-text" name="'.esc_html($item1).'" type="text" value="'.esc_html( $value1 ).'"' ; ?> 
			<label class="description" for="rpi_settings_dropdown[item1_website_label]"><?php esc_html_e( 'By default this field will be labelled "Enter site URL" change this wording here if you wish', 'bbp-profile-information' ); ?></label><br/>
		</td>
		</tr>
		<tr>
		
		<tr>
			<td></td>
			<td></td>
			
		<?php 
		$name1 = 'item'.$i.'_website_helptext' ;
		$item1='rpi_settings_dropdown['.$name1.']' ;
		$value1 = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : '') ;
		?>
		<td>
			<?php echo '<input id="'.esc_html($item1).'" class="large-text" name="'.esc_html($item1).'" type="text" value="'.esc_html( $value1 ).'"' ; ?> 
			<label class="description" for="rpi_settings_dropdown[item1_website_helptext]"><?php esc_html_e( 'Under the field will be help text.  By default this will say "Enter the full site URL \'e.g. https://mysite.com\'" - change this here if you wish', 'bbp-profile-information' ); ?>
		</tr>
		<tr>
	
	
		
	
			
					
	
					
<?php
	//increments $i	
		$i++;	
	} ?>
				
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

