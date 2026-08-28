<?php
/**
 * Archive / Category Page - Grid layout with Customizer Controls & Infinite Scroll.
 *
 * @package KeralamLiveNews
 */

get_header();

$show_sidebar = get_theme_mod( 'klm_archive_show_sidebar', false ) && klm_has_sidebar();
$cols         = get_theme_mod( 'klm_archive_columns', '4' );
$show_author  = get_theme_mod( 'klm_archive_show_author', true );
$show_date    = get_theme_mod( 'klm_archive_show_date', true );
$current_cat  = get_queried_object_id();
global $wp_query;
$max_pages    = $wp_query->max_num_pages;
?>
<div class="container klm-archive <?php echo $show_sidebar ? 'klm-archive--with-sidebar' : 'klm-archive--full'; ?>">
	<main class="klm-archive__main">
		<?php klm_breadcrumb(); ?>
		<h1 class="klm-archive__title"><?php the_archive_title(); ?></h1>
		<?php if ( term_description() ) : ?>
			<div class="klm-archive__desc"><?php echo wp_kses_post( term_description() ); ?></div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="klm-archive__grid klm-archive__grid--cols-<?php echo esc_attr( $cols ); ?>" id="klm-archive-grid" data-cat="<?php echo esc_attr( $current_cat ); ?>" data-maxpages="<?php echo esc_attr( $max_pages ); ?>" data-showauthor="<?php echo esc_attr( $show_author ? 1 : 0 ); ?>" data-showdate="<?php echo esc_attr( $show_date ? 1 : 0 ); ?>">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'klm-archive__card' ); ?>>
						<a href="<?php the_permalink(); ?>" class="klm-archive__card-link">
							<?php klm_thumbnail( get_the_ID(), 'klm-square', 'klm-archive__card-img' ); ?>
							<h3 class="klm-archive__card-title"><?php the_title(); ?></h3>
						</a>
						<p class="klm-archive__card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
						<?php klm_post_meta( $show_author, $show_date ); ?>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<div class="klm-infinite-scroll" id="klm-infinite-scroll">
				<div class="klm-loader" id="klm-loader" style="display:none;"><?php esc_html_e( 'Loading more news…', 'keralamlivenews' ); ?></div>
				<div class="klm-end-msg" id="klm-end-msg" style="display:none;"><?php esc_html_e( 'You have reached the end of news updates.', 'keralamlivenews' ); ?></div>
			</div>
		<?php else : ?>
			<p class="klm-empty-state"><?php esc_html_e( 'No posts found in this section yet.', 'keralamlivenews' ); ?></p>
		<?php endif; ?>
	</main>
	<?php if ( $show_sidebar ) { get_sidebar(); } ?>
</div>
<?php get_footer(); ?>
