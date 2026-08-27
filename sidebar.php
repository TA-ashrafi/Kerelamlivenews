<?php
/**
 * The right sidebar. Stack "News Category Block" and "Ad Slot" widgets
 * in Appearance > Widgets > "Right Sidebar" to fill it in. If it has
 * no widgets it simply doesn't print (front-page.php and single.php
 * both check klm_has_sidebar() before calling this).
 *
 * @package KeralamLiveNews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! klm_has_sidebar() ) {
	return;
}
?>
<aside class="klm-sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-primary' ); ?>
</aside>
