<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nepali Date Converter Widget
 *
 * @package Nepali Date Converter
 * @since 1.0.0
 */

if ( ! class_exists( 'Widget_NDC' ) ) {

	/**
	 * Class Widget_NDC - Nepali Date Converter Widget
	 */
	class Widget_NDC extends WP_Widget {

		/**
		 * Widget constructor
		 */
		public function __construct() {
			parent::__construct(
				'widget_nepali_date_converter',
				__( 'NDC: Nepali Date Converter', 'nepali-date-converter' ),
				array(
					'description' => __( 'Easily convert English Date to Nepali Date and Vice Versa', 'nepali-date-converter' ),
				)
			);

			// Load scripts only if widget is active.
			if ( is_active_widget( false, false, $this->id_base ) ) {
				add_action( 'wp_enqueue_scripts', 'ndc_widget_scripts' );
				add_action( 'wp_footer', 'ndc_widget_wp_footer' );
			}
		}

		/**
		 * Widget backend form
		 *
		 * @param array $instance Current widget instance.
		 */
		public function form( $instance ) {
			$defaults = array(
				'title'                               => __( 'Nepali Date Converter', 'nepali-date-converter' ),
				'disable_ndc_convert_nep_to_eng'      => '',
				'disable_ndc_convert_eng_to_nep'      => '',
				'nepali_date_converter_result_format' => 'D, F j, Y',
				'nepali_date_lang'                    => 'nep_char',
				'nep_to_eng_button_text'              => __( 'Nepali to English', 'nepali-date-converter' ),
				'eng_to_nep_button_text'              => __( 'English to Nepali', 'nepali-date-converter' ),
			);

			$instance = wp_parse_args( (array) $instance, $defaults );

			// Form fields.
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php esc_html_e( 'Enter title:', 'nepali-date-converter' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
					type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'disable_ndc_convert_nep_to_eng' ) ); ?>" 
					name="<?php echo esc_attr( $this->get_field_name( 'disable_ndc_convert_nep_to_eng' ) ); ?>" 
					type="checkbox" value="1" <?php checked( 1, $instance['disable_ndc_convert_nep_to_eng'] ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'disable_ndc_convert_nep_to_eng' ) ); ?>">
					<?php esc_html_e( 'Disable convert nep to eng', 'nepali-date-converter' ); ?>
				</label><br>

				<input id="<?php echo esc_attr( $this->get_field_id( 'disable_ndc_convert_eng_to_nep' ) ); ?>" 
					name="<?php echo esc_attr( $this->get_field_name( 'disable_ndc_convert_eng_to_nep' ) ); ?>" 
					type="checkbox" value="1" <?php checked( 1, $instance['disable_ndc_convert_eng_to_nep'] ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'disable_ndc_convert_eng_to_nep' ) ); ?>">
					<?php esc_html_e( 'Disable convert eng to nep', 'nepali-date-converter' ); ?>
				</label><br>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'nepali_date_converter_result_format' ) ); ?>">
					<?php esc_html_e( 'Result format', 'nepali-date-converter' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'nepali_date_converter_result_format' ) ); ?>" 
					name="<?php echo esc_attr( $this->get_field_name( 'nepali_date_converter_result_format' ) ); ?>" 
					type="text" value="<?php echo esc_attr( $instance['nepali_date_converter_result_format'] ); ?>" 
					placeholder="<?php esc_attr_e( '1,25,9', 'nepali-date-converter' ); ?>"/>
				<small>
					<?php
					printf(
						// translators: 1: Example date format, 2: Opening anchor tag to WordPress date formatting codex, 3: Closing anchor tag.
						esc_html__( 'By default the date format is %1$s. Other %2$sdate formats%3$s also supported except "S"', 'nepali-date-converter' ),
						'<code style="background: #ddd;display: inline;padding: 5px">D, F j, Y</code>',
						'<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">',
						'</a>'
					);
					?>
				</small>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'nepali_date_lang' ) ); ?>">
					<?php esc_html_e( 'Nepali date language', 'nepali-date-converter' ); ?>
				</label>
				<select class="widefat" 
					name="<?php echo esc_attr( $this->get_field_name( 'nepali_date_lang' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'nepali_date_lang' ) ); ?>">
					<?php
					$options = array(
						'nep_char' => __( 'Nepali', 'nepali-date-converter' ),
						'eng_char' => __( 'English', 'nepali-date-converter' ),
					);

					foreach ( $options as $value => $label ) {
						printf(
							'<option value="%s" %s>%s</option>',
							esc_attr( $value ),
							selected( $value, $instance['nepali_date_lang'], false ),
							esc_html( $label )
						);
					}
					?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'nep_to_eng_button_text' ) ); ?>">
					<?php esc_html_e( 'Nepali to english button text', 'nepali-date-converter' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'nep_to_eng_button_text' ) ); ?>" 
					name="<?php echo esc_attr( $this->get_field_name( 'nep_to_eng_button_text' ) ); ?>" 
					type="text" value="<?php echo esc_attr( $instance['nep_to_eng_button_text'] ); ?>" 
					placeholder="<?php esc_attr_e( '1,25,9', 'nepali-date-converter' ); ?>"/>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'eng_to_nep_button_text' ) ); ?>">
					<?php esc_html_e( 'English to Nepali button text', 'nepali-date-converter' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'eng_to_nep_button_text' ) ); ?>" 
					name="<?php echo esc_attr( $this->get_field_name( 'eng_to_nep_button_text' ) ); ?>" 
					type="text" value="<?php echo esc_attr( $instance['eng_to_nep_button_text'] ); ?>" 
					placeholder="<?php esc_attr_e( 'Select option', 'nepali-date-converter' ); ?>"/>
			</p>
			<?php
		}

		/**
		 * Update widget settings
		 *
		 * @param array $new_instance New settings.
		 * @param array $old_instance Old settings.
		 * @return array Updated settings
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['title']                               = sanitize_text_field( $new_instance['title'] ?? '' );
			$instance['disable_ndc_convert_nep_to_eng']      = isset( $new_instance['disable_ndc_convert_nep_to_eng'] ) ? 1 : 0;
			$instance['disable_ndc_convert_eng_to_nep']      = isset( $new_instance['disable_ndc_convert_eng_to_nep'] ) ? 1 : 0;
			$instance['nepali_date_converter_result_format'] = sanitize_text_field( $new_instance['nepali_date_converter_result_format'] ?? '' );
			$instance['nepali_date_lang']                    = sanitize_text_field( $new_instance['nepali_date_lang'] ?? '' );
			$instance['nep_to_eng_button_text']              = sanitize_text_field( $new_instance['nep_to_eng_button_text'] ?? '' );
			$instance['eng_to_nep_button_text']              = sanitize_text_field( $new_instance['eng_to_nep_button_text'] ?? '' );

			return $instance;
		}

		/**
		 * Display the widget
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Widget instance.
		 */
		public function widget( $args, $instance ) {
			$defaults = array(
				'title'                               => __( 'Nepali Date Converter', 'nepali-date-converter' ),
				'disable_ndc_convert_nep_to_eng'      => '',
				'disable_ndc_convert_eng_to_nep'      => '',
				'nepali_date_converter_result_format' => 'D, F j, Y',
				'nepali_date_lang'                    => 'nep_char',
				'nep_to_eng_button_text'              => __( 'Nepali to English', 'nepali-date-converter' ),
				'eng_to_nep_button_text'              => __( 'English to Nepali', 'nepali-date-converter' ),
			);

			$instance = wp_parse_args( (array) $instance, $defaults );
			$title    = apply_filters( 'widget_title', $instance['title'] );

			// Display the widget.
			ndc_frontend()->nepali_date_converter(
				array(
					'before'                         => $args['before_widget'],
					'after'                          => $args['after_widget'],
					'before_title'                   => $args['before_title'],
					'after_title'                    => $args['after_title'],
					'title'                          => $title,
					'disable_ndc_convert_nep_to_eng' => $instance['disable_ndc_convert_nep_to_eng'],
					'disable_ndc_convert_eng_to_nep' => $instance['disable_ndc_convert_eng_to_nep'],
					'nepali_date_lang'               => $instance['nepali_date_lang'],
					'nep_to_eng_button_text'         => $instance['nep_to_eng_button_text'],
					'eng_to_nep_button_text'         => $instance['eng_to_nep_button_text'],
					'result_format'                  => $instance['nepali_date_converter_result_format'],
				)
			);
		}
	}
}

/**
 * Register the widget
 */
function register_ndc_widget() {//phpcs:ignore
	register_widget( 'Widget_NDC' );
}
add_action( 'widgets_init', 'register_ndc_widget' );
