<?php
/**
 * Theme Customizer settings.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function klm_customize_register( $wp_customize ) {

	/* ---------- Header ---------- */
	$wp_customize->add_section(
		'klm_header',
		array(
			'title'    => __( 'Header', 'keralamlivenews' ),
			'priority' => 25,
		)
	);

	$wp_customize->add_setting( 'klm_header_weather', array( 'default' => '28°C Kochi', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'klm_header_weather',
		array(
			'label'       => __( 'Left side text (temperature/city)', 'keralamlivenews' ),
			'description' => __( 'Shown at the top-left of the header, e.g. "28°C Kochi".', 'keralamlivenews' ),
			'section'     => 'klm_header',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'klm_header_show_date', array( 'default' => true, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_header_show_date',
		array(
			'label'   => __( "Show today's date under the logo", 'keralamlivenews' ),
			'section' => 'klm_header',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'klm_header_right_text', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'klm_header_right_text',
		array(
			'label'       => __( 'Right side text (optional)', 'keralamlivenews' ),
			'description' => __( 'Shown at the top-right of the header, next to the search icon.', 'keralamlivenews' ),
			'section'     => 'klm_header',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'klm_header_show_search', array( 'default' => true, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_header_show_search',
		array(
			'label'   => __( 'Show search icon in header', 'keralamlivenews' ),
			'section' => 'klm_header',
			'type'    => 'checkbox',
		)
	);

	/* ---------- Single post display ---------- */
	$wp_customize->add_section(
		'klm_single',
		array(
			'title'    => __( 'Single Post Display', 'keralamlivenews' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting( 'klm_single_show_author', array( 'default' => true, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_single_show_author',
		array(
			'label'   => __( 'Show author name on posts', 'keralamlivenews' ),
			'section' => 'klm_single',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'klm_single_show_date', array( 'default' => true, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_single_show_date',
		array(
			'label'   => __( 'Show publish date on posts', 'keralamlivenews' ),
			'section' => 'klm_single',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'klm_single_show_readtime', array( 'default' => true, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_single_show_readtime',
		array(
			'label'   => __( 'Show "N min read"', 'keralamlivenews' ),
			'section' => 'klm_single',
			'type'    => 'checkbox',
		)
	);

	/* ---------- Layout & Image Design ---------- */
	$wp_customize->add_section(
		'klm_layout_design',
		array(
			'title'    => __( 'Layout & Image Design', 'keralamlivenews' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_setting( 'klm_border_radius', array( 'default' => 4, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		'klm_border_radius',
		array(
			'label'       => __( 'Image Border Radius (px)', 'keralamlivenews' ),
			'description' => __( 'Set corner rounding for post thumbnails (0px to 20px).', 'keralamlivenews' ),
			'section'     => 'klm_layout_design',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 20,
				'step' => 1,
			),
		)
	);

	/* ---------- Category / Archive Display ---------- */
	$wp_customize->add_section(
		'klm_archive',
		array(
			'title'    => __( 'Category & Menu Click Display', 'keralamlivenews' ),
			'priority' => 33,
		)
	);

	$wp_customize->add_setting( 'klm_archive_show_sidebar', array( 'default' => false, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_archive_show_sidebar',
		array(
			'label'       => __( 'Show Sidebar on Category / Archive Pages', 'keralamlivenews' ),
			'description' => __( 'Uncheck to display full-width category grids without sidebar.', 'keralamlivenews' ),
			'section'     => 'klm_archive',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'klm_archive_columns', array( 'default' => '4', 'sanitize_callback' => 'sanitize_key' ) );
	$wp_customize->add_control(
		'klm_archive_columns',
		array(
			'label'   => __( 'Number of columns on Category Page', 'keralamlivenews' ),
			'section' => 'klm_archive',
			'type'    => 'select',
			'choices' => array(
				'3' => __( '3 Columns', 'keralamlivenews' ),
				'4' => __( '4 Columns', 'keralamlivenews' ),
				'5' => __( '5 Columns', 'keralamlivenews' ),
			),
		)
	);

	$wp_customize->add_setting( 'klm_archive_show_author', array( 'default' => true, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_archive_show_author',
		array(
			'label'   => __( 'Show Author on Category Posts', 'keralamlivenews' ),
			'section' => 'klm_archive',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'klm_archive_show_date', array( 'default' => true, 'sanitize_callback' => 'klm_sanitize_checkbox' ) );
	$wp_customize->add_control(
		'klm_archive_show_date',
		array(
			'label'   => __( 'Show Date on Category Posts', 'keralamlivenews' ),
			'section' => 'klm_archive',
			'type'    => 'checkbox',
		)
	);

	/* ---------- Colors ---------- */
	$wp_customize->add_section(
		'klm_colors',
		array(
			'title'    => __( 'Theme Colors', 'keralamlivenews' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_setting( 'klm_color_primary', array( 'default' => '#cc0000', 'sanitize_callback' => 'sanitize_hex_color' ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'klm_color_primary',
			array(
				'label'       => __( 'Primary / accent color', 'keralamlivenews' ),
				'description' => __( 'Used for section headings, the nav bar and buttons.', 'keralamlivenews' ),
				'section'     => 'klm_colors',
			)
		)
	);

	$wp_customize->add_setting( 'klm_color_link', array( 'default' => '#0b5ed7', 'sanitize_callback' => 'sanitize_hex_color' ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'klm_color_link',
			array(
				'label'   => __( 'Link color', 'keralamlivenews' ),
				'section' => 'klm_colors',
			)
		)
	);

	$wp_customize->add_setting( 'klm_color_bg', array( 'default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color' ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'klm_color_bg',
			array(
				'label'   => __( 'Site background color', 'keralamlivenews' ),
				'section' => 'klm_colors',
			)
		)
	);

	/* ---------- Footer ---------- */
	$wp_customize->add_section(
		'klm_footer',
		array(
			'title'    => __( 'Footer & Social Media', 'keralamlivenews' ),
			'priority' => 40,
		)
	);

	/* Separate Footer Logo */
	$wp_customize->add_setting( 'klm_footer_logo', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'klm_footer_logo',
			array(
				'label'       => __( 'Footer Custom Logo', 'keralamlivenews' ),
				'description' => __( 'Upload a separate custom logo specifically for the footer.', 'keralamlivenews' ),
				'section'     => 'klm_footer',
			)
		)
	);

	/* Footer Logo Width */
	$wp_customize->add_setting( 'klm_footer_logo_width', array( 'default' => 200, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		'klm_footer_logo_width',
		array(
			'label'       => __( 'Footer Logo Width (px)', 'keralamlivenews' ),
			'description' => __( 'Adjust footer logo width (50px to 400px).', 'keralamlivenews' ),
			'section'     => 'klm_footer',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 50,
				'max'  => 400,
				'step' => 5,
			),
		)
	);

	/* Footer About Title & Text */
	$wp_customize->add_setting( 'klm_footer_about_title', array( 'default' => __( 'ABOUT US CONTENT', 'keralamlivenews' ), 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'klm_footer_about_title',
		array(
			'label'   => __( 'About Section Title', 'keralamlivenews' ),
			'section' => 'klm_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'klm_footer_about_text', array( 'default' => __( 'Welcome to Keralam Live News. Delivering latest headlines, trending stories, and in-depth news coverage daily.', 'keralamlivenews' ), 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control(
		'klm_footer_about_text',
		array(
			'label'   => __( 'About Us Description', 'keralamlivenews' ),
			'section' => 'klm_footer',
			'type'    => 'textarea',
		)
	);

	/* Footer Social Media Links */
	$wp_customize->add_setting( 'klm_social_facebook', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control(
		'klm_social_facebook',
		array(
			'label'   => __( 'Facebook Page URL', 'keralamlivenews' ),
			'section' => 'klm_footer',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting( 'klm_social_instagram', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control(
		'klm_social_instagram',
		array(
			'label'   => __( 'Instagram Profile URL', 'keralamlivenews' ),
			'section' => 'klm_footer',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting( 'klm_social_youtube', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control(
		'klm_social_youtube',
		array(
			'label'   => __( 'YouTube Channel URL', 'keralamlivenews' ),
			'section' => 'klm_footer',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting( 'klm_social_x', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control(
		'klm_social_x',
		array(
			'label'   => __( 'X (Twitter) Profile URL', 'keralamlivenews' ),
			'section' => 'klm_footer',
			'type'    => 'url',
		)
	);

	/* Bottom credit */
	$wp_customize->add_setting( 'klm_footer_credit', array( 'default' => __( 'Made with ❤️ by Tahseen Ashrafi', 'keralamlivenews' ), 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'klm_footer_credit',
		array(
			'label'   => __( 'Bottom credit line', 'keralamlivenews' ),
			'section' => 'klm_footer',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'klm_customize_register' );

function klm_sanitize_checkbox( $checked ) {
	return (bool) $checked;
}
