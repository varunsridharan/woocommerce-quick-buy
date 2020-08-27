<?php

namespace WC_Quick_Buy;

defined( 'ABSPATH' ) || exit;

/**
 * Class URL_Generator
 *
 * @package WC_Quick_Buy
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class URL_Generator extends Generator_Base {
	/**
	 * Button_Generator constructor.
	 *
	 * @param $args
	 */
	public function __construct( $args ) {
		$args = wp_parse_args( $args, array(
			'product' => false,
			'qty'     => Helper::option( 'quantity', 1 ),
			'seo'     => true,
		) );

		if ( empty( $args['qty'] ) ) {
			$args['qty'] = 1;
		}

		$this->args = $args;
	}

	/**
	 * Generates HTML A Tag.
	 *
	 * @return bool|mixed|string
	 */
	public function html() {
		if ( false === $this->html ) {
			$args = $this->args;
			if ( ! $this->init_product( $args['product'] ) ) {
				return false;
			}

			$types = Helper::option( 'enabled_product_types' );
			$types = ( ! is_array( $types ) ) ? array() : $types;

			if ( is_array( $types ) && ! in_array( 'all', $types, true ) && ! in_array( $this->product_type(), $types, true ) ) {
				return '';
			}

			if ( true === $args['seo'] ) {
				$string = Helper::option( 'url_endpoint', '' );
				if ( ! empty( $string ) ) {
					$data = array(
						'{sku}'  => $this->product->get_sku(),
						'{id}'   => $this->product_id(),
						'{qty}'  => $args['qty'],
						'{slug}' => $this->product->get_slug(),
					);
					$url  = str_replace( array_keys( $data ), $data, $string );
					if ( ! empty( $url ) ) {
						$this->html = vsp_slashit( Helper::get_valid_wp_url() ) . trim( $url, '/' );
					}
				}
			} else {
				$this->html = add_query_arg( array(
					'quantity'    => $args['qty'],
					'add-to-cart' => $this->product->get_id(),
					'quick_buy'   => true,
				), $this->product->add_to_cart_url() );
			}
			$this->html = empty( $this->html ) ? false : $this->html;
		}
		return $this->html;
	}
}
