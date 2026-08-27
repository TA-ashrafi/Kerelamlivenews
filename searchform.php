<?php
/**
 * Search form.
 *
 * @package KeralamLiveNews
 */
?>
<form role="search" method="get" class="klm-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="klm-search-field"><?php esc_html_e( 'Search for:', 'keralamlivenews' ); ?></label>
	<input type="search" id="klm-search-field" class="klm-search-form__field" placeholder="<?php esc_attr_e( 'Search news…', 'keralamlivenews' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button type="submit" class="klm-search-form__submit"><?php esc_html_e( 'Search', 'keralamlivenews' ); ?></button>
</form>
