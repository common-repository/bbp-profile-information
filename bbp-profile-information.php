<?php
/*
Plugin Name: bbp profile information
Plugin URL: http://www.rewweb.co.uk/bbp-profile-information/
Description: adds fields to the bbp user profile and displays any combination of these under the authors avatar in topics and replies
Version: 2.1.4
Author: Robin W
Author URI: http://www.rewweb.co.uk/
Contributors: Parts of code adapted from Pippin's Restrict Content plugin, with thanks.
License: GPL2
*/
/*  Copyright 2016-2024  Robin Wilson  (email : wilsonrobine@btinternet.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

   https://www.gnu.org/licenses/gpl-2.0.html

*/


/*******************************************
* global variables
*******************************************/

// load the plugin options
$rpi_options = get_option( 'rpi_settings' );
//uses $rpi_settings_dropdown as the fieldtype settings
$rpi_settings_dropdown = get_option( 'rpi_settings_dropdown' );

if(!defined('RPI_PLUGIN_DIR'))
	define('RPI_PLUGIN_DIR', dirname(__FILE__));




/*******************************************
* file includes
*******************************************/

include(RPI_PLUGIN_DIR . '/includes/settings.php');
include(RPI_PLUGIN_DIR . '/includes/display.php');
include(RPI_PLUGIN_DIR . '/includes/registration.php');
include(RPI_PLUGIN_DIR . '/includes/settings-page.php');
include(RPI_PLUGIN_DIR . '/includes/user_management.php');
include(RPI_PLUGIN_DIR . '/includes/settings-fieldtype.php');
include(RPI_PLUGIN_DIR . '/includes/functions.php');
include(RPI_PLUGIN_DIR . '/includes/profile.php');





