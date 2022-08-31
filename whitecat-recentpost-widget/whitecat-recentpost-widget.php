<?php
/*
Plugin Name: WhiteCat RecentPost Widget
Plugin URI: 
Description: 最近の個別投稿を一覧表示する
Author: SynthTAROU
Version: 0.1
Author URI:
*/
?>

<?php
/*  Copyright 2022 Syntaro (email : lpe.syntaro.yoshida@gmail.com)

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
function whitecat_register_recentpost_widget() {
	register_widget( 'whitecat_recentpost_widget' );
}

add_action( 'widgets_init', 'whitecat_register_recentpost_widget' );

// // テスト実装マイウィジェット 
class whitecat_recentpost_widget extends WP_Widget {
	/**
	 * ウィジェット名などを設定
	 */
	function __construct() {
		$widget_ops = array(
			'classname' => 'WhiteCatRecentPost_class',
			'description' => '最近の投稿を表示'
		);
		parent::__construct( 'WhiteCatRecentPost', 'WhiteCat RecentPost', $widget_ops );
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
		
		$title = $instance['title'];
		$category = $instance['category'];
		$count = $instance['count'];

		if (strlen($category) == 0) {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $count,
			);	
		}else {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $count,
				'category_name' => $category,
			);
		}
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
		?>
		<div id="whitecat_recentpost">
			<h3><?php echo $instance['title'] ?></h3>
			<ul class="wp-block-latest-posts__list has-dates wp-block-latest-posts">
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<li>
					<div class="wp-block-latest-posts__featured-image alignleft">
						<a href="<?php the_permalink() ?>">
						<?php if ( has_post_thumbnail()) :
							the_post_thumbnail( 'thumbnail', array( 'class' => 'attachment-thumbnail size-thumbnail wp-post-image' ) );
						endif; ?>
						</a>
					</div>
						<a href="<?php the_permalink() ?>" class="wp-block-latest-posts__post-title">
							<?php the_title(); ?>
						</a>
						<time class="wp-block-latest-posts__post-date">
							<?php the_modified_date(); ?>
						</time>
						<div class="wp-block-latest-posts__post-excerpt">
							<?php $content = get_the_content();
								print $content;
							?>
						</div>
					<div class="vk_post_btnOuter text-right" style="margin-right: 40px;">
						<a class="btn btn-sm btn-primary vk_post_btn" href="<?php the_permalink() ?>">続きを読む</a>
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
			</div>
		<?php
		endif;

		echo $after_widget;
		
?>

<?php

	}

	function form( $instance ) {
		$defaults = array(
			'title' => 'タイトルを入力',
			'category' => 'カテゴリを選択',
			'count' => '件数'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$category = $instance['category'];
		$count = $instance['count'];
	?>
	<p>タイトル:
		<input class="widefat"
			   name="<?php echo $this->get_field_name( 'title' ); ?>"
			   type="text"
			   value="<?php echo esc_attr( $title ); ?>"
			   />
	</p>
	<p>カテゴリ:
		<input class="widefat"
			   name="<?php echo $this->get_field_name( 'category' ); ?>"
			   type="text"
			   value="<?php echo esc_attr( $category ); ?>"
			   />
	</p>
    <p>表示件数：
		<select name="<?php echo $this->get_field_name( 'count' ); ?>">
	<?php
		for ($i = 1; $i <= 20; ++ $i) {
            echo "<option value='$i'";
			if ($count == $i) {
				echo ' selected';
			}
			echo ">$i</option>";
		}
	?>
        </select>
    </p>
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
		$instance['category'] = sanitize_text_field( $new_instance['category'] );
		$instance['count'] = sanitize_text_field( $new_instance['count'] );
		return $instance;
	}
}


?>