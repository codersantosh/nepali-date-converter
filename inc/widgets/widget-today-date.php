<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nepali Date Converter - Today's Date Widget
 *
 * @package Nepali Date Converter
 * @since 1.0.0
 */

if ( ! class_exists( 'Widget_NDC_Today' ) ) {

	/**
	 * Widget for displaying today's date in English and Nepali
	 */
	class Widget_NDC_Today extends WP_Widget {

		/**
		 * Widget constructor
		 */
		public function __construct() {
			parent::__construct(
				'widget_ndc_today',
				__( 'NDC: Today Date', 'nepali-date-converter' ),
				array(
					'description' => __( 'Show Today English Date / Nepali Date', 'nepali-date-converter' ),
					'classname'   => 'widget-ndc-today',
				)
			);
		}

		/**
		 * Widget backend form
		 *
		 * @param array $instance Current widget instance.
		 */
		public function form( $instance ) {
			$defaults = array(
				'title'                   => __( 'Date', 'nepali-date-converter' ),
				'disable_today_nep_date'  => '',
				'disable_today_eng_date'  => '',
				'ndc_today_result_format' => 'D, F j, Y',
				'nepali_date_lang'        => 'nep_char',
			);

			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php esc_html_e( 'Title:', 'nepali-date-converter' ); ?>
				</label>
				<input class="widefat" 
						id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
						name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
						type="text" 
						value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'disable_today_nep_date' ) ); ?>" 
						name="<?php echo esc_attr( $this->get_field_name( 'disable_today_nep_date' ) ); ?>" 
						type="checkbox" 
						value="1" <?php checked( '1', $instance['disable_today_nep_date'] ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'disable_today_nep_date' ) ); ?>">
					<?php esc_html_e( 'Disable today nep date', 'nepali-date-converter' ); ?>
				</label>
				<br>

				<input id="<?php echo esc_attr( $this->get_field_id( 'disable_today_eng_date' ) ); ?>" 
						name="<?php echo esc_attr( $this->get_field_name( 'disable_today_eng_date' ) ); ?>" 
						type="checkbox" 
						value="1" <?php checked( '1', $instance['disable_today_eng_date'] ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'disable_today_eng_date' ) ); ?>">
					<?php esc_html_e( 'Disable today eng date', 'nepali-date-converter' ); ?>
				</label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'ndc_today_result_format' ) ); ?>">
					<?php esc_html_e( 'Result format:', 'nepali-date-converter' ); ?>
				</label>
				<input class="widefat" 
						id="<?php echo esc_attr( $this->get_field_id( 'ndc_today_result_format' ) ); ?>" 
						name="<?php echo esc_attr( $this->get_field_name( 'ndc_today_result_format' ) ); ?>" 
						type="text" 
						value="<?php echo esc_attr( $instance['ndc_today_result_format'] ); ?>" 
						placeholder="D, F j, Y" />
				<small>
					<?php
					printf(
						// translators: 1: Example date format, 2: Opening anchor tag to WordPress date formatting codex, 3: Closing anchor tag.
						esc_html__(
							'By default the date format is %1$s. Other %2$sdate formats%3$s also supported except "S"',
							'nepali-date-converter'
						),
						'<code style="background: #ddd;display: inline;padding: 5px">D, F j, Y</code>',
						'<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">',
						'</a>'
					);
					?>
				</small>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'nepali_date_lang' ) ); ?>">
					<?php esc_html_e( 'Nepali date language:', 'nepali-date-converter' ); ?>
				</label>
				<select class="widefat" 
						id="<?php echo esc_attr( $this->get_field_id( 'nepali_date_lang' ) ); ?>" 
						name="<?php echo esc_attr( $this->get_field_name( 'nepali_date_lang' ) ); ?>">
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

			$instance['title']                   = sanitize_text_field( $new_instance['title'] ?? '' );
			$instance['disable_today_nep_date']  = isset( $new_instance['disable_today_nep_date'] ) ? '1' : '';
			$instance['disable_today_eng_date']  = isset( $new_instance['disable_today_eng_date'] ) ? '1' : '';
			$instance['ndc_today_result_format'] = sanitize_text_field( $new_instance['ndc_today_result_format'] ?? 'D, F j, Y' );
			$instance['nepali_date_lang']        = in_array( $new_instance['nepali_date_lang'] ?? '', array( 'nep_char', 'eng_char' ) )
				? $new_instance['nepali_date_lang']
				: 'nep_char';

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
				'title'                   => __( 'Date', 'nepali-date-converter' ),
				'disable_today_nep_date'  => '',
				'disable_today_eng_date'  => '',
				'ndc_today_result_format' => 'D, F j, Y',
				'nepali_date_lang'        => 'nep_char',
			);

			$instance = wp_parse_args( (array) $instance, $defaults );
			$title    = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

			// Output the widget.
			ndc_frontend()->today_date(
				array(
					'before'                 => $args['before_widget'],
					'after'                  => $args['after_widget'],
					'before_title'           => $args['before_title'],
					'after_title'            => $args['after_title'],
					'title'                  => $title,
					'disable_today_nep_date' => $instance['disable_today_nep_date'],
					'disable_today_eng_date' => $instance['disable_today_eng_date'],
					'nepali_date_lang'       => $instance['nepali_date_lang'],
					'result_format'          => $instance['ndc_today_result_format'],
				)
			);
		}
	}
}

/**
 * Register the widget
 */
function register_ndc_today_widget() {//phpcs:ignore
	register_widget( 'Widget_NDC_Today' );
}
add_action( 'widgets_init', 'register_ndc_today_widget' );
