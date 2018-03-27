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

class WooCommerce_Quick_Buy_Shortcode {
	/**
	 * Class Constructor
	 */
	public function __construct() {
		add_shortcode( 'wc_quick_buy', array( $this, 'add_quick_buy_button' ) );
		add_shortcode( 'wc_quick_buy_link', array( $this, 'quick_buy_link' ) );
	}

	public function add_quick_buy_button( $attrs ) {
		$show_button = false;
		$output      = '';
		global $product;

		$attrs = shortcode_atts( array(
			'label'        => wc_qb_option( 'label' ),
			'product'      => null,
			'hide_in_cart' => wc_qb_option( 'hide_in_cart' ),
		), $attrs );

		if ( $attrs['product'] == null ) {
			global $product;
			$shortcode_product = $product;
		} else {
			$shortcode_product = wc_get_product( $attrs['product'] );
		}

		if ( ! $shortcode_product ) {
			return '';
		}

		if ( $shortcode_product->is_in_stock() ) {
			$show_button = true;
		}

		if ( $show_button ) {
			$output = WooCommerce_Quick_Buy()
				->func()
				->generate_button( array( 'product' => $shortcode_product, 'label' => $attrs['label'] ) );
		}

		return $output;
	}

	public function quick_buy_link( $attrs ) {
		$output = '';
		$attrs  = shortcode_atts( array(
			'product'      => null,
			'hide_in_cart' => wc_qb_option( 'hide_in_cart' ),
			'qty'          => wc_qb_option( 'product_qty' ),
			'label'        => wc_qb_option( 'label' ),
			'type'         => 'button',
			'htmlclass'    => null,
		), $attrs );

		if ( $attrs['product'] == null ) {
			global $product;
			$attrs['product'] = $product;
		} else {
			$attrs['product'] = wc_get_product( $attrs['product'] );
		}

		extract( $attrs );

		if ( ! $product ) {
			return '';
		}

		if ( $type == 'link' ) {
			$output = WooCommerce_Quick_Buy()
				->func()
				->get_product_addtocartLink( $product, $qty );
		} elseif ( $type == 'button' ) {
			$args   = array( 'product' => $product, 'label' => $label, 'tag' => 'link', 'class' => $htmlclass );
			$output = WooCommerce_Quick_Buy()
				->func()
				->generate_button( $args );
		}

		return $output;
	}
}

return new WooCommerce_Quick_Buy_Shortcode;