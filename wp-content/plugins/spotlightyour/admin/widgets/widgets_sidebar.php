<?php
// Register widgetized areas
if ( function_exists('register_sidebar') ) {
	$sidebar_widget_arr = array();
		
	register_sidebar(array(
		'id' => 'deals-right-sidebar',
		'description' => __( 'Deals Offer sidebar'),
		'name' => 'Deals Right Sidebar',
		'before_widget' => '<div class="widget-deals">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

}
?>