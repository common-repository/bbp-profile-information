<?php
 
  
 //********************************************start of user management

	 
	function rpi_user_management($field='all') {
		global $user_ID;
		global $rpi_options ;
		global $users ;
				
		//from settings.php we enter this with $group = 'all' so unless changed it will show all users
		
		//calls the set function to change bulk users to no-group
		if ( isset($_POST['confirm-bulk-action-nonce']) && !empty($_POST['action']) && wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['confirm-bulk-action-nonce']), 'confirm-bulk-action' )) 	) { 
			$field = sanitize_text_field(wp_unslash($_POST['action'])) ;
		}
			
		//WHICH USERS TO SHOW?
		
		//if not been set, then $field will be 'all'
		if ($field=='all') $users= get_users () ;
				
		//if a specific field, then sort by that field
		else {
			//see if entries or blanks
			$show= substr($field,-1) ;
			$field_sort= substr($field,0,-1) ;
			$sort_number = ltrim($field_sort, 'rpi_label') ;
			
			//order a-z
			$user_args = array(
					'meta_key' => $field_sort,
					'orderby' => 'meta_value',
					'order' => 'ASC'
			);
			$users1 = get_users($user_args);
			
			//get blanks
			$users2 = get_users( array( 
					'meta_key' => $field_sort,
					'meta_value' => '',
					'meta_compare' => 'NOT EXISTS'
					)
				) ;
			if ($show == 'b') {
				$users=array_merge($users2,$users1);
			}
			else {
				$users=array_merge($users1,$users2	);
				
			}
		}
		?>

		<form name="UserManagement" method="post">

			<?php wp_nonce_field( 'confirm-bulk-action', 'confirm-bulk-action-nonce' ) ?>
			
			<?php 
			//sets up the field names as actions
					$top = (!empty($rpi_options['number_of_fields']) ? $rpi_options['number_of_fields'] : '4') ;
					$field_name = __('Field' , 'bbp-profile-information' );
					$entries = __('-Blanks last' , 'bbp-profile-information' );
					$blanks = __('-Blanks First' , 'bbp-profile-information' );
					$i=1 ;
					while($i<= $top)   {
						$name = 'item'.esc_html($i).'_label' ;
						$value[$i] = (!empty($rpi_options[$name]) ? $rpi_options[$name] : $field_name.$i) ;
						$i++ ;
					}
				?>

			<div class="tablenav top">
				<select name="action">
					<option value=""><?php esc_html_e( 'Sort list by field' , 'bbp-profile-information' ); ?></option>
					<?php
					//sets up the field names as actions
					$top = (!empty($rpi_options['number_of_fields']) ? $rpi_options['number_of_fields'] : '4') ;
					$i=1 ;
					while($i<= $top)   {
						
						?>
						<option value="<?php echo 'rpi_label'.esc_html($i).'e' ?>"><?php echo esc_html($value[$i]).' '.esc_html($entries) ?></option>
						<option value="<?php echo 'rpi_label'.esc_html($i).'b' ?>"><?php echo esc_html($value[$i]).' '.esc_html($blanks) ?></option>
						<?php
						$i++ ;
					}
							
							
					?>
				</select>
			<input type="submit" value="<?php esc_html_e( 'Sort' , 'bbp-profile-information' ); ?>" class="button action doaction" name="" >
				
			
				
			<?php do_action( 'rpi_user_management_filter' ); ?>
			
			</div>

			<table class="widefat">
				<thead>
					<tr>
						<th id="gravatar"><?php esc_html_e( 'Gravatar', 'bbp-profile-information' ); ?></th>
						<th id="display_name"><?php esc_html_e( 'Name', 'bbp-profile-information' ); ?></th>
						<?php
							if (!empty ($sort_number)) {
								echo '<th id="display_name">'.esc_html($value[$sort_number]).'</th>' ;
							}
							$i=1 ;
							while($i<= $top)   {
								if (!empty ($sort_number) && $sort_number == $i) {
								$i++;
								continue ;
								}
								echo '<th id="display_name">'.esc_html($value[$i]).'</th>' ;
								$i++ ;
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
					if ( $users ) :
						$i = 1;
						foreach ( $users as $user ) :
							$class = ( $i % 2 == 1 ) ? 'alternate' : 'default';
							$user_data = get_userdata( $user->ID );
							$user_registered = mysql2date(get_option('date_format'), $user->user_registered);
							?>
							<tr id="user-<?php echo esc_html($user->ID) ?>" class="<?php echo esc_html($class) ?>">
								<td><img class="gravatar" src="http://www.gravatar.com/avatar/<?php echo esc_html(md5( $user->user_email )) ?>?s=32"></td>
								<td>
									<a href="user-edit.php?user_id=<?php echo esc_html($user->ID) ?>"><?php echo esc_html($user->display_name) ?></a>
									<div class="row-actions">
										<?php if ( current_user_can( 'edit_user',  $user->ID ) ) : ?>
											<span class="edit"><a href="<?php echo esc_html(admin_url( 'user-edit.php?user_id=' . esc_html($user->ID) ) ) ?>"><?php esc_html_e( 'Edit', 'bbp-profile-information' ); ?></a>
										<?php endif; ?>
										<?php if ( current_user_can( 'edit_user',  $user->ID ) && current_user_can( 'delete_user', esc_html($user->ID )) && $user_ID != $user->ID ) : ?>
											&nbsp;|&nbsp;</span>
										<?php endif; ?>
										<?php if ( current_user_can( 'delete_user', $user->ID ) && $user_ID != $user->ID ) : ?>
											<span class="delete"><a href="<?php echo esc_html(admin_url( 'users.php?action=delete&user=' . $user->ID ). '&_wpnonce=' . wp_create_nonce( 'bulk-users' ) ) ?>"><?php esc_html_e( 'Delete' ); ?></a></span>
										<?php endif; ?>
									</div>
								</td>
								<?php
								//show sorted column first if present
								if (!empty ($sort_number)) {
									$name = 'rpi_label'.$sort_number ;
									$value = get_user_meta ($user->ID, $name, true) ;
									echo '<td id="field_data">';
									echo esc_html($value).'</td>' ;
								}
								$j=1 ;
								while($j<= $top)   {
									if (!empty ($sort_number) && $sort_number == $j) {
										$j++;
										continue ;
									}
									$name = 'rpi_label'.$j ;
									$value = get_user_meta ($user->ID, $name, true) ;
									echo '<td id="field_data">';
									echo esc_html($value).'</td>' ;
									$j++ ;
									}
								?>
										
								
							</tr>
							<?php
							$i++;
						endforeach;

					else :

						?>
						<tr>
							<td colspan="6"><strong><?php esc_html_e( 'No Users found', 'bbp-profile-information' ); ?></strong></td>
						</tr>
						<?php

					endif;
					?>
				</tbody>
			</table>

		</form>
		<?php
	}


