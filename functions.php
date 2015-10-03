<?php

// Include Beans
require_once( get_template_directory() . '/lib/init.php' );


add_action( 'admin_menu', 'themebutler_deregister_menu', -1 );

function themebutler_deregister_menu() {

    remove_menu_page( 'upload.php' );
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit.php?post_type=page' );
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'tools.php' );

}


add_action( 'admin_bar_menu', 'themebutler_admin_bar_menu', 999 );

function themebutler_admin_bar_menu( $wp_admin_bar ) {

	$wp_admin_bar->remove_node( 'comments' );
	$wp_admin_bar->remove_node( 'new-content' );

}


add_action( 'themebutler_init', 'themebutler_load_dependencies', -1 );

function themebutler_load_dependencies() {

	// Load the necessary Butler components.
	beans_load_api_components( array( 'uikit' ) );

	// Add third party styles and scripts compiler support.
	beans_add_component_support( 'wp_styles_compiler' );
	beans_add_component_support( 'wp_scripts_compiler' );

}


add_action( 'beans_uikit_enqueue_scripts', 'themebutler_enqueue_uikit_components' );

function themebutler_enqueue_uikit_components() {

	beans_uikit_enqueue_components( array(
		'base',
		'text',
		'utility',
		'dropdown',
		'overlay',
		'icon',
		'animation',
		'flex'
	) );

}


add_action( 'wp_enqueue_scripts', 'themebutler_euqueue_assets' );

function themebutler_euqueue_assets() {

	$dir = get_template_directory_uri();

	wp_enqueue_style( 'themebutler', $dir . '/style.css' );
	beans_compile_js_fragments( 'themebutler', $dir . '/js/demo.js', array( 'minify_js' => true ) );

}


do_action( 'themebutler_init' );
