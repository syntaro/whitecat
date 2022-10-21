<?php
/*
Plugin Name: WhiteCat SiteMap Widget
Plugin URI: 
Description: SiteMapを表示するウィジェットを追加する
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
add_action('widgets_init', 'whitecat_sitemap_widget_register' );
function whitecat_sitemap_widget_register() {
	register_widget( 'whitecat_sitemap_widget' );
}

// // // テスト実装マイウィジェット 
class whitecat_sitemap_widget extends WP_Widget {

	/**
	 * ウィジェット名などを設定
	 */
	function __construct() {
		$widget_ops = array(
			'classname' => 'WhiteCatsitemap_class',
			'description' => 'ウィジェットのサンプル'
		);
		parent::__construct( 'WhiteCatSiteMap', 'WhiteCat SiteMap', $widget_ops );

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
		echo '<div id="whitecat_sitemap_' . $this->number . '">';
		echo '<h3>' . $instance['title'] . '</h3>';
		$args = array(
			'depth' => 0,
			'show_date' => '', // modified
			'date_format' => 'Y年M月d日',
			'title_li' => '', $instance['title'],
			'link_before' => '',
			'link_after' => '',
			'echo' => '1',
			/*	child_of
				exclude
				include*/
		);
		wp_list_pages( $args );

		echo '</div>';

		echo "<style>" . PHP_EOL;
		echo "#whitecat_sitemap_" . $this->number . " {". PHP_EOL;
		//echo "width: 240px;" . PHP_EOL;
		if($instance['background'] != '') :
			echo "    background-color: " . $instance['background'] .";" . PHP_EOL;
		endif;
		if($instance['color'] != '') :
			echo "    color: " . $instance['color'] .";" . PHP_EOL;
		endif;
		echo '}';
		if($instance['color'] != '') :
			echo "    #whitecat_sitemap_" . $this->number . " li { list-style: none; margin-left: 12px;  } " . PHP_EOL;
			//echo "    #whitecat_sitemap_" . $this->number . " li { list-style: square; margin-left: 25px; } " . PHP_EOL;
			//echo "    #whitecat_sitemap_" . $this->number . " li { list-style: disk / circle / none; color: red; } " . PHP_EOL;
			echo "    #whitecat_sitemap_" . $this->number . " a { color: " . $instance['color'] ."; } " . PHP_EOL;
			echo "    #whitecat_sitemap_" . $this->number . " a:link { color: " . $instance['color'] ."; } " . PHP_EOL;
			echo "    #whitecat_sitemap_" . $this->number . " a:visited { color: " . $instance['color'] ."; } " . PHP_EOL;
			echo "    #whitecat_sitemap_" . $this->number . " a:hover { color: " . $instance['color'] ."; } " . PHP_EOL;
			echo "    #whitecat_sitemap_" . $this->number . " a:active { color: " . $instance['color'] ."; } " . PHP_EOL;
		endif;
		echo "</style>";
		
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
		$instance['color'] = sanitize_text_field( $new_instance['color'] );
		$instance['background'] = sanitize_text_field( $new_instance['background'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title' => 'タイトルを入力',
			'color' => '文字色',
			'background' => '背景色'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$color = $instance['color'];
		$background = $instance['background'];

		$name_title = $this->get_field_name ('title');
		$name_color = $this->get_field_name ('color');
		$name_background = $this->get_field_name ('background');

		$esc_title = esc_attr($title);
		$esc_color = esc_attr($color);
		$esc_background = esc_attr($background);

		echo "<p>タイトル: <input class='widefat'";
		echo " name='" . $name_title . "'";
		echo " type='text' value='" . $esc_title . "'>";
		echo "</p>";

		echo '<p>文字カラー:' . PHP_EOL;
		echo '<input name="' . $name_color . '" ';
		echo 'type="color" value="' . $esc_color . '">';
		echo '</p>';
		echo '<p>背景カラー:' . PHP_EOL;
		echo '<input name="' . $name_background . '" ';
		echo 'type="color" value="' . $esc_background . '">';
		echo '</p>';
	}
}

?>