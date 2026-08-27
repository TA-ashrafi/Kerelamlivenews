<?php
/**
 * Comments template.
 *
 * @package KeralamLiveNews
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="klm-comments">
	<?php if ( have_comments() ) : ?>
		<h3 class="klm-comments__title">
			<?php
			printf(
				/* translators: %s: number of comments */
				esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'keralamlivenews' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h3>
		<ol class="klm-comments__list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="klm-comments__closed"><?php esc_html_e( 'Comments are closed.', 'keralamlivenews' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
