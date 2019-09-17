<?php

namespace WC_Quick_Buy;

if ( ! class_exists( '\WC_Quick_Buy\Helper' ) ) {
	/**
	 * Class Helper
	 *
	 * @package WC_Quick_Buy
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 * @since 1.0
	 */
	final class Helper {
		/**
		 * @var bool
		 * @static
		 */
		protected static $custom_style = false;

		/**
		 * @param      $option_key
		 * @param bool $defaults
		 *
		 * @static
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
				'cart'     => __( 'Cart' ),
				'checkout' => __( 'Checkout' ),
				'custom'   => __( 'Custom URL' ),
			);
		}

		/**
		 * Returns All Possible Product Types.
		 *
		 * @static
		 * @return array
		 */
		public static function product_types() {
			return array(
				'all'                   => __( 'All Product Types' ),
				'simple'                => __( 'Simple Products' ),
				'variable'              => __( 'Variable Products' ),
				'yith-bundle'           => __( 'YITH Product Bundles' ),
				'bundle'                => __( 'WC Product Bundles' ),
				'subscription'          => __( 'WC Variable Subscription' ),
				'variable-subscription' => __( 'WC Variable Subscription' ),
			);
		}

		/**
		 * @static
		 * @return array
		 */
		public static function single_product_placement() {
			return array(
				'none'          => __( 'Disable' ),
				'before_form'   => __( 'Before Add To Cart' ),
				'after_form'    => __( 'After Add To Cart' ),
				'after_button'  => __( 'Next To Add To Cart Button' ),
				'before_button' => __( 'Prev To Add To Cart Button' ),
			);
		}

		/**
		 * @static
		 * @return array
		 */
		public static function shop_page_placement() {
			return array(
				'none'          => __( 'Disable' ),
				'after_button'  => __( 'Next To Add To Cart Button' ),
				'before_button' => __( 'Prev To Add To Cart Button' ),
			);
		}

		/**
		 * @static
		 * @return array
		 */
		public static function button_presets() {
			return array(
				'none'    => __( 'None' ),
				'preset1' => __( 'Carrot Orange' ),
				'preset2' => __( 'Mango Color' ),
				'preset3' => __( 'Hydrate Leaf' ),
				'preset4' => __( 'Sea & Cloud' ),
				'preset5' => __( 'Dark Room' ),
				'preset6' => __( 'Tomato' ),
			);
		}

		/**
		 * Fetches DB And returns a valid redirect url.
		 *
		 * @static
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
		 *
		 * @static
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
		 * @static
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
	}
}
