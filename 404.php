<?php
/**
 * 404 page.
 *
 * @package KeralamLiveNews
 */

get_header();
?>
<div class="container klm-404">
	<h1><?php esc_html_e( '404 — Page Not Found', 'keralamlivenews' ); ?></h1>
	<p><?php esc_html_e( "The page you're looking for doesn't exist or has moved.", 'keralamlivenews' ); ?></p>
	<?php get_search_form(); ?>
	<a class="klm-404__home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( '← Back to homepage', 'keralamlivenews' ); ?></a>
</div>
<?php get_footer(); ?>
