<?php
/**
 * The footer for our theme.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</div><!-- #klm-content -->

<footer class="klm-footer">
	<div class="container klm-footer__columns">
		<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
			<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
				<div class="klm-footer__col">
					<?php dynamic_sidebar( 'footer-' . $i ); ?>
				</div>
			<?php endif; ?>
		<?php endfor; ?>

		<?php if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) && ! is_active_sidebar( 'footer-4' ) ) : ?>
			<div class="klm-footer__col">
				<h4><?php bloginfo( 'name' ); ?></h4>
				<p><?php bloginfo( 'description' ); ?></p>
			</div>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<div class="klm-footer__col">
					<h4><?php esc_html_e( 'Quick Links', 'keralamlivenews' ); ?></h4>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'klm-footer__menu',
						)
					);
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="klm-footer__bottom">
		<div class="container klm-footer__bottom-inner">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'keralamlivenews' ); ?></span>
			<span class="klm-footer__credit"><?php echo esc_html( get_theme_mod( 'klm_footer_credit', __( 'Made with love by Tahseen Ashrafi', 'keralamlivenews' ) ) ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
