<?php
/**
 * Loads Beans's template parts.
 *
 * The templates parts contain the structural markup and hooks to which the fragments are attached.
 *
 * @package Beans\Render\Template_Parts
 */

beans_add_smart_action( 'beans_load_document', 'beans_header_template', 5 );

/**
 * Echo header template part.
 *
 * @since 1.0.0
 */
function beans_header_template() {

	get_header();

}


beans_add_smart_action( 'beans_load_document', 'beans_content_template' );

/**
 * Echo main content template part.
 *
 * @since 1.0.0
 */
function beans_content_template() {

	// Allow overwrite.
	if ( locate_template( 'content.php', true ) != '' )
		return;

	require_once( BEANS_STRUCTURE_PATH . 'content.php' );

}


beans_add_smart_action( 'beans_content', 'beans_loop_template' );

/**
 * Echo loop template part.
 *
 * @since 1.0.0
 */
function beans_loop_template() {

	// Only run new query if a filter is set.
	if ( $_has_filter = has_filter( 'beans_loop_query_args' ) ) :

		global $wp_query;

		/**
	     * Filter the beans loop query. This can be used for custom queries.
	     *
	     * @since 1.0.0
	     */
	    if ( $args = apply_filters( 'beans_loop_query_args', false ) )
			$wp_query = new WP_Query( $args );

	endif;

	// Allow overwrite.
	if ( locate_template( 'loop.php', true ) != '' )
		return;

	require_once( BEANS_STRUCTURE_PATH . 'loop.php' );

	// Only reset the query if a filter is set.
	if ( $_has_filter )
		wp_reset_query();

}


beans_add_smart_action( 'beans_post_after_markup', 'beans_comments_template', 15 );

/**
 * Echo comments template part.
 *
 * The comments template part only loads if comments are active to prevent unnecessary memory usage.
 *
 * @since 1.0.0
 */
function beans_comments_template() {

	global $post;

	if ( !post_type_supports( beans_get( 'post_type', $post ), 'comments' ) )
		return;

	comments_template();

}


beans_add_smart_action( 'beans_comment', 'beans_comment_template' );

/**
 * Echo comment template part.
 *
 * @since 1.0.0
 */
function beans_comment_template() {

	// Allow overwrite.
	if ( locate_template( 'comment.php', true, false ) != '' )
		return;

	require( BEANS_STRUCTURE_PATH . 'comment.php' );

}


beans_add_smart_action( 'beans_widget_area', 'beans_widget_area_template' );

/**
 * Echo widget area template part.
 *
 * @since 1.0.0
 */
function beans_widget_area_template() {

	// Allow overwrite.
	if ( locate_template( 'widget-area.php', true, false ) != '' )
		return;

	require( BEANS_STRUCTURE_PATH . 'widget-area.php' );

}


beans_add_smart_action( 'beans_primary_after_markup', 'beans_sidebar_primary_template' );

/**
 * Echo primary sidebar template part.
 *
 * The primary sidebar template part only loads if the layout set includes it, thus prevent unnecessary memory usage.
 *
 * @since 1.0.0
 */
function beans_sidebar_primary_template() {

	if ( stripos( beans_get_layout(), 'sp' ) === false || !beans_has_widget_area( 'sidebar_primary' ) )
		return;

	get_sidebar( 'primary' );

}


beans_add_smart_action( 'beans_primary_after_markup', 'beans_sidebar_secondary_template' );

/**
 * Echo secondary sidebar template part.
 *
 * The secondary sidebar template part only loads if the layout set includes it, thus prevent unnecessary memory usage.
 *
 * @since 1.0.0
 */
function beans_sidebar_secondary_template() {

	if ( stripos( beans_get_layout(), 'ss' ) === false || !beans_has_widget_area( 'sidebar_secondary' ) )
		return;

	get_sidebar( 'secondary' );

}


beans_add_smart_action( 'beans_load_document', 'beans_footer_template' );

/**
 * Echo footer template part.
 *
 * @since 1.0.0
 */
function beans_footer_template() {

	get_footer();

}