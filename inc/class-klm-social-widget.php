<?php
/**
 * KLM_Social_Widget — Social Links Widget
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class KLM_Social_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'klm_social_widget',
			__( 'Social Media Links', 'keralamlivenews' ),
			array(
				'description' => __( 'Display social media icons and links for Facebook, Instagram, Twitter/X, YouTube.', 'keralamlivenews' ),
			)
		);
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? $instance['title'] : __( 'Follow Us', 'keralamlivenews' );
		$facebook  = isset( $instance['facebook'] ) ? $instance['facebook'] : '';
		$instagram = isset( $instance['instagram'] ) ? $instance['instagram'] : '';
		$twitter   = isset( $instance['twitter'] ) ? $instance['twitter'] : '';
		$youtube   = isset( $instance['youtube'] ) ? $instance['youtube'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php esc_html_e( 'Facebook URL:', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="url" value="<?php echo esc_attr( $facebook ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php esc_html_e( 'Instagram URL:', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="url" value="<?php echo esc_attr( $instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"><?php esc_html_e( 'Twitter / X URL:', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="url" value="<?php echo esc_attr( $twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php esc_html_e( 'YouTube URL:', 'keralamlivenews' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="url" value="<?php echo esc_attr( $youtube ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['facebook']  = esc_url_raw( $new_instance['facebook'] );
		$instance['instagram'] = esc_url_raw( $new_instance['instagram'] );
		$instance['twitter']   = esc_url_raw( $new_instance['twitter'] );
		$instance['youtube']   = esc_url_raw( $new_instance['youtube'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title']; // phpcs:ignore
		}

		echo '<div class="klm-social-links">';
		if ( ! empty( $instance['facebook'] ) ) {
			echo '<a href="' . esc_url( $instance['facebook'] ) . '" class="klm-social-btn klm-social-btn--fb" target="_blank" rel="noopener" aria-label="Facebook">FB</a>';
		}
		if ( ! empty( $instance['instagram'] ) ) {
			echo '<a href="' . esc_url( $instance['instagram'] ) . '" class="klm-social-btn klm-social-btn--ig" target="_blank" rel="noopener" aria-label="Instagram">IG</a>';
		}
		if ( ! empty( $instance['twitter'] ) ) {
			echo '<a href="' . esc_url( $instance['twitter'] ) . '" class="klm-social-btn klm-social-btn--tw" target="_blank" rel="noopener" aria-label="Twitter">X</a>';
		}
		if ( ! empty( $instance['youtube'] ) ) {
			echo '<a href="' . esc_url( $instance['youtube'] ) . '" class="klm-social-btn klm-social-btn--yt" target="_blank" rel="noopener" aria-label="YouTube">YT</a>';
		}
		echo '</div>';

		echo $args['after_widget']; // phpcs:ignore
	}
}
