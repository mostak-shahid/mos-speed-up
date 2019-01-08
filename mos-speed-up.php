<?php
/*
Plugin Name: Mos Speed up
Plugin URI: http://mostak.belocal.today/plugins/mos-speed-up/
Description: Increases the speed of your site to improve your scores in Pingdom, GTmetrix, PageSpeed and YSlow. 
Version: 0.0.1
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
// Define MOS_SPEED_UP_SETTINGS.
if ( ! defined( 'MOS_SPEED_UP_SETTINGS' ) ) {
  //define( 'MOS_SPEED_UP_SETTINGS', admin_url('/edit.php?post_type=post_type&page=plugin_settings') );
	define( 'MOS_SPEED_UP_SETTINGS', admin_url('/options-general.php?page=mos_speed_up_settings') );
}
$plugin = plugin_basename(MOS_PLUGIN_FILE); 
require_once ( plugin_dir_path( __FILE__ ) . 'mos-speed-up-functions.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'mos-speed-up-settings.php' );

require_once('plugins/update/plugin-update-checker.php');
$pluginInit = Puc_v4_Factory::buildUpdateChecker(
    'https://raw.githubusercontent.com/mostak-shahid/update/master/mos-speed-up.json',
    __FILE__,
    'mos-speed-up'
);

register_activation_hook(MOS_SPEED_UP_FILE, 'mos_speed_up_activate');
add_action('admin_init', 'mos_speed_up_redirect');
 
function mos_speed_up_activate() {
    $mos_speed_up_options = array();
    // $mos_speed_up_option['mos_login_type'] = 'basic';
    // update_option( 'mos_speed_up_option', $mos_speed_up_option, false );
    add_option('mos_speed_up_do_activation_redirect', true);
    $mos_speed_up_options = get_option( 'mos_speed_up_options' );
    if (!$mos_speed_up_options) {
      $mos_speed_up_options['query_enable'] = 1;
      $mos_speed_up_options['query_key'] = array('?ver', '&ver');
      $mos_speed_up_options['defer_enable'] = 1;
      $mos_speed_up_options['defer_mode'] = 'defer';
      $mos_speed_up_options['defer_except'] = array('jquery.js');
      update_option( 'mos_speed_up_options', $mos_speed_up_options );
    }
}
 
function mos_speed_up_redirect() {
    if (get_option('mos_speed_up_do_activation_redirect', false)) {
        delete_option('mos_speed_up_do_activation_redirect');
        if(!isset($_GET['activate-multi'])){
            wp_safe_redirect(MOS_SPEED_UP_SETTINGS);
        }
    }
}

// Add settings link on plugin page
function mos_speed_up_settings_link($links) { 
  $settings_link = '<a href="'.MOS_SPEED_UP_SETTINGS.'">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
} 
add_filter("plugin_action_links_$plugin", 'mos_speed_up_settings_link' );