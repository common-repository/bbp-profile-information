<?php

//new file

function rpi_settings()
{
	global $rpi_options ;
		
	?>
	<div class="wrap">
		<div id="upb-wrap" class="upb-help">
			<h2><?php esc_html_e('Profile information Settings', 'bbp-profile-information'); ?></h2>
			
			<?php
			wp_nonce_field( 'profile_information_settings', 'profile_settings_nonce' );
			if ( !empty( $_POST['profile_settings_nonce'] )) wp_verify_nonce(sanitize_text_field( wp_unslash( $_POST['profile_settings_nonce'])), 'profile_information_settings' ) ;
			if ( ! isset( $_REQUEST['updated'] ) )
				$_REQUEST['updated'] = false;
			?>
			<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php esc_html_e( 'Group saved', 'bbp-profile-information'); ?> ); ?></strong></p></div>
			<?php endif; 
			//}  //end if ( !empty( $_POST['profile_settings_nonce']
			?>
			
			<?php //tests if we have selected a tab ?>
			<?php
             if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = sanitize_text_field(wp_unslash($_GET[ 'tab' ]));
			}
			else {
				$active_tab= 'settings';
            } // end if
        ?>
		
		<?php // sets up the tabs ?>			
		<h2 class="nav-tab-wrapper">
	<a href="?page=bbp-profile-information&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Settings' , 'bbp-profile-information' ) ; ?></a>
	<a href="?page=bbp-profile-information&tab=fieldtype" class="nav-tab <?php echo $active_tab == 'fieldtype' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Field Type' , 'bbp-profile-information' ) ; ?></a>
	<a href="?page=bbp-profile-information&tab=user-management" class="nav-tab <?php echo $active_tab == 'user-management' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('User Management' , 'bbp-profile-information' ) ; ?></a>
	
		
	<table class="form-table">
		<tr>		
			
			<td>
				<?php esc_html_e('If you find this plugin useful, please consider donating just a few dollars to help me develop and maintain it. You support will be appreciated, just click the donate button', 'bbp-style-pack'); ?>
			</td>
			<td>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick" />
					<input type="hidden" name="hosted_button_id" value="GEMT7XS7C8PS4" />
					<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
					<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
				</form>
			</td>
			
			
		</tr>
	</table>

<?php

//****  management info
if( $active_tab == 'settings' ) { 
rpi_settings_page() ;
}
//****  management info
if( $active_tab == 'fieldtype' ) { 
rpi_settings_fieldtype() ;
//uses settings_dropdown as wp_options field
}
//****  user management
if ($active_tab == 'user-management' ) {
rpi_user_management() ;
}

//end of tab function
}


// register the plugin settings
function rpi_register_settings() {

	register_setting( '$rpi_options', '$rpi_options' );
	register_setting( 'rpi_settings_group', 'rpi_settings' );
	register_setting( 'rpi_settings_dropdown', 'rpi_settings_dropdown' );
}
	
//call register settings function
add_action( 'admin_init', 'rpi_register_settings' );

function rpi_settings_menu() {
	//allows filter for which capability can access the settings page - default = 'manage_options'
	$cap = apply_filters('rpi_plugin_settings_capability','manage_options');
	// add settings page
	add_submenu_page('options-general.php', __('bbp-profile-information', 'bbp-profile-information'), __('bbp-profile-information', 'bbp-profile-information'), $cap, 'bbp-profile-information', 'rpi_settings');
}
add_action('admin_menu', 'rpi_settings_menu');

