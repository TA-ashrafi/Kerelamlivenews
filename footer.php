<?php
/**
 * Modern Footer Layout.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_logo       = get_theme_mod( 'klm_footer_logo', '' );
$footer_logo_width = get_theme_mod( 'klm_footer_logo_width', 200 );
$about_title       = get_theme_mod( 'klm_footer_about_title', __( 'ABOUT US CONTENT', 'keralamlivenews' ) );
$about_text        = get_theme_mod( 'klm_footer_about_text', __( 'Welcome to Keralam Live News. Delivering latest headlines, trending stories, and in-depth news coverage daily.', 'keralamlivenews' ) );

$fb_url  = get_theme_mod( 'klm_social_facebook', '#' );
$ig_url  = get_theme_mod( 'klm_social_instagram', '#' );
$yt_url  = get_theme_mod( 'klm_social_youtube', '#' );
$x_url   = get_theme_mod( 'klm_social_x', '#' );
?>
</div><!-- #klm-content -->

<footer class="klm-footer">
	<div class="container klm-footer__inner">
		<div class="klm-footer__grid">

			<!-- Column 1: Logo & About Us -->
			<div class="klm-footer__col klm-footer__col--brand">
				<div class="klm-footer__logo-card">
					<?php if ( ! empty( $footer_logo ) ) : ?>
						<img src="<?php echo esc_url( $footer_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" style="max-width: <?php echo esc_attr( $footer_logo_width ); ?>px; height: auto;">
					<?php elseif ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<span class="klm-footer__brand-title"><?php bloginfo( 'name' ); ?></span>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $about_title ) ) : ?>
					<h4 class="klm-footer__widget-title"><?php echo esc_html( $about_title ); ?></h4>
				<?php endif; ?>
				<?php if ( ! empty( $about_text ) ) : ?>
					<p class="klm-footer__desc"><?php echo esc_html( $about_text ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Column 2: Quick Links -->
			<div class="klm-footer__col">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php else : ?>
					<h4 class="klm-footer__widget-title"><?php esc_html_e( 'QUICK LINKS', 'keralamlivenews' ); ?></h4>
					<?php
					if ( has_nav_menu( 'footer' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'container'      => false,
								'menu_class'     => 'klm-footer__menu',
							)
						);
					} else {
						klm_fallback_menu();
					}
					?>
				<?php endif; ?>
			</div>

			<!-- Column 3: Legal -->
			<div class="klm-footer__col">
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<?php dynamic_sidebar( 'footer-2' ); ?>
				<?php else : ?>
					<h4 class="klm-footer__widget-title"><?php esc_html_e( 'LEGAL', 'keralamlivenews' ); ?></h4>
					<ul class="klm-footer__menu">
						<li><a href="#"><?php esc_html_e( 'Privacy Policy', 'keralamlivenews' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Terms and Conditions', 'keralamlivenews' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Disclaimer', 'keralamlivenews' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Contact Us', 'keralamlivenews' ); ?></a></li>
					</ul>
				<?php endif; ?>
			</div>

			<!-- Column 4: Follow Us -->
			<div class="klm-footer__col">
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<?php dynamic_sidebar( 'footer-3' ); ?>
				<?php else : ?>
					<h4 class="klm-footer__widget-title"><?php esc_html_e( 'FOLLOW US', 'keralamlivenews' ); ?></h4>
					<div class="klm-footer__social-stack">
						<?php if ( $fb_url ) : ?>
							<a href="<?php echo esc_url( $fb_url ); ?>" class="klm-social-pill klm-social-pill--fb" target="_blank" rel="noopener noreferrer">
								<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-4.873-12-10.875-12S2.25 5.446 2.25 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H9.703v-3.47h2.672V9.42c0-2.637 1.57-4.093 3.972-4.093 1.15 0 2.351.205 2.351.205v2.584h-1.324c-1.306 0-1.714.81-1.714 1.643v1.97h2.912l-.465 3.47h-2.447v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
								<span>Facebook</span>
							</a>
						<?php endif; ?>
						<?php if ( $ig_url ) : ?>
							<a href="<?php echo esc_url( $ig_url ); ?>" class="klm-social-pill klm-social-pill--ig" target="_blank" rel="noopener noreferrer">
								<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
								<span>Instagram</span>
							</a>
						<?php endif; ?>
						<?php if ( $yt_url ) : ?>
							<a href="<?php echo esc_url( $yt_url ); ?>" class="klm-social-pill klm-social-pill--yt" target="_blank" rel="noopener noreferrer">
								<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.016 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
								<span>YouTube</span>
							</a>
						<?php endif; ?>
						<?php if ( $x_url ) : ?>
							<a href="<?php echo esc_url( $x_url ); ?>" class="klm-social-pill klm-social-pill--x" target="_blank" rel="noopener noreferrer">
								<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
								<span>X (Twitter)</span>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<div class="klm-footer__bottom">
		<div class="container klm-footer__bottom-inner">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> &mdash; <?php esc_html_e( 'All Rights Reserved.', 'keralamlivenews' ); ?></span>
			<span class="klm-footer__credit"><?php echo esc_html( get_theme_mod( 'klm_footer_credit', __( 'Made with ❤️ by Tahseen Ashrafi', 'keralamlivenews' ) ) ); ?></span>
			<button type="button" id="klm-back-to-top" class="klm-backtotop" aria-label="<?php esc_attr_e( 'Back to top', 'keralamlivenews' ); ?>">&#8593;</button>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
