<?php
/**
 * KeralamLiveNews functions and definitions
 *
 * @package KeralamLiveNews
 * @author  Tahseen Ashrafi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KLM_VERSION', '1.0.0' );
define( 'KLM_DIR', get_template_directory() );
define( 'KLM_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function klm_setup() {
	load_theme_textdomain( 'keralamlivenews', KLM_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	set_post_thumbnail_size( 640, 400, true );
	add_image_size( 'klm-lead', 760, 480, true );
	add_image_size( 'klm-small', 160, 120, true );
	add_image_size( 'klm-square', 300, 300, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'keralamlivenews' ),
			'footer'  => __( 'Footer Menu', 'keralamlivenews' ),
		)
	);
}
add_action( 'after_setup_theme', 'klm_setup' );

/**
 * Widget areas.
 *
 * Every homepage block below is a normal WordPress widget area.
 * Drop the "News Category Block" widget (see inc/class-klm-news-widget.php)
 * into any of these from Appearance > Widgets and pick the category,
 * post count, layout, and whether to show author/date - no code needed.
 * Leave an area empty and it simply won't be printed (so the sidebar,
 * for example, can be removed just by clearing its widgets).
 */
function klm_widgets_init() {

	$blocks = array(
		'homepage-lead'            => __( 'Homepage: The Lead (left column)', 'keralamlivenews' ),
		'homepage-in-the-news'     => __( 'Homepage: In The News (right of Lead)', 'keralamlivenews' ),
		'homepage-mangalam-special'=> __( 'Homepage: Mangalam Specials', 'keralamlivenews' ),
		'homepage-todays-mangalam' => __( 'Homepage: Today\'s Mangalam (tabs)', 'keralamlivenews' ),
		'homepage-entertainment'   => __( 'Homepage: Entertainment', 'keralamlivenews' ),
		'homepage-inside-mangalam' => __( 'Homepage: Inside Mangalam (4 columns)', 'keralamlivenews' ),
		'homepage-health'          => __( 'Homepage: Health', 'keralamlivenews' ),
		'homepage-video'           => __( 'Homepage: News in Reels (video)', 'keralamlivenews' ),
		'homepage-gallery'         => __( 'Homepage: Photo Gallery', 'keralamlivenews' ),
	);

	foreach ( $blocks as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'description'   => __( 'Add one "News Category Block" widget here and choose its category, post count and display options.', 'keralamlivenews' ),
				'before_widget' => '<section id="%1$s" class="klm-block %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="klm-block__title">',
				'after_title'   => '</h2>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => __( 'Right Sidebar (used site-wide)', 'keralamlivenews' ),
			'id'            => 'sidebar-primary',
			'description'   => __( 'Stack multiple "News Category Block" or "Ad Slot" widgets here — e.g. Advertisement, Trending Now, Off Beat, Astrology, Crime. Leave empty to hide the sidebar completely.', 'keralamlivenews' ),
			'before_widget' => '<div id="%1$s" class="klm-sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="klm-sidebar-widget__title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( __( 'Footer Column %d', 'keralamlivenews' ), $i ),
				'id'            => 'footer-' . $i,
				'before_widget' => '<div id="%1$s" class="klm-footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="klm-footer-widget__title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'klm_widgets_init' );

/** Enqueue scripts/styles, customizer, template helpers, widgets, meta boxes. */
require KLM_DIR . '/inc/enqueue.php';
require KLM_DIR . '/inc/customizer.php';
require KLM_DIR . '/inc/template-functions.php';
require KLM_DIR . '/inc/class-klm-news-widget.php';
require KLM_DIR . '/inc/class-klm-ad-widget.php';
require KLM_DIR . '/inc/meta-boxes.php';

/** Register the custom widgets. */
function klm_register_widgets() {
	register_widget( 'KLM_News_Widget' );
	register_widget( 'KLM_Ad_Widget' );
}
add_action( 'widgets_init', 'klm_register_widgets' );

/** Excerpt length + "..." */
function klm_excerpt_length( $length ) {
	return 24;
}
add_filter( 'excerpt_length', 'klm_excerpt_length' );

function klm_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'klm_excerpt_more' );

/** Fallback menu if no "primary" menu is assigned yet. */
function klm_fallback_menu() {
	echo '<ul class="klm-nav__menu">';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
		)
	);
	echo '</ul>';
}

/** 1x1 gif style placeholder note removed — theme uses CSS for missing images (see .klm-noimg). */

/** Reading time helper is in inc/template-functions.php */
