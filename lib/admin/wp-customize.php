<?php
/**
 * Add Beans options to the WordPress Customizer.
 *
 * @package Beans\Admin
 */

beans_add_smart_action( 'customize_preview_init', 'beans_do_enqueue_wp_customize_assets' );

/**
 * Enqueue Beans assets for the WordPress Customizer.
 *
 * @since 1.0.0
 */
function beans_do_enqueue_wp_customize_assets() {

	wp_enqueue_script( 'beans-wp-customize-preview', BEANS_ADMIN_JS_URL . 'wp-customize-preview.js', array( 'jquery', 'customize-preview' ), BEANS_VERSION, true );

}


beans_add_smart_action( 'init', 'beans_do_register_wp_customize_options' );

/**
 * Add Beans options to the WordPress Customizer.
 *
 * @since 1.0.0
 */
function beans_do_register_wp_customize_options() {

	$fields = array(
		array(
			'id' => 'beans_logo_image',
			'label' => __( 'Logo Image', 'beans' ),
			'type' => 'WP_Customize_Image_Control',
			'transport' => 'refresh'
		)
	);

	beans_register_wp_customize_options( $fields, 'title_tagline', array( 'title' => __( 'Branding', 'beans' ) ) );

	// Get layout option without default for the count.
	$options = beans_get_layouts_for_options();

	// Only show the layout options if more than two layouts are registered.
	if ( count( $options ) > 2 ) {

		$fields = array(
			array(
				'id' => 'beans_layout',
				'label' => __( 'Default Layout', 'beans' ),
				'type' => 'radio',
				'default' => beans_get_default_layout(),
				'options' => $options,
				'transport' => 'refresh'
			)
		);

		beans_register_wp_customize_options( $fields, 'beans_layout', array( 'title' => __( 'Default Layout', 'beans' ), 'priority' => 1000 ) );

	}

	$fields = array(
		array(
			'id' => 'beans_viewport_width_group',
			'label' => __( 'Viewport Width', 'beans' ),
			'type' => 'group',
			'fields' => array(
				array(
					'id' => 'beans_enable_viewport_width',
					'type' => 'activation',
					'default' => false
				),
				array(
					'id' => 'beans_viewport_width',
					'type' => 'slider',
					'default' => 1000,
					'min' => 300,
					'max' => 2500,
					'interval' => 10,
					'unit' => 'px'
				),
			)
		),
		array(
			'id' => 'beans_viewport_height_group',
			'label' => __( 'Viewport Height', 'beans' ),
			'type' => 'group',
			'fields' => array(
				array(
					'id' => 'beans_enable_viewport_height',
					'type' => 'activation',
					'default' => false
				),
				array(
					'id' => 'beans_viewport_height',
					'type' => 'slider',
					'default' => 1000,
					'min' => 300,
					'max' => 2500,
					'interval' => 10,
					'unit' => 'px'
				),
			)
		)
	);

	beans_register_wp_customize_options( $fields, 'beans_preview', array( 'title' => __( 'Preview Tools', 'beans' ), 'priority' => 1010 ) );

}