<?php // phpcs:ignore
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ndc_widget_scripts' ) ) {
	/**
	 * Enqueue necessary JavaScript dependencies
	 *
	 * Ensures jQuery is loaded for widget functionality
	 *
	 * @since 1.0.0
	 * @hook wp_enqueue_scripts
	 */
	function ndc_widget_scripts() {
		// Enqueue jQuery (already registered by WordPress core).
		wp_enqueue_script( 'jquery' );

		/**
		 * Fires after core scripts are enqueued
		 *
		 * @since 1.0.0
		 */
		do_action( 'ndc_after_widget_scripts' );
	}
	add_action( 'wp_enqueue_scripts', 'ndc_widget_scripts' );
}
