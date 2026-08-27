<?php
/**
 * A single optional field, "Video URL", used by the "News in Reels"
 * video-strip layout. If left blank, the widget just links to the
 * post itself.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function klm_add_video_meta_box() {
	add_meta_box( 'klm_video_url', __( 'Video URL (optional)', 'keralamlivenews' ), 'klm_render_video_meta_box', 'post', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'klm_add_video_meta_box' );

function klm_render_video_meta_box( $post ) {
	wp_nonce_field( 'klm_save_video_url', 'klm_video_url_nonce' );
	$value = get_post_meta( $post->ID, 'klm_video_url', true );
	echo '<label for="klm_video_url_field" class="screen-reader-text">' . esc_html__( 'Video URL', 'keralamlivenews' ) . '</label>';
	echo '<input type="url" id="klm_video_url_field" name="klm_video_url_field" class="widefat" placeholder="https://youtube.com/watch?v=..." value="' . esc_attr( $value ) . '">';
	echo '<p class="description">' . esc_html__( 'Used by the "News in Reels" widget layout. Leave blank to just link to this post.', 'keralamlivenews' ) . '</p>';
}

function klm_save_video_meta_box( $post_id ) {
	if ( ! isset( $_POST['klm_video_url_nonce'] ) || ! wp_verify_nonce( $_POST['klm_video_url_nonce'], 'klm_save_video_url' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['klm_video_url_field'] ) ) {
		update_post_meta( $post_id, 'klm_video_url', esc_url_raw( wp_unslash( $_POST['klm_video_url_field'] ) ) );
	}
}
add_action( 'save_post', 'klm_save_video_meta_box' );
