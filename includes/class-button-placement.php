<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

use VSP\Base;

/**
 * Class Button_Placement
 *
 * @package WC_Quick_Buy
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Button_Placement extends Base {
	/**
	 * Button_Placement constructor.
	 */
	public function __construct() {
		/* @uses add_wc_quick_buy_chain */
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'add_wc_quick_buy_chain' ) );
		$this->shop_page_hook();
		$this->single_product_page_hook();
	}

	/**
	 * Adds Quick Buy Product ID
	 */
	public function add_wc_quick_buy_chain() {
		global $product;
		/* @var \WC_Product $product */
		if ( null !== $product && method_exists( $product, 'get_id' ) ) {
			echo '<input type="hidden" id="wc_quick_buy_hook_' . $product->get_id() . '" value="' . $product->get_id() . '"  />';
		}
	}

	/**
	 * Registers Shop Page Hook.
	 */
	public function shop_page_hook() {
		$placement = Helper::option( 'shop_page_placement' );

		if ( ! empty( $placement ) && 'none' !== $placement ) {
			$p = ( 'after_button' === $placement ) ? 11 : 9;
			/* @uses shop_page_button */
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'shop_page_button' ), $p );
		}
	}

	/**
	 * Registers Single Product Page Hook.
	 */
	public function single_product_page_hook() {
		$placement = Helper::option( 'single_product_page_placement' );

		if ( ! empty( $placement ) && 'none' !== $placement ) {
			$hook = null;
			switch ( $placement ) {
				case 'before_form':
					$hook = 'woocommerce_before_add_to_cart_form';
					break;
				case 'after_form':
					$hook = 'woocommerce_after_add_to_cart_form';
					break;
				case 'after_button':
					$hook = 'woocommerce_after_add_to_cart_button';
					break;
				case 'before_button':
					$hook = 'woocommerce_before_add_to_cart_button';
					break;
			}
			/* @uses single_product_page_button */
			add_action( $hook, array( $this, 'single_product_page_button' ), 99 );
		}
	}

	/**
	 * For Shop Listing Page.
	 */
	public function shop_page_button() {
		global $product;

		if ( apply_filters( 'wc_quick_buy_allow_render_button', true, $product, false ) ) {
			$quick_buy_link_product_types = Helper::option( 'quick_buy_link_product_types' );
			$quick_buy_link_product_types = ( ! is_array( $quick_buy_link_product_types ) ) ? array( 'simple' ) : $quick_buy_link_product_types;

			/* @var \WC_Product $product */
			if ( in_array( $product->get_type(), $quick_buy_link_product_types, true ) ) {
				$args     = array(
					'product' => $product,
					'type'    => 'link',
				);
				$instance = new Button_Generator( $args );
				echo $instance->html();
			}
		}
	}

	/**
	 * For Single Product Page.
	 */
	public function single_product_page_button() {
		global $product;
		if ( apply_filters( 'wc_quick_buy_allow_render_button', true, $product, true ) ) {
			$args     = array( 'product' => $product );
			$instance = new Button_Generator( $args );
			echo $instance->html();
		}
	}
}
