<?php

namespace WC_Quick_Buy;

use VSP\Base;

if ( ! class_exists( '\WC_Quick_Buy\Load_Custom_Styles' ) ) {
	/**
	 * Class Load_Custom_Styles
	 *
	 * @package WC_Quick_Buy
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Load_Custom_Styles extends Base {
		/**
		 * Load_Custom_Styles constructor.
		 */
		public function __construct() {
			if ( ! empty( $this->render_quick_buy_style() ) ) {
				wp_add_inline_style( 'wc_quick_buy_custom_style', $this->render_quick_buy_style() );
			}
		}

		/**
		 * @return string
		 */
		private function render_quick_buy_style() {
			$style = Helper::option( 'custom_css', '' );
			$style = str_replace( '<style>', '', $style );
			$style = str_replace( '</style>', '', $style );
			return $style;
		}
	}
}
