<?php
/**
 * KLM_News_Widget — Flexible Category News Block Widget
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class KLM_News_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'klm_news_widget',
			__( 'News Category Block', 'keralamlivenews' ),
			array(
				'description' => __( 'Display posts from any category with custom grid layouts, post filter modes (Latest, Most Viewed, Recent Random), offset controls, and author & date toggles.', 'keralamlivenews' ),
			)
		);
	}

	private function layouts() {
		return array(
			'lead'             => __( 'Hero Lead Grid', 'keralamlivenews' ),
			'custom_grid'      => __( 'Featured News Grid (Asymmetrical Top + 4-Col Bottom)', 'keralamlivenews' ),
			'horizontal_5col'  => __( 'Full-Width 5-Column Grid', 'keralamlivenews' ),
			'list'             => __( 'Standard News List', 'keralamlivenews' ),
			'sidebar_cards'    => __( 'Featured Sidebar Stack', 'keralamlivenews' ),
			'magazine'         => __( 'Magazine Grid', 'keralamlivenews' ),
			'fourcol'          => __( '4-Column News Grid', 'keralamlivenews' ),
			'video'            => __( 'News in Reels (Video Strip)', 'keralamlivenews' ),
			'gallery'          => __( 'Photo Gallery Grid', 'keralamlivenews' ),
		);
	}

	/* ---------------------------------------------------------------- */
	/* ADMIN FORM                                                        */
	/* ---------------------------------------------------------------- */
	public function form( $instance ) {
		$title         = isset( $instance['title'] ) ? $instance['title'] : '';
		$layout        = isset( $instance['layout'] ) ? $instance['layout'] : 'list';
		$order_mode    = isset( $instance['order_mode'] ) ? $instance['order_mode'] : 'latest';
		$category      = isset( $instance['category'] ) ? (int) $instance['category'] : 0;
		$count         = isset( $instance['count'] ) ? (int) $instance['count'] : 5;
		$offset        = isset( $instance['offset'] ) ? (int) $instance['offset'] : 0;
		$border_radius = isset( $instance['border_radius'] ) ? (int) $instance['border_radius'] : 4;
		$show_author   = ! empty( $instance['show_author'] );
		$show_date     = ! empty( $instance['show_date'] );
		$show_excerpt  = ! empty( $instance['show_excerpt'] );
		$view_all      = isset( $instance['view_all'] ) ? (bool) $instance['view_all'] : true;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'keralamlivenews' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
				<?php foreach ( $this->layouts() as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $layout, $key ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order_mode' ) ); ?>"><?php esc_html_e( 'Post Filter Mode:', 'keralamlivenews' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order_mode' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order_mode' ) ); ?>">
				<option value="latest" <?php selected( $order_mode, 'latest' ); ?>><?php esc_html_e( 'Latest News (Default)', 'keralamlivenews' ); ?></option>
				<option value="most_viewed" <?php selected( $order_mode, 'most_viewed' ); ?>><?php esc_html_e( 'Most Viewed News (Ascending Order)', 'keralamlivenews' ); ?></option>
				<option value="recent_random" <?php selected( $order_mode, 'recent_random' ); ?>><?php esc_html_e( 'Recent Random News (All Categories)', 'keralamlivenews' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category (Disabled if Recent Random is selected):', 'keralamlivenews' ); ?></label>
			<?php klm_category_dropdown( $this->get_field_name( 'category' ), $category, $this->get_field_id( 'category' ) ); ?>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset (Skip N posts):', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" min="0" max="50" value="<?php echo esc_attr( $offset ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'border_radius' ) ); ?>"><?php esc_html_e( 'Thumbnail Border Radius (px):', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'border_radius' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border_radius' ) ); ?>" type="number" min="0" max="30" value="<?php echo esc_attr( $border_radius ); ?>">
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_author' ) ); ?>" <?php checked( $show_author ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>"><?php esc_html_e( 'Show author name', 'keralamlivenews' ); ?></label>
			<br>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" <?php checked( $show_date ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show post date', 'keralamlivenews' ); ?></label>
			<br>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_excerpt' ) ); ?>" <?php checked( $show_excerpt ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>"><?php esc_html_e( 'Show short excerpt', 'keralamlivenews' ); ?></label>
			<br>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'view_all' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all' ) ); ?>" <?php checked( $view_all ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'view_all' ) ); ?>"><?php esc_html_e( 'Show "View All »" link', 'keralamlivenews' ); ?></label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['layout']        = sanitize_key( $new_instance['layout'] );
		$instance['order_mode']    = sanitize_key( $new_instance['order_mode'] );
		$instance['category']      = isset( $new_instance['category'] ) ? (int) $new_instance['category'] : 0;
		$instance['count']         = isset( $new_instance['count'] ) ? max( 1, (int) $new_instance['count'] ) : 5;
		$instance['offset']        = isset( $new_instance['offset'] ) ? max( 0, (int) $new_instance['offset'] ) : 0;
		$instance['border_radius'] = isset( $new_instance['border_radius'] ) ? max( 0, (int) $new_instance['border_radius'] ) : 4;
		$instance['show_author']   = ! empty( $new_instance['show_author'] );
		$instance['show_date']     = ! empty( $new_instance['show_date'] );
		$instance['show_excerpt']  = ! empty( $new_instance['show_excerpt'] );
		$instance['view_all']      = ! empty( $new_instance['view_all'] );
		return $instance;
	}

	/* ---------------------------------------------------------------- */
	/* FRONT END                                                         */
	/* ---------------------------------------------------------------- */
	public function widget( $args, $instance ) {
		$layout        = isset( $instance['layout'] ) ? $instance['layout'] : 'list';
		$order_mode    = isset( $instance['order_mode'] ) ? $instance['order_mode'] : 'latest';
		$category      = isset( $instance['category'] ) ? (int) $instance['category'] : 0;
		$count         = isset( $instance['count'] ) ? max( 1, (int) $instance['count'] ) : 5;
		$offset        = isset( $instance['offset'] ) ? max( 0, (int) $instance['offset'] ) : 0;
		$border_radius = isset( $instance['border_radius'] ) ? (int) $instance['border_radius'] : 4;
		$show_author   = ! empty( $instance['show_author'] );
		$show_date     = ! empty( $instance['show_date'] );
		$show_excerpt  = ! empty( $instance['show_excerpt'] );
		$view_all      = ! empty( $instance['view_all'] );

		if ( 'recent_random' !== $order_mode && ! $category ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore

		echo '<div class="klm-widget-content" style="--klm-widget-radius: ' . esc_attr( $border_radius ) . 'px;">';

		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
			if ( $view_all && $category && 'recent_random' !== $order_mode ) {
				$title .= ' <a class="klm-block__viewall" href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html__( 'View All »', 'keralamlivenews' ) . '</a>';
			}
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore
		}

		switch ( $layout ) {
			case 'lead':
				$this->render_lead( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt );
				break;
			case 'custom_grid':
				$this->render_custom_grid( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt );
				break;
			case 'horizontal_5col':
				$this->render_horizontal_5col( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt );
				break;
			case 'sidebar_cards':
				$this->render_sidebar_cards( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt );
				break;
			case 'magazine':
				$this->render_magazine( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt );
				break;
			case 'fourcol':
				$this->render_fourcol( $category, $count, $offset, $order_mode, $show_author, $show_date );
				break;
			case 'video':
				$this->render_video( $category, $count, $offset, $order_mode );
				break;
			case 'gallery':
				$this->render_gallery( $category, $count, $offset, $order_mode );
				break;
			case 'list':
			default:
				$this->render_list( $category, $count, $offset, $order_mode, $show_author, $show_date );
				break;
		}

		echo '</div>'; // close klm-widget-content

		echo $args['after_widget']; // phpcs:ignore
	}

	private function query( $category, $count, $offset = 0, $order_mode = 'latest' ) {
		$args = array(
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);

		if ( 'recent_random' === $order_mode ) {
			$args['orderby'] = 'rand';
			if ( $offset > 0 ) {
				$args['offset'] = $offset;
			}
		} elseif ( 'most_viewed' === $order_mode ) {
			if ( $category ) {
				$args['cat'] = $category;
			}
			if ( $offset > 0 ) {
				$args['offset'] = $offset;
			}
			$args['meta_key'] = 'klm_post_views';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'ASC';
		} else {
			if ( $category ) {
				$args['cat'] = $category;
			}
			if ( $offset > 0 ) {
				$args['offset'] = $offset;
			}
		}

		return new WP_Query( $args );
	}

	private function render_custom_grid( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt ) {
		$q = $this->query( $category, max( 6, $count ), $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		$posts = $q->posts;
		$total = count( $posts );

		echo '<div class="klm-custom-grid">';
		echo '<div class="klm-custom-grid__top">';

		if ( isset( $posts[0] ) ) {
			$post = $posts[0];
			setup_postdata( $post );
			echo '<article class="klm-custom-grid__col1">';
			$cats = get_the_category( $post->ID );
			if ( ! empty( $cats ) ) {
				echo '<span class="klm-badge">' . esc_html( $cats[0]->name ) . '</span>';
			}
			echo '<h3 class="klm-custom-grid__col1-title"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . esc_html( get_the_title( $post->ID ) ) . '</a></h3>';
			if ( $show_excerpt ) {
				echo '<p class="klm-custom-grid__excerpt">' . esc_html( wp_trim_words( get_the_excerpt( $post->ID ), 24 ) ) . '</p>';
			}
			klm_post_meta( $show_author, $show_date );
			echo '</article>';
		}

		if ( isset( $posts[1] ) ) {
			$post = $posts[1];
			setup_postdata( $post );
			echo '<article class="klm-custom-grid__col2">';
			echo '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
			klm_thumbnail( $post->ID, 'klm-lead', 'klm-custom-grid__big-img' );
			echo '<h2 class="klm-custom-grid__big-title">' . esc_html( get_the_title( $post->ID ) ) . '</h2>';
			echo '</a>';
			klm_post_meta( $show_author, $show_date );
			echo '</article>';
		}

		if ( isset( $posts[2] ) ) {
			$post = $posts[2];
			setup_postdata( $post );
			echo '<article class="klm-custom-grid__col3">';
			echo '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
			klm_thumbnail( $post->ID, 'klm-square', 'klm-custom-grid__col3-img' );
			echo '</a>';
			$cats = get_the_category( $post->ID );
			if ( ! empty( $cats ) ) {
				echo '<span class="klm-badge">' . esc_html( $cats[0]->name ) . '</span>';
			}
			echo '<h4 class="klm-custom-grid__col3-title"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . esc_html( get_the_title( $post->ID ) ) . '</a></h4>';
			if ( $show_excerpt ) {
				echo '<p class="klm-custom-grid__excerpt">' . esc_html( wp_trim_words( get_the_excerpt( $post->ID ), 20 ) ) . '</p>';
			}
			klm_post_meta( $show_author, $show_date );
			echo '</article>';
		}

		echo '</div>'; // close top

		if ( $total > 3 ) {
			echo '<div class="klm-custom-grid__bottom">';
			for ( $i = 3; $i < $total; $i++ ) {
				$post = $posts[$i];
				setup_postdata( $post );
				echo '<article class="klm-custom-grid__card">';
				echo '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
				klm_thumbnail( $post->ID, 'klm-square', 'klm-custom-grid__card-img' );
				echo '</a>';
				$cats = get_the_category( $post->ID );
				if ( ! empty( $cats ) ) {
					echo '<span class="klm-badge">' . esc_html( $cats[0]->name ) . '</span>';
				}
				echo '<h4 class="klm-custom-grid__card-title"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . esc_html( get_the_title( $post->ID ) ) . '</a></h4>';
				if ( $show_excerpt ) {
					echo '<p class="klm-custom-grid__excerpt">' . esc_html( wp_trim_words( get_the_excerpt( $post->ID ), 14 ) ) . '</p>';
				}
				if ( $show_author || $show_date ) {
					klm_post_meta( $show_author, $show_date );
				}
				echo '</article>';
			}
			echo '</div>';
		}

		echo '</div>';
		wp_reset_postdata();
	}

	private function render_horizontal_5col( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt ) {
		$q = $this->query( $category, max( 5, $count ), $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		echo '<div class="klm-5col-row">';
		while ( $q->have_posts() ) {
			$q->the_post();
			echo '<article class="klm-5col-row__item">';
			echo '<a href="' . esc_url( get_permalink() ) . '">';
			klm_thumbnail( get_the_ID(), 'klm-square', 'klm-5col-row__img' );
			echo '<h4 class="klm-5col-row__title">' . esc_html( get_the_title() ) . '</h4>';
			echo '</a>';
			if ( $show_excerpt ) {
				echo '<p class="klm-5col-row__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 12 ) ) . '</p>';
			}
			if ( $show_author || $show_date ) {
				klm_post_meta( $show_author, $show_date );
			}
			echo '</article>';
		}
		echo '</div>';
		wp_reset_postdata();
	}

	private function render_sidebar_cards( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt ) {
		$q = $this->query( $category, max( 3, $count ), $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		$total = $q->post_count;
		$i = 0;
		echo '<div class="klm-sidebar-cards">';
		while ( $q->have_posts() ) {
			$q->the_post();
			if ( 0 === $i ) {
				echo '<article class="klm-sidebar-cards__top">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-lead', 'klm-sidebar-cards__big-img' );
				echo '<h3 class="klm-sidebar-cards__title">' . esc_html( get_the_title() ) . '</h3>';
				echo '</a>';
				if ( $show_excerpt ) {
					echo '<p class="klm-sidebar-cards__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 18 ) ) . '</p>';
				}
				klm_post_meta( $show_author, $show_date );
				echo '</article>';
				if ( $total > 1 ) {
					echo '<ul class="klm-list klm-sidebar-cards__list">';
				}
			} elseif ( $i < $total - 1 ) {
				echo '<li class="klm-list__item">';
				echo '<a href="' . esc_url( get_permalink() ) . '" class="klm-list__link">';
				echo '<span class="klm-list__title">' . esc_html( get_the_title() ) . '</span>';
				klm_thumbnail( get_the_ID(), 'klm-small', 'klm-list__img' );
				echo '</a>';
				if ( $show_author || $show_date ) {
					klm_post_meta( $show_author, $show_date );
				}
				echo '</li>';
			} else {
				if ( $total > 1 ) {
					echo '</ul>';
				}
				echo '<article class="klm-sidebar-cards__bottom">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-lead', 'klm-sidebar-cards__big-img' );
				echo '<h3 class="klm-sidebar-cards__title">' . esc_html( get_the_title() ) . '</h3>';
				echo '</a>';
				if ( $show_excerpt ) {
					echo '<p class="klm-sidebar-cards__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 18 ) ) . '</p>';
				}
				klm_post_meta( $show_author, $show_date );
				echo '</article>';
			}
			$i++;
		}
		echo '</div>';
		wp_reset_postdata();
	}

	private function render_lead( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt ) {
		$q = $this->query( $category, max( 5, $count ), $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		$i = 0;
		echo '<div class="klm-lead">';
		while ( $q->have_posts() ) {
			$q->the_post();
			if ( 0 === $i ) {
				echo '<article class="klm-lead__top">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-lead', 'klm-lead__top-img' );
				echo '<h2 class="klm-lead__top-title">' . esc_html( get_the_title() ) . '</h2>';
				echo '</a>';
				if ( $show_excerpt ) {
					echo '<p class="klm-lead__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 28 ) ) . '</p>';
				}
				klm_post_meta( $show_author, $show_date );
				echo '</article>';
				echo '<div class="klm-lead__row">';
			} elseif ( $i >= 1 && $i <= 4 ) {
				echo '<article class="klm-lead__card">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-square', 'klm-lead__card-img' );
				echo '<h4 class="klm-lead__card-title">' . esc_html( get_the_title() ) . '</h4>';
				echo '</a>';
				if ( $show_author || $show_date ) {
					klm_post_meta( $show_author, $show_date );
				}
				echo '</article>';
			} else {
				if ( 5 === $i ) {
					echo '</div>';
				}
				echo '<article class="klm-lead__extra">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-lead', 'klm-lead__extra-img' );
				echo '<h3 class="klm-lead__extra-title">' . esc_html( get_the_title() ) . '</h3>';
				echo '</a>';
				if ( $show_excerpt ) {
					echo '<p class="klm-lead__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 24 ) ) . '</p>';
				}
				klm_post_meta( $show_author, $show_date );
				echo '</article>';
			}
			$i++;
		}
		if ( $i >= 1 && $i <= 4 ) {
			echo '</div>';
		}
		echo '</div>';
		wp_reset_postdata();
	}

	private function render_list( $category, $count, $offset, $order_mode, $show_author, $show_date ) {
		$q = $this->query( $category, $count, $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		echo '<ul class="klm-list">';
		while ( $q->have_posts() ) {
			$q->the_post();
			echo '<li class="klm-list__item">';
			echo '<a href="' . esc_url( get_permalink() ) . '" class="klm-list__link">';
			echo '<span class="klm-list__title">' . esc_html( get_the_title() ) . '</span>';
			klm_thumbnail( get_the_ID(), 'klm-small', 'klm-list__img' );
			echo '</a>';
			if ( $show_author || $show_date ) {
				klm_post_meta( $show_author, $show_date );
			}
			echo '</li>';
		}
		echo '</ul>';
		wp_reset_postdata();
	}

	private function render_magazine( $category, $count, $offset, $order_mode, $show_author, $show_date, $show_excerpt ) {
		$q = $this->query( $category, max( 3, $count ), $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		$i = 0;
		echo '<div class="klm-magazine">';
		while ( $q->have_posts() ) {
			$q->the_post();
			if ( 0 === $i ) {
				echo '<article class="klm-magazine__main">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-lead', 'klm-magazine__img' );
				echo '<h3>' . esc_html( get_the_title() ) . '</h3>';
				echo '</a>';
				if ( $show_excerpt ) {
					echo '<p class="klm-magazine__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 28 ) ) . '</p>';
				}
				klm_post_meta( $show_author, $show_date );
				echo '</article>';
			} elseif ( 1 === $i ) {
				echo '<article class="klm-magazine__side">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-square', 'klm-magazine__side-img' );
				echo '<span>' . esc_html( get_the_title() ) . '</span>';
				echo '</a>';
				echo '</article>';
				echo '<div class="klm-magazine__row">';
			} else {
				echo '<article class="klm-magazine__row-item">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-square', 'klm-magazine__row-img' );
				echo '<span>' . esc_html( get_the_title() ) . '</span>';
				echo '</a>';
				echo '</article>';
			}
			$i++;
		}
		if ( $i > 1 ) {
			echo '</div>';
		}
		echo '</div>';
		wp_reset_postdata();
	}

	private function render_fourcol( $category, $count, $offset, $order_mode, $show_author, $show_date ) {
		$q = $this->query( $category, max( 4, $count ), $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		echo '<div class="klm-fourcol">';
		while ( $q->have_posts() ) {
			$q->the_post();
			echo '<article class="klm-fourcol__item">';
			echo '<a href="' . esc_url( get_permalink() ) . '">';
			klm_thumbnail( get_the_ID(), 'klm-square', 'klm-fourcol__img' );
			$cats = get_the_category();
			if ( ! empty( $cats ) ) {
				echo '<span class="klm-fourcol__cat">' . esc_html( $cats[0]->name ) . '</span>';
			}
			echo '<h4>' . esc_html( get_the_title() ) . '</h4>';
			echo '</a>';
			if ( $show_author || $show_date ) {
				klm_post_meta( $show_author, $show_date );
			}
			echo '</article>';
		}
		echo '</div>';
		wp_reset_postdata();
	}

	private function render_video( $category, $count, $offset, $order_mode ) {
		$q = $this->query( $category, $count, $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		echo '<div class="klm-strip klm-strip--video">';
		echo '<button type="button" class="klm-strip__arrow klm-strip__arrow--prev" aria-label="' . esc_attr__( 'Previous', 'keralamlivenews' ) . '">&#10094;</button>';
		echo '<div class="klm-strip__track">';
		while ( $q->have_posts() ) {
			$q->the_post();
			$video_url = get_post_meta( get_the_ID(), 'klm_video_url', true );
			echo '<article class="klm-strip__item">';
			echo '<a href="' . esc_url( $video_url ? $video_url : get_permalink() ) . '">';
			klm_thumbnail( get_the_ID(), 'klm-square', 'klm-strip__img' );
			echo '<span class="klm-strip__play" aria-hidden="true">&#9658;</span>';
			echo '<span class="klm-strip__caption">' . esc_html( get_the_title() ) . '</span>';
			echo '</a>';
			echo '</article>';
		}
		echo '</div>';
		echo '<button type="button" class="klm-strip__arrow klm-strip__arrow--next" aria-label="' . esc_attr__( 'Next', 'keralamlivenews' ) . '">&#10095;</button>';
		echo '</div>';
		wp_reset_postdata();
	}

	private function render_gallery( $category, $count, $offset, $order_mode ) {
		$q = $this->query( $category, $count, $offset, $order_mode );
		if ( ! $q->have_posts() ) {
			return;
		}
		echo '<div class="klm-strip klm-strip--gallery">';
		echo '<button type="button" class="klm-strip__arrow klm-strip__arrow--prev" aria-label="' . esc_attr__( 'Previous', 'keralamlivenews' ) . '">&#10094;</button>';
		echo '<div class="klm-strip__track">';
		while ( $q->have_posts() ) {
			$q->the_post();
			echo '<article class="klm-strip__item">';
			echo '<a href="' . esc_url( get_permalink() ) . '">';
			echo '<span class="klm-strip__tag">' . esc_html__( 'NEWS', 'keralamlivenews' ) . '</span>';
			klm_thumbnail( get_the_ID(), 'klm-square', 'klm-strip__img' );
			echo '<span class="klm-strip__gicon" aria-hidden="true">&#9635;</span>';
			echo '<span class="klm-strip__caption">' . esc_html( get_the_title() ) . '</span>';
			echo '</a>';
			echo '</article>';
		}
		echo '</div>';
		echo '<button type="button" class="klm-strip__arrow klm-strip__arrow--next" aria-label="' . esc_attr__( 'Next', 'keralamlivenews' ) . '">&#10095;</button>';
		echo '</div>';
		wp_reset_postdata();
	}
}
