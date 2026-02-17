<?php
/**
 * sumun Admin Functions
 *
 * @package sumun
 */

// Add a parent shortcut link
add_action('admin_bar_menu', 'custom_toolbar_links', 999);
function custom_toolbar_links($wp_admin_bar) {
	$args = array(
		'id' => 'portfolio',
		'title' => 'Ver Portfolio', 
		'href' => get_the_permalink( PORTFOLIO_LIST_ID ), 
		'parent' => 'site-name',
		'meta' => array(
			// 'class' => 'portfolio', 
			'title' => 'Ver listado del portfolio'
			)
	);
	$wp_admin_bar->add_node($args);

}