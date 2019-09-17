<?php

namespace WC_Quick_Buy;

if ( ! class_exists( '\WC_Quick_Buy\Generator_Base' ) ) {
	/**
	 * Class Generator_Base
	 *
	 * @package WC_Quick_Buy
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Generator_Base {

		/**
		 * @var bool|string|int
		 */
		protected $product_type = false;

		/**
		 * @var bool|string|int
		 */
		protected $product_id = false;

		/**
		 * @var bool|\WC_Product
		 */
		protected $product = false;

		/**
		 * @var bool|\WC_Product
		 */
		protected $args = false;

		/**
		 * @var bool
		 */
		protected $html = false;


		/**
		 * @return bool|\WC_Product
		 */
		public function product() {
			return ( $this->product instanceof \WC_Product ) ? $this->product : false;
		}

		/**
		 * @return bool|int|string
		 */
		public function product_id() {
			if ( false === $this->product_id && $this->product() ) {
				$this->product_id = $this->product()
					->get_id();
			}
			return $this->product_id;
		}

		/**
		 * @return bool|int|string
		 */
		public function product_type() {
			if ( false === $this->product_type && $this->product() ) {
				$this->product_type = $this->product()
					->get_type();
			}
			return $this->product_type;
		}

		/**
		 * @param $product
		 *
		 * @return bool
		 */
		protected function init_product( $product ) {
			if ( is_numeric( $product ) ) {
				$product = wc_get_product( $product );
			}

			if ( ! $product instanceof \WC_Product ) {
				return false;
			}
			$this->product = $product;
			return true;
		}

	}
}
