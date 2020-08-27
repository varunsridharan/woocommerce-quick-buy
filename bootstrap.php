<?php

defined( 'ABSPATH' ) || exit;

use VSP\Framework;

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
			$options                  = array(
				'name'         => WCQB_NAME,
				'version'      => WCQB_VERSION,
				'file'         => WCQB_FILE,
				'slug'         => 'wc-quick-buy',
				'db_slug'      => 'wcqb',
				'hook_slug'    => 'wc_quick_buy',
				'addons'       => false,
				'logging'      => false,
				'system_tools' => false,
				'localizer'    => false,
				'autoloader'   => array(
					'namespace' => 'WC_Quick_Buy',
					'base_path' => $this->plugin_path( 'includes/', WCQB_FILE ),
					'options'   => array(
						'classmap' => $this->plugin_path( 'classmaps.php', WCQB_FILE ),
					),
				),
			);
			$options['settings_page'] = array(
				'option_name'    => '_wc_quick_buy',
				'framework_desc' => __( 'Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button', 'wc-quick-buy' ),
				'theme'          => 'wp',
				'is_single_page' => 'submenu',
				'ajax'           => true,
				'search'         => false,
				'assets'         => array( 'wcqb-admin-script', 'wcqb-admin-style' ),
				'menu'           => array(
					'page_title' => WCQB_NAME,
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
			$this->_instance( '\WC_Quick_Buy\URL_Endpoint' );
			$this->add_action( 'woocommerce_init', 'on_wc_init' );
		}

		/**
		 * Runs On WC Init.
		 *
		 * @since {NEWVERSION}
		 */
		public function on_wc_init() {
			$this->_instance( '\WC_Quick_Buy\Add_To_Cart_Redirect' );
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

		/**
		 * On Admin Init.
		 */
		public function admin_init() {
			if ( vsp_is_admin() && ! vsp_is_ajax() ) {
				wponion_plugin_links( $this->file() )
					->action_link_before( 'settings', __( 'Settings', 'wc-quick-buy' ), admin_url( 'admin.php?page=quick-buy' ) )
					->action_link_after( 'sysinfo', __( 'System Info', 'wc-quick-buy' ), admin_url( 'admin.php?page=quick-buy&container-id=sysinfo' ) )
					->row_link( __( '📚 F.A.Q', 'wc-quick-buy' ), 'https://wordpress.org/plugins/woocommerce-quick-buy/faq' )
					->row_link( __( '📦 View On Github', 'wc-quick-buy' ), 'https://github.com/varunsridharan/woocommerce-quick-buy' )
					->row_link( __( '📝 Report An Issue', 'wc-quick-buy' ), 'https://github.com/varunsridharan/woocommerce-quick-buy/issues' )
					->row_link( __( '💁🏻 Donate', 'wc-product-subtitle', 'wc-quick-buy' ), 'https://paypal.me/varunsridharan' );
			}
		}
	}
}
