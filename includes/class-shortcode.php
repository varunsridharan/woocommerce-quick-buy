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
if ( ! defined( 'WPINC' ) ) { die; }

class WooCommerce_Quick_Buy_Shortcode {
    /**
     * Class Constructor
     */
    public function __construct() {
        add_shortcode( 'wc_quick_buy', array($this,'add_quick_buy_button') );
		add_shortcode( 'wc_quick_buy_link', array($this,'quick_buy_link') );
    }
    
    public function add_quick_buy_button($attrs){
        $show_button = false;
        $output = '';
		global $product; 
		$shortcode_product = $product;
        $attrs = shortcode_atts( array('lable' => wc_qb_option('lable')),  $attrs );
        if($shortcode_product->is_in_stock()){ $show_button = true; }
        if($show_button){ $output = WooCommerce_Quick_Buy()->func()->generate_button(array('product' => $shortcode_product,'lable' => $attrs['lable'])); }

		return $output;
    }
	
	public function quick_buy_link($attrs){
		$output = '';
		$attrs = shortcode_atts( array(
			'product' => null,
			'qty' => wc_qb_option('product_qty'),
			'lable' => wc_qb_option('lable'),
			'type' => 'button',
		),  $attrs );
		
		if($attrs['product'] == null){
			global $product;
			$attrs['product'] = $product;
		} else {
			$attrs['product'] = wc_get_product($attrs['product']);
		}
		
		extract($attrs);
		
		if($type == 'link'){
			$output = WooCommerce_Quick_Buy()->func()->get_product_addtocartLink($product,$qty);
		} else if($type == 'button'){
			$args = array('product' => $product, 'lable' => $lable,'tag' => 'link');
			$output = WooCommerce_Quick_Buy()->func()->generate_button($args);
		}
		
		return $output;
	}
}

return new WooCommerce_Quick_Buy_Shortcode;