<?php
/**
 * Add Beans assets.
 *
 * @package Beans\Assets
 */

beans_add_smart_action( 'beans_uikit_enqueue_scripts', 'beans_enqueue_uikit_components', 5 );

/**
 * Enqueue UIKit components and Beans style.
 *
 * Beans style is enqueued with the UIKit components to have access to UIKit LESS variables.
 *
 * @since 1.0.0
 */
function beans_enqueue_uikit_components() {

	$core = array(
		'base',
		'block',
		'grid',
		'article',
		'comment',
		'panel',
		'nav',
		'navbar',
		'subnav',
		'table',
		'breadcrumb',
		'pagination',
		'list',
		'form',
		'button',
		'badge',
		'alert',
		'dropdown',
		'offcanvas',
		'text',
		'utility',
		'icon'
	);

	beans_uikit_enqueue_components( $core );

	// Include uikit default theme.
	beans_uikit_enqueue_theme( 'default' );

	// Enqueue uikit overwrite theme folder.
	beans_uikit_enqueue_theme( 'beans', BEANS_ASSETS_URL . 'less/uikit-overwrite' );

	// Add the theme style as a uikit fragment to have access to all the variables.
	beans_compiler_add_fragment( 'uikit', BEANS_ASSETS_URL . 'less/style.less', 'less' );

}


beans_add_smart_action( 'wp_enqueue_scripts', 'beans_enqueue_assets', 5 );

/**
 * Enqueue Beans assets.
 *
 * @since 1.0.0
 */
function beans_enqueue_assets() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

}