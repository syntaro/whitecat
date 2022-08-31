<?php

function footer_php_include()  {
    include('footer-include.php');
}
add_action('wp_footer', 'footer_php_include');

function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css', array('parent-style') );
	wp_enqueue_style( 'staradvance-google-font', '//fonts.googleapis.com/css?family=Satisfy&display=swap', false, null, 'all' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/* メールアドレス確認用 */
add_filter( 'wpcf7_validate_email', 'wpcf7_validate_email_filter_confrim', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_validate_email_filter_confrim', 11, 2 );
function wpcf7_validate_email_filter_confrim( $result, $tag ) {
	$type = $tag['type'];
	$name = $tag['name'];
	if ( 'email' == $type || 'email*' == $type ) {
		if (preg_match('/(.*)-confirm$/', $name, $matches)){
			//確認用メルアド入力フォーム名を ○○○-confirm としています。
			$target_name = $matches[1];
			$posted_value = trim( (string) $_POST[$name] ); //前後空白の削除
			$posted_target_value = trim( (string) $_POST[$target_name] ); //前後空白の削除
			if ($posted_value != $posted_target_value) {
				$result->invalidate( $tag,"確認用のメールアドレスが一致していません");
			}
		}
	}
	return $result;
}

/*
add_filter('walker_nav_menu_start_el', 'description_in_nav_menu', 10, 4);
function description_in_nav_menu($item_output, $item){
  return preg_replace('/(<a.*?>[^<]*?)</', '$1' . "<br /><span>{$item->description}</span><", $item_output);
}*/

?>
