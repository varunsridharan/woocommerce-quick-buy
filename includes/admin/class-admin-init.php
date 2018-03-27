<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    @TODO
 * @subpackage @TODO
 * @author     Varun Sridharan <varunsridharan23@gmail.com>
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WooCommerce_Quick_Buy_Admin extends WooCommerce_Quick_Buy {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      0.1
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'settings_page' ) );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_links' ), 10, 2 );
	}

	public function settings_page( $integrations ) {
		foreach ( glob( WCQB_ADMIN . 'woocommerce-settings*.php' ) as $file ) {
			$integrations[] = require_once( $file );
		}
		return $integrations;
	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {
		if ( in_array( $this->current_screen(), $this->get_screen_ids() ) ) {
			wp_enqueue_style( WCQB_SLUG . '_core_style', WCQB_CSS . 'style.css', array(), WCQB_V, 'all' );
		}
	}

	/**
	 * Gets Current Screen ID from wordpress
	 *
	 * @return string [Current Screen ID]
	 */
	public function current_screen() {
		$screen = get_current_screen();
		return $screen->id;
	}

	/**
	 * Returns Predefined Screen IDS
	 *
	 * @return [Array]
	 */
	public function get_screen_ids() {
		$screen_ids = array();
		return $screen_ids;
	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
		if ( in_array( $this->current_screen(), $this->get_screen_ids() ) ) {
			wp_enqueue_script( WCQB_SLUG . '_core_script', WCQB_JS . 'script.js', array( 'jquery' ), WCQB_V, false );
		}

	}

	/**
	 * Adds Some Plugin Options
	 *
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 *
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( WCQB_FILE == $plugin_file ) {
			$settings_url  = admin_url( 'admin.php?page=wc-settings&tab=wc_quick_buy_settings' );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', $settings_url, __( 'Settings', WCQB_TXT ) );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'https://wordpress.org/plugins/woocommerce-quick-buy/faq/', __( 'F.A.Q', WCQB_TXT ) );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'http://github.com/technofreaky/woocommerce-quick-buy', __( 'View On Github', WCQB_TXT ) );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'http://github.com/technofreaky/woocommerce-quick-buy', __( 'Report Issue', WCQB_TXT ) );
			$plugin_meta[] = sprintf( '&hearts; <a href="%s">%s</a>', 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YUBNEPWZMGTTQ', $this->__( 'Donate', WCQB_TXT ) );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __( 'Contact Author', WCQB_TXT ) );
		}
		return $plugin_meta;
	}
}