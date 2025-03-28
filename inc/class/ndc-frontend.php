<?php // phpcs:ignore Class file names should be based on the class name with "class-" prepended.
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Frontend display handler.
 *
 * Handles all frontend display logic including date conversion UI and today's date display.
 *
 * @package Nepali Date Converter
 * @since 1.0.0
 */

if ( ! class_exists( 'NDC_Frontend' ) ) {
	/**
	 * Class NDC_Frontend
	 *
	 * Handles frontend display and Nepali date conversion functionality.
	 */
	class NDC_Frontend {

		/**
		 * Nepali month names.
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private const NEPALI_MONTHS = array(
			'बैशाख',
			'जेष्ठ',
			'असार',
			'साउन',
			'भदौ',
			'अशोज',
			'कार्तिक',
			'मंसिर',
			'पुस',
			'माघ',
			'फाल्गुन',
			'चैत्र',
		);

		/**
		 * English month names.
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private const ENGLISH_MONTHS = array(
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December',
		);

		/**
		 * Nepali day names.
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private const NEPALI_DAYS = array(
			'आइतवार',
			'सोमवार',
			'मङ्लबार',
			'बुधबार',
			'बिहिबार',
			'शुक्रबार',
			'शनिबार',
		);

		/**
		 * Default date format.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		private const DEFAULT_DATE_FORMAT = 'D, F j, Y';

		/**
		 * Default language setting.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		private const DEFAULT_LANGUAGE = 'nep_char';

		/**
		 * Singleton instance.
		 *
		 * @var NDC_Frontend|null
		 * @since 2.0.0
		 */
		private static $instance = null;

		/**
		 * Gets the singleton instance.
		 *
		 * @return NDC_Frontend
		 * @since 2.0.0
		 */
		public static function get_instance(): NDC_Frontend {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Converts a number to Nepali numeral.
		 *
		 * @param int|string $num Number to convert.
		 * @return string|false Nepali numeral or false on failure.
		 * @since 1.0.0
		 */
		public function get_nep_num( $num ) {
			if ( ! is_numeric( $num ) ) {
				return false;
			}

			return strtr( (string) $num, ndc_nepali_calendar()->eng_nep_num );
		}

		/**
		 * Gets Nepali month name by number.
		 *
		 * @param int $month_num Month number (1-12).
		 * @return string|false Month name or false if invalid.
		 * @since 1.0.0
		 */
		public function get_mahina( int $month_num ) {
			return self::NEPALI_MONTHS[ $month_num - 1 ] ?? false;
		}

		/**
		 * Gets English month name by number.
		 *
		 * @param int $month_num Month number (1-12).
		 * @return string|false Month name or false if invalid.
		 * @since 1.0.0
		 */
		public function get_months( int $month_num ) {
			return self::ENGLISH_MONTHS[ $month_num - 1 ] ?? false;
		}

		/**
		 * Gets Nepali day name by number.
		 *
		 * @param int $day_num Day number (1-7).
		 * @return string|false Day name or false if invalid.
		 * @since 1.0.0
		 */
		public function get_bar( int $day_num ) {
			return self::NEPALI_DAYS[ $day_num - 1 ] ?? false;
		}

		/**
		 * Displays the Nepali date converter interface.
		 *
		 * @param array $args {
		 *     Configuration arguments.
		 *
		 *     @type string $before           HTML before the converter.
		 *     @type string $before_title     HTML before the title.
		 *     @type string $title            Title text.
		 *     @type string $after_title      HTML after the title.
		 *     @type string $result_format    PHP date format for results.
		 *     @type string $nepali_date_lang Output language ('nep_char' or 'eng').
		 *     @type bool   $disable_ndc_convert_nep_to_eng Whether to disable Nep-to-Eng conversion.
		 *     @type bool   $disable_ndc_convert_eng_to_nep Whether to disable Eng-to-Nep conversion.
		 *     @type string $after            HTML after the converter.
		 * }
		 * @return void
		 * @since 1.0.0
		 */
		public function nepali_date_converter( array $args ): void {
			$args = wp_parse_args(
				$args,
				array(
					'result_format'    => self::DEFAULT_DATE_FORMAT,
					'nepali_date_lang' => self::DEFAULT_LANGUAGE,
				)
			);

			// Output before content if provided.
			$this->output_if_set( $args, 'before' );
			$this->output_if_set( $args, 'before_title' );
			$this->output_if_set( $args, 'title' );
			$this->output_if_set( $args, 'after_title' );

			// Get current dates.
			$current_eng_date = $this->get_current_english_date( $args['result_format'] );
			$current_nep_date = $this->get_current_nepali_date( $args );

			// Display conversion interfaces if not disabled.
			if ( empty( $args['disable_ndc_convert_nep_to_eng'] ) ) {
				$this->display_nep_to_eng_converter( $current_nep_date, $args['result_format'] );
			}

			if ( empty( $args['disable_ndc_convert_eng_to_nep'] ) ) {
				$this->display_eng_to_nep_converter( $current_eng_date, $args );
			}

			// Display result.
			printf(
				'<div class="nepali-date-converter-result">%s</div>',
				esc_html( $current_nep_date['result'] )
			);

			$this->output_if_set( $args, 'after' );
		}

		/**
		 * Displays today's date in both English and Nepali.
		 *
		 * @param array $args {
		 *     Configuration arguments.
		 *
		 *     @type string $before               HTML before the display.
		 *     @type string $before_title         HTML before the title.
		 *     @type string $title                Title text.
		 *     @type string $after_title          HTML after the title.
		 *     @type string $result_format        PHP date format for results.
		 *     @type string $nepali_date_lang     Output language ('nep_char' or 'eng').
		 *     @type bool   $disable_today_nep_date Whether to disable Nepali date display.
		 *     @type bool   $disable_today_eng_date Whether to disable English date display.
		 *     @type string $after                HTML after the display.
		 * }
		 * @return void
		 * @since 1.0.0
		 */
		public function today_date( array $args ): void {
			$args = wp_parse_args(
				$args,
				array(
					'result_format'    => self::DEFAULT_DATE_FORMAT,
					'nepali_date_lang' => self::DEFAULT_LANGUAGE,
				)
			);

			// Output before content if provided.
			$this->output_if_set( $args, 'before' );
			$this->output_if_set( $args, 'before_title' );
			$this->output_if_set( $args, 'title' );
			$this->output_if_set( $args, 'after_title' );

			// Get current dates.
			$current_eng_date = $this->get_current_english_date( $args['result_format'] );
			$current_nep_date = $this->get_current_nepali_date( $args );

			// Display dates if not disabled.
			if ( empty( $args['disable_today_nep_date'] ) ) {
				printf(
					'<div class="nep-to-eng nepali-date-converter">%s</div>',
					esc_html( $current_nep_date['result'] )
				);
			}

			if ( empty( $args['disable_today_eng_date'] ) ) {
				printf(
					'<div class="eng-to-nep nepali-date-converter">%s</div>',
					esc_html( $current_eng_date['formatted'] )
				);
			}

			$this->output_if_set( $args, 'after' );
		}

		/**
		 * Creates HTML select options for date selection.
		 *
		 * @param string $select_name Name attribute for select element.
		 * @param int    $min_num     Minimum value.
		 * @param int    $max_num     Maximum value.
		 * @param int    $selected    Currently selected value.
		 * @param string $type        Type of selection (year/month/day).
		 * @param string $from        Source language ('eng' or 'nep').
		 * @param string $char        Display character set ('eng' or 'nep').
		 * @return string HTML select element.
		 * @since 1.0.0
		 */
		public function selection_options(
			string $select_name,
			int $min_num,
			int $max_num,
			int $selected,
			string $type,
			string $from,
			string $char = 'eng'
		): string {
			if ( ! in_array( $type, array( 'year', 'month', 'day' ), true ) ) {
				return '';
			}

			$options = array();
			for ( $i = $min_num; $i <= $max_num; $i++ ) {
				$option_value = $i;
				$option_text  = $i;

				if ( 'month' === $type ) {
					$option_text = ( 'nep' === $from && 'nep' === $char )
					? $this->get_mahina( $i )
					: $this->get_months( $i );
				} elseif ( 'nep' === $from && 'nep' === $char ) {
					$option_text = $this->get_nep_num( $i );
				}

				$options[] = sprintf(
					'<option value="%s"%s>%s</option>',
					esc_attr( $option_value ),
					selected( $i, $selected, false ),
					esc_html( $option_text )
				);
			}

			return sprintf(
				'<select name="%s" class="ndc-select %s">%s</select>',
				esc_attr( $select_name ),
				esc_attr( $type ),
				implode( '', $options )
			);
		}

		/**
		 * Gets current English date information.
		 *
		 * @param string $format Date format.
		 * @return array Current English date data.
		 * @since 2.0.0
		 */
		private function get_current_english_date( string $format ): array {
			$date_string = wp_date( 'Y-m-d' );
			$dates       = explode( '-', $date_string );

			return array(
				'year'      => (int) $dates[0],
				'month'     => (int) $dates[1],
				'day'       => (int) $dates[2],
				'formatted' => wp_date( $format ),
			);
		}

		/**
		 * Gets current Nepali date information.
		 *
		 * @param array $args Configuration arguments.
		 * @return array Current Nepali date data.
		 * @since 2.0.0
		 */
		private function get_current_nepali_date( array $args ): array {
			$eng_date = $this->get_current_english_date( $args['result_format'] );

			$nepali_date = ndc_eng_to_nep_date(
				array(
					'year'  => $eng_date['year'],
					'month' => $eng_date['month'],
					'day'   => $eng_date['day'],
				),
				$args['nepali_date_lang'],
				$args['result_format']
			);

			return array(
				'year'   => (int) $nepali_date['nep_date']['year'],
				'month'  => (int) $nepali_date['nep_date']['month'],
				'day'    => (int) $nepali_date['nep_date']['date'],
				'result' => $nepali_date['result'],
			);
		}

		/**
		 * Displays Nepali to English date converter.
		 *
		 * @param array  $current_date Current date data.
		 * @param string $result_format Date format.
		 * @return void
		 * @since 2.0.0
		 */
		private function display_nep_to_eng_converter( array $current_date, string $result_format ): void {
			$date_range = ndc_nepali_calendar()->get_nepali_date_range();

			echo '<div class="nep-to-eng nepali-date-converter">';
			echo '<div class="wrapper-select">';

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- selection_options() escapes output
			echo $this->selection_options( 'nte_year', $date_range['first'], $date_range['last'], $current_date['year'], 'year', 'nep', 'nep' );

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- selection_options() escapes output
			echo $this->selection_options( 'nte_month', 1, 12, $current_date['month'], 'month', 'nep', 'nep' );

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- selection_options() escapes output
			echo $this->selection_options( 'nte_day', 1, 32, $current_date['day'], 'day', 'nep', 'nep' );

			printf(
				'<br /><button class="nepali-date-converter-trigger from-nep" data-result="%s">%s</button>',
				esc_attr( $result_format ),
				esc_html__( 'To Eng Date', 'nepali-date-converter' )
			);

			echo '</div></div>';
		}

		/**
		 * Displays English to Nepali date converter.
		 *
		 * @param array $current_date Current date data.
		 * @param array $args Configuration arguments.
		 * @return void
		 * @since 2.0.0
		 */
		private function display_eng_to_nep_converter( array $current_date, array $args ): void {
			$date_range = ndc_nepali_calendar()->get_english_date_range();

			echo '<div class="eng-to-nep nepali-date-converter">';
			echo '<div class="wrapper-select">';

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- selection_options() escapes output
			echo $this->selection_options( 'etn_year', $date_range['first'], $date_range['last'], $current_date['year'], 'year', 'eng' );

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- selection_options() escapes output
			echo $this->selection_options( 'etn_month', 1, 12, $current_date['month'], 'month', 'eng' );

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- selection_options() escapes output
			echo $this->selection_options( 'etn_day', 1, 31, $current_date['day'], 'day', 'eng' );

			printf(
				'<br /><button type="submit" class="nepali-date-converter-trigger from-eng" data-result="%s" data-lang="%s">%s</button>',
				esc_attr( $args['result_format'] ),
				esc_attr( $args['nepali_date_lang'] ),
				esc_html__( 'To Nep Date', 'nepali-date-converter' )
			);

			echo '</div></div>';
		}

		/**
		 * Outputs a value from an array if the key exists and is set.
		 *
		 * @param array  $data Array to check.
		 * @param string $key  Key to check.
		 * @return void
		 * @since 2.0.0
		 */
		private function output_if_set( array $data, string $key ): void {
			if ( isset( $data[ $key ] ) ) {
				echo wp_kses_post( $data[ $key ] );
			}
		}
	}
}


/**
 * Returns the singleton instance of NDC_Frontend.
 *
 * @return NDC_Frontend
 * @since 2.0.0
 */
function ndc_frontend(): NDC_Frontend {//phpcs:ignore
	return NDC_Frontend::get_instance();
}
