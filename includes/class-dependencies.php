<?php
/**
 * WC Dependency Checker
 *
 * Checks if WooCommerce is enabled
 */
if ( ! class_exists( 'WooCommerce_Quick_Buy_Dependencies' ) ) {
	class WooCommerce_Quick_Buy_Dependencies {

		private static $active_plugins;

		public static function init() {
			self::$active_plugins = (array) get_option( 'active_plugins', array() );
			if ( is_multisite() )
				self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		public static function active_check( $pluginToCheck = '' ) {
			if ( ! self::$active_plugins )
				self::init();
			return in_array( $pluginToCheck, self::$active_plugins ) || array_key_exists( $pluginToCheck, self::$active_plugins );
		}
	}
}
/**
 * WC Detection
 */
if ( ! function_exists( 'WooCommerce_Quick_Buy_Dependencies' ) ) {
	function WooCommerce_Quick_Buy_Dependencies( $pluginToCheck = 'woocommerce/woocommerce.php' ) {
		return WooCommerce_Quick_Buy_Dependencies::active_check( $pluginToCheck );
	}
}