<?php

namespace WC_Quick_Buy;

use VSP\Base;

if ( ! class_exists( '\WC_Quick_Buy\URL_Endpoint' ) ) {
	/**
	 * Class URL_Endpoint
	 *
	 * @package WC_Quick_Buy
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class URL_Endpoint extends Base {
		/**
		 * URL_Endpoint constructor.
		 */
		public function __construct() {
			$this->register_endpoint();
			/* @uses addtocart_if_quickbuy */
			add_action( 'parse_request', array( $this, 'addtocart_if_quickbuy' ) );
		}

		/**
		 * Registers Quick Buy Endpoint
		 */
		private function register_endpoint() {
			$value_types = array(
				'id'  => '([\d]+)',
				'qty' => '([\d]+)',
			);
			$endpoint    = Helper::option( 'url_endpoint' );
			$link        = ltrim( ltrim( untrailingslashit( $endpoint ), '/' ), '^' );
			$no_qty      = str_replace( '{qty}', '', $link );
			$instance    = wponion_endpoint( 'quickbuy' );

			// Quick Buy URL With Qty
			$instance->add_rewrite_rule( $link, $value_types );

			// Quick Buy Without Qty
			$instance->add_rewrite_rule( untrailingslashit( $no_qty ), $value_types );
		}

		/**
		 * @param $query
		 *
		 * @return mixed
		 * @throws \Exception
		 */
		public function addtocart_if_quickbuy( $query ) {
			if ( ! isset( $query->query_vars['quickbuy_id'] ) && ! isset( $query->query_vars['quickbuy_sku'] ) ) {
				return $query;
			}

			$qty  = ( isset( $query->query_vars['quickbuy_qty'] ) ) ? $query->query_vars['quickbuy_qty'] : Helper::option( 'quantity' );
			$type = ( isset( $query->query_vars['quickbuy_sku'] ) && ! isset( $query->query_vars['quickbuy_id'] ) ) ? 'sku' : 'id';
			$id   = ( isset( $query->query_vars['quickbuy_id'] ) ) ? $query->query_vars['quickbuy_id'] : false;
			$sku  = ( isset( $query->query_vars['quickbuy_sku'] ) ) ? $query->query_vars['quickbuy_sku'] : false;

			if ( 'sku' === $type && false === $id ) {
				$id = wc_get_product_id_by_sku( $sku );
			}

			if ( false !== $id ) {
				$_REQUEST['quick_buy'] = true;
				do_action( 'wc_quick_buy_endpoint_add_to_cart_before' );
				wc()->cart->add_to_cart( $id, $qty );
				do_action( 'wc_quick_buy_endpoint_add_to_cart_after' );
				wp_safe_redirect( Helper::redirect_url() );
				exit;
			}

			return $query;
		}
	}
}
