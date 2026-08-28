<?php
/**
 * Comments & "Leave a Reply" Form.
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
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 50,
				)
			);
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="klm-comments__closed"><?php esc_html_e( 'Comments are closed for this article.', 'keralamlivenews' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'     => __( 'Leave a Reply', 'keralamlivenews' ),
			'title_reply_to'  => __( 'Leave a Reply to %s', 'keralamlivenews' ),
			'class_container' => 'klm-comment-form-container',
			'class_form'      => 'klm-comment-form',
			'class_submit'    => 'klm-comment-submit-btn',
			'comment_field'   => '<p class="klm-comment-form-field"><label for="comment">' . __( 'Comment *', 'keralamlivenews' ) . '</label><textarea id="comment" name="comment" cols="45" rows="5" required></textarea></p>',
		)
	);
	?>
</div>
