<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AJAX callback for date conversion
 *
 * @since 1.0.0
 */
add_action( 'wp_ajax_nepali_date_converter_ajax', 'ndc_ajax_callback' );
add_action( 'wp_ajax_nopriv_nepali_date_converter_ajax', 'ndc_ajax_callback' );

if ( ! function_exists( 'ndc_ajax_callback' ) ) :

	/**
	 * AJAX callback for date conversion
	 *
	 * @since 1.0.0
	 */
	function ndc_ajax_callback() {
		// Verify nonce first.
		check_ajax_referer( 'ndc_ajax_nonce', 'security' );

		// Unslash and sanitize all input data.
		$from          = isset( $_POST['from'] ) ? sanitize_text_field( wp_unslash( $_POST['from'] ) ) : '';
		$year          = isset( $_POST['year'] ) ? absint( wp_unslash( $_POST['year'] ) ) : 0;
		$month         = isset( $_POST['month'] ) ? absint( wp_unslash( $_POST['month'] ) ) : 0;
		$day           = isset( $_POST['day'] ) ? absint( wp_unslash( $_POST['day'] ) ) : 0;
		$result_format = isset( $_POST['result_format'] ) ? sanitize_text_field( wp_unslash( $_POST['result_format'] ) ) : 'D, F j, Y';

		// Validate required fields.
		if ( empty( $from ) || ! in_array( $from, array( 'from-eng', 'from-nep' ), true ) || empty( $year ) || empty( $month ) || empty( $day ) ) {
			wp_send_json_error( __( 'Invalid request parameters', 'nepali-date-converter' ) );
		}

		$date = array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day,
		);

		try {
			if ( 'from-eng' === $from ) {
				$lang   = isset( $_POST['lang'] ) ? sanitize_text_field( wp_unslash( $_POST['lang'] ) ) : 'nep_char';
				$result = ndc_eng_to_nep_date( $date, $lang, $result_format );
			} else {
				$result = ndc_nep_to_eng_date( $date, $result_format );
			}

			if ( isset( $result['result'] ) ) {
				wp_send_json_success( wp_kses_post( $result['result'] ) );
			} else {
				wp_send_json_error( __( 'Conversion failed', 'nepali-date-converter' ) );
			}
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}

		wp_die();
	}
endif;
