<?php

namespace WC_Quick_Buy\Admin\Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Trait General
 *
 * @package WC_Quick_Buy\Admin\Settings
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
trait General {
	/**
	 * Generates Basic Config Fields.
	 *
	 * @param \WPO\Container $builder
	 */
	public function general( $builder ) {
		$general       = $builder->container( 'general', __( 'General', 'wc-quick-buy' ), 'wpoic-gear' );
		$product       = $builder->container( 'product', __( 'Product', 'wc-quick-buy' ), 'wpoic-database' );
		$btn_placement = $builder->container( 'button-placement', __( 'Button Placement', 'wc-quick-buy' ), 'wpoic-display' );
		$this->basic_config( $general );
		$this->redirect_config( $general );
		$this->product_config( $product );
		$this->single_product_placement( $btn_placement );
	}

	/**
	 * Generates Basic Config Fields.
	 *
	 * @param \WPO\Container $builder
	 */
	private function basic_config( $builder ) {
		$builder->subheading( __( 'Basic Config', 'wc-quick-buy' ) );
		$builder->switcher( 'auto_clear_cart', __( 'Auto Clear Cart ?', 'wc-quick-buy' ) )
			->desc_field( __( 'if Enabled then cart contents will be auto cleared if quick buy button used.', 'wc-quick-buy' ) );

		$builder->select( 'url_type', __( 'WordPress URL Type', 'wc-quick-buy' ) )
			->style( 'width:20%;' )
			->wrap_id( 'url_type' )
			->select_framework( 'select2' )
			->option( 'site_url', array(
				'label'      => __( 'Site URL', 'wc-quick-buy' ),
				'attributes' => array( 'data-url' => trailingslashit( site_url() ) ),
			) )
			->option( 'home_url', array(
				'label'      => __( 'Home URL', 'wc-quick-buy' ),
				'attributes' => array( 'data-url' => trailingslashit( home_url() ) ),
			) )
			->desc_field( array(
				__( '**Site Url** : Retrieves the URL for the current site where WordPress application files `(e.g. wp-blog-header.php or the wp-admin/ folder)` are accessible.', 'wc-quick-buy' ),
				__( '**Home Url** : Retrieves the URL for the current site where the front end is accessible.', 'wc-quick-buy' ),
			) );

		$builder->text( 'url_endpoint', __( 'URL Endpoint', 'wc-quick-buy' ) )
			->field_default( 'quick-buy/{id}/{qty}' )
			->style( 'width:350px' )
			->wrap_id( 'url_endpoint' )
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
	 * Generate Product Config Fields.
	 *
	 * @param \WPO\Container $builder
	 *
	 * @uses \WC_Quick_Buy\Helper::product_types()
	 * @uses \WC_Quick_Buy\Helper::get_all_product_types()
	 */
	private function product_config( $builder ) {
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
			->style( 'width: 10%;' )
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
			->options( array( '\WC_Quick_Buy\Helper', 'get_all_product_types' ) )
			->multiple( true )
			->select_framework( 'select2' )
			->desc_field( array(
				__( 'Selected Product Types Will Get `Quick Buy` Button Generated Only in Places Where Products are listed. example places like ***Shop*** / ***Archive*** / ***Search***', 'wc-quick-buy' ),
				/* translators: Added Red Color Description */
				sprintf( __( '%1$s Note : Not All Product Types Will Work. only product types that are related to simple will work. and product types like variable / will not work. %2$s', 'wc-quick-buy' ), '<span class="wpo-text-danger">', '</span>' ),
			) );
	}

	/**
	 * Generates Redirect Related Fields.
	 *
	 * @param \WPO\Container $builder
	 *
	 * @uses \WC_Quick_Buy\Helper::redirect_locations()
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
	 * Generates Button Placement Related Fields.
	 *
	 * @param \WPO\Container $builder
	 *
	 * @uses \WC_Quick_Buy\Helper::single_product_placement()
	 * @uses \WC_Quick_Buy\Helper::shop_page_placement()
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
