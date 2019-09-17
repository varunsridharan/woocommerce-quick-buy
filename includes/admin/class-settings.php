<?php

namespace WC_Quick_Buy\Admin;

use VSP\Core\Abstracts\Plugin_Settings;

if ( ! class_exists( '\WC_Quick_Buy\Admin\Settings' ) ) {
	/**
	 * Class Settings
	 *
	 * @package WC_Quick_Buy\Admin
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	class Settings extends Plugin_Settings {
		use Settings\General;
		use Settings\Button_Styling;

		/**
		 * Registers Fields.
		 */
		protected function fields() {
			$this->general( $this->builder->container( 'general', __( 'General', 'wc-quick-buy' ) ) );
			$this->button_styling( $this->builder->container( 'button_styling', __( 'Button Styling', 'wc-quick-buy' ) ) );
		}
	}
}
