<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper functions for Nepali Date Converter
 *
 * @package Nepali Date Converter
 * @since 1.1.0
 */

if ( ! function_exists( 'ndc_array_key_exists' ) ) {
	/**
	 * Check if multiple keys exist in an array.
	 *
	 * @param array $keys        Array of keys to check.
	 * @param array $target_array The array to check against.
	 * @return bool True if all keys exist, false otherwise.
	 * @since 1.1.0
	 */
	function ndc_array_key_exists( array $keys, array $target_array ): bool {
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $target_array ) ) {
				return false;
			}
		}
		return true;
	}
}

if ( ! function_exists( 'ndc_eng_to_nep_date' ) ) {
	/**
	 * Convert English date to Nepali date (array input)
	 *
	 * @param array  $input_date Date array with year, month, day keys.
	 * @param string $date_format Output format ('nep_char' or 'eng_char').
	 * @param string $format PHP date format string.
	 * @return array|string Converted date data or error message
	 * @since 1.1.0
	 */
	function ndc_eng_to_nep_date( array $input_date, string $date_format = 'nep_char', string $format = 'D, F j, Y' ) {
		if ( ! ndc_array_key_exists( array( 'year', 'month', 'day' ), $input_date ) ) {
			return sprintf(
				// translators: %s example array..
				__( 'Invalid array provided, please pass array in this format: %s', 'nepali-date-converter' ),
				'array( "year"=>"2015","month"=>"09","day"=>"11" )'
			);
		}
		return ndc_nepali_calendar()->eng_to_nep( $input_date, trim( $date_format ), $format );
	}
}

if ( ! function_exists( 'ndc_convert_eng_to_nep' ) ) {
	/**
	 * Convert English date to Nepali date (string input)
	 *
	 * @param string $input_date_str Date string in Y-m-d format.
	 * @param string $date_format Output format ('nep_char' or 'eng_char').
	 * @param string $format PHP date format string.
	 * @return array Converted date data.
	 * @since 1.1.0
	 */
	function ndc_convert_eng_to_nep( string $input_date_str, string $date_format = 'nep_char', string $format = 'D, F j, Y' ): array {
		$parts = explode( '-', trim( $input_date_str ) );
		return ndc_nepali_calendar()->eng_to_nep(
			array(
				'year'  => (int) $parts[0],
				'month' => (int) $parts[1],
				'day'   => (int) $parts[2],
			),
			trim( $date_format ),
			$format
		);
	}
}

if ( ! function_exists( 'ndc_nep_to_eng_date' ) ) {
	/**
	 * Convert Nepali date to English date (array input)
	 *
	 * @param array  $input_date Date array with year, month, day keys.
	 * @param string $format PHP date format string.
	 * @return array|string Converted date data or error message
	 * @since 1.1.0
	 */
	function ndc_nep_to_eng_date( array $input_date, string $format = 'D, F j, Y' ) {
		if ( ! ndc_array_key_exists( array( 'year', 'month', 'day' ), $input_date ) ) {
			return sprintf(
				// translators: %s example array..
				__( 'Invalid array provided, please pass array in this format: %s', 'nepali-date-converter' ),
				'array( "year"=>"2015","month"=>"09","day"=>"11" )'
			);
		}
		return ndc_nepali_calendar()->nep_to_eng( $input_date, $format );
	}
}

if ( ! function_exists( 'ndc_convert_nep_to_eng' ) ) {
	/**
	 * Convert Nepali date to English date (string input)
	 *
	 * @param string $input_date_str Date string in Y-m-d format.
	 * @param string $format PHP date format string.
	 * @return array Converted date data.
	 * @since 1.1.0
	 */
	function ndc_convert_nep_to_eng( string $input_date_str, string $format = 'D, F j, Y' ): array {
		$parts = explode( '-', trim( $input_date_str ) );
		return ndc_nepali_calendar()->nep_to_eng(
			array(
				'year'  => (int) $parts[0],
				'month' => (int) $parts[1],
				'day'   => (int) $parts[2],
			),
			$format
		);
	}
}


if ( ! function_exists( 'ndc_human_time_diff' ) ) {
	/**
	 * Get human-readable time difference in Nepali
	 *
	 * @see  https://developer.wordpress.org/reference/functions/human_time_diff/
	 * @param int $from Unix timestamp.
	 * @param int $to Optional. Unix timestamp (default: current time).
	 * @return string Formatted time difference
	 * @since 2.0.1
	 */
	function ndc_human_time_diff( int $from, int $to = 0 ): string {
		if ( empty( $to ) ) {
			$to = time();
		}
		$diff = (int) abs( $to - $from );

		switch ( true ) {
			case $diff < MINUTE_IN_SECONDS:
				$secs  = max( $diff, 1 );
				$since = sprintf( '%s सेकेन्ड', $secs );
				break;
			case $diff < HOUR_IN_SECONDS:
				$mins  = max( round( $diff / MINUTE_IN_SECONDS ), 1 );
				$since = sprintf( '%s मिनेट', $mins );
				break;
			case $diff < DAY_IN_SECONDS:
				$hours = max( round( $diff / HOUR_IN_SECONDS ), 1 );
				$since = sprintf( '%s घण्टा', $hours );
				break;
			case $diff < WEEK_IN_SECONDS:
				$days  = max( round( $diff / DAY_IN_SECONDS ), 1 );
				$since = sprintf( '%s दिन', $days );
				break;
			case $diff < MONTH_IN_SECONDS:
				$weeks = max( round( $diff / WEEK_IN_SECONDS ), 1 );
				$since = sprintf( '%s हप्ता', $weeks );
				break;
			case $diff < YEAR_IN_SECONDS:
				$months = max( round( $diff / MONTH_IN_SECONDS ), 1 );
				$since  = sprintf( '%s महिना', $months );
				break;
			default:
				$years = max( round( $diff / YEAR_IN_SECONDS ), 1 );
				$since = sprintf( '%s वर्ष', $years );
		}

		/*
		* Note: We are not using _n() here because in Nepali language,
		* the singular and plural forms of these time units (सेकेन्ड, मिनेट, etc.)
		* are the same. Therefore, pluralization is not necessary.
		*/

		/* Convert numbers to Nepali */
		$since = strtr( $since, ndc_nepali_calendar()->eng_nep_num );

		/**
		 * Filters the human readable difference between two timestamps.
		 *
		 * @since 4.0.0
		 *
		 * @param string $since The difference in human readable text.
		 * @param int    $diff  The difference in seconds.
		 * @param int    $from  Unix timestamp from which the difference begins.
		 * @param int    $to    Unix timestamp to end the time difference.
		 */
		return apply_filters( 'ndc_human_time_diff', $since, $diff, $from, $to );
	}

}

if ( ! function_exists( 'ndc_get_post_types' ) ) {
	/**
	 * Get filtered list of post types
	 *
	 * @param array $args WP_Query args.
	 * @param array $excludes Post types to exclude.
	 * @param array $includes Post types to force include.
	 * @return array List of post types with value/label pairs
	 * @since 2.1.0
	 */
	function ndc_get_post_types( array $args = array( 'public' => true ), array $excludes = array(), array $includes = array() ): array {
		$post_types       = get_post_types( $args, 'objects' );
		$default_excludes = array( 'edd_wish_list', 'elementor_library' );

		$exclude_pt = array_unique( array_merge( $default_excludes, $excludes ) );
		$exclude_pt = array_diff( $exclude_pt, $includes );
		$exclude_pt = apply_filters( 'ndc_get_post_types', $exclude_pt, $excludes, $includes );

		$options = array();
		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name, $exclude_pt, true ) ) {
				continue;
			}
			$options[] = array(
				'value' => $post_type->name,
				'label' => $post_type->label,
			);
		}
		return $options;
	}
}
