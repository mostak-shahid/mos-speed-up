<?php
function mos_speed_up_settings_init() {
	register_setting( 'mos_speed_up', 'mos_speed_up_options' );
	
	add_settings_section('mos_speed_up_section_con_start', '', 'mos_speed_up_section_con_start_cb', 'mos_speed_up');

	/*Remove query strings from static resources*/

	add_settings_section('mos_speed_up_section_query_start', '', 'mos_speed_up_section_query_start_cb', 'mos_speed_up');

	add_settings_section('mos_speed_up_section_query_collapse_start', '', 'mos_speed_up_collapse_start_cb', 'mos_speed_up');

	add_settings_field( 'field_query_enable', __( 'Enable', 'mos_speed_up' ), 'mos_speed_up_field_query_enable_cb', 'mos_speed_up', 'mos_speed_up_section_query_collapse_start', [ 'label_for' => 'query_enable' ] );

	add_settings_section('mos_speed_up_section_collapse_end', '', 'mos_speed_up_section_end_cb', 'mos_speed_up');

	add_settings_section('mos_speed_up_section_query_end', '', 'mos_speed_up_section_end_cb', 'mos_speed_up');

	/*Defer parsing of JavaScript*/

	add_settings_section('mos_speed_up_section_defer_start', '', 'mos_speed_up_section_defer_start_cb', 'mos_speed_up');

	add_settings_section('mos_speed_up_section_defer_collapse_start', '', 'mos_speed_up_collapse_start_cb', 'mos_speed_up');

	add_settings_field( 'field_defer_enable', __( 'Enable', 'mos_speed_up' ), 'mos_speed_up_field_defer_enable_cb', 'mos_speed_up', 'mos_speed_up_section_defer_collapse_start', [ 'label_for' => 'defer_enable' ] );

	add_settings_section('mos_speed_up_section_collapse_end', '', 'mos_speed_up_section_end_cb', 'mos_speed_up');

	add_settings_section('mos_speed_up_section_defer_end', '', 'mos_speed_up_section_end_cb', 'mos_speed_up');

	add_settings_section('mos_speed_up_section_con_end', '', 'mos_speed_up_section_end_cb', 'mos_speed_up');

}
add_action( 'admin_init', 'mos_speed_up_settings_init' );

function get_mos_speed_up_active_tab () {
	$output = array(
		'option_prefix' => admin_url() . "/options-general.php?page=mos_speed_up_settings&tab=",
		//'option_prefix' = "?post_type=p_file&page=mos_speed_up_settings&tab=",
	);
	if (isset($_GET['tab'])) $active_tab = $_GET['tab'];
	elseif (isset($_COOKIE['speed_up_active_tab'])) $active_tab = $_COOKIE['speed_up_active_tab'];
	else $active_tab = 'dashboard';
	$output['active_tab'] = $active_tab;
	return $output;
}
function mos_speed_up_section_con_start_cb( $args ) {
	$data = get_mos_speed_up_active_tab ();
	?>
	<div class="tab-con acc-group">
	<?php
}
function mos_speed_up_section_query_start_cb( $args ) {
	$data = get_mos_speed_up_active_tab ();
	?>
	<div id="mos-speed-up-query" class="<?php if($data['active_tab'] == 'query') echo 'active';?>">
		<div class="acc-heading"><h3 class="acc-title"><a data-id="query" href="javascript:void(0)">Remove query strings</a></h3></div>
	<?php
}
function mos_speed_up_field_query_enable_cb( $args ) {
	$options = get_option( 'mos_speed_up_options' );
	?>	
		<label for="<?php echo esc_attr( $args['label_for'] ); ?>"><input name="mos_speed_up_options[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, false ) ) : ( '' ); ?>><?php esc_html_e( 'Yes I like to remove query strings from static resources.', 'mos_speed_up' ); ?></label>				
	<?php
}
function mos_speed_up_section_defer_start_cb( $args ) {
	$data = get_mos_speed_up_active_tab ();
	?>
	<div id="mos-speed-up-defer" class="<?php if($data['active_tab'] == 'defer') echo 'active';?>">
		<div class="acc-heading"><h3 class="acc-title"><a data-id="defer" href="javascript:void(0)">Defer parsing of JavaScript</a></h3></div>
	<?php
}
function mos_speed_up_field_defer_enable_cb( $args ) {
	$options = get_option( 'mos_speed_up_options' );
	?>	
		<label for="<?php echo esc_attr( $args['label_for'] ); ?>"><input name="mos_speed_up_options[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, false ) ) : ( '' ); ?>><?php esc_html_e( 'Yes I like to defer parsing of JavaScript.', 'mos_speed_up' ); ?></label>				
	<?php
}

function mos_speed_up_collapse_start_cb( $args ) {
	$data = get_mos_speed_up_active_tab ();
	?>
	<div class="acc-collapse">
	<?php
}

function mos_speed_up_section_end_cb( $args ) {
	$data = get_mos_speed_up_active_tab ();
	?>
	</div>
	<?php
}


function mos_speed_up_options_page() {
	//add_menu_page( 'WPOrg', 'WPOrg Options', 'manage_options', 'mos_speed_up', 'mos_speed_up_options_page_html' );
	add_submenu_page( 'options-general.php', 'Mos Speed up Settings', 'Mos Speed up', 'manage_options', 'mos_speed_up_settings', 'mos_speed_up_admin_page' );
}
add_action( 'admin_menu', 'mos_speed_up_options_page' );

function mos_speed_up_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error( 'mos_speed_up_messages', 'mos_speed_up_message', __( 'Settings Saved', 'mos_speed_up' ), 'updated' );
	}
	settings_errors( 'mos_speed_up_messages' );
	?>
	<div class="wrap mos-speed-up-wrapper">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
		<?php
		settings_fields( 'mos_speed_up' );
		do_settings_sections( 'mos_speed_up' );
		submit_button( 'Save Settings' );
		?>
		</form>
	</div>
	<?php
}