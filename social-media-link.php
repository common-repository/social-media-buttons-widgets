<?php
/*
Plugin Name: Social Media Buttons &amp; Widgets
Plugin URI: http://wordpress.org/plugins/social-media-buttons-widgets/
Description: This is plugin is a simple social media button that appear on all page and post it has also facebook like box, google badge and twitter feed.
Author: Ruel Nopal
Author URI: http://radongrafix.com
Version: 1.4.1
*/


/******************************
* global variables
******************************/

$smbw_prefix = 'smbw_';
$smbw_plugin_name = 'SM Buttons &amp; Widgets';

// retrieve our plugin settings from the options table
$smbw_options = get_option('smbw_settings');

/******************************
* includes
******************************/

include('includes/scripts.php'); // this controls all JS / CSS
include('includes/display-functions.php'); // display content functions
include('includes/admin-page.php'); // the plugin options page HTML and save functions