<?php

namespace WC_Quick_Buy;

use VSP\Base;

if ( ! class_exists( '\WC_Quick_Buy\Add_To_Cart_Redirect' ) ) {
	/**
	 * Class Add_To_Cart_Redirect
	 *
	 * @package WC_Quick_Buy
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Add_To_Cart_Redirect extends Base {
		/**
		 * Add_To_Cart_Redirect constructor.
		 *
		 * @uses quick_buy_redirect
		 */
		public function __construct() {
			add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'quick_buy_redirect' ), 99 );
		}

		/**
		 * Fetches Proper Redirect Url From DB And Returns It.
		 *
		 * @return bool|string
		 */
		private function get_redirect_url() {
			$redirect = Helper::option( 'redirect_location' );
			$url      = false;
			switch ( $redirect ) {
				case 'cart':
					$url = array(
						'type' => 'internal',
						'url'  => wc_get_cart_url(),
					);
					break;
				case 'checkout':
					$url = array(
						'type' => 'internal',
						'url'  => wc_get_checkout_url(),
					);
					break;
				case 'custom':
					if ( ! empty( Helper::option( 'custom_location' ) ) ) {
						$url = array(
							'type' => 'custom',
							'url'  => Helper::option( 'custom_location' ),
						);
					}
					break;
			}
			return $url;

		}

		/**
		 * Custom Plugin Integration For : WooCommerce added to cart popup (Ajax)
		 *
		 * @param $data
		 *
		 * @return mixed
		 * @todo need to work for the below plugin
		 * @since 2.4
		 * @link https://wordpress.org/support/topic/compatibility-issue-41/ -- https://wordpress.org/plugins/added-to-cart-popup-woocommerce/
		 */
		public function plugin_integration_xoo_cp( $data ) {
			$data['div.wcquickbuy-ajax-response'] = wp_json_encode( $this->get_redirect_url() );
			return $data;
		}

		/**
		 * Function to redirect user after qucik buy button is submitted
		 *
		 * @param string $url
		 *
		 * @return string
		 */
		public function quick_buy_redirect( $url ) {
			/*if ( vsp_is_ajax() && vsp_is_ajax( 'xoo_cp_add_to_cart' ) ) {
				# @uses plugin_integration_xoo_cp
				add_filter( 'woocommerce_add_to_cart_fragments', array( &$this, 'plugin_integration_xoo_cp' ) );
				return $url;
			}*/

			if ( isset( $_REQUEST['quick_buy'] ) && ! empty( $_REQUEST['quick_buy'] ) ) {
				$redirect = $this->get_redirect_url();
				$redirect = ( ! is_array( $redirect ) ) ? array( 'url' => false ) : $redirect;

				if ( isset( $redirect['type'] ) && isset( $redirect['url'] ) && ! empty( $redirect['url'] ) ) {
					if ( 'internal' === $redirect['type'] ) {
						return $redirect['url'];
					} elseif ( 'custom' === $redirect['type'] ) {
						wp_safe_redirect( $redirect['url'] );
						exit;
					}
				}
			}
			return $url;
		}
	}
}
