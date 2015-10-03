<?php
/**
 * Echo the primary sidebar structural markup. It also calls the primary sidebar action hooks.
 *
 * @package Beans\Structure\Primary_Sidebar
 */

echo beans_open_markup( 'beans_sidebar_primary', 'aside', array(
	'class' => 'tm-secondary ' . beans_get_layout_class( 'sidebar_primary' ),
	'role' => 'complementary'
) );

	/**
	 * Fires in the primary sidebar.
	 *
	 * @since 1.0.0
	 */
	do_action( 'beans_sidebar_primary' );

echo beans_close_markup( 'beans_sidebar_primary', 'aside' );