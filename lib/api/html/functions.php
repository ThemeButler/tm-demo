<?php
/**
 * The Beans HTML component contains a powerful set of functions to create flexible and easy overwritable HTML markup,
 * attributes and content.
 *
 * @package Beans\API\HTML
 */

/**
 * Register output by ID.
 *
 * The output can be modified using the available Beans HTML "output" functions.
 *
 * HTML comments containing the ID are added before and after the output if BEANS_HTML_DEV_MODE is set
 * to true. This makes it very easy to find a content ID when inspecting an element in your web browser.
 *
 * Since this function uses {@see beans_apply_filters()}, the $id argument may contain sub-hook(s).
 *
 * @since 1.0.0
 *
 * @param string $id     A unique string used as a reference. The $id argument may contain sub-hook(s).
 * @param string $output Content to output.
 * @param mixed  $var    Additional variables passed to the functions hooked to <tt>$id</tt>.
 *
 * @return string The output.
 */
function beans_output( $id, $output ) {

	$args = func_get_args();
	$args[0] = $id . '_output';

	$output = call_user_func_array( 'beans_apply_filters', $args );

	if ( empty( $output ) )
		return;

	if ( BEANS_HTML_DEV_MODE )
		$output = "<!-- open output: $id -->" . $output . "<!-- close output: $id -->";

	return $output;

}


/**
 * Remove output.
 *
 * HTML comments containing the ID are added before and after the output if BEANS_HTML_DEV_MODE is set
 * to true. This makes it very easy to find a content ID when inspecting an element in your web browser.
 *
 * @since 1.0.0
 *
 * @param string $id The output ID.
 *
 * @return bool Will always return true.
 */
function beans_remove_output( $id ) {

	return beans_add_filter( $id . '_output', false );

}


/**
 * Register open markup and attributes by ID.
 *
 * The Beans HTML "markups" and "attributes" functions make it really easy to modify, replace, extend,
 * remove or hook into registered markup or attributes.
 *
 * The "data-markup-id" is added as a HTML attribute if BEANS_HTML_DEV_MODE is set to true. This makes it very
 * easy to find the content ID when inspecting an element in a web browser.
 *
 * Since this function uses {@see beans_apply_filters()}, the $id argument may contain sub-hook(s).
 *
 * @since 1.0.0
 *
 * @param string $id               A unique string used as a reference. The $id argument may contain sub-filter(s).
 * @param string|bool $tag         The HTML tag. If set to False or empty, the markup HTML tag will be removed but
 *                                 the actions hook will be called. If set the Null, both markup HTML tag and actions
 *                                 hooks will be removed.
 * @param string|array $attributes Optional. Query string or array of attributes. The array key defines the
 *                                 attribute name and the array value defines the attribute value. Setting
 *                                 the array value to '' will display the attribute value as empty
 *                                 (e.g. class=""). Setting it to 'false' will only display
 *                                 the attribute name (e.g. data-example). Setting it to 'null' will not
 *                                 display anything.
 * @param mixed  $var              Additional variables passed to the functions hooked to <tt>$id</tt>.
 *
 * @return string The output.
 */
function beans_open_markup( $id, $tag, $attributes = array() ) {

	global $_temp_beans_selfclose_markup;

	$args = func_get_args();
	$attributes_args = $args;

	// Set markup tag filter id.
	$args[0] = $id . '_markup';

	if ( isset( $args[2] ) )
		unset( $args[2] );

	// Remove function $tag argument.
	unset( $attributes_args[1] );

	// Stop here if the tag is set to false, the before and after actions won't run in this case.
	if ( ( $tag = call_user_func_array( 'beans_apply_filters', $args ) ) === null )
		return;

	// Remove function $tag argument.
	unset( $args[1] );

	// Set before action id.
	$args[0] = $id . '_before_markup';

	$output = call_user_func_array( '_beans_render_action', $args );

		// Don't output the tag if empty, the before and after actions still run.
		if ( $tag )
			$output .= '<' . $tag . ' ' . call_user_func_array( 'beans_add_attributes', $attributes_args ) . ( BEANS_HTML_DEV_MODE ? ' data-markup-id="' . $id . '"' : null ) . ( $_temp_beans_selfclose_markup ? '/' : '' ) . '>';

	// Set after action id.
	$args[0] = $id . ( $_temp_beans_selfclose_markup ? '_after_markup' : '_prepend_markup' );

	$output .= call_user_func_array( '_beans_render_action', $args );

	// Reset temp selfclose global to reduce memory usage.
	unset( $GLOBALS['_temp_beans_selfclose_markup'] );

	return $output;

}


/**
 * Register self-close markup and attributes by ID.
 *
 * This function is shortuct of {@see beans_open_markup()}. It should be used for self-closed HTML markup such as
 * images or inputs.
 *
 * @since 1.0.0
 *
 * @param string $id               A unique string used as a reference. The $id argument may contain sub-hook(s).
 * @param string|bool $tag         The HTML self-close tag.If set to False or empty, the markup HTML tag will
 *                                 be removed but the actions hook will be called. If set the Null, both
 *                                 markup HTML tag and actions hooks will be removed.
 * @param string|array $attributes Optional. Query string or array of attributes. The array key defines the
 *                                 attribute name and the array value defines the attribute value. Setting
 *                                 the array value to '' will display the attribute value as empty
 *                                 (e.g. class=""). Setting it to 'false' will only display
 *                                 the attribute name (e.g. data-example). Setting it to 'null' will not
 *                                 display anything.
 * @param mixed  $var              Additional variables passed to the functions hooked to <tt>$id</tt>.
 *
 * @return string The output.
 */
function beans_selfclose_markup( $id, $tag, $attributes = array() ) {

	global $_temp_beans_selfclose_markup;

	$_temp_beans_selfclose_markup = true;

	return call_user_func_array( 'beans_open_markup', func_get_args() );

}


/**
 * Register close markup.
 *
 * This function is similar to {@see beans_open_markup()}, but does not accept HTML attributes. The $id
 * argument must be the identical to the opening markup.
 *
 * @since 1.0.0
 *
 * @param string $id  Identical to the opening markup ID.
 * @param string $tag The HTML tag.
 * @param mixed  $var Additional variables passed to the functions hooked to <tt>$id</tt>.
 *
 * @return string The output.
 */
function beans_close_markup( $id, $tag ) {

	// Stop here if the tag is set to false, the before and after actions won't run in this case.
	if ( ( $tag = beans_apply_filters( $id . '_markup', $tag ) ) === null )
		return;

	$args = func_get_args();

	// Remove function $tag argument.
	unset( $args[1] );

	// Set before action id.
	$args[0] = $id . '_append_markup';

	$output = call_user_func_array( '_beans_render_action', $args );

		// Don't output the tag if empty, the before and after actions still run.
		if ( $tag )
			$output .= '</' . $tag . '>';

	// Set after action id.
	$args[0] = $id . '_after_markup';

	$output .= call_user_func_array( '_beans_render_action', $args );

	return $output;

}


/**
 * Modify opening and closing HTML tag. Also works for self-closed markup.
 *
 * This function will automatically modify the opening and the closing HTML tag. If the markup is self-closed,
 * the HTML tag will be modified accordingly.
 *
 * The "data-markup-id" is added as a HTML attribute if BEANS_HTML_DEV_MODE is set to true. This makes it very
 * easy to find the content ID when inspecting an element in a web browser.
 *
 * @since 1.0.0
 *
 * @param string          $id       The markup ID.
 * @param string|callback $markup   The replacment HTML tag. A callback is accepted if conditions needs
 *                                  to be applied. If arguments are available, they are passed to the callback.
 * @param int             $priority Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed. Default 10.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action.
 * @param int              $args    Optional. The number of arguments the function accepts. Default 1.
 *
 * @return bool Will always return true.
 */
function beans_modify_markup( $id, $markup, $priority = 10, $args = 1 ) {

	return beans_add_filter( $id . '_markup', $markup, $priority, $args );

}


/**
 * Remove markup.
 *
 * This function will automatically remove the opening and the closing HTML tag. If the markup is self-closed,
 * the HTML tag will be removed accordingly.
 *
 * The "data-markup-id" is added as a HTML attribute if BEANS_HTML_DEV_MODE is set to true. This makes it very
 * easy to find the content ID when inspecting an element in a web browser.
 *
 * @since 1.0.0
 *
 * @param string $id             The markup ID.
 * @param bool   $remove_actions Whether elements attached to a markup should be removed or not. This must be used
 * with absolute caution.
 *
 * @return bool Will always return true.
 */
function beans_remove_markup( $id, $remove_actions = false ) {

	if ( $remove_actions )
		return beans_add_filter( $id . '_markup', null );

	return beans_add_filter( $id . '_markup', false );

}


/**
 * Wrap markup.
 *
 * This function calls {@see beans_open_markup()} before the opening markup and
 * {@see beans_close_markup()} after the closing markup.
 *
 * @since 1.0.0
 *
 * @param string $id               The markup ID.
 * @param string $new_id           A unique string used as a reference. The $id argument may contain sub-hook(s).
 * @param string $tag              The HTML wrap tag.
 * @param string|array $attributes Optional. Query string or array of attributes. The array key defines the
 *                                 attribute name and the array value define the attribute value. Setting
 *                                 the array value to '' will display the attribute value as empty
 *                                 (e.g. class=""). Setting it to 'false' will only display
 *                                 the attribute name (e.g. data-example). Setting it to 'null' will not
 *                                 display anything.
 * @param mixed  $var              Additional variables passed to the functions hooked to <tt>$id</tt>.
 *
 * @return bool Will always return true.
 */
function beans_wrap_markup( $id, $new_id, $tag, $attributes = array() ) {

	$args = func_get_args();
	unset( $args[0] );

	_beans_add_anonymous_action( $id . '_before_markup', array( 'beans_open_markup', $args ), 9999 );

	unset( $args[3] );

	_beans_add_anonymous_action( $id . '_after_markup', array( 'beans_close_markup', $args ), 1 );

	return true;

}


/**
 * Wrap markup inner content.
 *
 * This function calls {@see beans_open_markup()} after the opening markup and
 * {@see beans_close_markup()} before the closing markup.
 *
 * @since 1.0.0
 *
 * @param string $id               The markup ID.
 * @param string $new_id           A unique string used as a reference. The $id argument may contain sub-hook(s).
 * @param string $tag              The HTML wrap tag.
 * @param string|array $attributes Optional. Query string or array of attributes. The array key defines the
 *                                 attribute name and the array value define the attribute value. Setting
 *                                 the array value to '' will display the attribute value as empty
 *                                 (e.g. class=""). Setting it to 'false' will only display
 *                                 the attribute name (e.g. data-example). Setting it to 'null' will not
 *                                 display anything.
 * @param mixed  $var              Additional variables passed to the functions hooked to <tt>$id</tt>.
 *
 * @return bool Will always return true.
 */
function beans_wrap_inner_markup( $id, $new_id, $tag, $attributes = array() ) {

	$args = func_get_args();
	unset( $args[0] );

	_beans_add_anonymous_action( $id . '_prepend_markup', array( 'beans_open_markup', $args ), 1 );

	unset( $args[3] );

	_beans_add_anonymous_action( $id . '_append_markup', array( 'beans_close_markup', $args ), 9999 );

	return true;

}


/**
 * Register attributes by ID.
 *
 * The Beans HTML "attributes" functions make it really easy to modify, replace, extend,
 * remove or hook into registered attributes.
 *
 * Since this function uses {@see beans_apply_filters()}, the $id argument may contain sub-hook(s).
 *
 * @since 1.0.0
 *
 * @param string $id               A unique string used as a reference. The $id argument may contain sub-hook(s).
 * @param string|array $attributes Optional. Query string or array of attributes. The array key defines the
 *                                 attribute name and the array value define the attribute value. Setting
 *                                 the array value to '' will display the attribute value as empty
 *                                 (e.g. class=""). Setting it to 'false' will only display
 *                                 the attribute name (e.g. data-example). Setting it to 'null' will not
 *                                 display anything.
 * @param mixed  $var              Additional variables passed to the functions hooked to <tt>$id</tt>.
 *
 * @return string The HTML attributes.
 */
function beans_add_attributes( $id, $attributes = array() ) {

	$args = func_get_args();
	$args[0] = $id . '_attributes';

	if ( !isset( $args[1] ) )
		$args[1] = array();

	$args[1] = wp_parse_args( $args[1] );

	$attributes = call_user_func_array( 'beans_apply_filters', $args );

	return beans_sanatize_attributes( $attributes );

}


/**
 * Add attribute to markup.
 *
 * This function must be called before the targeted markup is called.
 *
 * The "data-markup-id" is added as a HTML attribute if BEANS_HTML_DEV_MODE is set to true. This makes it very
 * easy to find the content ID when inspecting an element in a web browser.
 *
 * @since 1.0.0
 *
 * @param string $id        The markup ID.
 * @param string $attribute Name of the HTML attribute.
 * @param string $value     Value of the HTML attribute. If set to '' will display the attribute value as empty
 *                          (e.g. class=""). Setting it to 'false' will only display the attribute name
 *                          (e.g. data-example). Setting it to 'null' will not display anything.
 *
 * @return array All targeted markup attributes.
 */
function beans_add_attribute( $id, $attribute, $value ) {

	$class = new _Beans_Attributes( $id, $attribute, $value );

	return $class->init( 'add' );

}


/**
 * Replace attribute to markup.
 *
 * This function must be called before the targeted markup is called.
 *
 * The "data-markup-id" is added as a HTML attribute if BEANS_HTML_DEV_MODE is set to true. This makes it very
 * easy to find the content ID when inspecting an element in a web browser.
 *
 * @since 1.0.0
 *
 * @param string $id        The markup ID.
 * @param string $attribute Name of the HTML attribute to target.
 * @param string $value     Value which should be replaced.
 * @param string $new_value Replacement value. If set to '' will display the attribute value as empty
 *                          (e.g. class=""). Setting it to 'false' will only display the attribute name
 *                          (e.g. data-example). Setting it to 'null' will not display anything.
 *
 * @return array All targeted markup attributes.
 */
function beans_replace_attribute( $id, $attribute, $value, $new_value = null ) {

	$class = new _Beans_Attributes( $id, $attribute, $value, $new_value );

	return $class->init( 'replace' );

}


/**
 * Remove markup attribute.
 *
 * This function must be called before the targeted markup is called.
 *
 * The "data-markup-id" is added as a HTML attribute if BEANS_HTML_DEV_MODE is set to true. This makes it very
 * easy to find the content ID when inspecting an element in a web browser.
 *
 * @since 1.0.0
 *
 * @param string $id        The markup ID.
 * @param string $attribute Name of the HTML attribute to target.
 * @param string $value     Name of the value to remove. Set it to 'false' to completely remove the attribute.
 *
 * @return array All targeted markup attributes remaining.
 */
function beans_remove_attribute( $id, $attribute, $value = null ) {

	$class = new _Beans_Attributes( $id, $attribute, $value );

	return $class->init( 'remove' );

}