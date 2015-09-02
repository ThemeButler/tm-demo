<?php
/**
 * Echo the posts loop structural markup. It also calls the loop action hooks.
 *
 * @package Beans\Structure\Loop
 */

/**
 * Fires before the loop.
 *
 * This hook fires even if no post exists.
 *
 * @since 1.0.0
 */
do_action( 'beans_before_loop' );

	if ( have_posts() && !is_404() ) :

		/**
		 * Fires before posts loop.
		 *
		 * This hook fires if posts exist.
		 *
		 * @since 1.0.0
		 */
		do_action( 'beans_before_posts_loop' );

		while ( have_posts() ) : the_post();

			echo beans_open_markup( 'beans_post', 'article', array(
				'id' => get_the_ID(),
				'class' => implode( ' ', get_post_class( array( 'uk-article', 'uk-panel-box' ) ) )
			) );

				echo beans_open_markup( 'beans_post_header', 'header' );

					/**
					 * Fires in the post header.
					 *
					 * @since 1.0.0
					 */
					do_action( 'beans_post_header' );

				echo beans_close_markup( 'beans_post_header', 'header' );

				echo beans_open_markup( 'beans_post_body', 'div' );

					/**
					 * Fires in the post body.
					 *
					 * @since 1.0.0
					 */
					do_action( 'beans_post_body' );

				echo beans_close_markup( 'beans_post_body', 'div' );

			echo beans_close_markup( 'beans_post', 'article' );

		endwhile;

		/**
		 * Fires after the posts loop.
		 *
		 * This hook fires if posts exist.
		 *
		 * @since 1.0.0
		 */
		do_action( 'beans_after_posts_loop' );

	else :

		/**
		 * Fires if no posts exist.
		 *
		 * @since 1.0.0
		 */
		do_action( 'beans_no_post' );

	endif;

/**
 * Fires after the loop.
 *
 * This hook fires even if no post exists.
 *
 * @since 1.0.0
 */
do_action( 'beans_after_loop' );