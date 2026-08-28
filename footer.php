<?php
/**
 * Modern Footer Layout.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</div><!-- #klm-content -->

<footer class="klm-footer">
	<div class="container klm-footer__inner">
		<div class="klm-footer__columns">
			<div class="klm-footer__col klm-footer__brand">
				<?php if ( has_custom_logo() ) : ?>
					<div class="klm-footer__logo"><?php the_custom_logo(); ?></div>
				<?php else : ?>
					<h3 class="klm-footer__title"><?php bloginfo( 'name' ); ?></h3>
				<?php endif; ?>
				<p class="klm-footer__desc"><?php bloginfo( 'description' ); ?></p>
			</div>

			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
				<div class="klm-footer__col">
					<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
						<?php dynamic_sidebar( 'footer-' . $i ); ?>
					<?php else : ?>
						<?php if ( 1 === $i && has_nav_menu( 'footer' ) ) : ?>
							<h4 class="klm-footer__widget-title"><?php esc_html_e( 'Quick Links', 'keralamlivenews' ); ?></h4>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'container'      => false,
									'menu_class'     => 'klm-footer__menu',
								)
							);
							?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
		</div>
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
