<?php
/**
 * Static page template.
 *
 * @package KeralamLiveNews
 */

get_header();
$has_sidebar = klm_has_sidebar();
?>
<div class="container klm-single <?php echo $has_sidebar ? 'klm-single--with-sidebar' : 'klm-single--full'; ?>">
	<main class="klm-single__main">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'klm-story' ); ?>>
				<h1 class="klm-story__title"><?php the_title(); ?></h1>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="klm-story__figure"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<div class="klm-story__content"><?php the_content(); ?></div>
			</article>
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
