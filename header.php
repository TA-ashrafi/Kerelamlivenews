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
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php
	// Dynamic SEO Meta Tags
	$seo_title       = is_singular() ? get_the_title() : get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
	$seo_description = is_singular() ? wp_strip_all_tags( get_the_excerpt() ) : get_bloginfo( 'description' );
	$seo_url         = is_singular() ? get_permalink() : home_url( '/' );
	$seo_image       = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : get_header_image();
	?>
	<title><?php echo esc_html( $seo_title ); ?></title>
	<meta name="description" content="<?php echo esc_attr( wp_trim_words( $seo_description, 30 ) ); ?>">
	<link rel="canonical" href="<?php echo esc_url( $seo_url ); ?>">

	<!-- OpenGraph SEO -->
	<meta property="og:locale" content="ml_IN">
	<meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
	<meta property="og:title" content="<?php echo esc_attr( $seo_title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( wp_trim_words( $seo_description, 30 ) ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $seo_url ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<?php if ( $seo_image ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $seo_image ); ?>">
	<?php endif; ?>

	<!-- Twitter Card SEO -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $seo_title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( wp_trim_words( $seo_description, 30 ) ); ?>">

	<!-- Schema.org NewsMediaOrganization -->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "NewsMediaOrganization",
		"name": "<?php echo esc_js( get_bloginfo( 'name' ) ); ?>",
		"url": "<?php echo esc_js( home_url( '/' ) ); ?>",
		"logo": "<?php echo esc_js( $seo_image ); ?>"
	}
	</script>

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
			<div class="klm-lang-select-wrap">
				<select id="klm-lang-switcher" class="klm-lang-select" aria-label="<?php esc_attr_e( 'Select Language', 'keralamlivenews' ); ?>" onchange="klmSwitchLanguage(this.value);">
					<option value="en" selected><?php esc_html_e( 'ENGLISH', 'keralamlivenews' ); ?></option>
					<option value="ml"><?php esc_html_e( 'MALAYALAM', 'keralamlivenews' ); ?></option>
				</select>
				<div id="google_translate_element" style="display:none;"></div>
				<script type="text/javascript">
				function googleTranslateElementInit() {
					new google.translate.TranslateElement({
						pageLanguage: 'ml',
						includedLanguages: 'en,ml',
						autoDisplay: false
					}, 'google_translate_element');
				}
				function klmSwitchLanguage(lang) {
					var select = document.querySelector('.goog-te-combo');
					if (select) {
						select.value = lang;
						select.dispatchEvent(new Event('change'));
					}
				}
				</script>
				<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
			</div>

			<?php if ( get_theme_mod( 'klm_header_right_text', '' ) ) : ?>
				<span class="klm-header__right-text"><?php echo esc_html( get_theme_mod( 'klm_header_right_text' ) ); ?></span>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'klm_header_show_search', true ) ) : ?>
				<button type="button" class="klm-header__search-toggle" aria-label="<?php esc_attr_e( 'Search', 'keralamlivenews' ); ?>" aria-expanded="false">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
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
