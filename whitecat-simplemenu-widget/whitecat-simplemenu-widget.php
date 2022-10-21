<?php
/*
Plugin Name: WhiteCat SimpleMenu Widget
Plugin URI: 
Description: Menuを表示するウィジェットを追加する
Author: SynTAROU
Version: 1.0
Author URI:
*/
/*  Copyright 2022 SynTAROU

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

function whitecat_simplemenu_widget_script() {
?>

<?php
}
//add_action('admin_print_scripts', 'whitecat_simplemenu_widget_script');

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
		// outputs the content of the widget
		echo $before_widget;
		//ウィジェットで表示する内容
		echo '<div id="whitecat_simplemenu_' . $this->number . '">';
		echo '<h3>' . $instance['title'] . '</h3>';
		$footer_text = wp_nav_menu(array('menu' => $instance['menu'], 'echo' => 'false'));
		echo $footer_text;
		echo '</div>';

		$color = $instance['color'];
		$background_css = $instance['background'];
		$esc_color_css = esc_attr($color);
		$esc_background_css = esc_attr($background_css);
?>
<style>
#whitecat_simplemenu_<?php echo $this->number; ?> {
   width: 240px;
   color: <?php echo $esc_color_css; ?>;
   background-color: <?php echo $esc_background_css; ?>;
   a { color: <?php echo $esc_color_css; ?>; }
   a:link { color: <?php echo $esc_color_css; ?>; }
   a:visited { color: <?php echo $esc_color_css; ?>; }
   a:hover { color: <?php echo $esc_color_css; ?>; }
   a:active { color: <?php echo $esc_color_css; ?>; }
   <?php echo $instance['text_css']; ?>
}
</style>
<?php
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
		$instance['text_css'] = sanitize_text_field( $new_instance['text_css'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title' => 'タイトルを入力',
			'menu' => 'メニューを選択',
			'color' => '文字色',
			'background' => '背景色',
			'text_css' => '追加CSS',
			'button_css' => 'ボタン',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$menu = $instance['menu'];
		$color = $instance['color'];
		$background_css = $instance['background'];
		$text_css = $instance['text_css'];
		$button_css = $instance['button_css'];

		$name_title = $this->get_field_name ('title');
		$name_menu = $this->get_field_name ('menu');
		$name_color_css = $this->get_field_name ('color');
		$name_background_css = $this->get_field_name ('background');
		$name_text_css = $this->get_field_name ('text_css');
		$name_button_css = $this->get_field_name ('button_css');

		$esc_title = esc_attr($title);
		$esc_menu = esc_attr($menu);
		$esc_color_css = esc_attr($color);
		$esc_background_css = esc_attr($background_css);
		$esc_text_css = esc_attr($text_css);
		$esc_button_css = esc_attr($button_css);
		
		$func_name = "javascript:whitecat_simplemenu_buttonaction";
		$func_name .= "('" . $name_color_css.  "', '". $name_background_css . "', '". $name_text_css . "');";

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
?>
	</p>
	<p>文字カラー:
		<input name="<?php echo $name_color_css; ?>" id="<?php echo $name_color_css;?>" type="color" 
			   value="<?php echo $esc_color_css; ?>">
	</p>
	<p>背景カラー:
		<input name="<?php echo $name_background_css; ?>" id="<?php echo $name_background_css;?>" type="color" 
			   value="<?php echo $esc_background_css; ?>">
	</p>
<?php
		/*
	<p>
		<button name="<?php echo $name_button_css; ?>" onclick="<?php echo $func_name?>">
			CSSに色を反映する</button>
		CSS（ウィジェット画面で使われます)
		<textarea name="<?php echo $name_text_css; ?>" id="<?php echo $name_text_css; ?>"><?php echo $esc_text_css; ?></textarea>
</p>
		*/
?>

<script type="text/javascript">
function whitecat_simplemenu_buttonaction(color_css, background_css, text_css) {
	var color = document.getElementById(color_css).value
	var back = document.getElementById(background_css).value
	var text = "#whitecat_simplemenu {\n";
	text = text + "    width: 240px;\n";
	text = text + "    color: " + color + ";\n";
	text = text + "    background-color: " + back + ";\n";
	text = text + "}\n";
	text = text + "#whitecat_simplemenu a { color: " + color + "; }\n";
	text = text + "#whitecat_simplemenu a:link { color: " + color + "; }\n";
	text = text + "#whitecat_simplemenu a:visited { color: " + color + "; }\n";
	text = text + "#whitecat_simplemenu a:hover { color: " + color + "; }\n";
	text = text + "#whitecat_simplemenu a:active { color: " + color + "; }\n";
	document.getElementById(text_css).value = text;
}
</script><?php
	}
}

?>