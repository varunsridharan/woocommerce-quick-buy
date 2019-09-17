<?php

use VSP\Framework;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'WC_Quick_Buy' ) ) {
	/**
	 * Class WC_Quick_Buy
	 *
	 * @author Varun Sridharan <varunsridharan23@gmail.com>
	 */
	final class WC_Quick_Buy extends Framework {
		/**
		 * WC_Quick_Buy constructor.
		 *
		 * @throws \Exception
		 */
		public function __construct() {
			$this->name      = WCQB_NAME;
			$this->file      = WCQB_FILE;
			$this->version   = WCQB_VERSION;
			$this->slug      = 'wc-quick-buy';
			$this->db_slug   = 'wcqb';
			$this->hook_slug = 'wc_quick_buy';

			$options                  = array(
				'addons'       => false,
				'logging'      => false,
				'system_tools' => false,
				'localizer'    => false,
				'autoloader'   => array(
					'namespace' => 'WC_Quick_Buy',
					'base_path' => $this->plugin_path( 'includes/' ),
				),
			);
			$options['settings_page'] = array(
				'option_name'    => '_wc_quick_buy',
				'framework_desc' => __( 'Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button', 'wc-quick-buy' ),
				'theme'          => 'wp',
				'is_single_page' => 'submenu',
				'ajax'           => true,
				'search'         => false,
				'extra_js'       => array( 'wcqb-admin-script' ),
				'extra_css'      => array( 'wcqb-admin-style' ),
				'menu'           => array(
					'page_title' => $this->plugin_name(),
					'menu_title' => __( 'Quick Buy', 'wc-quick-buy' ),
					'submenu'    => 'woocommerce',
					'menu_slug'  => 'quick-buy',
				),
			);
			parent::__construct( $options );
		}

		/**
		 * Inits All Basic Classes.
		 */
		public function init_class() {
			$this->_instance( '\WC_Quick_Buy\Add_To_Cart_Redirect' );
			$this->_instance( '\WC_Quick_Buy\URL_Endpoint' );
			$this->_instance( '\WC_Quick_Buy\Button_Placement' );
			$this->_instance( '\WC_Quick_Buy\Cart_Clear_Handler' );
			$this->_instance( '\WC_Quick_Buy\Shortcodes\Button' );
			$this->_instance( '\WC_Quick_Buy\Shortcodes\Link' );
		}

		/**
		 * On Settings Init Before.
		 */
		public function settings_init_before() {
			$this->_instance( '\WC_Quick_Buy\Admin\Settings' );
		}

		/**
		 * Registers Frontend Asset.
		 */
		public function frontend_assets() {
			wp_register_style( 'wcqb-button-presets', $this->plugin_url( 'assets/css/button-presets.css' ) );
			wp_register_script( 'wcqb-frontend-script', $this->plugin_url( 'assets/js/frontend-script.js' ) );
		}

		/**
		 * Registers Admin Assets
		 */
		public function admin_assets() {
			wp_register_style( 'wcqb-admin-style', $this->plugin_url( 'assets/css/admin.css' ) );
			wp_register_script( 'wcqb-admin-script', $this->plugin_url( 'assets/js/admin-script.js' ) );
		}
	}
}
