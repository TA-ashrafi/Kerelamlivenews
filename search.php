<?php
/**
 * Search results.
 *
 * @package KeralamLiveNews
 */

get_header();
$has_sidebar = klm_has_sidebar();
?>
<div class="container klm-archive <?php echo $has_sidebar ? 'klm-archive--with-sidebar' : 'klm-archive--full'; ?>">
	<main class="klm-archive__main">
		<?php klm_breadcrumb(); ?>
		<h1 class="klm-archive__title">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search results for: %s', 'keralamlivenews' ),
				'<span>' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
		<?php if ( have_posts() ) : ?>
			<div class="klm-archive__grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'klm-archive__item' ); ?>>
						<a href="<?php the_permalink(); ?>">
							<?php klm_thumbnail( get_the_ID(), 'medium', 'klm-archive__img' ); ?>
							<h2><?php the_title(); ?></h2>
						</a>
						<p class="klm-archive__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<div class="klm-pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'No results found. Try a different search.', 'keralamlivenews' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
