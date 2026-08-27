<?php
/**
 * KLM_Ad_Widget — a plain "Advertisement" slot, matching the boxes
 * seen throughout the reference site's sidebar. Paste any ad code
 * (AdSense, a banner image link, etc.) or leave it empty to show a
 * placeholder box.
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class KLM_Ad_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'klm_ad_widget',
			__( 'Ad Slot', 'keralamlivenews' ),
			array( 'description' => __( 'A simple advertisement box for the sidebar. Paste ad code/HTML, or leave blank for a placeholder.', 'keralamlivenews' ) )
		);
	}

	public function form( $instance ) {
		$code = isset( $instance['code'] ) ? $instance['code'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>"><?php esc_html_e( 'Ad code / HTML (leave blank for a placeholder box):', 'keralamlivenews' ); ?></label>
			<textarea class="widefat" rows="5" id="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'code' ) ); ?>"><?php echo esc_textarea( $code ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		return array( 'code' => wp_kses_post( $new_instance['code'] ) );
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore
		echo '<div class="klm-ad">';
		if ( ! empty( $instance['code'] ) ) {
			echo $instance['code']; // phpcs:ignore -- admin-entered ad code, intentionally unescaped.
		} else {
			echo '<span>' . esc_html__( 'Advertisement', 'keralamlivenews' ) . '</span>';
		}
		echo '</div>';
		echo $args['after_widget']; // phpcs:ignore
	}
}
