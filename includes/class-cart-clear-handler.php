<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

use VSP\Base;

/**
 * Class Cart_Clear_Handler
 *
 * @package WC_Quick_Buy
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Cart_Clear_Handler extends Base {
	/**
	 * Cart_Clear_Handler constructor.
	 */
	public function __construct() {
		/* @uses validate_and_clear */
		add_filter( 'woocommerce_add_to_cart_quantity', array( &$this, 'validate_and_clear' ) );
		add_action( 'wc_quick_buy_endpoint_add_to_cart_before', array( &$this, 'validate_and_clear' ) );
	}

	/**
	 * Clears WC Cart if Not Empty And Quick Buy Used.
	 *
	 * @param $dummy
	 *
	 * @return mixed
	 */
	public function validate_and_clear( $dummy ) {
		if ( Helper::is_add_to_cart_request() && false !== Helper::option( 'auto_clear_cart' ) ) {
			\VSP\Helper::wc_clear_cart_if_notempty();
		}
		return $dummy;
	}
}
