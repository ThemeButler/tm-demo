<?php
/**
 * Echo the structural markup for the main content. It also calls the content action hooks.
 *
 * @package Beans\Structure\Content
 */

echo beans_open_markup( 'beans_content', 'div', array( 'class' => 'tm-content', 'role' => 'main' ) );

	/**
	 * Fires in the main content.
	 *
	 * @since 1.0.0
	 */
	do_action( 'beans_content' );

echo beans_close_markup( 'beans_content', 'div' );