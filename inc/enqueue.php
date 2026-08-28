<?php
/**
 * Enqueue styles and scripts.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function klm_enqueue_assets() {
	wp_enqueue_style( 'klm-google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800&family=Noto+Serif:ital,wght@0,600;0,800;1,600&display=swap', array(), null );
	wp_enqueue_style( 'klm-style', get_stylesheet_uri(), array(), KLM_VERSION );
	wp_enqueue_style( 'klm-custom', KLM_URI . '/assets/css/custom.css', array( 'klm-style' ), KLM_VERSION );

	wp_enqueue_script( 'klm-custom', KLM_URI . '/assets/js/custom.js', array(), KLM_VERSION, true );
	wp_localize_script(
		'klm-custom',
		'klm_ajax',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'klm_nonce' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* Color and border-radius settings from the Customizer become CSS variables, printed inline. */
	$primary     = get_theme_mod( 'klm_color_primary', '#cc0000' );
	$link        = get_theme_mod( 'klm_color_link', '#0b5ed7' );
	$bg          = get_theme_mod( 'klm_color_bg', '#ffffff' );
	$radius      = get_theme_mod( 'klm_border_radius', 4 );
	$logo_radius = get_theme_mod( 'klm_logo_border_radius', 0 );

	$custom_css = sprintf(
		':root{--klm-primary:%1$s;--klm-primary-dark:%1$s;--klm-link:%2$s;--klm-bg:%3$s;--klm-radius:%4$dpx;--klm-logo-radius:%5$dpx;}',
		esc_html( $primary ),
		esc_html( $link ),
		esc_html( $bg ),
		absint( $radius ),
		absint( $logo_radius )
	);
	wp_add_inline_style( 'klm-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'klm_enqueue_assets' );

function klm_admin_enqueue( $hook ) {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'klm_admin_enqueue' );
