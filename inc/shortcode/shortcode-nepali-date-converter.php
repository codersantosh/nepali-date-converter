<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nepali Date Converter Shortcode
 *
 * @package Nepali Date Converter
 * @since 1.0.0
 */
add_shortcode( 'nepali-date-converter', 'ndc_shortcode' );


if ( ! function_exists( 'ndc_shortcode' ) ) :
	/**
	 * Shortcode handler for Nepali Date Converter
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output
	 */
	function ndc_shortcode( $atts ) {
		// Default attributes.
		$defaults = array(
			'before'                         => '',
			'after'                          => '',
			'before_title'                   => '',
			'after_title'                    => '',
			'title'                          => __( 'Nepali Date Converter', 'nepali-date-converter' ),
			'disable_ndc_convert_nep_to_eng' => '',
			'disable_ndc_convert_eng_to_nep' => '',
			'nep_to_eng_button_text'         => __( 'Nepali to English', 'nepali-date-converter' ),
			'eng_to_nep_button_text'         => __( 'English to Nepali', 'nepali-date-converter' ),
			'result_format'                  => 'D, F j, Y',
			'nepali_date_lang'               => 'nep_char',
		);

		// Parse attributes with defaults.
		$args = shortcode_atts( $defaults, $atts );

		// Sanitize attributes based on their content type.
		$html_attributes = array(
			'before',
			'after',
			'before_title',
			'after_title',
		);

		$text_attributes = array(
			'title',
			'nep_to_eng_button_text',
			'eng_to_nep_button_text',
			'result_format',
			'nepali_date_lang',
		);

		$bool_attributes = array(
			'disable_ndc_convert_nep_to_eng',
			'disable_ndc_convert_eng_to_nep',
		);

		// Sanitize HTML attributes.
		foreach ( $html_attributes as $attr ) {
			$args[ $attr ] = wp_kses_post( $args[ $attr ] );
		}

		// Sanitize text attributes.
		foreach ( $text_attributes as $attr ) {
			$args[ $attr ] = sanitize_text_field( $args[ $attr ] );
		}

		// Sanitize boolean attributes.
		foreach ( $bool_attributes as $attr ) {
			$args[ $attr ] = ! empty( $args[ $attr ] ) ? '1' : '';
		}

		// Start output buffering.
		ob_start();

		// Get the frontend converter instance.
		$front_date_converter = ndc_frontend();

		// Add nonce field for security.
		wp_nonce_field( 'ndc_date_conversion', 'ndc_nonce' );

		// Display the converter.
		$front_date_converter->nepali_date_converter(
			array(
				'before'                         => $args['before'],
				'after'                          => $args['after'],
				'before_title'                   => $args['before_title'],
				'after_title'                    => $args['after_title'],
				'title'                          => $args['title'],
				'disable_ndc_convert_nep_to_eng' => $args['disable_ndc_convert_nep_to_eng'],
				'disable_ndc_convert_eng_to_nep' => $args['disable_ndc_convert_eng_to_nep'],
				'nep_to_eng_button_text'         => $args['nep_to_eng_button_text'],
				'eng_to_nep_button_text'         => $args['eng_to_nep_button_text'],
				'result_format'                  => $args['result_format'],
				'nepali_date_lang'               => $args['nepali_date_lang'],
			)
		);

		// Get the buffered content.
		$content = ob_get_clean();

		return $content;
	}
endif;
