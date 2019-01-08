<?php
function mos_speed_up_admin_enqueue_scripts(){
    global $pagenow, $typenow;
    $page = @$_GET['page']; //page=mos_speed_up_settings
    // var_dump($pagenow); //options-general.php
    // var_dump($typenow); //''
    // var_dump($page);
    if ($pagenow == 'options-general.php' AND $page == 'mos_speed_up_settings') {
        wp_enqueue_style( 'mos-speed-up-admin', plugins_url( 'css/mos-speed-up-admin.css', __FILE__ ) );
        //wp_enqueue_media();
        wp_enqueue_script( 'jquery' );      
        wp_enqueue_script( 'mos-speed-up-functions', plugins_url( 'js/mos-speed-up-functions.js', __FILE__ ), array('jquery') );
        wp_enqueue_script( 'mos-speed-up-admin', plugins_url( 'js/mos-speed-up-admin.js', __FILE__ ), array('jquery') );
    }
}
add_action( 'admin_enqueue_scripts', 'mos_speed_up_admin_enqueue_scripts' );

if (!(is_admin() )) {
    function mos_speed_up_defer_parsing_of_js ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        // return "$url' defer ";
        //return "$url' async onload='";
        return "$url' defer onload='";
    }
    add_filter( 'clean_url', 'mos_speed_up_defer_parsing_of_js', 11, 1 );
}
/*Remove query string*/
function mos_speed_up_remove_script_version_one ( $src ){ 
    $parts = explode( '?ver', $src );  
    return $parts[0]; 
}
function mos_speed_up_remove_script_version_two ( $src ){ 
    $parts = explode( '&ver', $src );  
    return $parts[0]; 
} 
add_filter( 'script_loader_src', 'mos_speed_up_remove_script_version_one', 15, 1 ); 
add_filter( 'style_loader_src', 'mos_speed_up_remove_script_version_one', 15, 1 );
add_filter( 'script_loader_src', 'mos_speed_up_remove_script_version_two', 15, 1 ); 
add_filter( 'style_loader_src', 'mos_speed_up_remove_script_version_two', 15, 1 );