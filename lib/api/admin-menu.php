<?php
/**
 * Beans admin page.
 *
 * @ignore
 */
class _Beans_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 20 );

	}


	/**
	 * Add beans menu.
	 */
	public function admin_menu() {

		add_options_page( __( 'Beans', 'beans' ), __( 'Beans', 'beans' ), 'manage_options', 'beans_settings', array( $this, 'display_screen' ) );

	}


	/**
	 * Beans options page content.
	 */
	public function display_screen() {

		echo '<div class="wrap">';

			echo '<h2>' . __( 'Beans Settings', 'beans' ) . '<span style="float: right; font-size: 10px; color: #888;">' . __( 'Version ', 'beans' ) . BEANS_VERSION . '</span></h2>';

			echo beans_options( 'beans_settings' );

		echo '</div>';

	}

}

new _Beans_Admin();