<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

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
		 * @uses add_to_cart_action
		 */
		public function __construct() {
			add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'quick_buy_redirect' ), 99 );
			add_action( 'wp_loaded', array( $this, 'add_to_cart_action' ), 100 );
		}

		/**
		 * Uses Custom AddToCart URL to override certain integrations
		 *
		 * @see WooCommerce added to cart popup (Ajax) | https://wordpress.org/plugins/added-to-cart-popup-woocommerce/
		 * @throws \Exception
		 */
		public function add_to_cart_action() {
			if ( ! isset( $_REQUEST['wcqb-add-to-cart'] ) || ! is_numeric( wp_unslash( $_REQUEST['wcqb-add-to-cart'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				return;
			}

			if ( ! isset( $_REQUEST['add-to-cart'] ) || isset( $_REQUEST['add-to-cart'] ) && $_REQUEST['add-to-cart'] !== $_REQUEST['wcqb-add-to-cart'] ) {
				$_REQUEST['add-to-cart'] = $_REQUEST['wcqb-add-to-cart'];
			}

			\WC_Form_Handler::add_to_cart_action();
			exit;
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
				case 'checkout':
					$url = array(
						'type' => 'internal',
						'url'  => ( 'cart' === $redirect ) ? wc_get_cart_url() : wc_get_checkout_url(),
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
		 * Function to redirect user after qucik buy button is submitted
		 *
		 * @param string $url
		 *
		 * @return string
		 */
		public function quick_buy_redirect( $url ) {
			if ( Helper::is_add_to_cart_request() ) {
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
