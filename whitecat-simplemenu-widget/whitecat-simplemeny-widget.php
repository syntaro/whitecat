<?php
/*
Plugin Name: WhiteCat SimpleMenu Widget
Plugin URI: 
Description: Menuを表示するウィジェットを追加する
Author: SynthTAROU
Version: 0.1
Author URI:
*/
?>

<?php
/*  Copyright 2022 SynthTAROU (email : yamanaka.kinoko@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
add_action('widgets_init', 'whitecat_simplemenu_widget_register' );
function whitecat_simplemenu_widget_register() {
	register_widget( 'whitecat_simplemenu_widget' );
}

// // // テスト実装マイウィジェット 
class whitecat_simplemenu_widget extends WP_Widget {
	/**
	 * ウィジェット名などを設定
	 */
	function __construct() {
		$widget_ops = array(
			'classname' => 'WhiteCatSimpleMenu_class',
			'description' => 'ウィジェットのサンプル'
		);
		parent::__construct( 'WhiteCatSimpleMenu', 'WhiteCat SimpleMenu', $widget_ops );

	}

	function whitecate_before_footer()  {
		echo '<div id="whitecat_simplemenu_child">' . $this->footer_text . '</div>';
	}

	/**
	 * ウィジェットの内容を出力
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo '<style type="text/css">' . $instance['addcss'] . '</style>';

		// outputs the content of the widget
		echo $before_widget;
		
		echo '<style>'; ?>
	#whitecat_simplemenu {
		width: 240px;
		background-color: <?php echo $instance['background']; ?>;
		color: <?php echo $instance['color']; ?>
	}
	#whitecat_simplemenu a { color: <?php echo $instance['color']; ?>}
<?php
		echo '</style>';
		//ウィジェットで表示する内容
		echo '<div id="whitecat_simplemenu">';
		echo '<h3>' . $instance['title'] . '</h3>';
		$footer_text = wp_nav_menu(array('menu' => $instance['menu'], 'echo' => 'false'));
		echo $footer_text;
		echo '</div>';

		echo $after_widget;
	}

	/**
	 * ウィジェットオプションの保存処理
	 *
	 * @param array $new_instance 新しいオプション
	 * @param array $old_instance 以前のオプション
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['menu'] = sanitize_text_field( $new_instance['menu'] );
		$instance['color'] = sanitize_text_field( $new_instance['color'] );
		$instance['background'] = sanitize_text_field( $new_instance['background'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title' => 'タイトルを入力',
			'menu' => 'メニューを選択',
			'color' => '文字色',
			'background' => '背景色'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$menu = $instance['menu'];
		$color = $instance['color'];
		$background = $instance['background'];
		$addcss = $instance['addcss'];

		$name_title = $this->get_field_name ('title');
		$name_menu = $this->get_field_name ('menu');
		$name_color = $this->get_field_name ('color');
		$name_background = $this->get_field_name ('background');
		$name_addcss = $this->get_field_name ('addcss');

		$esc_title = esc_attr($title);
		$esc_menu = esc_attr($menu);
		$esc_color = esc_attr($color);
		$esc_background = esc_attr($background);
		$esc_addcss = esc_attr($addcss);
		
		$whitecat_make_css = "whitecat_make_css";
		
		echo "<p>タイトル: <input class='widefat'";
		echo " name='" . $name_title . "'";
		echo " type='text' value='" . $esc_title . "'>";
		echo "</p>";
		echo "<p>メニュー:";

		$nav_menus = wp_get_nav_menus();
		if ( count( $nav_menus ) > 0 ) :
			echo "<select name='" . $name_menu . "'>";
 			foreach ( (array) $nav_menus as $menu_elem ) {
				echo "<option value=\"" . esc_attr( $menu_elem->name ) . "\"";
				if ($menu == $menu_elem->name) {
					echo " selected";
				}
				$esc_name = esc_attr($menu_elem->name);
				echo '>' .$esc_name .  '</option>';
			}
			echo '</select>';
		endif ;
		echo '</p>';
		echo '<p>文字カラー:' . PHP_EOL;
		echo '<input name="' . $name_color . '" ';
		echo 'type="color" value="' . $esc_color . '">';
		echo '</p>';
		echo '<p>背景カラー:' . PHP_EOL;
		echo '<input name="' . $name_background . '" ';
		echo 'type="color" value="' . $esc_background . '">';
		echo '</p>';
		echo '<p>追加CSSは、#whitecat_simplemenu a:link { color: ???; }として設定できます</p>';
/*
	#whitecat_simplemenu a:link { color: <?php echo $instance['color']; ?>}
	#whitecat_simplemenu a:visited { color: <?php echo $instance['color']; ?>}
	#whitecat_simplemenu a:hover { color: <?php echo $instance['color']; ?>}
	#whitecat_simplemenu a:active { color: <?php echo $instance['color']; ?>}
*/
	}
}

?>
