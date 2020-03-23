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

/**
 * legacy require replace with composer autoloading
 */
require_once __DIR__ . '/php/classes/class-main.php';

/**
 * Add to globals, allows others to remove it if required.
 */
$GLOBALS['lcb_main'] = new LCBMain();