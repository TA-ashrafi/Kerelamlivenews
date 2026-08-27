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
 * single posts and inside widget blocks, respecting the show/hide
 * toggles that come from the Customizer (single posts) or from the
 * individual widget's own checkboxes (homepage/sidebar blocks).
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

/** Thumbnail with a graceful "No Image" placeholder, like the reference site. */
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

/** Whether the sidebar has any widgets — used to decide layout width and whether to print it at all. */
function klm_has_sidebar() {
	return is_active_sidebar( 'sidebar-primary' );
}
