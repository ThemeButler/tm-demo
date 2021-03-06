<?php
/**
 * @package Beans\API\Fields
 */

beans_add_smart_action( 'beans_field_wrap_prepend_markup', 'beans_field_label' );

/**
 * Echo field label.
 *
 * @since 1.0.0
 *
 * @param array $field {
 *      Array of data.
 *
 *      @type string $label The field label. Default false.
 * }
 */
function beans_field_label( $field ) {

	if ( !$label = beans_get( 'label', $field ) )
		return;

	echo beans_open_markup( 'beans_field_label', 'label' );

		echo $field['label'];

	echo beans_close_markup( 'beans_field_label', 'label' );

}


beans_add_smart_action( 'beans_field_wrap_append_markup', 'beans_field_description' );

/**
 * Echo field description.
 *
 * @since 1.0.0
 *
 * @param array $field {
 *      Array of data.
 *
 *      @type string $description The field description. The description can be truncated using <!--more-->
 *            					  as a delimiter. Default false.
 * }
 */
function beans_field_description( $field ) {

	if ( !$description = beans_get( 'description', $field ) )
		return;

	echo beans_open_markup( 'beans_field_description', 'div', array( 'class' => 'bs-field-description' ) );

		if ( preg_match( '#<!--more-->#', $description, $matches ) )
			list( $description, $extended ) = explode( $matches[0], $description, 2 );

		echo $description;

		if ( isset( $extended ) ) {

			echo '&nbsp;<a class="bs-read-more" href="#">' . __( 'More...', 'beans' ) . '</a>';
			echo '<div class="bs-extended-content">' . $extended . '</div>';

		}

	echo beans_close_markup( 'beans_field_description', 'div' );

}