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
		 * Function to redirect user after qucik buy button is submitted
		 *
		 * @param string $url
		 *
		 * @return string
		 */
		public function quick_buy_redirect( $url ) {
			if ( isset( $_REQUEST['quick_buy'] ) && ! empty( $_REQUEST['quick_buy'] ) ) {
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
							wp_safe_redirect( Helper::option( 'custom_location' ) );
							exit;
						}
						break;
				}
			}
			return $url;
		}
	}
}
