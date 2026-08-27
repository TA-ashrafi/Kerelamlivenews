<?php
/**
 * The header for our theme.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#klm-content"><?php esc_html_e( 'Skip to content', 'keralamlivenews' ); ?></a>

<header class="klm-header">
	<div class="container klm-header__top">
		<div class="klm-header__left">
			<span class="klm-header__weather">
				<span class="dashicons-before klm-weather-icon" aria-hidden="true">&#9728;</span>
				<?php echo esc_html( get_theme_mod( 'klm_header_weather', '28°C Kochi' ) ); ?>
			</span>
		</div>

		<div class="klm-header__center">
			<?php if ( has_custom_logo() ) : ?>
				<div class="klm-header__logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<a class="klm-header__sitename" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'klm_header_show_date', true ) ) : ?>
				<div class="klm-header__date"><?php echo esc_html( date_i18n( 'l, j F Y' ) ); ?></div>
			<?php endif; ?>
		</div>

		<div class="klm-header__right">
			<?php if ( get_theme_mod( 'klm_header_right_text', '' ) ) : ?>
				<span class="klm-header__right-text"><?php echo esc_html( get_theme_mod( 'klm_header_right_text' ) ); ?></span>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'klm_header_show_search', true ) ) : ?>
				<button type="button" class="klm-header__search-toggle" aria-label="<?php esc_attr_e( 'Search', 'keralamlivenews' ); ?>" aria-expanded="false">
					<span aria-hidden="true">&#128269;</span>
				</button>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( get_theme_mod( 'klm_header_show_search', true ) ) : ?>
		<div class="klm-header__search-panel">
			<div class="container"><?php get_search_form(); ?></div>
		</div>
	<?php endif; ?>

	<nav class="klm-nav" aria-label="<?php esc_attr_e( 'Primary', 'keralamlivenews' ); ?>">
		<div class="container klm-nav__inner">
			<button type="button" class="klm-nav__toggle" aria-label="<?php esc_attr_e( 'Menu', 'keralamlivenews' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'klm-nav__menu',
					)
				);
			} else {
				klm_fallback_menu();
			}
			?>
		</div>
	</nav>
</header>

<div id="klm-content" class="klm-site-content">
