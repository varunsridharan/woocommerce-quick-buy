<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

/**
 * Class Button_Generator
 *
 * @package WC_Quick_Buy
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Button_Generator extends Generator_Base {

	/**
	 * Button_Generator constructor.
	 *
	 * @param $args
	 */
	public function __construct( $args ) {
		$args                 = wp_parse_args( $args, array(
			'product'      => false,
			'qty'          => 1, # Works Only If Type == Link
			'type'         => 'button', // Output Type : link,button
			'seo'          => true, # Works Only If Type == Link
			'label'        => Helper::option( 'button_label' ),
			'class'        => Helper::option( 'css_class' ),
			'hide_in_cart' => Helper::option( 'hide_if_in_cart' ),
			'preset'       => Helper::option( 'button_style_styles' ),
		) );
		$args['hide_in_cart'] = wponion_is_bool_val( $args['hide_in_cart'] );
		$args['hide_in_cart'] = ( 'on' === $args['hide_in_cart'] ) ? true : $args['hide_in_cart'];
		$args['hide_in_cart'] = ( 'off' === $args['hide_in_cart'] ) ? false : $args['hide_in_cart'];
		$this->args           = $args;
	}

	/**
	 * Generates Button HTML
	 *
	 * @return string
	 */
	public function html() {
		if ( false === $this->html ) {
			if ( ! wp_style_is( 'wcqb-frontend-script' ) ) {
				wp_enqueue_script( 'wcqb-frontend-script' );
			}

			$args = $this->args;
			$tag  = ( 'button' === $args['type'] ) ? 'button' : 'a';

			if ( ! $this->init_product( $args['product'] ) ) {
				return '';
			}

			$types      = Helper::option( 'enabled_product_types' );
			$types      = ( ! is_array( $types ) ) ? array() : $types;
			$is_in_cart = \VSP\Helper::wc_has_product_in_cart( $this->product_id() );

			/* Validates Product Type. */
			if ( is_array( $types ) && ! in_array( 'all', $types, true ) && ! in_array( $this->product_type(), $types, true ) ) {
				return '';
			}

			/* Checks if hide_in_cart set to REMOVE */
			if ( $is_in_cart && 'remove' === $args['hide_in_cart'] ) {
				return '';
			}

			wp_enqueue_style( 'wcqb-button-presets' );
			Helper::add_custom_style();

			$preset = $args['preset'];
			$preset = ( 'none' === $preset ) ? '' : $preset;
			$attrs  = array(
				'id'                => 'quick_buy_' . $this->product_id() . '_button',
				'data-product-id'   => $this->product_id(),
				'data-product-type' => $this->product_type(),
				'class'             => wponion_html_class( $args['class'], array(
					( ! empty( $preset ) ) ? 'wcqb-preset ' . $preset : '',
					( $is_in_cart ) ? 'wcqb-product-in-cart' : '',
					'wcqb_button',
					'wc_quick_buy_button',
					'quick_buy_button',
					'quick_buy_' . $tag . '_tag',
					'quick_buy_' . $this->product_type(),
					'quick_buy_' . $this->product_type() . '_button',
					'quick_buy_' . $this->product_id(),
					'quick_buy_' . $this->product_id() . '_button',
					'quick_buy_' . $this->product_id() . '_' . $this->product_type() . '',
					'quick_buy_' . $this->product_id() . '_' . $this->product_type() . '_button',
				) ),
			);

			if ( $is_in_cart && in_array( $args['hide_in_cart'], array( true, 'hide' ), true ) ) {
				$attrs['style'] = 'display:none;';
			} elseif ( $is_in_cart && 'soft' === $args['hide_in_cart'] ) {
				$attrs['disabled'] = 'disabled';
			}

			if ( 'button' === $tag ) {
				$attrs['type'] = 'button';
			} elseif ( 'a' === $tag ) {
				$instance      = new URL_Generator( array(
					'product' => $this->product_id(),
					'qty'     => $args['qty'],
					'seo'     => $args['seo'],
				) );
				$attrs['href'] = $instance->html();
			}

			$wrap_attr  = apply_filters( 'wc_quick_buy_button_wrap_attributes', wponion_array_to_html_attributes( array(
				'class' => wponion_html_class( array(
					'quick_buy_container',
					'quick_buy_' . $this->product_id() . '_container',
				) ),
				'id'    => 'quick_buy_' . $this->product_id() . '_container',
			) ), $this->product_id(), $this->product_type(), $this );
			$this->html = '<div ' . $wrap_attr . ' >';
			$this->html .= sprintf( '<%1$s %3$s>%2$s</%1$s>', esc_html( $tag ), esc_html( $args['label'] ), wponion_array_to_html_attributes( $attrs ) );
			$this->html .= '</div>';
		}
		return $this->html;
	}
}
