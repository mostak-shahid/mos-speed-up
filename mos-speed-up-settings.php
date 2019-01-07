<?php
function mos_speed_up_settings_init() {
	register_setting( 'mos_speed_up', 'mos_speed_up_options' );
	
	add_settings_section('mos_speed_up_section_scripts_start', '', 'mos_speed_up_section_scripts_start_cb', 'mos_speed_up');
	add_settings_field( 'field_jquery', __( 'JQuery', 'mos_speed_up' ), 'mos_speed_up_field_jquery_cb', 'mos_speed_up', 'mos_speed_up_section_scripts_start', [ 'label_for' => 'jquery', 'class' => 'mos_speed_up_row', 'mos_speed_up_custom_data' => 'custom', ] );
	add_settings_field( 'field_bootstrap', __( 'Bootstrap', 'mos_speed_up' ), 'mos_speed_up_field_bootstrap_cb', 'mos_speed_up', 'mos_speed_up_section_scripts_start', [ 'label_for' => 'bootstrap', 'class' => 'mos_speed_up_row', 'mos_speed_up_custom_data' => 'custom', ] );
	add_settings_field( 'field_css', __( 'Custom Css', 'mos_speed_up' ), 'mos_speed_up_field_css_cb', 'mos_speed_up', 'mos_speed_up_section_scripts_start', [ 'label_for' => 'mos_speed_up_css' ] );
	add_settings_field( 'field_js', __( 'Custom Js', 'mos_speed_up' ), 'mos_speed_up_field_js_cb', 'mos_speed_up', 'mos_speed_up_section_scripts_start', [ 'label_for' => 'mos_speed_up_js' ] );
	add_settings_section('mos_speed_up_section_scripts_end', '', 'mos_speed_up_section_end_cb', 'mos_speed_up');

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
function mos_speed_up_section_scripts_start_cb( $args ) {
	$data = get_mos_speed_up_active_tab ();
	?>
	<div id="mos-speed-up-scripts" class="tab-con <?php if($data['active_tab'] == 'scripts') echo 'active';?>">
	<?php
}
function mos_speed_up_field_jquery_cb( $args ) {
	$options = get_option( 'mos_speed_up_options' );
	?>
	<label for="<?php echo esc_attr( $args['label_for'] ); ?>"><input name="mos_speed_up_options[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, false ) ) : ( '' ); ?>><?php esc_html_e( 'Yes I like to add JQuery from Plugin.', 'mos_speed_up' ); ?></label>
	<?php
}
function mos_speed_up_field_bootstrap_cb( $args ) {
	$options = get_option( 'mos_speed_up_options' );
	?>
	<label for="<?php echo esc_attr( $args['label_for'] ); ?>"><input name="mos_speed_up_options[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, false ) ) : ( '' ); ?>><?php esc_html_e( 'Yes I like to add JQuery from Plugin.', 'mos_speed_up' ); ?></label>
	<?php
}
function mos_speed_up_field_css_cb( $args ) {
	$options = get_option( 'mos_speed_up_option' );
	?>
	<textarea name="mos_speed_up_option[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>" rows="10" class="regular-text"><?php echo isset( $options[ $args['label_for'] ] ) ? esc_html_e($options[$args['label_for']]) : '';?></textarea>
	<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("mos_speed_up_css"), {
      lineNumbers: true,
      mode: "text/css",
      extraKeys: {"Ctrl-Space": "autocomplete"}
    });
	</script>
	<?php
}
function mos_speed_up_field_js_cb( $args ) {
	$options = get_option( 'mos_speed_up_option' );
	?>
	<textarea name="mos_speed_up_option[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>" rows="10" class="regular-text"><?php echo isset( $options[ $args['label_for'] ] ) ? esc_html_e($options[$args['label_for']]) : '';?></textarea>
	<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("mos_speed_up_js"), {
      lineNumbers: true,
      mode: "text/css",
      extraKeys: {"Ctrl-Space": "autocomplete"}
    });
	</script>
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
	add_submenu_page( 'options-general.php', 'Settings', 'Settings', 'manage_options', 'mos_speed_up_settings', 'mos_speed_up_admin_page' );
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