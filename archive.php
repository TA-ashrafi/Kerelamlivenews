<?php
/**
 * Archive / category listing — "Menu Click" layout: breadcrumb, big
 * lead post, grid of the rest, sidebar.
 *
 * @package KeralamLiveNews
 */

get_header();
$has_sidebar = klm_has_sidebar();

$show_author = get_theme_mod( 'klm_single_show_author', true );
$show_date   = get_theme_mod( 'klm_single_show_date', true );
?>
<div class="container klm-archive <?php echo $has_sidebar ? 'klm-archive--with-sidebar' : 'klm-archive--full'; ?>">
	<main class="klm-archive__main">
		<?php klm_breadcrumb(); ?>
		<h1 class="klm-archive__title"><?php the_archive_title(); ?></h1>
		<?php if ( term_description() ) : ?>
			<div class="klm-archive__desc"><?php echo wp_kses_post( term_description() ); ?></div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="klm-archive__grid">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					$i++;
					?>
					<article <?php post_class( 0 === $i % 7 ? 'klm-archive__item klm-archive__item--wide' : 'klm-archive__item' ); ?>>
						<a href="<?php the_permalink(); ?>">
							<?php klm_thumbnail( get_the_ID(), 1 === $i ? 'klm-lead' : 'medium', 'klm-archive__img' ); ?>
							<h2><?php the_title(); ?></h2>
						</a>
						<?php if ( 1 === $i ) : ?>
							<p class="klm-archive__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
						<?php endif; ?>
						<?php klm_post_meta( $show_author, $show_date ); ?>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<div class="klm-pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts found in this section yet.', 'keralamlivenews' ); ?></p>
		<?php endif; ?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
