<?php
/**
 * Plugin Name:       WooCommerce Quick Buy
 * Plugin URI:        https://wordpress.org/plugins/woocommerce-quick-buy/
 * Description:       Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button
 * Version:           1.9
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in
 * Text Domain:       woocommerce-quick-buy
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/varunsridharan/woocommerce-quick-buy
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'includes/common-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'bootstrap.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-dependencies.php' );


if ( WooCommerce_Quick_Buy_Dependencies() ) {
	if ( ! function_exists( 'WooCommerce_Quick_Buy' ) ) {
		function WooCommerce_Quick_Buy() {
			return WooCommerce_Quick_Buy::get_instance();
		}
	}
	WooCommerce_Quick_Buy();
}