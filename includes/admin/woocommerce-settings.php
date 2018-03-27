<?php
/**
 * WooCommerce General Settings
 *
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WooCommerce_Quick_Buy_Settings' ) ) :

	/**
	 * WC_Admin_Settings_General
	 */
	class WooCommerce_Quick_Buy_Settings extends WC_Settings_Page {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->redirect_locations = array(
				'cart'     => __( 'Cart Page', WCQB_TXT ),
				'checkout' => __( 'Checkout Page', WCQB_TXT ),
				'custom'   => __( 'Custom URL', WCQB_TXT ),
			);

			$this->product_types = array(
				'all'                   => __( "All Product Types", WCQB_TXT ),
				'simple'                => __( 'Simple Products', WCQB_TXT ),
				'variable'              => __( 'Variable Products', WCQB_TXT ),
				'yith-bundle'           => __( "YITH Product Bundles", WCQB_TXT ),
				'bundle'                => __( "WC Product Bundles", WCQB_TXT ),
				'subscription'          => __( "WC Variable Subscription", WCQB_TXT ),
				'variable-subscription' => __( "WC Variable Subscription", WCQB_TXT ),
			);

			$this->show_position = array(
				'before_form'   => __( 'Before  Add To Cart Form', WCQB_TXT ),
				'after_form'    => __( 'After Add To Cart Form', WCQB_TXT ),
				'after_button'  => __( 'Next To Add To Cart Button', WCQB_TXT ),
				'before_button' => __( 'Prev To Add To Cart Button', WCQB_TXT ),
			);

			$this->show_listing_page_position = array(
				'after_button'  => __( 'Next To Add To Cart Button', WCQB_TXT ),
				'before_button' => __( 'Prev To Add To Cart Button', WCQB_TXT ),
			);

			$this->id    = 'wc_quick_buy_settings';
			$this->label = __( 'WC Quick Buy', WCQB_TXT );

			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
			add_filter( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
			add_filter( 'woocommerce_settings_' . $this->id, array( $this, 'output_settings' ) );
			add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		}

		/**
		 * Get sections
		 *
		 * @return array
		 */
		public function get_sections() {
			$sections = array(
				''                    => __( 'General', WCQB_TXT ),
				'button_style'        => __( 'Button Styling', WCQB_TXT ),
				'button_position'     => __( 'Button Position', WCQB_TXT ),
				'shortcode_generator' => __( 'Shortcode Generator', WCQB_TXT ),
			);
			return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
		}


		public function output_settings() {
			global $current_section;

			if ( $current_section == 'shortcode_generator' ) {
				echo $this->get_shortcode_generator();
			} else {
				$settings = $this->get_settings( $current_section );
				WC_Admin_Settings::output_fields( $settings );
			}
		}


		/**
		 * Get settings array
		 *
		 * @return array
		 */
		public function get_settings( $section = null ) {
			$settings = array();

			if ( $section == '' ) {
				return $this->get_general();
			} elseif ( $section == 'button_style' ) {
				return $this->get_button_style();
			} elseif ( $section == 'button_position' ) {
				return $this->get_button_position();
			} else {
				$settings = apply_filters( 'woocommerce_quick_buy_section_settings', array() );
				//return $settings;
			}

			return $settings;
		}


		public function get_general() {
			$settings_array = array();

			$settings_array[] = array(
				'name' => __( 'General Settings', WCQB_TXT ),
				'type' => 'title',
				'desc' => __( 'The following options are used to configure WC Quick Buy Actions', WCQB_TXT ),
				'id'   => WCQB_DB . 'settings_start',
			);

			$settings_array[] = array(
				'name'     => __( 'Redirect Location', WCQB_TXT ),
				'desc_tip' => __( 'After Add To Cart Where To Redirect The user', WCQB_TXT ),
				'id'       => WCQB_DB . 'redirect',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => $this->redirect_locations,
			);

			$settings_array[] = array(
				'name'        => __( 'Custom Redirect Location', WCQB_TXT ),
				'desc'        => __( 'Enter a full url if custom selected in redirect location', WCQB_TXT ),
				'id'          => WCQB_DB . 'custom_redirect',
				'type'        => 'text',
				'placeholder' => get_site_url() . '/custom-add-to-cart/',
			);

			$settings_array[] = array(
				'name'     => __( 'Show Quick Buy Button For ', WCQB_TXT ),
				'desc_tip' => __( 'For Which Products To Show Quick Buy Button [eg to show for simple products select only simple products]', WCQB_TXT ),
				'id'       => WCQB_DB . 'product_types',
				'type'     => 'multiselect',
				'class'    => 'chosen_select',
				'options'  => $this->product_types,
			);

			$settings_array[] = array(
				'name' => __( 'Quick Buy Cart Quantity', WCQB_TXT ),
				'desc' => __( 'You can set min product Quantity. works only with <strong> shop page </strong> <u>(Product listing)</u> & 
			<code>[wc_quick_buy_link]</code> shortcode
			', WCQB_TXT ),
				'id'   => WCQB_DB . 'product_qty',
				'type' => 'number',
				'css'  => 'width:100px;',
			);

			$settings_array[] = array(
				'name' => __( "Hide if already in Cart", WCQB_TXT ),
				'desc' => __( "Hide Quick Buy Button if already in cart" ),
				'id'   => WCQB_DB . 'hide_in_cart',
				'type' => 'checkbox',
			);

			/*$settings_array[] = array(
				'name' => __( "Hide if Product OutofStock", WCQB_TXT ),
				'desc' => __( "Hide Quick Buy Button if Product OutofStock" ),
				'id'   => WCQB_DB . 'hide_outofstock',
				'type' => 'checkbox',
			);*/

			$settings_array[] = array( 'type' => 'sectionend', 'id' => WCQB_DB . 'settings_end' );

			return apply_filters( 'woocommerce_quick_buy_general_settings', $settings_array );
		}

		public function get_button_style() {
			$settings_array = array();

			$settings_array[] = array(
				'name' => __( 'Quick Buy Button Settings', WCQB_TXT ),
				'type' => 'title',
				'desc' => __( 'The following options are used to configure WC Quick Buy Button', WCQB_TXT ),
				'id'   => WCQB_DB . 'settings_button_start',
			);


			$settings_array[] = array(
				'name'     => __( 'Button Label', WCQB_TXT ),
				'desc_tip' => __( 'You Can Change The Quick Buy Button Label', WCQB_TXT ),
				'id'       => WCQB_DB . 'label',
				'type'     => 'text',
			);

			$settings_array[] = array(
				'name'     => __( 'Button CSS Class', WCQB_TXT ),
				'desc_tip' => __( 'You can add your own custom class for easy styling', WCQB_TXT ),
				'id'       => WCQB_DB . 'class',
				'type'     => 'text',
			);

			$settings_array[] = array(
				'name'     => __( 'Button Internal Style', WCQB_TXT ),
				'desc_tip' => __( 'Enter your custom css to change the look of the quick buy button', WCQB_TXT ),
				'desc'     => __( 'Css Class Used : <code>wc_quick_buy_button</code>,<code>quick_buy_button</code>,<code>quick_buy_{pid}_button</code>,<code>quick_buy_{pid}</code>,<code>quick_buy_{ptype}</code> <br/>
			<strong>pid</strong> Refers to product id. which will replaced dynamically <br/>
			<strong>ptype</strong> Refers to product type : <i>quick_buy_simple</i> | <i>quick_buy_variable</i>
			', WCQB_TXT ),
				'id'       => WCQB_DB . 'btn_css',
				'type'     => 'textarea',
				'class'    => '',
				'css'      => 'height:200px; width:400px;',
			);


			$settings_array[] = array( 'type' => 'sectionend', 'id' => WCQB_DB . 'settings_button_end' );

			return apply_filters( 'woocommerce_quick_buy_button_style_settings', $settings_array );
		}

		public function get_button_position() {
			$settings_array = array();


			$settings_array[] = array(
				'name' => __( 'Single Product Page', WCQB_TXT ),
				'type' => 'title',
				'desc' => __( 'Options To Configure The Button In Single Product Page', WCQB_TXT ),
				'id'   => WCQB_DB . 'single_product_start',
			);


			$settings_array[] = array(
				'name'     => __( 'Auto Add Quick Button ', WCQB_TXT ),
				'desc_tip' => __( 'Automaticaly Adds Button After Add To Cart In Single Product View', WCQB_TXT ),
				'id'       => WCQB_DB . 'single_product_auto',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => array(
					'true'  => __( "Yes", WCQB_TXT ),
					'false' => __( "No (I Will Use Shortcode)", WCQB_TXT ),
				),
			);
			$settings_array[] = array(
				'name'     => __( 'Quick Buy Position', WCQB_TXT ),
				'desc_tip' => __( 'Where the button need to be added in single page .. before / after', WCQB_TXT ),
				'id'       => WCQB_DB . 'single_product_pos',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => $this->show_position,
			);

			$settings_array[] = array( 'type' => 'sectionend', 'id' => WCQB_DB . 'single_product_end' );


			$settings_array[] = array(
				'name' => __( 'Shop Page', WCQB_TXT ),
				'type' => 'title',
				'desc' => __( 'Options To Configure The Button In Shop Page (Product Listing Page)', WCQB_TXT ),
				'id'   => WCQB_DB . 'shop_page',
			);


			$settings_array[] = array(
				'name'     => __( 'Auto Add Quick Button ', WCQB_TXT ),
				'desc_tip' => __( 'Automaticaly Adds Button After Add To Cart In Single Product View', WCQB_TXT ),
				'id'       => WCQB_DB . 'listing_page_auto',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => array(
					'true'  => __( "Yes", WCQB_TXT ),
					'false' => __( "No (I Will Use Shortcode)", WCQB_TXT ),
				),
			);
			$settings_array[] = array(
				'name'     => __( 'Quick Buy Position', WCQB_TXT ),
				'desc_tip' => __( 'Where the button need to be added in shop page .. before / after', WCQB_TXT ),
				'id'       => WCQB_DB . 'listing_page_pos',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => $this->show_listing_page_position,
			);


			$settings_array[] = array( 'type' => 'sectionend', 'id' => WCQB_DB . 'shop_page' );

			return apply_filters( 'woocommerce_quick_buy_button_position_settings', $settings_array );
		}

		public function get_shortcode_generator() {
			$GLOBALS['hide_save_button'] = true;
			require_once( WCQB_ADMIN . 'html-shortcodegen.php' );
		}

		/**
		 * Save settings
		 */
		public function save() {
			global $current_section;
			$settings = $this->get_settings( $current_section );
			WC_Admin_Settings::save_fields( $settings );
		}

	}

endif;

return new WooCommerce_Quick_Buy_Settings();