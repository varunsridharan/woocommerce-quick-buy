<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

use WC_Product;

/**
 * Class Generator_Base
 *
 * @package WC_Quick_Buy
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Generator_Base {
	/**
	 * Stores Product Type for which it generates.
	 *
	 * @var bool|string|int
	 */
	protected $product_type = false;

	/**
	 * Stores Product ID for which it generates
	 *
	 * @var bool|string|int
	 */
	protected $product_id = false;

	/**
	 * Stores \WC_Product Instance for which it generates
	 *
	 * @var bool|\WC_Product
	 */
	protected $product = false;

	/**
	 * Custom Arguments.
	 *
	 * @var array|bool
	 */
	protected $args = false;

	/**
	 * Stores Generated HTML.
	 *
	 * @var string|bool
	 */
	protected $html = false;


	/**
	 * Returns Current Product.
	 *
	 * @return bool|\WC_Product
	 */
	public function product() {
		return ( $this->product instanceof WC_Product ) ? $this->product : false;
	}

	/**
	 * Returns Current Product ID.
	 *
	 * @return bool|int|string
	 */
	public function product_id() {
		if ( false === $this->product_id && $this->product() ) {
			$this->product_id = $this->product()->get_id();
		}
		return $this->product_id;
	}

	/**
	 * Returns Product Type.
	 *
	 * @return bool|int|string
	 */
	public function product_type() {
		if ( false === $this->product_type && $this->product() ) {
			$this->product_type = $this->product()->get_type();
		}
		return $this->product_type;
	}

	/**
	 * Generates A Product Instance.
	 *
	 * @param $product
	 *
	 * @return bool
	 */
	protected function init_product( $product ) {
		if ( is_numeric( $product ) ) {
			$product = wc_get_product( $product );
		}

		if ( ! $product instanceof WC_Product ) {
			return false;
		}
		$this->product = $product;
		return true;
	}
}
