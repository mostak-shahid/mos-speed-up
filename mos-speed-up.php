<?php
/*
Plugin Name: Mos Speed up
Plugin URI: http://mostak.belocal.today/plugins/mos-speed-up/
Description: Mos FAQs plugin that lets you easily create, order and publicize FAQs using shortcodes.
Version: 2.0.1
Author: Md. Mostak Shahid
Author URI: http://mostak.belocal.today/
License: GPL2
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define MOS_FAQ_FILE.
if ( ! defined( 'MOS_SPEED_UP_FILE' ) ) {
	define( 'MOS_SPEED_UP_FILE', __FILE__ );
}
require_once ( plugin_dir_path( __FILE__ ) . 'mos-speed-up-functions.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'mos-speed-up-settings.php' );

require_once('plugins/update/plugin-update-checker.php');
$pluginInit = Puc_v4_Factory::buildUpdateChecker(
    'https://raw.githubusercontent.com/mostak-shahid/update/master/mos-speed-up.json',
    __FILE__,
    'mos-speed-up'
);