<?php
global $wc_quick_buy_settings_values;
$wc_quick_buy_settings_values = array();

if ( ! function_exists( 'wc_quick_buy_db_settings' ) ) {
	function wc_quick_buy_db_settings() {
		global $wc_quick_buy_settings_values;
		$wc_quick_buy_settings_values                        = array();
		$wc_quick_buy_settings_values['redirect']            = get_option( WCQB_DB . 'redirect' );
		$wc_quick_buy_settings_values['custom_redirect']     = get_option( WCQB_DB . 'custom_redirect' );
		$wc_quick_buy_settings_values['product_types']       = get_option( WCQB_DB . 'product_types' );
		$wc_quick_buy_settings_values['single_product_auto'] = get_option( WCQB_DB . 'single_product_auto' );
		$wc_quick_buy_settings_values['single_product_pos']  = get_option( WCQB_DB . 'single_product_pos' );
		$wc_quick_buy_settings_values['listing_page_auto']   = get_option( WCQB_DB . 'listing_page_auto' );
		$wc_quick_buy_settings_values['listing_page_pos']    = get_option( WCQB_DB . 'listing_page_pos' );
		$wc_quick_buy_settings_values['product_qty']         = get_option( WCQB_DB . 'product_qty' );
		$wc_quick_buy_settings_values['label']               = get_option( WCQB_DB . 'label' );
		$wc_quick_buy_settings_values['class']               = get_option( WCQB_DB . 'class' );
		$wc_quick_buy_settings_values['btn_css']             = get_option( WCQB_DB . 'btn_css' );
		$wc_quick_buy_settings_values['hide_in_cart']        = get_option( WCQB_DB . 'hide_in_cart' );
		#$wc_quick_buy_settings_values['hide_outofstock']     = get_option( WCQB_DB . 'hide_outofstock' );
	}
}

if ( ! function_exists( 'wc_qb_option' ) ) {
	function wc_qb_option( $key = '' ) {
		global $wc_quick_buy_settings_values;
		if ( isset( $wc_quick_buy_settings_values[ $key ] ) ) {
			return $wc_quick_buy_settings_values[ $key ];
		}
		return false;
	}
}

if ( ! function_exists( 'wc_qb_is_wc_v' ) ) {
	function wc_qb_is_wc_v( $compare = '>=', $version = '' ) {
		$version = empty( $version ) ? WOOCOMMERCE_VERSION : $version;
		if ( version_compare( WOOCOMMERCE_VERSION, $version, $compare ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'wc_qb_product_in_cart' ) ) {
	function wc_qb_product_in_cart( $product_id ) {
		global $woocommerce;

		foreach ( $woocommerce->cart->get_cart() as $key => $val ) {
			$_product = $val['data'];

			if ( $product_id == $_product->get_id() ) {
				return true;
			}
		}

		return false;
	}
}