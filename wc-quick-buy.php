<?php
/**
 * Plugin Name:       Quick Buy For WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/woocommerce-quick-buy/
 * Description:       Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button
 * Version:           2.8.1
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in
 * Text Domain:       wc-quick-buy
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * GitHub Plugin URI: https://github.com/varunsridharan/woocommerce-quick-buy
 * Domain Path:       /i18n
 * WC requires at least: 2.0
 * WC tested up to: 4.4.1
 */

defined( 'ABSPATH' ) || exit;

defined( 'WCQB_FILE' ) || define( 'WCQB_FILE', __FILE__ );
defined( 'WCQB_VERSION' ) || define( 'WCQB_VERSION', '2.8.1' );
defined( 'WCQB_NAME' ) || define( 'WCQB_NAME', __( 'Quick Buy For WooCommerce', 'wc-quick-buy' ) );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

if ( function_exists( 'vsp_maybe_load' ) ) {
	vsp_maybe_load( 'wc_quick_buy_init', __DIR__ . '/vendor/varunsridharan' );
}

if ( function_exists( 'wponion_load' ) ) {
	wponion_load( __DIR__ . '/vendor/wponion/wponion' );
}

if ( ! function_exists( 'wc_quick_buy_init' ) ) {
	/**
	 * Inits WC Quick Buy Plugin Once VSP Framework is Loaded.
	 *
	 * @return bool|\WC_Quick_Buy
	 */
	function wc_quick_buy_init() {
		if ( ! vsp_add_wc_required_notice( WCQB_NAME ) && ( ! vsp_is_ajax() || ! vsp_is_cron() ) ) {
			require_once __DIR__ . '/bootstrap.php';
			return wc_quick_buy();
		}
		return false;
	}
}

if ( ! function_exists( 'wc_quikc_buy' ) ) {
	/**
	 * Returns Quick Buy Plugins Instance.
	 *
	 * @return bool|\WC_Quick_Buy
	 */
	function wc_quick_buy() {
		return WC_Quick_Buy::instance();
	}
}
