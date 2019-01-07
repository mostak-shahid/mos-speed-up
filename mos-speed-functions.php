<?php
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