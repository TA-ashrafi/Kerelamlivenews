<?php
/**
 * Single post — "Open Story" layout: breadcrumb, title, meta line,
 * featured image, content, author bio box, share icons, sidebar.
 *
 * @package KeralamLiveNews
 */

get_header();
$has_sidebar = klm_has_sidebar();

$show_author   = get_theme_mod( 'klm_single_show_author', true );
$show_date     = get_theme_mod( 'klm_single_show_date', true );
$show_readtime = get_theme_mod( 'klm_single_show_readtime', true );
?>
<div class="container klm-single <?php echo $has_sidebar ? 'klm-single--with-sidebar' : 'klm-single--full'; ?>">
	<main class="klm-single__main">
		<?php klm_breadcrumb(); ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'klm-story' ); ?>>
				<?php
				$cats = get_the_category();
				if ( ! empty( $cats ) ) :
					?>
					<a class="klm-story__eyebrow" href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
				<?php endif; ?>

				<h1 class="klm-story__title"><?php the_title(); ?></h1>

				<div class="klm-story__meta">
					<?php klm_post_meta( $show_author, $show_date, $show_readtime ); ?>
					<div class="klm-story__share" aria-label="<?php esc_attr_e( 'Share', 'keralamlivenews' ); ?>">
						<a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">&#128172;</a>
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">f</a>
						<button type="button" class="klm-story__print" onclick="window.print()" aria-label="<?php esc_attr_e( 'Print', 'keralamlivenews' ); ?>">&#128424;</button>
					</div>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="klm-story__figure"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>

				<div class="klm-story__content">
					<?php the_content(); ?>
				</div>

				<?php
				wp_link_pages(
					array(
						'before' => '<div class="klm-story__pages">' . esc_html__( 'Pages:', 'keralamlivenews' ),
						'after'  => '</div>',
					)
				);
				?>

				<!-- Author Bio Box -->
				<div class="klm-author-box">
					<div class="klm-author-box__avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80, '', get_the_author() ); ?>
					</div>
					<div class="klm-author-box__info">
						<h3 class="klm-author-box__name"><?php echo esc_html( get_the_author() ); ?></h3>
						<p class="klm-author-box__bio">
							<?php
							$bio = get_the_author_meta( 'description' );
							echo esc_html( $bio ? $bio : __( 'Journalist and News Editor at Keralam Live News.', 'keralamlivenews' ) );
							?>
						</p>
					</div>
				</div>
			</article>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="klm-story__comments"><?php comments_template(); ?></div>
			<?php endif; ?>
			<?php
		endwhile;
		?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
