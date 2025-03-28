<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ndc_widget_wp_footer' ) ) :

	/**
	 * Add styles and scripts for Nepali Date Converter widget in footer
	 *
	 * @since 1.0.0
	 */
	function ndc_widget_wp_footer() {
		// Generate nonce for AJAX requests.
		$ajax_nonce = wp_create_nonce( 'ndc_ajax_nonce' );
		?>
		<style type="text/css">
			.nepali-date-converter,
			.nepali-date-converter-result,
			.nepali-date-converter-trigger {
				margin-top: 10px;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(document).on("click", ".nepali-date-converter-trigger", function(e) {
					e.preventDefault();
					
					if ($(this).hasClass('from-nep') || $(this).hasClass('from-eng')) {
						var from = 'from-eng';
						if ($(this).hasClass('from-nep')) {
							from = 'from-nep';
						}
						
						var lang = 'nep_char';
						if ($(this).data('lang')) {
							lang = $(this).data('lang');
						}
						
						var year = $(this).siblings('.year').val();
						var month = $(this).siblings('.month').val();
						var day = $(this).siblings('.day').val();
						var result_format = $(this).data('result');
						var result_html = $(this).closest('.nepali-date-converter').siblings('.nepali-date-converter-result');
						
						jQuery.ajax({
							type: "POST",
							url: "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>",
							data: {
								action: 'nepali_date_converter_ajax',
								from: from,
								year: year,
								month: month,
								day: day,
								result_format: result_format,
								lang: lang,
								security: '<?php echo esc_js( $ajax_nonce ); ?>'
							},
							beforeSend: function() {
								var wait = '<?php esc_html_e( 'Please wait...', 'nepali-date-converter' ); ?>';
								if ('from-eng' == from) {
									wait = '<?php esc_html_e( 'कृपया पर्खनुहोस्...', 'nepali-date-converter' ); ?>';
								}
								result_html.html(wait);
							},
							success: function(response) {
								if (response && response.success && response.data) {
									result_html.html(response.data);
								} else {
									result_html.html('<?php esc_html_e( 'Invalid response', 'nepali-date-converter' ); ?>');
								}
							},
							error: function(xhr, status, error) {
								result_html.html('<?php esc_html_e( 'Error processing request', 'nepali-date-converter' ); ?>');
								console.error(error);
							},
							dataType: 'json'
						});
					}
				});
			});
		</script>
		<?php
	}
endif;
