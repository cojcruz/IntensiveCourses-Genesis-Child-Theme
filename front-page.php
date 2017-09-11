<?php
/**
 * This file adds the Home Page to the Intensive Courses Theme.
 *
 * @author StudioPress / CojCruz
 * @package Intensive Courses branched from intensivecourses Pro 
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'intensivecourses_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function intensivecourses_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-bottom' ) ) {

		//* Force full-width-content layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		
		//* Add intensivecourses-pro-home body class
		add_filter( 'body_class', 'intensivecourses_body_class' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Add home top widgets
		add_action( 'genesis_loop', 'intensivecourses_home_top_widgets' );

		//* Add home bottom widgets
		add_action( 'genesis_before_footer', 'intensivecourses_home_bottom_widgets', 1 );

	}

}

function intensivecourses_body_class( $classes ) {

	$classes[] = 'intensivecourses-pro-home';
	return $classes;
	
}

function intensivecourses_home_top_widgets() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );
	
}

function intensivecourses_home_bottom_widgets() {
	
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
