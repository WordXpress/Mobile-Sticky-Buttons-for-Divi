<?php
/*
Plugin Name: Lead Call Buttons
Plugin URI: http://getyoursmartsiteon.com
Description: Make it easy for website visitors to reach you. When enabled adds customizable buttons to the mobile view of the website, i.e. Call, Map, Schedule.
Author: Team Smart Site
Author URI: http://getyoursmartsiteon.com
Version: 1.0.7
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