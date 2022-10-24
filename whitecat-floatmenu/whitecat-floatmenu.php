	<?php

	/*
	Plugin Name: WhiteCat FloatMenu
	Plugin URI:
	Description: 画面下部にフローティングメニュー
	Version: 0.1
	Author: SynthTAROU
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
	function whitecat_body_php_include()  {
		echo '<div id="whitecat-htmlbody">' . PHP_EOL;
		whitecat_floatmenu_styles();
	}
	add_action('wp_body_open', 'whitecat_body_php_include');

	function whitecat_floatmenu_include()  {
		whitecat_floatmenu_show();
		echo '</div> <!-- whitecat-htmlbody -->'.PHP_EOL;
	}
	add_action('wp_footer', 'whitecat_floatmenu_include');

	add_action('admin_menu', 'custom_menu_page');

	function custom_menu_page()
	{
	    add_menu_page('WhiteCat FloatMenu', 'WhiteCat FloatMenu'
					  , 'manage_options', 'custom_menu_page'
					  , 'whitecat_floatmenu_add_menu', 'dashicons-admin-generic', 80);
	    add_action('admin_init', 'whitecat_floatmenu_register_setting');
	}

	function whitecat_floatmenu_add_menu()
	{
	    ?>
	<div class="wrap">
	  <h2>WhiteCat FloatMenu</h2>
	  <form method="post" action="options.php" enctype="multipart/form-data" encoding="multipart/form-data">
	    <?php
	    settings_fields('whitecat-floatmenu');
	    do_settings_sections('whitecat-floatmenu');
		$color_background = get_option('backgroundcolor');
		if ($color_background == '') {
			$color_background = '#64a404';
		}
		$textcolor = get_option('textcolor');
		if ($textcolor == '') {
			$textcolor = '#fafad2';
		}
		$pluginopacity = get_option('pluginopacity');
		if ($pluginopacity == '') {
			$pluginopacity = '80';
		}
		$pluginheight = get_option('pluginheight');
		if ($pluginheight == '') {
			$pluginheight = '80';
		}
		$viewportwidth1 = get_option('viewportwidth1');
		if ($viewportwidth1 == '') {
			$viewportwidth1 = '993';
		}
		$viewportwidth2 = get_option('viewportwidth2');
		if ($viewportwidth2 == '') {
			$viewportwidth2 = '1400';
		}
		$widthbywhitecat = get_option('widthbywhitecat');
		if ($widthbywhitecat == '') {
			$widthbywhitecat = '1';
		}

	?>
	    <div class="metabox-holder">
	      <div class="postbox ">
	        <h3 class='handle'><span>メニュー設定</span></h3>
	        <div class="inside">
	          <div class="main">
	            <p class="setting_description">ページとフッターメニューを紐づけてください。</p>
					<table>
					  <tr>
					    <th>ページおよび投稿</th>
					    <th>メニュー</th>
					  </tr>
					  <tr>
				    	<td><?php whitecat_floatmenu_view_select_page(1); ?></td>
						<td><?php whitecat_floatmenu_view_select_menu(1); ?></td>
					  </tr>
					  <tr>
				    	<td><?php whitecat_floatmenu_view_select_page(2); ?></td>
						<td><?php whitecat_floatmenu_view_select_menu(2); ?></td>
					  </tr>
					  <tr>
				    	<td><?php whitecat_floatmenu_view_select_page(3); ?></td>
						<td><?php whitecat_floatmenu_view_select_menu(3); ?></td>
					  </tr>
					  <tr>
				    	<td><?php whitecat_floatmenu_view_select_page(4); ?></td>
						<td><?php whitecat_floatmenu_view_select_menu(4); ?></td>
					  </tr>
					  <tr>
				    	<td><?php whitecat_floatmenu_view_select_page(5); ?></td>
						<td><?php whitecat_floatmenu_view_select_menu(5); ?></td>
					  </tr>
				</table>
	          </div>
	        </div>
	      </div>

	        <div class="inside">
	          <div class="main">
	            <p class="setting_description">文字色 (推奨 #fafad2)</p>
				  <input type="color" name="textcolor" value="<?php echo $textcolor; ?>">
	            <p class="setting_description">背景色 (推奨 #64a404)</p>
				  <input type="color" name="backgroundcolor" value="<?php echo $color_background; ?>">
	            <p class="setting_description">透過 (推奨 80%)</p>
				  <input type="number" name="pluginopacity" min="0" max="100"
						 value="<?php echo $pluginopacity; ?>">
	            <p class="setting_description">高さ (推奨 80px)</p>
				  <input type="number" name="pluginheight" min="0" max="200"
						 value="<?php echo $pluginheight; ?>">
	            <p class="setting_description">テーマやプラグインで画面最大幅を指定していますか？(0: していない 993+1400: WhiteCat Theme ETC)</p>
				  <input type="number" name="viewportwidth1" min="0" max="2000"
						 value="<?php echo $viewportwidth1; ?>">
				  <input type="number" name="viewportwidth2" min="0" max="2000"
						 value="<?php echo $viewportwidth2; ?>">
	            <p class="setting_description">このプラグインで幅を変更しますか？(推奨： どちらでも)</p>
				  <input type="number" name="widthbywhitecat" min="0" max="1"
						 value="<?php echo $widthbywhitecat; ?>">
		      </div>
	        </div>
	      </div>
	    <?php submit_button(); ?>
	  </form>
	</div>
	<?php
	}

	function whitecat_floatmenu_view_select_menu($number) {
		$field_name = 'menu' . $number;
		$nav_menus = wp_get_nav_menus();
		echo '<select name="' . $field_name.  '">' . PHP_EOL;
		echo '<option value="" ' .  selected('', get_option($field_name)) . '>選択してください</option>';
	    if ( count( $nav_menus ) > 0 ) {
		    foreach ( (array) $nav_menus as $e ) { ?>
				<option value="<?php echo $e->term_id; ?>"
		    	<?php selected($e->term_id, get_option($field_name)); ?> >
				<?php echo $e->name; ?></option> <?php
			}
			echo "</select>";
		}
	}

	function whitecat_floatmenu_view_select_page($number) {
		$field_name = 'page' . $number;
		$pages = get_pages( array( 'sort_order'=>'ASC', 'sort_column'=>'menu_order') );
		$posts = get_posts( array( 'sort_oder'=>'DESC', 'sort_column'=>'post_date'));

		echo '<select name="'. $field_name.'">' . PHP_EOL;
		echo '<option value="" ' . selected('', get_option($field_name)) . '>選択してください</option>';

		if ( count ($posts) > 0) :
			?>
			<option value="ARCHIVE"
					<?php selected('ARCHIVE', get_option($field_name)); ?> >一般（アーカイブ）</option>
			<option value="POST_DEFAULT"
					<?php selected('POST_DEFAULT', get_option($field_name)); ?> >一般（投稿）</option> <?php
		    foreach( (array)$posts as $p ) { ?>
				<option value="<?php echo 'POST' . $p->ID; ?>"
					<?php selected('POST' . $p->ID, get_option($field_name)); ?> >
					<?php echo $p->post_title; ?></option> <?php
			}
		endif ;
		if ( count ($pages) >= 0 ) : ?>
			<option value="PAGE_DEFAULT"
					<?php selected('PAGE_DEFAULT', get_option($field_name)); ?> >一般（固定ページ）</option> <?php
		    foreach( (array)$pages as $p ) { ?>
				<option value="<?php echo 'PAGE' . $p->ID; ?>"
					<?php selected('PAGE' . $p->ID, get_option($field_name)); ?> >
					<?php echo $p->post_title; ?></option> <?php
			}
		endif ;
		?>	</select> <?php
	}

	function whitecat_floatmenu_register_setting()
	{
	    register_setting('whitecat-floatmenu', 'menu1');
	    register_setting('whitecat-floatmenu', 'page1');
	    register_setting('whitecat-floatmenu', 'menu2');
	    register_setting('whitecat-floatmenu', 'page2');
	    register_setting('whitecat-floatmenu', 'menu3');
	    register_setting('whitecat-floatmenu', 'page3');
	    register_setting('whitecat-floatmenu', 'menu4');
	    register_setting('whitecat-floatmenu', 'page4');
	    register_setting('whitecat-floatmenu', 'menu5');
	    register_setting('whitecat-floatmenu', 'page5');
	    register_setting('whitecat-floatmenu', 'radio');
	    register_setting('whitecat-floatmenu', 'textcolor');
	    register_setting('whitecat-floatmenu', 'backgroundcolor');
	    register_setting('whitecat-floatmenu', 'pluginopacity');
	    register_setting('whitecat-floatmenu', 'pluginheight');
		register_setting('whitecat-floatmenu', 'viewportwidth1');
		register_setting('whitecat-floatmenu', 'viewportwidth2');
		register_setting('whitecat-floatmenu', 'widthbywhitecat');
	}

	function whitecat_floatmenu_which()
	{
		$menu_default = '';
		$menu_custom = '';

		for ($i = 1; $i <= 5; $i++) {
			$menu_id = get_option('menu' . $i);
			$page_id = get_option('page' . $i);
			if ($page_id == '') {
				continue;
			}
			
			if ($page_id == 'ARCHIVE') {
				if (is_archive()) {
					$menu_defaujlt = $menu_id;
				}
			}else if ($page_id == 'POST_DEFAULT') {
				if (is_single()) {
					$menu_default = $menu_id;
				}
			}else if ($page_id == 'PAGE_DEFAULT') {
				if (is_page() || is_home()) {
					$menu_default = $menu_id;
				}
			}

			if (preg_match("/^POST/", $page_id)) {
				$seek_id = substr($page_id, 4);
				if (is_single($seek_id)) {
					$menu_custom = $menu_id;
				}
			}else if (preg_match("/^PAGE/", $page_id)) {
				$seek_id = substr($page_id, 4);
				if (is_page($seek_id)) {
					$menu_custom = $menu_id;
				}
			}
		}
		if ($menu_custom != '') {
			return $menu_custom;
		}else if ($menu_default != '') {
			return $menu_default;
		}
		return '';
	}

	function whitecat_floatmenu_show() {
		$menu = whitecat_floatmenu_which();

		echo "<aside><div id='whitecat-floatmenu'>";
		if ($menu != '') {
			wp_nav_menu( array ('menu'=>$menu ) );
		}
		echo "</div></aside>";
	}

	function whitecat_floatmenu_styles() {
		$menu = whitecat_floatmenu_which();

		$color_background = get_option('backgroundcolor');
		if ($color_background == '') {
			$color_background = '#64a404';
		}
		$textcolor = get_option('textcolor');
		if ($textcolor == '') {
			$textcolor = '#fafad2';
		}
		$pluginopacity = get_option('pluginopacity');
		if ($pluginopacity == '') {
			$pluginopacity = '70';
		}
		$pluginheight = get_option('pluginheight');
		if ($pluginheight == '') {
			$pluginheight = '80';
		}
		$viewportwidth1 = get_option('viewportwidth1');
		if ($viewportwidth1 == '') {
			$viewportwidth1 = '993';
		}
		$viewportwidth2 = get_option('viewportwidth2');
		if ($viewportwidth2 == '') {
			$viewportwidth2 = '1400';
		}
		$widthbywhitecat = get_option('widthbywhitecat');
		if ($widthbywhitecat == '') {
			$widthbywhitecat = '1';
		}
		if ($menu != '') {
			$margin1 = 'margin-bottom: ' . $pluginheight . 'px;' . PHP_EOL;
		}
		$margin2 = 'margin-left: auto;' . PHP_EOL . 'margin-right: auto;' . PHP_EOL;
		if ($widthbywhitecat != '0') { 
			$maxwidth1 = 'max-width: ' . $viewportwidth1 . 'px; ' . PHP_EOL;
			$maxwidth2 = 'max-width: ' . $viewportwidth2 . 'px; ' . PHP_EOL;
		}else {
			$maxwidth1 = '';
			$maxwidth2 = '';
		}
		echo '<style type="text/css">'.PHP_EOL;
		?>
		body {
			background-color: lightblue;
		}
		<?php
	    if ($viewportwidth1 != $viewportwidth2) { ?>
		#whitecat-htmlbody {
			background-color: white;
		}
		#whitecat-floatmenu {
			background-color: <?php echo $color_background ; ?> !important;
			color: <?php echo $textcolor; ?> !important;
			opacity: <?php echo $pluginopacity;?>% !important;

			text-align: center;
			padding: 0 0;

			position: fixed;
			bottom: 0;
			width: 100%;
			z-index: 100;
			<?php echo $margin2; ?>
		}
		#whitecat-htmlbody {
			<?php echo $margin1 . $margin2; ?>
		}
	    @media screen and (min-width: <?php echo $viewportwidth1; ?>px) and (max-width: <?php echo ($viewportwidth2 - 0.1); ?>px) {
			#whitecat-htmlbody {
				<?php echo $maxwidth1; ?> 
			}
			#whitecat-floatmenu {
			    <?php echo $maxwidth1; ?>
			}
		}
	  <?php } ?>
	    @media screen and (min-width: <?php echo $viewportwidth2; ?>px) {
			#whitecat-htmlbody {
				<?php echo $maxwidth2; ?> 
			}
			#whitecat-floatmenu {
			    <?php echo $maxwidth2; ?>
			}
		}

		#whitecat-floatmenu ul{
			display: flex;
			list-style: none;
			padding: 0;
			margin: 0;
			width: 100%;
		    height: <?php echo $pluginheight ?>px;
		}

		#whitecat-floatmenu li {
			justify-content: center;
			align-items: center;
			width: 100%;
			padding: 0;
			margin: 0;
			font-size: 14px;
			border-left: 1px solid #fff;
			border-right: 1px solid #fff;
		}

		#whitecat-floatmenu li a{
			text-align: center;	
			color: <?php echo $textcolor; ?> !important;
			display:block;
			width: 100%;
			padding:20px;	
		}
		#whitecat-floatmenu li a:hover{
			position: relative;top:2px;left:2px;
		}

		</style>
	<?php
	}
