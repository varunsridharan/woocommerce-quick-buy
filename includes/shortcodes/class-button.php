<?php

namespace WC_Quick_Buy\Shortcodes;

defined( 'ABSPATH' ) || exit;

use VSP\Modules\Shortcode;
use WC_Quick_Buy\Button_Generator;
use WC_Quick_Buy\Helper;

/**
 * Class Button
 *
 * @package WC_Quick_Buy\Shortcodes
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
final class Button extends Shortcode {
	/**
	 * Registers Shortcode Name.
	 *
	 * @var string
	 */
	protected $name = 'wc_quick_buy';

	/**
	 * Return's Default Value.
	 *
	 * @return array
	 */
	protected function defaults() {
		return array(
			'label'        => Helper::option( 'button_label' ),
			'product'      => false,
			'qty'          => Helper::option( 'quantity', 1 ),
			'hide_in_cart' => Helper::option( 'hide_if_in_cart' ),
			'css_class'    => Helper::option( 'css_class' ),
		);
	}

	/**
	 * Generates Shortcode Output.
	 *
	 * @return mixed|string
	 */
	protected function output() {
		global $product;
		$shortcode_product = ( empty( $this->option( 'product' ) ) ) ? $product : wc_get_product( $this->option( 'product' ) );

		if ( $shortcode_product ) {
			if ( $shortcode_product->is_in_stock() ) {
				$quick_buy_link_product_types = Helper::option( 'quick_buy_link_product_types' );
				$quick_buy_link_product_types = ( ! is_array( $quick_buy_link_product_types ) ) ? array( 'simple' ) : $quick_buy_link_product_types;

				/* @var \WC_Product $product */
				if ( in_array( $shortcode_product->get_type(), $quick_buy_link_product_types, true ) ) {
					$instance = new Button_Generator( array(
						'type'         => 'link',
						'product'      => $shortcode_product,
						'qty'          => $this->option( 'qty' ),
						'label'        => $this->option( 'label' ),
						'hide_in_cart' => $this->option( 'hide_in_cart' ),
						'class'        => $this->option( 'css_class' ),
					) );
					return $instance->html();
				}
			}
		}

		return '';
	}
}
