<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Today's Date Shortcode for Nepali Date Converter
 *
 * @package Nepali Date Converter
 * @since 1.0.0
 */
add_shortcode( 'ndc-today-date', 'ndc_today_shortcode' );

if ( ! function_exists( 'ndc_today_shortcode' ) ) :
	/**
	 * Shortcode handler for displaying today's date in both Nepali and English
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output
	 */
	function ndc_today_shortcode( $atts ) {
		// Default attributes.
		$defaults = array(
			'before'                 => '',
			'after'                  => '',
			'before_title'           => '',
			'after_title'            => '',
			'title'                  => __( 'Date', 'nepali-date-converter' ),
			'disable_today_nep_date' => '',
			'disable_today_eng_date' => '',
			'nepali_date_lang'       => 'nep_char',
			'result_format'          => 'D, F j, Y',
		);

		// Parse attributes with defaults.
		$args = shortcode_atts( $defaults, $atts );

		// Sanitize attributes based on their content type.
		$html_attributes = array(
			'before',
			'after',
			'before_title',
			'after_title',
			'title',
		);

		$text_attributes = array(
			'nepali_date_lang',
			'result_format',
		);

		$bool_attributes = array(
			'disable_today_nep_date',
			'disable_today_eng_date',
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

		// Add nonce field for security (if form submission is involved).
		wp_nonce_field( 'ndc_today_date_action', 'ndc_today_nonce' );

		// Display today's date.
		$front_date_converter->today_date(
			array(
				'before'                 => $args['before'],
				'after'                  => $args['after'],
				'before_title'           => $args['before_title'],
				'after_title'            => $args['after_title'],
				'title'                  => $args['title'],
				'disable_today_nep_date' => $args['disable_today_nep_date'],
				'disable_today_eng_date' => $args['disable_today_eng_date'],
				'nepali_date_lang'       => $args['nepali_date_lang'],
				'result_format'          => $args['result_format'],
			)
		);

		// Get the buffered content.
		$content = ob_get_clean();

		return $content;
	}
endif;
