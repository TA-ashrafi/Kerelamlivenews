<?php
/**
 * The homepage. Every block below is a real WordPress widget area —
 * add a "News Category Block" widget to each one (Appearance > Widgets)
 * to assign its category, post count, layout and author/date display.
 * A block with no widget in it simply doesn't print.
 *
 * @package KeralamLiveNews
 */

get_header();

$has_sidebar = klm_has_sidebar();
?>

<div class="container klm-home <?php echo $has_sidebar ? 'klm-home--with-sidebar' : 'klm-home--full'; ?>">

	<main class="klm-home__main">

		<?php if ( is_active_sidebar( 'homepage-lead' ) || is_active_sidebar( 'homepage-in-the-news' ) ) : ?>
			<div class="klm-home__row klm-home__row--lead">
				<?php if ( is_active_sidebar( 'homepage-lead' ) ) : ?>
					<div class="klm-home__row-main"><?php dynamic_sidebar( 'homepage-lead' ); ?></div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'homepage-in-the-news' ) ) : ?>
					<div class="klm-home__row-side"><?php dynamic_sidebar( 'homepage-in-the-news' ); ?></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
		$full_width_blocks = array(
			'homepage-mangalam-special',
			'homepage-todays-mangalam',
			'homepage-entertainment',
			'homepage-inside-mangalam',
			'homepage-health',
			'homepage-video',
			'homepage-gallery',
		);
		foreach ( $full_width_blocks as $block_id ) :
			if ( is_active_sidebar( $block_id ) ) :
				?>
				<div class="klm-home__row klm-home__row--full">
					<?php dynamic_sidebar( $block_id ); ?>
				</div>
				<?php
			endif;
		endforeach;
		?>

		<?php if ( empty( array_filter( array_map( 'is_active_sidebar', array_merge( array( 'homepage-lead', 'homepage-in-the-news' ), $full_width_blocks ) ) ) ) ) : ?>
			<p class="klm-empty-state">
				<?php esc_html_e( 'No homepage widgets yet. Go to Appearance → Widgets and add a "News Category Block" to any "Homepage: …" area to get started.', 'keralamlivenews' ); ?>
			</p>
		<?php endif; ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
