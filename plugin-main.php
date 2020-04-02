<?php
/**
 * Plugin Name: Mobile Sticky Buttons for Divi
 * Plugin URI: http://getyoursmartsiteon.com
 * Description: Make it easy for website visitors to reach you. When enabled adds customizable buttons to the mobile view of a Divi website, i.e. Call, Map, Schedule.
 * Author: WordXpress
 * Author URI: https://wordx.press/
 * Version: 0.0.1
 *
 * This software is forked from the original [Lead Call Buttons](https://wordpress.org/plugins/lead-call-buttons/) plugin (c) Team Smart Site
 *
 */

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LEAD_CALL_BUTTON_HOOK', WP_PLUGIN_URL . '/' . plugin_basename( __DIR__ ) . '/' );

define( 'LEAD_CALL_BUTTON_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LEAD_CALL_BUTTON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * legacy require possibly replace with composer autoloading
 */
require_once __DIR__ . '/php/classes/class-main.php';
require_once __DIR__ . '/php/classes/class-settings.php';
require_once __DIR__ . '/php/classes/class-admin.php';

// Create New Framework
// require_once( LEAD_CALL_BUTTON_PLUGIN_PATH . 'php/templates/lead-call-button-frame.php' );

/**
 * Add to globals, allows others to remove it if required.
 */
$GLOBALS['lcb_main'] = new LCBMain();