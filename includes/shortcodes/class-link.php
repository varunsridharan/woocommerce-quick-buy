<?php

namespace WC_Quick_Buy\Shortcodes;

defined( 'ABSPATH' ) || exit;

use VSP\Modules\Shortcode;
use WC_Product;
use WC_Quick_Buy\Helper;
use WC_Quick_Buy\URL_Generator;

/**
 * Class Button
 *
 * @package WC_Quick_Buy\Shortcodes
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
final class Link extends Shortcode {
	/**
	 * Registers Shortcode Name.
	 *
	 * @var string
	 */
	protected $name = 'wc_quick_buy_link';

	/**
	 * Returns Default Args.
	 *
	 * @return array
	 */
	protected function defaults() {
		return array(
			'product' => false,
			'qty'     => Helper::option( 'quantity', 1 ),
		);
	}

	/**
	 * Generates Output.
	 *
	 * @return bool|mixed|string
	 */
	protected function output() {
		global $product;
		$shortcode_product = ( empty( $this->option( 'product' ) ) ) ? $product : wc_get_product( $this->option( 'product' ) );
		if ( $shortcode_product instanceof WC_Product && method_exists( $shortcode_product, 'is_in_stock' ) ) {
			if ( $shortcode_product->is_in_stock() ) {
				$quick_buy_link_product_types = Helper::option( 'enabled_product_types' );
				$quick_buy_link_product_types = ( ! is_array( $quick_buy_link_product_types ) ) ? array( 'simple' ) : $quick_buy_link_product_types;

				/* @var \WC_Product $product */
				if ( in_array( 'all', $quick_buy_link_product_types ) || in_array( $shortcode_product->get_type(), $quick_buy_link_product_types, true ) ) {
					$instance = new URL_Generator( array(
						'product' => $shortcode_product->get_id(),
						'qty'     => $this->option( 'qty' ),
						'seo'     => true,
					) );
					return $instance->html();
				}
			}
		}

		return '';
	}
}
