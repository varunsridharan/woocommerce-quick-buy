<?php

namespace WC_Quick_Buy\Admin;

defined( 'ABSPATH' ) || exit;

use VSP\Core\Abstracts\Plugin_Settings;

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
		$this->general( $this->builder->container( 'general', __( 'General', 'wc-quick-buy' ), 'wpoic-settings' ) );
		$this->button_styling( $this->builder->container( 'button_styling', __( 'Button Styling', 'wc-quick-buy' ), 'wpoic-brush' ) );

		$this->builder->container( 'docs', __( 'Documentation', 'wc-quick-buy' ), 'wpoic-book' )
			->container_class( 'wpo-text-success' )
			->href( 'https://wordpress.org/plugins/woocommerce-quick-buy/' )
			->attribute( 'target', '_blank' );

		$this->builder->container( 'sysinfo', __( 'System Info', 'wc-quick-buy' ), ' wpoic-info ' )
			->callback( 'wponion_sysinfo' )
			->set_var( 'developer', 'varunsridharan23@gmail.com' );
	}
}
