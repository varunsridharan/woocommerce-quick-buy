<?php
/**
 * functionality of the plugin.
 *
 * @link       @TODO
 * @since      1.0
 *
 * @package    @TODO
 * @subpackage @TODO
 * @author     Varun Sridharan <varunsridharan23@gmail.com>
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WooCommerce_Quick_Buy_Auto_Add {

	/**
	 * Class Constructor
	 */
	public function __construct() {
		$this->setup_single_product_quick_buy();
		$this->setup_shop_loop_quick_buy();
	}

	public function setup_single_product_quick_buy() {
		$single_auto = wc_qb_option( 'single_product_auto' );
		$single_pos  = wc_qb_option( 'single_product_pos' );

		if ( isset( $single_auto ) && $single_auto == 'true' ) {
			if ( ! empty( $single_pos ) && ! $single_pos == null ) {
				$pos = '';
				if ( $single_pos == 'before_form' ) {
					$pos = 'woocommerce_before_add_to_cart_form';
				}
				if ( $single_pos == 'after_form' ) {
					$pos = 'woocommerce_after_add_to_cart_form';
				}
				if ( $single_pos == 'after_button' ) {
					$pos = 'woocommerce_after_add_to_cart_button';
				}
				if ( $single_pos == 'before_button' ) {
					$pos = 'woocommerce_before_add_to_cart_button';
				}
				add_action( $pos, array( $this, 'add_quick_buy_button' ), 99 );
			}
		}
	}

	public function setup_shop_loop_quick_buy() {
		$single_auto = wc_qb_option( 'listing_page_auto' );
		$single_pos  = wc_qb_option( 'listing_page_pos' );

		if ( isset( $single_auto ) && $single_auto == 'true' ) {
			if ( ! empty( $single_pos ) && ! $single_pos == null ) {
				$pos = 'woocommerce_after_shop_loop_item';
				$p   = 5;
				if ( $single_pos == 'after_button' ) {
					$p = 11;
				}
				if ( $single_pos == 'before_button' ) {
					$p = 9;
				}
				add_action( $pos, array( $this, 'add_shop_quick_buy_button' ), $p );
			}
		}
	}

	public function add_quick_buy_button() {
		global $product;
		$args = array( 'product' => $product );
		echo WooCommerce_Quick_Buy()
			->func()
			->generate_button( $args );
	}

	public function add_shop_quick_buy_button() {
		global $product;
		if ( $product->get_type() == 'simple' ) {
			$args = array( 'product' => $product, 'tag' => 'link' );
			echo WooCommerce_Quick_Buy()
				->func()
				->generate_button( $args );
		}
	}


}