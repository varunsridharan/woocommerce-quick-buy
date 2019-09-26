<?php

namespace WC_Quick_Buy\Admin\Settings;

use WC_Quick_Buy\Helper;

if ( ! trait_exists( '\WC_Quick_Buy\Admin\Settings\General' ) ) {
	trait General {
		/**
		 * @param \WPO\Container $builder
		 */
		public function general( $builder ) {
			$general       = $builder->container( 'general', __( 'General', 'wc-quick-buy' ) );
			$product       = $builder->container( 'product', __( 'Product', 'wc-quick-buy' ) );
			$btn_placement = $builder->container( 'button-placement', __( 'Button Placement', 'wc-quick-buy' ) );
			$this->basic_config( $general );
			$this->redirect_config( $general );
			$this->product_config( $product );
			$this->single_product_placement( $btn_placement );
		}

		/**
		 * @param \WPO\Container $builder
		 */
		private function basic_config( $builder ) {
			$builder->subheading( __( 'Basic Config', 'wc-quick-buy' ) );
			$builder->switcher( 'auto_clear_cart', __( 'Auto Clear Cart ?', 'wc-quick-buy' ) )
				->desc_field( __( 'if Enabled then cart contents will be auto cleared if quick buy button used.', 'wc-quick-buy' ) );

			$builder->text( 'url_endpoint', __( 'URL Endpoint', 'wc-quick-buy' ) )
				->field_default( 'quick-buy/{id}/{qty}' )
				->style( 'width:350px' )
				->placeholder( 'quick-buy/{id}/{sku}/{qty}' )
				->prefix( trailingslashit( site_url() ) )
				->desc_field( array(
					__( 'Customize the URL Endpoint for Quick Buy URL Action', 'wc-quick-buy' ),
					__( '1. `{id}` : Product ID', 'wc-quick-buy' ),
					__( '2. `{slug}` : Product Slug', 'wc-quick-buy' ),
					__( '3. `{sku}` : Product SKU', 'wc-quick-buy' ),
					__( '4. `{qty}` : Quantity', 'wc-quick-buy' ),
				) );

			$builder->wp_notice( '<p style="font-weight: bold;">' . __( 'If Quick Buy Link Not Working. Then Try Updating Permalink ', 'wc-quick-buy' ) . '</p>' )
				->notice_type( 'warning' )
				->alt( true )
				->large( true );
		}

		/**
		 * @param \WPO\Container $builder
		 */
		private function product_config( $builder ) {
			#$builder->subheading( __( 'Product Configuration' ) );
			$builder->select( 'enabled_product_types', __( 'Enabled Product Types', 'wc-quick-buy' ) )
				->options( array( '\WC_Quick_Buy\Helper', 'product_types' ) )
				->style( 'width:40%;' )
				->multiple( true )
				->select_framework( 'select2' )
				->desc_field( __( '`Quick Buy` Button Will Be Generated Only For Selected Product Types', 'wc-quick-buy' ) );

			$builder->select( 'hide_if_in_cart', __( 'Auto Hide Button', 'wc-quick-buy' ) )
				->option( 'hard', __( 'Hide', 'wc-quick-buy' ) )
				->option( 'soft', __( 'Non Clickable', 'wc-quick-buy' ) )
				->option( 'remove', __( 'Remove', 'wc-quick-buy' ) )
				->option( 'none', __( 'None', 'wc-quick-buy' ) )
				->select_framework( 'select2' )
				->desc_field( array(
					__( '1. if `Hide` Selected then button will be **hidden** untill product removed from cart / purchase is completed', 'wc-quick-buy' ),
					__( '2. if `Non Clickable` Selected then button will be **disabled** untill product removed from cart / purchase is completed', 'wc-quick-buy' ),
					__( '3. if `Remove` Selected then button will not be rendered & button also will not be shown even if product removed from cart via ajax ', 'wc-quick-buy' ),
				) );

			$builder->text( 'quantity', __( 'Cart Quantity', 'wc-quick-buy' ), array( 'text_type' => 'number' ) )
				->attribute( 'min', '0' )
				->style( 'min-width: 10%;width: 10%;padding: 10px 10px;height: auto;' )
				->desc_field( __( ' You can set min product Quantity. works only with shop page (`Product listing`) & `[wc_quick_buy_link]` shortcode', 'wc-quick-buy' ) );

			$builder->select( 'quick_buy_link_product_types', __( 'Shop Page Enabled Types', 'wc-quick-buy' ) )
				->badge( array(
					'type'      => 'danger',
					'content'   => __( 'EXPERIMENTAL', 'wc-quick-buy' ),
					'placement' => 'top-left',
				) )
				->style( 'width:50%;' )
				->options( Helper::get_all_product_types() )
				->multiple( true )
				->select_framework( 'select2' )
				->desc_field( array(
					__( 'Selected Product Types Will Get `Quick Buy` Button Generated Only in Places Where Products are listed. example places like ***Shop*** / ***Archive*** / ***Search***', 'wc-quick-buy' ),
					/* translators: Added Red Color Description */
					sprintf( __( '%1$s Note : Not All Product Types Will Work. only product types that are related to simple will work. and product types like variable / will not work. %2$s', 'wc-quick-buy' ), '<span class="wpo-text-danger">', '</span>' ),
				) );
		}

		/**
		 * @param \WPO\Container $builder
		 */
		private function redirect_config( $builder ) {
			$builder->subheading( __( 'Redirect Configuration', 'wc-quick-buy' ) );
			$builder->select( 'redirect_location', __( 'Location', 'wc-quick-buy' ) )
				->desc_field( __( 'Location To Redirect Once Product Added To Cart', 'wc-quick-buy' ) )
				->select_framework( 'select2' )
				->style( 'width:25%;' )
				->options( array( '\WC_Quick_Buy\Helper', 'redirect_locations' ) );

			$builder->text( 'custom_location', __( 'Custom Redirect Location', 'wc-quick-buy' ) )
				->style( 'width:300px;' )
				->desc_field( __( 'Enter a full url if custom selected in redirect location', 'wc-quick-buy' ) )
				->placeholder( 'https://example.com/your-custom-page' )
				->dependency( 'redirect_location', '=', 'custom' );
		}

		/**
		 * @param \WPO\Container $builder
		 */
		private function single_product_placement( $builder ) {
			#$builder->subheading( __( 'Quick Buy Button Placement' ) );
			$builder->select( 'single_product_page_placement', __( 'Single Product Page Placement', 'wc-quick-buy' ) )
				->options( array( '\WC_Quick_Buy\Helper', 'single_product_placement' ) )
				->style( 'width:20%;' )
				->desc_field( array(
					__( 'Where the button need to be added in single product page ', 'wc-quick-buy' ),
					__( 'if `Disabled` selected then you need to modify your **WooCommerce** template and quick buy shortcode', 'wc-quick-buy' ),
				) )
				->select_framework( 'select2' );

			$builder->select( 'shop_page_placement', __( 'Shop Page Placement', 'wc-quick-buy' ) )
				->options( array( '\WC_Quick_Buy\Helper', 'shop_page_placement' ) )
				->style( 'width:20%;' )
				->desc_field( array(
					__( 'Where the button need to be added in shop page ', 'wc-quick-buy' ),
					__( 'if `Disabled` selected then you need to modify your **WooCommerce** template and quick buy shortcode', 'wc-quick-buy' ),
				) )
				->select_framework( 'select2' );
		}
	}
}
