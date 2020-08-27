<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

use VSP\Base;

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
	 * Add's To Cart if Quick Buy Sent Request.
	 *
	 * @param $query
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function addtocart_if_quickbuy( $query ) {
		if ( ! isset( $query->query_vars['quickbuy_id'] ) && ! isset( $query->query_vars['quickbuy_sku'] ) && ! isset( $query->query_vars['quickbuy_slug'] ) ) {
			return $query;
		}

		$qty = ( isset( $query->query_vars['quickbuy_qty'] ) ) ? $query->query_vars['quickbuy_qty'] : Helper::option( 'quantity' );
		$id  = ( isset( $query->query_vars['quickbuy_id'] ) ) ? $query->query_vars['quickbuy_id'] : false;

		if ( isset( $query->query_vars['quickbuy_sku'] ) ) {
			$id = wc_get_product_id_by_sku( $query->query_vars['quickbuy_sku'] );
		}

		if ( isset( $query->query_vars['quickbuy_slug'] ) ) {
			$product = get_page_by_path( $query->query_vars['quickbuy_slug'], OBJECT, 'product' );
			$id      = ( isset( $product->ID ) ) ? $product->ID : false;
		}

		if ( false !== $id ) {
			$_REQUEST['quick_buy'] = true;
			do_action( 'wc_quick_buy_endpoint_add_to_cart_before' );
			wc()->cart->add_to_cart( $id, $qty );
			do_action( 'wc_quick_buy_endpoint_add_to_cart_after' );
			wp_safe_redirect( Helper::redirect_url() );
			exit;
		} else {
			/*global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			nocache_headers();*/
		}

		return $query;
	}
}
