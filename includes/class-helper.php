<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

/**
 * Class Helper
 *
 * @package WC_Quick_Buy
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
final class Helper {
	/**
	 * @var bool
	 */
	protected static $custom_style = false;

	/**
	 * @param      $option_key
	 * @param bool $defaults
	 *
	 * @return array|bool|\WPOnion\DB\Option
	 */
	public static function option( $option_key, $defaults = false ) {
		return wpo_settings( '_wc_quick_buy', $option_key, $defaults );
	}

	/**
	 * Provides All Possible Redirect Locations.
	 *
	 * @return array
	 */
	public static function redirect_locations() {
		return array(
			'cart'       => __( 'Cart', 'wc-quick-buy' ),
			'checkout'   => __( 'Checkout', 'wc-quick-buy' ),
			'custom'     => __( 'Custom URL', 'wc-quick-buy' ),
			'noredirect' => __( 'No Redirect', 'wc-quick-buy' ),
		);
	}

	/**
	 * Returns All Possible Product Types.
	 *
	 * @return array
	 */
	public static function product_types() {
		return array(
			'all'                   => __( 'All Product Types', 'wc-quick-buy' ),
			'simple'                => __( 'Simple Products', 'wc-quick-buy' ),
			'variable'              => __( 'Variable Products', 'wc-quick-buy' ),
			'yith-bundle'           => __( 'YITH Product Bundles', 'wc-quick-buy' ),
			'bundle'                => __( 'WC Product Bundles', 'wc-quick-buy' ),
			'subscription'          => __( 'WC Variable Subscription', 'wc-quick-buy' ),
			'variable-subscription' => __( 'WC Variable Subscription', 'wc-quick-buy' ),
		);
	}

	/**
	 * Returns Single Product Placement Options.
	 *
	 * @return array
	 */
	public static function single_product_placement() {
		return array(
			'none'          => __( 'Disable', 'wc-quick-buy' ),
			'before_form'   => __( 'Before Add To Cart', 'wc-quick-buy' ),
			'after_form'    => __( 'After Add To Cart', 'wc-quick-buy' ),
			'after_button'  => __( 'Next To Add To Cart Button', 'wc-quick-buy' ),
			'before_button' => __( 'Prev To Add To Cart Button', 'wc-quick-buy' ),
		);
	}

	/**
	 * Returns Shop Page Placement Options.
	 *
	 * @return array
	 */
	public static function shop_page_placement() {
		return array(
			'none'          => __( 'Disable', 'wc-quick-buy' ),
			'after_button'  => __( 'Next To Add To Cart Button', 'wc-quick-buy' ),
			'before_button' => __( 'Prev To Add To Cart Button', 'wc-quick-buy' ),
		);
	}

	/**
	 * Returns Button Presets Options.
	 *
	 * @return array
	 */
	public static function button_presets() {
		return array(
			'none'    => __( 'None', 'wc-quick-buy' ),
			'preset1' => __( 'Carrot Orange', 'wc-quick-buy' ),
			'preset2' => __( 'Mango Color', 'wc-quick-buy' ),
			'preset3' => __( 'Hydrate Leaf', 'wc-quick-buy' ),
			'preset4' => __( 'Sea & Cloud', 'wc-quick-buy' ),
			'preset5' => __( 'Dark Room', 'wc-quick-buy' ),
			'preset6' => __( 'Tomato', 'wc-quick-buy' ),
		);
	}

	/**
	 * Fetches DB And returns a valid redirect url.
	 *
	 * @return array|bool|string|\WPOnion\DB\Option
	 */
	public static function redirect_url() {
		$redirect = Helper::option( 'redirect_location' );
		switch ( $redirect ) {
			case 'cart':
				return wc_get_cart_url();
				break;
			case 'checkout':
				return wc_get_checkout_url();
				break;
			case 'custom':
				if ( ! empty( Helper::option( 'custom_location' ) ) ) {
					return Helper::option( 'custom_location' );
				}
				break;
		}
		return wc_get_cart_url();
	}

	/**
	 * Adds Custom Style in Frontend.
	 */
	public static function add_custom_style() {
		if ( false === self::$custom_style ) {
			$style = Helper::option( 'custom_css', '' );
			$style = str_replace( '<style>', '', $style );
			$style = str_replace( '</style>', '', $style );
			if ( ! empty( $style ) ) {
				wp_add_inline_style( 'wcqb-button-presets', $style );
			}
			self::$custom_style = true;
		}
	}

	/**
	 * Returns All Product Types.
	 *
	 * @return array
	 */
	public static function get_all_product_types() {
		$types = wc_get_product_types();
		if ( isset( $types['variable'] ) ) {
			unset( $types['variable'] );
		}
		if ( isset( $types['external'] ) ) {
			unset( $types['external'] );
		}
		if ( isset( $types['grouped'] ) ) {
			unset( $types['grouped'] );
		}
		return $types;
	}

	/**
	 * Checks if is_add_to_cart request made by Quick Buy.
	 *
	 * @return bool
	 */
	public static function is_add_to_cart_request() {
		return isset( $_REQUEST['quick_buy'] ) && ! empty( $_REQUEST['quick_buy'] );
	}

	/**
	 * Fetches Valid URL For Site.
	 *
	 * @static
	 * @return string|void
	 * @since {NEWVERSION}
	 */
	public static function get_valid_wp_url() {
		return ( 'home_url' === self::option( 'url_type' ) ) ? home_url() : site_url();
	}
}
