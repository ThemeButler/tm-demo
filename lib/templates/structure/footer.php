<?php
/**
 * Despite its name, this template echos between the closing primary markup and the closing HTML markup.
 *
 * This template must be called using get_footer().
 *
 * @package Beans\Structure\Footer
 */

							echo beans_close_markup( 'beans_primary', 'div' );

						echo beans_close_markup( 'beans_main_grid', 'div' );

					echo beans_close_markup( 'beans_fixed_wrap[_main]', 'div' );

				echo beans_close_markup( 'beans_main', 'main' );

				echo beans_open_markup( 'beans_footer', 'footer', array( 'class' => 'tm-footer uk-block' ) );

					echo beans_open_markup( 'beans_fixed_wrap[_footer]', 'div', 'class=uk-container uk-container-center' );

						/**
						 * Fires in the footer.
						 *
						 * This hook fires in the footer HTML section, not in wp_footer().
						 *
						 * @since 1.0.0
						 */
						do_action( 'beans_footer' );

					echo beans_close_markup( 'beans_fixed_wrap[_footer]', 'div' );

				echo beans_close_markup( 'beans_footer', 'footer' );

		echo beans_close_markup( 'beans_site', 'div' );

		// Keep it for plugins.
		wp_footer();

	echo beans_close_markup( 'beans_body', 'body' );

echo beans_close_markup( 'beans_html', 'html' );