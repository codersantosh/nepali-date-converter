<?php // phpcs:ignore Class file names should be based on the class name with "class-" prepended.
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * NDC Post Date Setting - Handles Nepali date conversion for post dates
 *
 * @package Nepali Date Converter
 * @since 2.0.0
 */

if ( ! class_exists( 'NDC_Post_Date' ) ) {
	/**
	 * Class NDC_Post_Date
	 *
	 * Handles Nepali date conversion for post dates in WordPress.
	 */
	class NDC_Post_Date {

		/**
		 * Plugin options
		 *
		 * @var array
		 * @since 2.0.0
		 */
		private $options;

		/**
		 * Default plugin options
		 *
		 * @var array
		 * @since 2.0.0
		 */
		private const DEFAULTS = array(
			'active'          => array(
				'date'          => false,
				'time'          => false,
				'modified_date' => false,
				'modified_time' => false,
			),
			'date_format'     => array(
				'selected' => 'F j, Y',
				'custom'   => '',
			),
			'force_format'    => false,
			'human_time_diff' => array(
				'front'   => false,
				'home'    => false,
				'archive' => false,
				'single'  => false,
				'suffix'  => 'अगाडि',
			),
			'post_types'      => array( 'post' ),
		);

		/**
		 * Singleton instance
		 *
		 * @var NDC_Post_Date|null
		 * @since 2.0.0
		 */
		private static $instance = null;

		/**
		 * Gets the singleton instance
		 *
		 * @return NDC_Post_Date
		 * @since 2.0.0
		 */
		public static function get_instance(): NDC_Post_Date {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Initialize the module
		 *
		 * @since 2.0.0
		 */
		public function run(): void {
			add_action( 'admin_init', array( $this, 'register_settings' ) );
			add_action( 'admin_head', array( $this, 'add_settings_js' ) );
			add_action( 'wp_ajax_ndc_date_format', array( $this, 'ajax_get_date_format' ) );
			add_action( 'init', array( $this, 'init' ) );
			add_filter( 'plugin_action_links_' . NEPALI_DATE_CONVERTER_NAME, array( $this, 'add_settings_link' ) );
		}

		/**
		 * Add settings link to plugin action links
		 *
		 * @param array $links Existing plugin action links.
		 * @return array Modified plugin action links
		 * @since 2.0.1
		 */
		public function add_settings_link( array $links ): array {
			$settings_link = sprintf(
				'<a href="%s">%s</a>',
				esc_url( admin_url( 'options-general.php#ndc-post-date-start' ) ),
				esc_html__( 'Settings', 'nepali-date-converter' )
			);
			$links[]       = $settings_link;
			return $links;
		}

		/**
		 * Register plugin settings
		 *
		 * @since 2.0.0
		 */
		public function register_settings(): void {
			// Register settings section.
			add_settings_section(
				'ndc_post_date_section',
				__( 'Nepali Post Date - Nepali Date Converter', 'nepali-date-converter' ),
				array( $this, 'render_settings_section' ),
				'general'
			);

			// Add nonce field.
			add_settings_field(
				'ndc_post_date_nonce',
				'',
				array( $this, 'render_nonce_field' ),
				'general',
				'ndc_post_date_section'
			);

			// Register settings fields.
			add_settings_field(
				'ndc_post_date_options[active]',
				__( 'Activate Nepali Post Date On', 'nepali-date-converter' ),
				array( $this, 'render_active_field' ),
				'general',
				'ndc_post_date_section'
			);

			add_settings_field(
				'ndc_post_date_options[date_format]',
				__( 'Date Format', 'nepali-date-converter' ),
				array( $this, 'render_date_format_field' ),
				'general',
				'ndc_post_date_section'
			);

			add_settings_field(
				'ndc_post_date_options[force_format]',
				__( 'Force Format', 'nepali-date-converter' ),
				array( $this, 'render_force_format_field' ),
				'general',
				'ndc_post_date_section'
			);

			add_settings_field(
				'ndc_post_date_options[human_time_diff]',
				__( 'Activate Nepali Human Time Diff On', 'nepali-date-converter' ),
				array( $this, 'render_human_time_diff_field' ),
				'general',
				'ndc_post_date_section'
			);

			add_settings_field(
				'ndc_post_date_options[post_types]',
				__( 'Post Types Support', 'nepali-date-converter' ),
				array( $this, 'render_post_types_field' ),
				'general',
				'ndc_post_date_section'
			);

			// Register the setting.
			register_setting(
				'general',
				'ndc_post_date_options',
				array(
					'type'              => 'array',
					'description'       => __( 'All Options related to NDC Post Date', 'nepali-date-converter' ),
					'sanitize_callback' => array( $this, 'sanitize_options' ),
					'default'           => self::DEFAULTS,
				)
			);
		}

		/**
		 * Render settings section description
		 *
		 * @since 2.0.0
		 */
		public function render_settings_section(): void {
			echo '<p id="ndc-post-date-start">';
			esc_html_e( 'All Options related to NDC Post Date.', 'nepali-date-converter' );
			esc_html_e( " Does not work on following date format: 'S'", 'nepali-date-converter' );
			echo '</p><hr/>';
		}

		/**
		 * Render nonce field for settings form
		 *
		 * @since 2.0.0
		 */
		public function render_nonce_field(): void {
			wp_nonce_field( 'ndc_post_date_options_nonce', 'ndc_post_date_nonce' );
		}

		/**
		 * Render active field
		 *
		 * @since 2.0.0
		 */
		public function render_active_field(): void {
			$active = $this->options['active'];
			?>
			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Date', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[active][date]">
					<input name="ndc_post_date_options[active][date]" type="checkbox" id="ndc_post_date_options[active][date]" value="1" <?php checked( true, $active['date'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Date', 'nepali-date-converter' ); ?></span>
					<code><?php esc_html_e( 'Uses get_the_date filter hook', 'nepali-date-converter' ); ?></code>
				</label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Time', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[active][time]">
					<input name="ndc_post_date_options[active][time]" type="checkbox" id="ndc_post_date_options[active][time]" value="1" <?php checked( true, $active['time'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Time', 'nepali-date-converter' ); ?></span>
					<code><?php esc_html_e( 'Uses get_the_time filter hook', 'nepali-date-converter' ); ?></code>
				</label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Date (Modified)', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[active][modified_date]">
					<input name="ndc_post_date_options[active][modified_date]" type="checkbox" id="ndc_post_date_options[active][modified_date]" value="1" <?php checked( true, $active['modified_date'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Date (Modified)', 'nepali-date-converter' ); ?></span>
					<code><?php esc_html_e( 'Uses get_the_modified_date filter hook', 'nepali-date-converter' ); ?></code>
				</label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Time (Modified)', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[active][modified_time]">
					<input name="ndc_post_date_options[active][modified_time]" type="checkbox" id="ndc_post_date_options[active][modified_time]" value="1" <?php checked( true, $active['modified_time'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Time (Modified)', 'nepali-date-converter' ); ?></span>
					<code><?php esc_html_e( 'Uses get_the_modified_time filter hook', 'nepali-date-converter' ); ?></code>
				</label>
			</fieldset>
			<?php
		}

		/**
		 * Render date format field
		 *
		 * @since 2.0.0
		 */
		public function render_date_format_field(): void {
			$date_formats = array_unique( apply_filters( 'ndc_date_formats', array( 'F j, Y', 'Y-m-d', 'm/d/Y', 'd/m/Y' ) ) );

			$front_date_converter = ndc_frontend();
			?>
			<fieldset>
				<legend class="screen-reader-text">
					<span><?php esc_html_e( 'Date Format', 'nepali-date-converter' ); ?></span>
				</legend>
				<?php foreach ( $date_formats as $format ) : ?>
					<label>
						<input type="radio" name="ndc_post_date_options[date_format][selected]" value="<?php echo esc_attr( $format ); ?>" <?php checked( $format, $this->options['date_format']['selected'] ); ?> />
						<span class="date-time-text format-i18n">
							<?php
							$front_date_converter->today_date(
								array(
									'result_format' => $format,
									'disable_today_eng_date' => true,
								)
							);
							?>
						</span>
						<code><?php echo esc_html( $format ); ?></code>
					</label><br />
				<?php endforeach; ?>

				<label>
					<input type="radio" id="ndc_post_date_options_custom_radio" name="ndc_post_date_options[date_format][selected]" value="ndc-date-format-custom" <?php checked( 'ndc-date-format-custom', $this->options['date_format']['selected'] ); ?> />
					<span class="date-time-text date-time-custom-text">
							<?php esc_html_e( 'Custom:', 'nepali-date-converter' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( 'enter a custom date format in the following field', 'nepali-date-converter' ); ?></span>
					</span>
				</label>
				<label for="ndc_post_date_options[date_format][custom]" class="screen-reader-text">
					<?php esc_html_e( 'Custom date format:', 'nepali-date-converter' ); ?>
				</label>
				<input type="text" name="ndc_post_date_options[date_format][custom]" id="ndc_post_date_options[date_format][custom]" value="<?php echo esc_attr( $this->options['date_format']['custom'] ); ?>" class="small-text" />
				<br />
				<strong><?php esc_html_e( 'Preview:', 'nepali-date-converter' ); ?></strong>
				<div class="example">
					<?php echo esc_html( $this->get_nepali_date_preview( 'ndc-date-format-custom' !== $this->options['date_format']['selected'] ? $this->options['date_format']['selected'] : $this->options['date_format']['custom'] ) ); ?>
				</div>
				<span class="spinner"></span>
			</fieldset>
			<?php
		}

		/**
		 * Render force format field
		 *
		 * @since 2.0.0
		 */
		public function render_force_format_field(): void {
			?>
			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Force Format', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[force_format]">
					<input name="ndc_post_date_options[force_format]" type="checkbox" id="ndc_post_date_options[force_format]" value="1" <?php checked( true, $this->options['force_format'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Force Format', 'nepali-date-converter' ); ?></span>
					<?php esc_html_e( 'When enabled, hard coded formats will be ignored. Example:', 'nepali-date-converter' ); ?>
					<code>get_the_date('F j, Y')</code>
				</label>
			</fieldset>
			<?php
		}

		/**
		 * Render human time diff field
		 *
		 * @since 2.0.1
		 */
		public function render_human_time_diff_field(): void {
			$human_time_diff = $this->options['human_time_diff'];
			?>
			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Front Page', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[human_time_diff][front]">
					<input name="ndc_post_date_options[human_time_diff][front]" type="checkbox" id="ndc_post_date_options[human_time_diff][front]" value="1" <?php checked( true, $human_time_diff['front'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Front Page', 'nepali-date-converter' ); ?></span>
				</label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Home - Blog Home', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[human_time_diff][home]">
					<input name="ndc_post_date_options[human_time_diff][home]" type="checkbox" id="ndc_post_date_options[human_time_diff][home]" value="1" <?php checked( true, $human_time_diff['home'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Home (Blog Home)', 'nepali-date-converter' ); ?></span>
				</label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Archive', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[human_time_diff][archive]">
					<input name="ndc_post_date_options[human_time_diff][archive]" type="checkbox" id="ndc_post_date_options[human_time_diff][archive]" value="1" <?php checked( true, $human_time_diff['archive'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Archive', 'nepali-date-converter' ); ?></span>
				</label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Single', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[human_time_diff][single]">
					<input name="ndc_post_date_options[human_time_diff][single]" type="checkbox" id="ndc_post_date_options[human_time_diff][single]" value="1" <?php checked( true, $human_time_diff['single'] ); ?> />
					<span class="date-time-text"><?php esc_html_e( 'Single', 'nepali-date-converter' ); ?></span>
				</label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_html_e( 'Suffix', 'nepali-date-converter' ); ?></span></legend>
				<label for="ndc_post_date_options[human_time_diff][suffix]">
					<span class="date-time-text"><?php esc_html_e( 'Suffix', 'nepali-date-converter' ); ?></span>
					<input name="ndc_post_date_options[human_time_diff][suffix]" type="text" id="ndc_post_date_options[human_time_diff][suffix]" value="<?php echo esc_attr( $human_time_diff['suffix'] ); ?>" />
				</label>
				<?php esc_html_e( 'Example', 'nepali-date-converter' ); ?>
				<code>अगाडि, अघि</code>
			</fieldset>
			<br />
			<strong><?php esc_html_e( 'Preview:', 'nepali-date-converter' ); ?></strong>
			<div id="ndc-htd-example">
				३ सेकेन्ड <span><?php echo esc_html( $human_time_diff['suffix'] ); ?></span>
			</div>
			<?php
		}

		/**
		 * Render post types field
		 *
		 * @since 2.0.3
		 */
		public function render_post_types_field(): void {
			$post_types       = ndc_get_post_types();
			$saved_post_types = $this->options['post_types'];

			if ( empty( $post_types ) ) {
				esc_html_e( 'No post types found!', 'nepali-date-converter' );
				return;
			}

			foreach ( $post_types as $post_type ) {
				?>
				<fieldset>
					<legend class="screen-reader-text">
						<span><?php echo esc_html( $post_type['value'] ); ?></span>
					</legend>
					<label for="ndc_post_date_options[post_types][<?php echo esc_attr( $post_type['value'] ); ?>]">
						<input name="ndc_post_date_options[post_types][]" type="checkbox" id="ndc_post_date_options[post_types][<?php echo esc_attr( $post_type['value'] ); ?>]" value="<?php echo esc_attr( $post_type['value'] ); ?>" <?php checked( in_array( $post_type['value'], $saved_post_types, true ) ); ?> />
						<span class="date-time-text"><?php echo esc_html( $post_type['label'] ); ?></span>
					</label>
				</fieldset>
				<?php
			}
		}

		/**
		 * Sanitize plugin options
		 *
		 * @param array $options Input options.
		 * @return array Sanitized options
		 * @since 2.0.0
		 */
		public function sanitize_options( array $options ): array {
			// Verify nonce.
			if ( ! isset( $_POST['ndc_post_date_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ndc_post_date_nonce'] ) ), 'ndc_post_date_options_nonce' ) ) {
				wp_die( esc_html__( 'Security check failed', 'nepali-date-converter' ) );
			}

			// Active settings.
			$sanitized['active']['date']          = isset( $options['active']['date'] );
			$sanitized['active']['time']          = isset( $options['active']['time'] );
			$sanitized['active']['modified_date'] = isset( $options['active']['modified_date'] );
			$sanitized['active']['modified_time'] = isset( $options['active']['modified_time'] );

			// Date format.
			$sanitized['date_format']['selected'] = isset( $options['date_format']['selected'] ) ? sanitize_text_field( $options['date_format']['selected'] ) : 'F j, Y';
			$sanitized['date_format']['custom']   = isset( $options['date_format']['custom'] ) ? sanitize_text_field( $options['date_format']['custom'] ) : '';

			// Force format.
			$sanitized['force_format'] = isset( $options['force_format'] );

			// Human time diff.
			$sanitized['human_time_diff']['front']   = isset( $options['human_time_diff']['front'] );
			$sanitized['human_time_diff']['home']    = isset( $options['human_time_diff']['home'] );
			$sanitized['human_time_diff']['archive'] = isset( $options['human_time_diff']['archive'] );
			$sanitized['human_time_diff']['single']  = isset( $options['human_time_diff']['single'] );
			$sanitized['human_time_diff']['suffix']  = sanitize_text_field( $options['human_time_diff']['suffix'] );

			// Post types.
			$sanitized['post_types'] = isset( $options['post_types'] ) ? array_map( 'sanitize_key', $options['post_types'] ) : array();

			return $sanitized;
		}

		/**
		 * Add JavaScript for settings page with nonce security
		 *
		 * @since 2.0.0
		 */
		public function add_settings_js(): void {
			$current_screen = get_current_screen();
			if ( 'options-general' !== $current_screen->id ) {
				return;
			}

			// Create a nonce for the AJAX request.
			$ajax_nonce = wp_create_nonce( 'ndc_date_format_nonce' );
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var ndcNonce = '<?php echo esc_js( $ajax_nonce ); ?>';
					
					// Handle date format selection
					$("input[name='ndc_post_date_options[date_format][selected]']").click(function() {
						if ( "ndc_post_date_options_custom_radio" !== $(this).attr("id") ) {
							$('input[name="ndc_post_date_options[date_format][custom]"]')
								.val($(this).val())
								.closest('fieldset')
								.find('.example')
								.text($(this).parent('label').children('.format-i18n').text());
						}
					});

					// Handle custom date format input
					$('input[name="ndc_post_date_options[date_format][custom]"]').on('click input', function() {
						$('#ndc_post_date_options_custom_radio').prop('checked', true);

						var format = $(this),
							fieldset = format.closest('fieldset'),
							example = fieldset.find('.example'),
							spinner = fieldset.find('.spinner');

						// Debounce the event callback while users are typing
						clearTimeout($.data(this, 'timer'));
						$(this).data('timer', setTimeout(function() {
							if (format.val()) {
								spinner.addClass('is-active');
								$.post(ajaxurl, {
									action: 'ndc_date_format',
									date: format.val(),
									_ajax_nonce: ndcNonce
								}, function(d) {
									spinner.removeClass('is-active');
									example.html(d);
								}).fail(function(xhr) {
									spinner.removeClass('is-active');
									example.text('Error: ' + xhr.responseText);
								});
							}
						}, 500));
					});

					// Update human time diff suffix preview
					$('input[name="ndc_post_date_options[human_time_diff][suffix]"]').on('click input', function() {
						$('#ndc-htd-example').children('span').text($(this).val());
					});
				});
			</script>
			<?php
		}

		/**
		 * Get Nepali date preview for a given format with error handling.
		 *
		 * @param string $format Date format.
		 * @return string Formatted Nepali date.
		 * @throws Exception If the date conversion result is invalid.
		 * @since 2.0.0
		 */
		private function get_nepali_date_preview( string $format ): string {
			try {
				$timezone   = new DateTimeZone( 'Asia/Kathmandu' );
				$datetime   = new DateTime( 'now', $timezone );
				$date_parts = explode( '-', $datetime->format( 'Y-m-d-H-i-s' ) );

				$nepali_date = ndc_eng_to_nep_date(
					array(
						'year'  => (int) $date_parts[0],
						'month' => (int) $date_parts[1],
						'day'   => (int) $date_parts[2],
						'hour'  => (int) $date_parts[3],
						'min'   => (int) $date_parts[4],
						'sec'   => (int) $date_parts[5],
					),
					'nep_char',
					$format
				);

				if ( ! isset( $nepali_date['result'] ) ) {
					throw new Exception( 'Invalid date conversion result' );
				}

				return $nepali_date['result'];
			} catch ( Exception $e ) {
				return __( 'Error generating date preview', 'nepali-date-converter' );
			}
		}

		/**
		 * AJAX handler for date format preview with nonce verification
		 *
		 * @since 2.0.0
		 */
		public function ajax_get_date_format(): void {
			// Verify nonce first.
			check_ajax_referer( 'ndc_date_format_nonce', '_ajax_nonce' );

			if ( ! isset( $_POST['date'] ) ) {
				wp_send_json_error( esc_html__( 'Date format not provided', 'nepali-date-converter' ) );
				wp_die();
			}

			// Sanitize the input.
			$format = sanitize_text_field( wp_unslash( $_POST['date'] ) );

			if ( empty( $format ) ) {
				wp_send_json_error( esc_html__( 'Invalid date format', 'nepali-date-converter' ) );
				wp_die();
			}

			wp_send_json_success( $this->get_nepali_date_preview( $format ) );
			wp_die();
		}

		/**
		 * Initialize the plugin functionality
		 *
		 * @since 2.0.0
		 */
		public function init(): void {
			// Load options for both backend and frontend.
			$db_options    = get_option( 'ndc_post_date_options', self::DEFAULTS );
			$this->options = wp_parse_args( $db_options, self::DEFAULTS );
			$this->options = apply_filters( 'ndc_post_date_options', $this->options );

			// Skip frontend hooks in admin.
			if ( is_admin() ) {
				return;
			}

			// Set up filters based on active options.
			$filters = array();
			if ( $this->options['active']['date'] ) {
				$filters[] = 'get_the_date';
			}
			if ( $this->options['active']['time'] ) {
				$filters[] = 'get_the_time';
			}
			if ( $this->options['active']['modified_date'] ) {
				$filters[] = 'get_the_modified_date';
			}
			if ( $this->options['active']['modified_time'] ) {
				$filters[] = 'get_the_modified_time';
			}

			$filters = apply_filters( 'ndc_post_date_filters', $filters );

			foreach ( $filters as $filter ) {
				add_filter( $filter, array( $this, 'convert_post_date_to_nepali' ), 10, 3 );
			}
		}

		/**
		 * Convert post date to Nepali date
		 *
		 * @param string  $the_date Original date string.
		 * @param string  $format Date format.
		 * @param WP_Post $post Post object.
		 * @return string Converted Nepali date.
		 * @since 2.0.0
		 */
		public function convert_post_date_to_nepali( string $the_date, string $format, WP_Post $post ): string {
			// Skip if post type not supported.
			if ( ! in_array( $post->post_type, $this->options['post_types'], true ) ) {
				return $the_date;
			}

			// Determine format to use.
			$result_format = $format && ! $this->options['force_format']
			? $format
			: ( 'ndc-date-format-custom' !== $this->options['date_format']['selected']
				? $this->options['date_format']['selected']
				: $this->options['date_format']['custom'] );

			// Handle Unix timestamp format.
			if ( 'U' === $result_format || 'U' === $format ) {
				return strtr( $the_date, ndc_nepali_calendar()->eng_nep_num );
			}

			// Handle human time diff if enabled.
			$post_timestamp = strtotime( $post->post_date );
			if ( $this->should_use_human_time_diff() ) {
				$current_local_timestamp = strtotime( get_date_from_gmt( gmdate( 'Y-m-d H:i:s' ), 'Y-m-d H:i:s' ) );
				return ndc_human_time_diff( $post_timestamp, $current_local_timestamp ) . ' ' . esc_html( $this->options['human_time_diff']['suffix'] );
			}

			// Convert to Nepali date.
			$date_parts = explode( '-', wp_date( 'Y-m-d-H-i-s', $post_timestamp ) );

			$nepali_date = ndc_eng_to_nep_date(
				array(
					'year'  => (int) $date_parts[0],
					'month' => (int) $date_parts[1],
					'day'   => (int) $date_parts[2],
					'hour'  => (int) $date_parts[3],
					'min'   => (int) $date_parts[4],
					'sec'   => (int) $date_parts[5],
				),
				'nep_char',
				$result_format
			);

			return $nepali_date['result'];
		}

		/**
		 * Check if human time diff should be used
		 *
		 * @return bool Whether to use human time diff
		 * @since 2.0.0
		 */
		private function should_use_human_time_diff(): bool {
			$htd = $this->options['human_time_diff'];
			return ( is_front_page() && $htd['front'] ) ||
				( is_home() && $htd['home'] ) ||
				( is_archive() && $htd['archive'] ) ||
				( is_single() && $htd['single'] );
		}
	}
}


/**
 * Get the NDC_Post_Date instance
 *
 * @return NDC_Post_Date
 * @since 2.0.0
 */
function ndc_post_date(): NDC_Post_Date {//phpcs:ignore
	return NDC_Post_Date::get_instance();
}

// Initialize the plugin.
ndc_post_date()->run();
