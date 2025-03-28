<?php // phpcs:ignore Class file names should be based on the class name with "class-" prepended.
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Nepali Date Converter - Calendar Conversion Class
 *
 * Handles conversion between English and Nepali dates with proper formatting.
 *
 * @package Nepali Date Converter
 * @since 1.0.0
 *
Day of Month
d   Numeric, with leading zeros     01–31
j   Numeric, without leading zeros  1–31
S   The English suffix for the day of the month     st, nd or th in the 1st, 2nd or 15th.//This is not supported

Weekday
l   Full name  (lowercase 'L')  Sunday – Saturday
D   Three letter name   Mon – Sun

Month
m   Numeric, with leading zeros     01–12
n   Numeric, without leading zeros  1–12
F   Textual full    January – December
M   Textual three letters   Jan - Dec

Year
Y   Numeric, 4 digits   Eg., 1999, 2003
y   Numeric, 2 digits   Eg., 99, 03

*/

if ( ! class_exists( 'NDC_Nepali_Calendar' ) ) {
	/**
	 * Class NDC_Nepali_Calendar
	 *
	 * Handles conversion between English and Nepali dates and provides formatting options.
	 */
	class NDC_Nepali_Calendar {

		/**
		 * Nepali calendar data
		 *
		 * @var array
		 * @access private
		 * @since 1.0
		 */
		private $calendar_data = array(
			0  => array( 2000, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			1  => array( 2001, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			2  => array( 2002, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			3  => array( 2003, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			4  => array( 2004, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			5  => array( 2005, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			6  => array( 2006, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			7  => array( 2007, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			8  => array( 2008, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31 ),
			9  => array( 2009, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			10 => array( 2010, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			11 => array( 2011, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			12 => array( 2012, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30 ),
			13 => array( 2013, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			14 => array( 2014, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			15 => array( 2015, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			16 => array( 2016, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30 ),
			17 => array( 2017, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			18 => array( 2018, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			19 => array( 2019, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			20 => array( 2020, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30 ),
			21 => array( 2021, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			22 => array( 2022, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30 ),
			23 => array( 2023, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			24 => array( 2024, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30 ),
			25 => array( 2025, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			26 => array( 2026, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			27 => array( 2027, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			28 => array( 2028, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			29 => array( 2029, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30 ),
			30 => array( 2030, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			31 => array( 2031, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			32 => array( 2032, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			33 => array( 2033, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			34 => array( 2034, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			35 => array( 2035, 30, 32, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31 ),
			36 => array( 2036, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			37 => array( 2037, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			38 => array( 2038, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			39 => array( 2039, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30 ),
			40 => array( 2040, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			41 => array( 2041, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			42 => array( 2042, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			43 => array( 2043, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30 ),
			44 => array( 2044, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			45 => array( 2045, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			46 => array( 2046, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			47 => array( 2047, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30 ),
			48 => array( 2048, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			49 => array( 2049, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30 ),
			50 => array( 2050, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			51 => array( 2051, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30 ),
			52 => array( 2052, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			53 => array( 2053, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30 ),
			54 => array( 2054, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			55 => array( 2055, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			56 => array( 2056, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30 ),
			57 => array( 2057, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			58 => array( 2058, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			59 => array( 2059, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			60 => array( 2060, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			61 => array( 2061, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			62 => array( 2062, 30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31 ),
			63 => array( 2063, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			64 => array( 2064, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			65 => array( 2065, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			66 => array( 2066, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31 ),
			67 => array( 2067, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			68 => array( 2068, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			69 => array( 2069, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			70 => array( 2070, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30 ),
			71 => array( 2071, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			72 => array( 2072, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			73 => array( 2073, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
			74 => array( 2074, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30 ),
			75 => array( 2075, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			76 => array( 2076, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30 ),
			77 => array( 2077, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			78 => array( 2078, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30 ),
			79 => array( 2079, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30 ),
			80 => array( 2080, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30 ),
			81 => array( 2081, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31 ),
			82 => array( 2082, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30 ),
			83 => array( 2083, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30 ),
			84 => array( 2084, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30 ),
			85 => array( 2085, 31, 32, 31, 32, 30, 31, 30, 30, 29, 30, 30, 30 ),
			86 => array( 2086, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30 ),
			87 => array( 2087, 31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30 ),
			88 => array( 2088, 30, 31, 32, 32, 30, 31, 30, 30, 29, 30, 30, 30 ),
			89 => array( 2089, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30 ),
			90 => array( 2090, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30 ),
			91 => array( 2091, 31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30 ),
			92 => array( 2092, 30, 31, 32, 32, 31, 30, 30, 30, 29, 30, 30, 30 ),
			93 => array( 2093, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30 ),
			94 => array( 2094, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30 ),
			95 => array( 2095, 31, 31, 32, 31, 31, 31, 30, 29, 30, 30, 30, 30 ),
			96 => array( 2096, 30, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30 ),
			97 => array( 2097, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30 ),
			98 => array( 2098, 31, 31, 32, 31, 31, 31, 29, 30, 29, 30, 29, 31 ),
			99 => array( 2099, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31 ),
		);

		/**
		 * Month Days
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private $month_days = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );

		/**
		 * Leap Month Days
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private $leap_month_days = array( 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );

		/**
		 * Reference dates (shared between conversions).
		 *
		 * Reference dates for calendar conversion:
		 *
		 * English date: January 1, 1944 (1944-01-01)
		 * Corresponds to Nepali date: Poush 17, 2000 (2000-09-17)
		 * Note: $ref_nep_day is 16 (not 17) because the algorithm:
		 *   1. Starts counting from day 0 (zero-based)
		 *   2. First increments the day ($nep_day++) before checking bounds
		 * So initializing at 16 makes the first iteration land on correct day 17.
		 *
		 * Nepali date: Baisakh 1, 2000 (2000-01-01)
		 * Corresponds to English date: April 14, 1943 (1943-04-14)
		 * Note: $ref_eng_day is 14 (not 15) because the algorithm:
		 *   1. Uses zero-based day counting internally
		 *   2. First increments the day ($eng_day++) before checking bounds
		 * So initializing at 14 makes the first iteration land on correct day 15.
		 *
		 * @var array
		 * @since 3.0.0
		 */
		private $ref_dates = array(
			'eng_to_nep' => array(
				'eng_year'    => 1944,
				'nep_year'    => 2000,
				'nep_month'   => 9,
				'nep_day'     => 16,
				'day_of_week' => 6,
			),
			'nep_to_eng' => array(
				'nep_year'  => 2000,
				'eng_year'  => 1943,
				'eng_month' => 4,
				'eng_day'   => 14,
			),
		);

		/**
		 * English to Nepali number mapping
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $eng_nep_num = array(
			'0' => '०',
			'1' => '१',
			'2' => '२',
			'3' => '३',
			'4' => '४',
			'5' => '५',
			'6' => '६',
			'7' => '७',
			'8' => '८',
			'9' => '९',
		);

		/**
		 * English to Nepali month names (long)
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $long_eng_nep_mth = array(
			'January'   => 'बैशाख',
			'February'  => 'जेष्ठ',
			'March'     => 'असार',
			'April'     => 'साउन',
			'May'       => 'भदौ',
			'June'      => 'अशोज',
			'July'      => 'कार्तिक',
			'August'    => 'मंसिर',
			'September' => 'पुस',
			'October'   => 'माघ',
			'November'  => 'फाल्गुन',
			'December'  => 'चैत्र',
		);

		/**
		 * English to Nepali month names (long) in English characters
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $long_eng_nep_mth_in_eng = array(
			'January'   => 'Baishakh',
			'February'  => 'Jestha',
			'March'     => 'Ashad',
			'April'     => 'Shrawan',
			'May'       => 'Bhadra',
			'June'      => 'Ashwin',
			'July'      => 'Kartik',
			'August'    => 'Mangshir',
			'September' => 'Poush',
			'October'   => 'Magh',
			'November'  => 'Falgun',
			'December'  => 'Chaitra',
		);

		/**
		 * English to Nepali month names (short)
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $short_eng_nep_mth = array(
			'Jan' => 'बैशाख',
			'Feb' => 'जेष्ठ',
			'Mar' => 'असार',
			'Apr' => 'साउन',
			'May' => 'भदौ',
			'Jun' => 'अशोज',
			'Jul' => 'कार्तिक',
			'Aug' => 'मंसिर',
			'Sep' => 'पुस',
			'Oct' => 'माघ',
			'Nov' => 'फाल्गुन',
			'Dec' => 'चैत्र',
		);

		/**
		 * English to Nepali month names (short) in English characters
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $short_eng_nep_mth_in_eng = array(
			'Jan' => 'Baishakh',
			'Feb' => 'Jestha',
			'Mar' => 'Ashad',
			'Apr' => 'Shrawan',
			'May' => 'Bhadra',
			'Jun' => 'Ashwin',
			'Jul' => 'Kartik',
			'Aug' => 'Mangshir',
			'Sep' => 'Poush',
			'Oct' => 'Magh',
			'Nov' => 'Falgun',
			'Dec' => 'Chaitra',
		);

		/**
		 * English to Nepali day names (long)
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $long_eng_nep_day = array(
			'Sunday'    => 'आइतवार',
			'Monday'    => 'सोमवार',
			'Tuesday'   => 'मङ्लबार',
			'Wednesday' => 'बुधबार',
			'Thursday'  => 'बिहिबार',
			'Friday'    => 'शुक्रबार',
			'Saturday'  => 'शनिबार',
		);

		/**
		 * English to Nepali day names (long) in English characters
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $long_eng_nep_day_eng = array(
			'Sunday'    => 'Aaitabar',
			'Monday'    => 'Sombar',
			'Tuesday'   => 'Mangalbar',
			'Wednesday' => 'Budhabar',
			'Thursday'  => 'Bihibar',
			'Friday'    => 'Sukrabar',
			'Saturday'  => 'Sanibar',
		);

		/**
		 * English to Nepali day names (short)
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $short_eng_nep_day = array(
			'Sun' => 'आइत',
			'Mon' => 'सोम',
			'Tue' => 'मङ्ल',
			'Wed' => 'बुध',
			'Thu' => 'बिहि',
			'Fri' => 'शुक्र',
			'Sat' => 'शनि',
		);

		/**
		 * English to Nepali day names (short) in English characters
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $short_eng_nep_day_eng = array(
			'Sun' => 'Aaita',
			'Mon' => 'Som',
			'Tue' => 'Mangal',
			'Wed' => 'Budha',
			'Thu' => 'Bihi',
			'Fri' => 'Sukra',
			'Sat' => 'Sani',
		);

		/**
		 * Date data structure
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private $date_data = array(
			'eng_date' => array(
				'year'    => '',
				'month'   => '',
				'wp_date' => '',
			),
			'nep_date' => array(
				'year'    => '',
				'month'   => '',
				'wp_date' => '',
			),
			'from'     => '',
			'result'   => '',
		);

		/**
		 * Singleton instance
		 *
		 * @var NDC_Nepali_Calendar|null
		 * @since 2.0.0
		 */
		private static $instance = null;

		/**
		 * Gets the singleton instance
		 *
		 * @return NDC_Nepali_Calendar
		 * @since 2.0.0
		 */
		public static function get_instance(): NDC_Nepali_Calendar {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Gets the Nepali wp_date range
		 *
		 * @return array First and last years in the Nepali calendar data
		 * @since 1.0.0
		 */
		public function get_nepali_date_range(): array {
			$first_year = $this->calendar_data[0][0];
			$last_year  = end( $this->calendar_data )[0];

			return array(
				'first' => $first_year,
				'last'  => $last_year,
			);
		}

		/**
		 * Gets the approximate English wp_date range
		 *
		 * @return array Approximate English years corresponding to Nepali range
		 * @since 1.0.0
		 */
		public function get_english_date_range(): array {
			$nepali_range = $this->get_nepali_date_range();
			return array(
				'first' => $nepali_range['first'] - 57,
				'last'  => $nepali_range['last'] - 56,
			);
		}

		/**
		 * Checks if an English wp_date is within the supported range
		 *
		 * @param int $year Year.
		 * @param int $month Month.
		 * @param int $day Day.
		 * @return bool|string True if valid, error message if invalid
		 * @since 1.0.0
		 */
		private function validate_english_date( int $year, int $month, int $day ) {
			$english_range = $this->get_english_date_range();

			if ( $year < $english_range['first'] || $year > $english_range['last'] ) {
				return sprintf(
				// translators: %1$d represents the first year, %2$d represents the last year in the supported Nepali wp_date range.
					__( 'Supported only between %1$d-%2$d', 'nepali-wp_date-converter' ),
					$english_range['first'],
					$english_range['last']
				);
			}

			if ( $month < 1 || $month > 12 ) {
				return __( 'Error! month value can be between 1-12 only', 'nepali-wp_date-converter' );
			}

			if ( $day < 1 || $day > 31 ) {
				return __( 'Error! day value can be between 1-31 only', 'nepali-wp_date-converter' );
			}

			return true;
		}

		/**
		 * Checks if a Nepali wp_date is within the supported range
		 *
		 * @param int $year Year.
		 * @param int $month Month.
		 * @param int $day Day.
		 * @return bool|string True if valid, error message if invalid
		 * @since 1.0.0
		 */
		private function validate_nepali_date( int $year, int $month, int $day ) {
			$nepali_range = $this->get_nepali_date_range();

			if ( $year < $nepali_range['first'] || $year > $nepali_range['last'] ) {
				return sprintf(
				// translators: %1$d represents the first year, %2$d represents the last year in the supported Nepali wp_date range.
					__( 'Supported only between %1$d-%2$d', 'nepali-wp_date-converter' ),
					$nepali_range['first'],
					$nepali_range['last']
				);
			}

			if ( $month < 1 || $month > 12 ) {
				return __( 'Error! month value can be between 1-12 only', 'nepali-wp_date-converter' );
			}

			if ( $day < 1 || $day > 32 ) {
				return __( 'Error! day value can be between 1-32 only', 'nepali-wp_date-converter' );
			}

			return true;
		}

		/**
		 * Determines if a year is a leap year
		 *
		 * @param int $year Year to check.
		 * @return bool True if leap year, false otherwise
		 * @since 1.0.0
		 */
		public function is_leap_year( int $year ): bool {
			if ( 0 === $year % 100 ) {
				return 0 === $year % 400;
			}
			return 0 === $year % 4;
		}

		/**
		 * Converts a number to two-character string with leading zero if needed
		 *
		 * @param string $str Number string.
		 * @return string Two-character string
		 * @since 1.0.0
		 */
		private function get_two_char_str( string $str ): string {
			if ( strlen( $str ) === 0 ) {
				return '00';
			}
			if ( strlen( $str ) === 1 ) {
				return '0' . $str;
			}
			return $str;
		}

		/**
		 * Converts English wp_date to Nepali wp_date
		 *
		 * @param array  $input_date Array with year, month, day, hour, min, sec.
		 * @param string $date_format Output format ('nep_char' or 'eng_char').
		 * @param string $format PHP wp_date format string.
		 * @return array Converted wp_date data.
		 * @since 1.0.0
		 */
		public function eng_to_nep( array $input_date, string $date_format = 'nep_char', string $format = 'D, F j, Y' ): array {
			$year  = $input_date['year'];
			$month = $input_date['month'];
			$day   = $input_date['day'];

			$validation = $this->validate_english_date( $year, $month, $day );
			if ( true !== $validation ) {
				return esc_html( $validation );
			}

			$this->date_data = array(
				'from'     => 'eng',
				'eng_date' => array(
					'year'  => $year,
					'month' => $month,
					'date'  => $day,
				),
				'nep_date' => array(
					'year'  => '',
					'month' => '',
					'date'  => '',
				),
				'result'   => '',
			);

			$ref           = $this->ref_dates['eng_to_nep'];
			$ref_eng_year  = $ref['eng_year'];
			$ref_nep_year  = $ref['nep_year'];
			$ref_nep_month = $ref['nep_month'];
			$ref_nep_day   = $ref['nep_day'];
			$day_of_week   = $ref['day_of_week'];

			$total_days = 0;

			// Calculate total days from reference English date.
			for ( $y = 0; $y < ( $year - $ref_eng_year ); $y++ ) {
				$total_days += $this->is_leap_year( $ref_eng_year + $y ) ? 366 : 365;
			}

			// Add days from months in current year.
			$month_days = $this->is_leap_year( $year ) ? $this->leap_month_days : $this->month_days;
			for ( $m = 0; $m < ( $month - 1 ); $m++ ) {
				$total_days += $month_days [ $m ];
			}

			// Add days in current month.
			$total_days += $day;

			// Convert to Nepali date.
			$nep_year  = $ref_nep_year;
			$nep_month = $ref_nep_month;
			$nep_day   = $ref_nep_day;
			$cal_index = 0;

			while ( $total_days > 0 ) {
				$days_in_month = $this->calendar_data[ $cal_index ][ $nep_month ];

				++$nep_day;
				++$day_of_week;

				if ( $nep_day > $days_in_month ) {
					++$nep_month;
					$nep_day = 1;
				}

				if ( $day_of_week > 7 ) {
					$day_of_week = 1;
				}

				if ( $nep_month > 12 ) {
					++$nep_year;
					$nep_month = 1;
					++$cal_index;
				}

				--$total_days;
			}

			/*
			Format the date.
			* no supported
			S, c, r, U
			may be c= $y.'-'.$m.'-'.$np_date.'स'.wp_date('H',$create_date).':'.wp_date('i',$create_date).':'.wp_date('s',$create_date).'+00:00',
			*/
			$hour = $input_date['hour'] ?? '';
			$min  = $input_date['min'] ?? '';
			$sec  = $input_date['sec'] ?? '';

			$date_str = sprintf( '%d-%d-%d', $year, $month, $day );
			if ( $hour ) {
				$date_str .= sprintf( ' %02d', $hour );
			}
			if ( $min ) {
				$date_str .= sprintf( ':%02d', $min );
			}
			if ( $sec ) {
				$date_str .= sprintf( ':%02d', $sec );
			}

			$timezone  = wp_timezone();
			$datetime  = new DateTimeImmutable( $date_str, $timezone );
			$timestamp = $datetime->getTimestamp();

			// Date format replacements.
			$replacements = array(
				'd' => $this->get_two_char_str( $nep_day ),
				'j' => $nep_day,
				'l' => wp_date( 'l', $timestamp ),
				'D' => wp_date( 'D', $timestamp ),
				'm' => $this->get_two_char_str( $nep_month ),
				'n' => $nep_month,
				'F' => array_keys( $this->long_eng_nep_mth )[ $nep_month - 1 ],
				'M' => array_keys( $this->short_eng_nep_mth )[ $nep_month - 1 ],
				'Y' => $nep_year,
				'y' => substr( $nep_year, 2 ),
				'a' => wp_date( 'a', $timestamp ),
				'A' => wp_date( 'A', $timestamp ),
				'g' => wp_date( 'g', $timestamp ),
				'h' => wp_date( 'h', $timestamp ),
				'G' => wp_date( 'G', $timestamp ),
				'H' => wp_date( 'H', $timestamp ),
				'i' => wp_date( 'i', $timestamp ),
				's' => wp_date( 's', $timestamp ),
				'T' => wp_date( 'T', $timestamp ),
				'c' => sprintf(
					'%d-%d-%dस%02d:%02d:%02d+00:00',
					$nep_year,
					$nep_month,
					$nep_day,
					wp_date( 'H', $timestamp ),
					wp_date( 'i', $timestamp ),
					wp_date( 's', $timestamp )
				),
				'r' => sprintf(
					'%s, %d %s %d %02d:%02d:%02d +0200',
					wp_date( 'D', $timestamp ),
					$nep_day,
					array_keys( $this->short_eng_nep_mth )[ $nep_month - 1 ],
					$nep_year,
					wp_date( 'H', $timestamp ),
					wp_date( 'i', $timestamp ),
					wp_date( 's', $timestamp )
				),
			);

			$nepali_date = strtr( $format, $replacements );

			// Temporary placeholders for day names.
			$day_placeholder = 'day' . $day_of_week;
			$long_day_map    = array(
				'Sunday'    => $day_placeholder . '_long',
				'Monday'    => $day_placeholder . '_long',
				'Tuesday'   => $day_placeholder . '_long',
				'Wednesday' => $day_placeholder . '_long',
				'Thursday'  => $day_placeholder . '_long',
				'Friday'    => $day_placeholder . '_long',
				'Saturday'  => $day_placeholder . '_long',
			);
			$short_day_map   = array(
				'Sun' => $day_placeholder . '_short',
				'Mon' => $day_placeholder . '_short',
				'Tue' => $day_placeholder . '_short',
				'Wed' => $day_placeholder . '_short',
				'Thu' => $day_placeholder . '_short',
				'Fri' => $day_placeholder . '_short',
				'Sat' => $day_placeholder . '_short',
			);

			if ( 'eng_char' === $date_format ) {
				$nepali_date = strtr( $nepali_date, $this->long_eng_nep_mth_in_eng );
				$nepali_date = strtr( $nepali_date, $this->short_eng_nep_mth_in_eng );

				$long_day_replace  = array(
					'day1_long' => 'Aaitabar',
					'day2_long' => 'Sombar',
					'day3_long' => 'Mangalbar',
					'day4_long' => 'Budhabar',
					'day5_long' => 'Bihibar',
					'day6_long' => 'Sukrabar',
					'day7_long' => 'Sanibar',
				);
				$short_day_replace = array(
					'day1_short' => 'Aaita',
					'day2_short' => 'Som',
					'day3_short' => 'Mangal',
					'day4_short' => 'Budha',
					'day5_short' => 'Bihi',
					'day6_short' => 'Sukra',
					'day7_short' => 'Sani',
				);

				$nepali_date = strtr( $nepali_date, $long_day_map );
				$nepali_date = strtr( $nepali_date, $short_day_map );
				$nepali_date = strtr( $nepali_date, $long_day_replace );
				$nepali_date = strtr( $nepali_date, $short_day_replace );

				$am_pm_replace = array(
					'am' => 'Bihana',
					'pm' => 'Madhyanha',
				);
				$nepali_date   = strtr( $nepali_date, $am_pm_replace );
			} else {
				$nepali_date = strtr( $nepali_date, $this->eng_nep_num );
				$nepali_date = strtr( $nepali_date, $this->long_eng_nep_mth );
				$nepali_date = strtr( $nepali_date, $this->short_eng_nep_mth );

				$long_day_replace  = array(
					'day1_long' => 'आइतवार',
					'day2_long' => 'सोमवार',
					'day3_long' => 'मङ्लबार',
					'day4_long' => 'बुधबार',
					'day5_long' => 'बिहिबार',
					'day6_long' => 'शुक्रबार',
					'day7_long' => 'शनिबार',
				);
				$short_day_replace = array(
					'day1_short' => 'आइत',
					'day2_short' => 'सोम',
					'day3_short' => 'मङ्ल',
					'day4_short' => 'बुध',
					'day5_short' => 'बिहि',
					'day6_short' => 'शुक्र',
					'day7_short' => 'शनि',
				);

				$nepali_date = strtr( $nepali_date, $long_day_map );
				$nepali_date = strtr( $nepali_date, $short_day_map );
				$nepali_date = strtr( $nepali_date, $long_day_replace );
				$nepali_date = strtr( $nepali_date, $short_day_replace );

				$am_pm_replace = array(
					'am' => 'बिहान',
					'pm' => 'मध्यान्ह',
				);
				$nepali_date   = strtr( $nepali_date, $am_pm_replace );
			}

			$this->date_data['nep_date'] = array(
				'year'  => $nep_year,
				'month' => $nep_month,
				'date'  => $nep_day,
			);
			$this->date_data['result']   = $nepali_date;

			return $this->date_data;
		}


		/**
		 * Converts Nepali date to English date
		 *
		 * @param array  $input_date Array with year, month, day.
		 * @param string $format PHP date format string.
		 * @return array Converted date data
		 * @since 1.0.0
		 */
		public function nep_to_eng( array $input_date, string $format = 'D, F j, Y' ): array {
			$year  = $input_date['year'];
			$month = $input_date['month'];
			$day   = $input_date['day'];

			$validation = $this->validate_nepali_date( $year, $month, $day );
			if ( true !== $validation ) {
				return esc_html( $validation );
			}

			$this->date_data = array(
				'from'     => 'nep',
				'nep_date' => array(
					'year'  => $year,
					'month' => $month,
					'date'  => $day,
				),
				'eng_date' => array(
					'year'  => '',
					'month' => '',
					'date'  => '',
				),
				'result'   => '',
			);

			$ref           = $this->ref_dates['nep_to_eng'];
			$ref_nep_year  = $ref['nep_year'];
			$ref_eng_year  = $ref['eng_year'];
			$ref_eng_month = $ref['eng_month'];
			$ref_eng_day   = $ref['eng_day'];

			$total_days = 0;
			$cal_index  = 0;

			// Calculate total days from reference Nepali date to input date.
			for ( $y = $ref_nep_year; $y < $year; $y++ ) {
				for ( $m = 1; $m <= 12; $m++ ) {
					$total_days += $this->calendar_data[ $cal_index ][ $m ];
				}
				++$cal_index;
			}

			// Add days from months in current year.
			for ( $m = 1; $m < $month; $m++ ) {
				$total_days += $this->calendar_data[ $cal_index ][ $m ];
			}

			// Add days in current month.
			$total_days += $day - 1; // Subtract 1 because we start counting from day 1.

			// Convert to English date.
			$eng_year  = $ref_eng_year;
			$eng_month = $ref_eng_month;
			$eng_day   = $ref_eng_day;

			while ( $total_days > 0 ) {
				// Get the correct month days array based on leap year.
				$current_month_days    = $this->is_leap_year( $eng_year ) ? $this->leap_month_days : $this->month_days;
				$days_in_current_month = $current_month_days[ $eng_month - 1 ]; // -1 because array is 0-based

				$days_remaining_in_month = $days_in_current_month - $eng_day + 1;

				if ( $total_days >= $days_remaining_in_month ) {
					$total_days -= $days_remaining_in_month;
					$eng_day     = 1;
					++$eng_month;

					if ( $eng_month > 12 ) {
						$eng_month = 1;
						++$eng_year;
					}
				} else {
					$eng_day   += $total_days;
					$total_days = 0;
				}
			}

			// Create DateTime object for proper formatting.
			$date_str       = sprintf( '%d-%d-%d', $eng_year, $eng_month, $eng_day );
			$date_obj       = new DateTime( $date_str );
			$formatted_date = $date_obj->format( $format );

			$this->date_data['eng_date'] = array(
				'year'  => $eng_year,
				'month' => $eng_month,
				'date'  => $eng_day,
			);
			$this->date_data['result']   = $formatted_date;

			return $this->date_data;
		}
	}
}
/**
 * Return Instance
 * NDC_Nepali_Calendar
 *
 * @since    2.0.0
 */
if ( ! function_exists( 'ndc_nepali_calendar' ) ) {

	function ndc_nepali_calendar(): NDC_Nepali_Calendar {//phpcs:ignore
		return NDC_Nepali_Calendar::get_instance();
	}
}
