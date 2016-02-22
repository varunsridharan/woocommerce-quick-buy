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
    }
    
    public function add_quick_buy_button($attrs){
        $show_button = false;
        $output = '';
        $attrs = shortcode_atts( array('product' => null, 'name' => null),  $attrs );
        
        if($prod['product'] == null) { 
            global $product; 
            $shortcode_product = $product;
        } else {
            $shortcode_product = get_product($prod['product']); 
        } 
        
        if($shortcode_product->is_in_stock()){
            $show_button = true;
        }
        
        if($show_button){
        }
        
        return $output;
    }
}