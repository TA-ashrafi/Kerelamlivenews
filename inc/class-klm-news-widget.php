<?php
/**
 * KLM_News_Widget — the one widget that powers every homepage block.
 *
 * Drop it into any of the "Homepage: ..." widget areas or into the
 * Right Sidebar. Pick a layout, a category (or, for the "Tabs" layout,
 * up to five categories), how many posts to pull, and whether to show
 * the author name and/or date on each post. That is the entire
 * category-assignment workflow Tahseen asked for — no template edits
 * needed to point a section at a different category later.
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
				'description' => __( 'Pulls posts from a category you choose. Used for every homepage section and the sidebar — set the layout, category, post count, and author/date visibility.', 'keralamlivenews' ),
			)
		);
	}

	private function layouts() {
		return array(
			'lead'     => __( 'Lead (1 big + 2 small) — e.g. "The Lead"', 'keralamlivenews' ),
			'list'     => __( 'Simple list — e.g. "In The News"', 'keralamlivenews' ),
			'magazine' => __( 'Magazine (1 big + side + row) — e.g. "Mangalam Specials", "Entertainment", "Health"', 'keralamlivenews' ),
			'tabs'     => __( 'Tabbed categories — e.g. "Today\'s Mangalam"', 'keralamlivenews' ),
			'fourcol'  => __( 'Four equal columns — e.g. "Inside Mangalam"', 'keralamlivenews' ),
			'video'    => __( 'Video strip — e.g. "News in Reels"', 'keralamlivenews' ),
			'gallery'  => __( 'Photo gallery strip', 'keralamlivenews' ),
		);
	}

	/* ---------------------------------------------------------------- */
	/* ADMIN FORM                                                        */
	/* ---------------------------------------------------------------- */
	public function form( $instance ) {
		$title        = isset( $instance['title'] ) ? $instance['title'] : '';
		$layout       = isset( $instance['layout'] ) ? $instance['layout'] : 'list';
		$category     = isset( $instance['category'] ) ? (int) $instance['category'] : 0;
		$tab_cats     = isset( $instance['tab_cats'] ) ? (array) $instance['tab_cats'] : array();
		$count        = isset( $instance['count'] ) ? (int) $instance['count'] : 5;
		$show_author  = ! empty( $instance['show_author'] );
		$show_date    = ! empty( $instance['show_date'] );
		$show_excerpt = ! empty( $instance['show_excerpt'] );
		$view_all     = isset( $instance['view_all'] ) ? (bool) $instance['view_all'] : true;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title (shown above the block):', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'keralamlivenews' ); ?></label>
			<select class="widefat klm-layout-select" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
				<?php foreach ( $this->layouts() as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $layout, $key ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p class="klm-single-cat-field" <?php echo 'tabs' === $layout ? 'style="display:none"' : ''; ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category to pull posts from:', 'keralamlivenews' ); ?></label>
			<?php klm_category_dropdown( $this->get_field_name( 'category' ), $category, $this->get_field_id( 'category' ) ); ?>
		</p>

		<p class="klm-tabs-cat-field" <?php echo 'tabs' !== $layout ? 'style="display:none"' : ''; ?>>
			<label><?php esc_html_e( 'Categories to show as tabs (pick 2–5, in order):', 'keralamlivenews' ); ?></label>
			<select class="widefat" multiple size="6" name="<?php echo esc_attr( $this->get_field_name( 'tab_cats' ) ); ?>[]">
				<?php foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) : ?>
					<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php echo in_array( (string) $cat->term_id, array_map( 'strval', $tab_cats ), true ) ? 'selected' : ''; ?>><?php echo esc_html( $cat->name ); ?></option>
				<?php endforeach; ?>
			</select>
			<small><?php esc_html_e( 'Hold Ctrl / Cmd to select multiple.', 'keralamlivenews' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts (per tab, for the Tabs layout):', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>">
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_author' ) ); ?>" <?php checked( $show_author ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>"><?php esc_html_e( 'Show author name', 'keralamlivenews' ); ?></label>
			<br>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" <?php checked( $show_date ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show post date', 'keralamlivenews' ); ?></label>
			<br>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_excerpt' ) ); ?>" <?php checked( $show_excerpt ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>"><?php esc_html_e( 'Show short excerpt (Lead / Magazine layouts)', 'keralamlivenews' ); ?></label>
			<br>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'view_all' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all' ) ); ?>" <?php checked( $view_all ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'view_all' ) ); ?>"><?php esc_html_e( 'Show "View All »" link to the category', 'keralamlivenews' ); ?></label>
		</p>
		<script>
		(function(){
			var sel = document.getElementById(<?php echo wp_json_encode( $this->get_field_id( 'layout' ) ); ?>);
			if(!sel) return;
			sel.addEventListener('change', function(){
				var widget = sel.closest('.widget-content');
				if(!widget) return;
				var isTabs = sel.value === 'tabs';
				widget.querySelectorAll('.klm-single-cat-field').forEach(function(el){ el.style.display = isTabs ? 'none' : ''; });
				widget.querySelectorAll('.klm-tabs-cat-field').forEach(function(el){ el.style.display = isTabs ? '' : 'none'; });
			});
		})();
		</script>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                 = array();
		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['layout']       = sanitize_key( $new_instance['layout'] );
		$instance['category']     = isset( $new_instance['category'] ) ? (int) $new_instance['category'] : 0;
		$instance['tab_cats']     = isset( $new_instance['tab_cats'] ) ? array_map( 'intval', (array) $new_instance['tab_cats'] ) : array();
		$instance['count']        = isset( $new_instance['count'] ) ? max( 1, (int) $new_instance['count'] ) : 5;
		$instance['show_author']  = ! empty( $new_instance['show_author'] );
		$instance['show_date']    = ! empty( $new_instance['show_date'] );
		$instance['show_excerpt'] = ! empty( $new_instance['show_excerpt'] );
		$instance['view_all']     = ! empty( $new_instance['view_all'] );
		return $instance;
	}

	/* ---------------------------------------------------------------- */
	/* FRONT END                                                         */
	/* ---------------------------------------------------------------- */
	public function widget( $args, $instance ) {
		$layout       = isset( $instance['layout'] ) ? $instance['layout'] : 'list';
		$category     = isset( $instance['category'] ) ? (int) $instance['category'] : 0;
		$tab_cats     = isset( $instance['tab_cats'] ) ? array_filter( array_map( 'intval', (array) $instance['tab_cats'] ) ) : array();
		$count        = isset( $instance['count'] ) ? max( 1, (int) $instance['count'] ) : 5;
		$show_author  = ! empty( $instance['show_author'] );
		$show_date    = ! empty( $instance['show_date'] );
		$show_excerpt = ! empty( $instance['show_excerpt'] );
		$view_all     = ! empty( $instance['view_all'] );

		if ( 'tabs' !== $layout && ! $category ) {
			return; // Nothing assigned yet — print nothing rather than an empty box.
		}
		if ( 'tabs' === $layout && empty( $tab_cats ) ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore

		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
			if ( $view_all && $category && 'tabs' !== $layout ) {
				$title .= ' <a class="klm-block__viewall" href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html__( 'View All »', 'keralamlivenews' ) . '</a>';
			}
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore
		}

		switch ( $layout ) {
			case 'lead':
				$this->render_lead( $category, $count, $show_author, $show_date, $show_excerpt );
				break;
			case 'magazine':
				$this->render_magazine( $category, $count, $show_author, $show_date, $show_excerpt );
				break;
			case 'tabs':
				$this->render_tabs( $tab_cats, $count, $show_author, $show_date );
				break;
			case 'fourcol':
				$this->render_fourcol( $category, $count, $show_author, $show_date );
				break;
			case 'video':
				$this->render_video( $category, $count );
				break;
			case 'gallery':
				$this->render_gallery( $category, $count );
				break;
			case 'list':
			default:
				$this->render_list( $category, $count, $show_author, $show_date );
				break;
		}

		echo $args['after_widget']; // phpcs:ignore
	}

	private function query( $category, $count ) {
		return new WP_Query(
			array(
				'cat'                 => $category,
				'posts_per_page'      => $count,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
	}

	private function render_lead( $category, $count, $show_author, $show_date, $show_excerpt ) {
		$q = $this->query( $category, max( 3, $count ) );
		if ( ! $q->have_posts() ) {
			return;
		}
		$i = 0;
		echo '<div class="klm-lead">';
		while ( $q->have_posts() ) {
			$q->the_post();
			if ( 0 === $i ) {
				echo '<article class="klm-lead__main">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-lead', 'klm-lead__img' );
				echo '<h3>' . esc_html( get_the_title() ) . '</h3>';
				echo '</a>';
				if ( $show_excerpt ) {
					echo '<p class="klm-lead__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 24 ) ) . '</p>';
				}
				klm_post_meta( $show_author, $show_date );
				echo '</article>';
				echo '<div class="klm-lead__side">';
			} else {
				echo '<article class="klm-lead__side-item">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				klm_thumbnail( get_the_ID(), 'klm-small', 'klm-lead__side-img' );
				echo '<span>' . esc_html( get_the_title() ) . '</span>';
				echo '</a>';
				echo '</article>';
			}
			$i++;
		}
		echo '</div></div>';
		wp_reset_postdata();
	}

	private function render_list( $category, $count, $show_author, $show_date ) {
		$q = $this->query( $category, $count );
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

	private function render_magazine( $category, $count, $show_author, $show_date, $show_excerpt ) {
		$q = $this->query( $category, max( 3, $count ) );
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

	private function render_tabs( $tab_cats, $count, $show_author, $show_date ) {
		$uid = 'klmtabs-' . wp_rand( 1000, 9999 );
		echo '<div class="klm-tabs" id="' . esc_attr( $uid ) . '">';
		echo '<div class="klm-tabs__nav" role="tablist">';
		foreach ( $tab_cats as $index => $cat_id ) {
			$term = get_term( $cat_id );
			if ( ! $term || is_wp_error( $term ) ) {
				continue;
			}
			echo '<button type="button" class="klm-tabs__btn' . ( 0 === $index ? ' is-active' : '' ) . '" data-tab="' . esc_attr( $uid . '-' . $cat_id ) . '">' . esc_html( $term->name ) . '</button>';
		}
		echo '</div>';

		foreach ( $tab_cats as $index => $cat_id ) {
			$term = get_term( $cat_id );
			if ( ! $term || is_wp_error( $term ) ) {
				continue;
			}
			$q = $this->query( $cat_id, max( 3, $count ) );
			echo '<div class="klm-tabs__panel' . ( 0 === $index ? ' is-active' : '' ) . '" id="' . esc_attr( $uid . '-' . $cat_id ) . '">';
			if ( $q->have_posts() ) {
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
						echo '<p class="klm-magazine__excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 22 ) ) . '</p>';
						klm_post_meta( $show_author, $show_date );
						echo '</article><ul class="klm-list klm-magazine__list">';
					} else {
						echo '<li class="klm-list__item"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
					}
					$i++;
				}
				if ( $i > 1 ) {
					echo '</ul>';
				}
				echo '</div>';
			}
			echo '</div>';
			wp_reset_postdata();
		}
		echo '</div>';
	}

	private function render_fourcol( $category, $count, $show_author, $show_date ) {
		$q = $this->query( $category, max( 4, $count ) );
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

	private function render_video( $category, $count ) {
		$q = $this->query( $category, $count );
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
			echo '<a href="' . esc_url( $video_url ? $video_url : get_permalink() ) . '"' . ( $video_url ? '' : '' ) . '>';
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

	private function render_gallery( $category, $count ) {
		$q = $this->query( $category, $count );
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
