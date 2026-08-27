<?php
/**
 * Fallback template — standard blog loop (used if this isn't set as
 * the homepage, e.g. for the "Posts page" or as a generic fallback).
 *
 * @package KeralamLiveNews
 */

get_header();
$has_sidebar = klm_has_sidebar();
?>
<div class="container klm-home <?php echo $has_sidebar ? 'klm-home--with-sidebar' : 'klm-home--full'; ?>">
	<main class="klm-home__main">
		<?php if ( have_posts() ) : ?>
			<ul class="klm-fourcol klm-fourcol--wrap">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'klm-fourcol__item' ); ?>>
						<a href="<?php the_permalink(); ?>">
							<?php klm_thumbnail( get_the_ID(), 'klm-square', 'klm-fourcol__img' ); ?>
							<h4><?php the_title(); ?></h4>
						</a>
						<?php klm_post_meta( get_theme_mod( 'klm_single_show_author', true ), get_theme_mod( 'klm_single_show_date', true ) ); ?>
					</article>
					<?php
				endwhile;
				?>
			</ul>
			<div class="klm-pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'keralamlivenews' ); ?></p>
		<?php endif; ?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
