<?php
/**
 * Small reusable template helpers.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print the "Authored by X | date | N min read" meta line used on
 * single posts and inside widget blocks.
 */
function klm_post_meta( $show_author = true, $show_date = true, $show_readtime = false ) {
	$bits = array();

	if ( $show_author ) {
		$bits[] = sprintf(
			/* translators: %s: author name */
			esc_html__( 'Authored by %s', 'keralamlivenews' ),
			'<span class="klm-meta__author">' . esc_html( get_the_author() ) . '</span>'
		);
	}

	if ( $show_date ) {
		$bits[] = '<span class="klm-meta__date">' . esc_html( get_the_date( 'j M Y, g:i A' ) ) . '</span>';
	}

	if ( $show_readtime ) {
		$bits[] = '<span class="klm-meta__readtime">' . esc_html( klm_reading_time() ) . '</span>';
	}

	if ( empty( $bits ) ) {
		return;
	}

	echo '<div class="klm-meta">' . implode( ' <span class="klm-meta__sep">|</span> ', $bits ) . '</div>'; // phpcs:ignore
}

/** Rough "N min read" based on word count. */
function klm_reading_time() {
	$content = get_post_field( 'post_content', get_the_ID() );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	$minutes = max( 1, (int) ceil( $words / 200 ) );
	return sprintf(
		/* translators: %d: number of minutes */
		_n( '%d min read', '%d min read', $minutes, 'keralamlivenews' ),
		$minutes
	);
}

/** Breadcrumb: Home > Section > Current. */
function klm_breadcrumb() {
	echo '<nav class="klm-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'keralamlivenews' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'keralamlivenews' ) . '</a>';

	if ( is_category() || is_tag() || is_tax() ) {
		echo ' <span class="klm-breadcrumb__sep">&rsaquo;</span> ';
		echo '<span>' . esc_html__( 'Print Edition', 'keralamlivenews' ) . '</span>';
		echo ' <span class="klm-breadcrumb__sep">&rsaquo;</span> ';
		echo '<span class="klm-breadcrumb__current">' . esc_html( single_term_title( '', false ) ) . '</span>';
	} elseif ( is_singular() ) {
		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			echo ' <span class="klm-breadcrumb__sep">&rsaquo;</span> ';
			echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
		}
		echo ' <span class="klm-breadcrumb__sep">&rsaquo;</span> ';
		echo '<span class="klm-breadcrumb__current">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_search() ) {
		echo ' <span class="klm-breadcrumb__sep">&rsaquo;</span> <span>' . esc_html__( 'Search results', 'keralamlivenews' ) . '</span>';
	}

	echo '</nav>';
}

/** Thumbnail with a graceful "No Image" placeholder. */
function klm_thumbnail( $post_id, $size = 'medium', $class = '' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, $size, array( 'class' => esc_attr( $class ), 'loading' => 'lazy' ) );
	} else {
		echo '<span class="klm-noimg ' . esc_attr( $class ) . '"><span>' . esc_html__( 'No Image', 'keralamlivenews' ) . '</span></span>';
	}
}

/** Output a <select> of all categories - shared by the widgets' admin forms. */
function klm_category_dropdown( $name, $selected = '', $id = '' ) {
	$id = $id ? $id : $name;
	echo '<select class="widefat" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '">';
	echo '<option value="0">' . esc_html__( '— Select a category —', 'keralamlivenews' ) . '</option>';
	$cats = get_categories( array( 'hide_empty' => false ) );
	foreach ( $cats as $cat ) {
		printf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $cat->term_id ),
			selected( $selected, $cat->term_id, false ),
			esc_html( $cat->name )
		);
	}
	echo '</select>';
}

/** Whether the sidebar has any widgets — used to decide layout width. */
function klm_has_sidebar() {
	return is_active_sidebar( 'sidebar-primary' );
}

/** AJAX Infinite Scroll Handler for category and archive pages. */
function klm_ajax_load_more() {
	check_ajax_referer( 'klm_nonce', 'nonce' );

	$page      = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
	$cat_id    = isset( $_POST['cat_id'] ) ? absint( $_POST['cat_id'] ) : 0;
	$show_auth = ! empty( $_POST['show_author'] );
	$show_date = ! empty( $_POST['show_date'] );

	$args = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'paged'          => $page,
		'posts_per_page' => get_option( 'posts_per_page', 12 ),
	);

	if ( $cat_id ) {
		$args['cat'] = $cat_id;
	}

	$q = new WP_Query( $args );

	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			?>
			<article class="klm-archive__card">
				<a href="<?php the_permalink(); ?>" class="klm-archive__card-link">
					<?php klm_thumbnail( get_the_ID(), 'klm-square', 'klm-archive__card-img' ); ?>
					<h3 class="klm-archive__card-title"><?php the_title(); ?></h3>
				</a>
				<p class="klm-archive__card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
				<?php klm_post_meta( $show_auth, $show_date ); ?>
			</article>
			<?php
		}
		wp_reset_postdata();
	}
	wp_die();
}
add_action( 'wp_ajax_klm_load_more', 'klm_ajax_load_more' );
add_action( 'wp_ajax_nopriv_klm_load_more', 'klm_ajax_load_more' );

/** Track single post view count for "Most View" option in widgets. */
function klm_track_post_views() {
	if ( is_single() ) {
		global $post;
		if ( isset( $post->ID ) ) {
			$views = (int) get_post_meta( $post->ID, 'klm_post_views_count', true );
			update_post_meta( $post->ID, 'klm_post_views_count', $views + 1 );
		}
	}
}
add_action( 'wp_head', 'klm_track_post_views' );
