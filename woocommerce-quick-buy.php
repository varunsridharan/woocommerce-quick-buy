<?php
/*  Copyright 2014  Varun Sridharan  (email : varunsridharan23@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 
    Plugin Name: Woocommerce Quick Buy
    Plugin URI: http://varunsridharan.in/
    Description: Woocommerce Quick Buy
    Version: 0.2
    Author: Varun Sridharan
    Author URI: http://varunsridharan.in/
    License: GPL2
*/
defined('ABSPATH') or die("No script kiddies please!"); 



class wc_quick_buy {
	private $settings;
	function __construct() {
		add_filter( 'woocommerce_get_sections_products', array($this,'wc_quick_buy_add_section' ));
		add_filter( 'woocommerce_get_settings_products', array($this,'wc_quick_buy_all_settings'), 10, 2 );
		add_filter('add_to_cart_redirect',array($this,'wc_quick_buy_add_to_cart_redirect_check'));
		add_action( 'woocommerce_update_options_settings_tab_demo', array($this,'update_settings' ));
		add_shortcode( 'wc_quick_buy', array($this,'wc_quick_buy_shortcode_handler' ));
		$this->settings = array();
		$this->get_db_data();
	}
	
	private function get_db_data(){
		$this->settings['lable'] = get_option('wc_quick_buy_lable');
		$this->settings['position'] = get_option('wc_quick_buy_position');
		$this->settings['class'] = get_option('wc_quick_buy_class');
		$this->settings['automatic'] = get_option('wc_quick_buy_auto');
		
		if(isset($this->settings['automatic']) && $this->settings['automatic'] == 'true'){
			if(! empty($this->settings['position']) && ! $this->settings['position'] == null){
				add_action ('woocommerce_'.$this->settings['position'].'_add_to_cart_form',array($this,'wc_quick_buy_after_add_to_cart_form_add'),99);
			}	
		}
		
	}
	
	
	
	/***
	* Create the section beneath the products tab
	*/
 	public function wc_quick_buy_add_section( $sections ) {
		$sections['wc_quick_buy'] = __( 'WC Quick Buy', 'text-domain' );
		return $sections;
	} 	
	
	public function install(){
		add_option('wc_quick_buy_auto','true');
		add_option('wc_quick_buy_position','after');
		add_option('wc_quick_buy_lable','Quick Buy');
		add_option('wc_quick_buy_class','quick_buy_button'); 
        add_option('wc_quick_buy_redirect','checkout'); 
	}
	
	
	/***
	* Add settings to the specific section we created before
	*/
	public function wc_quick_buy_all_settings( $settings, $current_section ) {
		if ( $current_section == 'wc_quick_buy' ) {
			$wc_quick_buy = array();
			$wc_quick_buy[] = array( 'name' => __( 'WC Quick Buy Settings', 'text-domain' ), 
									   	'type' => 'title',
									   	'desc' => __( 'The following options are used to configure WC Quick Buy', 'text-domain' ), 
									   	'id' => 'wc_quick_buy' );
            $wc_quick_buy[] = array(
				'name' => __( 'Redirect Location', 'text-domain' ),
				'desc_tip' => __( 'After Add To Cart Where To Redirect The user', 'text-domain' ),
				'id' => 'wc_quick_buy_redirect',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => array('cart' => 'Cart Page','checkout'=>'Checkout Page')
			);
            
			$wc_quick_buy[] = array(
				'name' => __( 'Automatically Add Button ', 'text-domain' ),
				'desc_tip' => __( 'Automaticaly Adds Button After Add To Cart In Single Product View', 'text-domain' ),
				'id' => 'wc_quick_buy_auto',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => array('true' => 'Yes','false'=>'No')
			);	
			$wc_quick_buy[] = array(
				'name' => __( 'Position', 'text-domain' ),
				'desc_tip' => __( 'Where the button need to be added in single page .. before / after', 'text-domain' ),
				'id' => 'wc_quick_buy_position',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => array('after' => 'After Add To Cart','before'=>'Before Add To Cart')
			);	
			$wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Button Text', 'text-domain' ),
				'desc_tip' => __( 'You Can Change The Quick Buy Button Lable', 'text-domain' ),
				'id' => 'wc_quick_buy_lable',
				'type' => 'text', 
			);
			$wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Button Class', 'text-domain' ),
				'desc_tip' => __( 'You Can Change The Quick Buy Button Class', 'text-domain' ),
				'id' => 'wc_quick_buy_class',
				'type' => 'text', 
			); 		
			
			$wc_quick_buy[] = array( 'type' => 'sectionend', 'id' => 'wc_quick_buy' );
			
			$wc_quick_buy[] = array( 'name' => __( 'WC Quick Buy Short Code', 'text-domain' ), 
									   	'type' => 'title',
									   	'desc' => __( 'You can also use <code>[wc_quick_buy]</code> short code to call where ever you want in your template <br/>  you can also set product id manually by <code>[wc_quick_buy product="2"]</code>									
										
										', 'text-domain' ), 
									   	'id' => 'wc_quick_buy_shortcode' );
			return $wc_quick_buy;
		} else {
			return $settings;
		}
	} 
	
	/**
	 * @since 0.1
     * @updated 0.2
	 */
	public function wc_quick_buy_add_to_cart_redirect_check(){
		if(isset($_REQUEST['quick_buy']) && $_REQUEST['quick_buy'] == true){
            $redirect_op = get_option('wc_quick_buy_redirect');
            var_dump($redirect_op);
            if($redirect_op == 'cart'){
                wp_safe_redirect(WC()->cart->get_cart_url() );
            } else if($redirect_op == 'checkout'){
                wp_safe_redirect(WC()->cart->get_checkout_url() );
            }
			
			exit;
		}
		return '';
	}	
	
	public function wc_quick_buy_after_add_to_cart_form_add(){
		global $product; 
		
		if($product->is_type( 'simple' )){ 
			echo $this->wc_quick_buy_add_quick_buy_form($product->id);
		}
		
	}
	
	
	
	public function wc_quick_buy_shortcode_handler($product) {
		$prod = shortcode_atts( array('product' => null), $product );
		if($prod['product'] == null){
			global $product;
			
			if($product->is_type( 'simple' )){ 
				echo $this->wc_quick_buy_add_quick_buy_form($product->id);
			}			
		} else {
			$product = get_product($a['product']);
			if($product->is_type( 'simple' )){ 
				echo $this->wc_quick_buy_add_quick_buy_form($product->id);
			}
		} 
	}
	
	
	
	public function wc_quick_buy_add_quick_buy_form($productid){
		
		$form = '<form class="cart" method="post" enctype="multipart/form-data">
		<input  type="hidden" value="1" name="quantity">
		<input  type="hidden" value="true" name="quick_buy" />
		<input  type="hidden" name="add-to-cart" value="'.esc_attr($productid).'" />
		<button type="submit" class="'.$this->settings['class'].'">'.$this->settings['lable'].'</button>
		</form> '; 
		return $form;
	}	
	
	
	public function update_settings() {
		woocommerce_update_options( get_settings() );
	}	
	
}





/**
 * Check if WooCommerce is active 
 * if yes then call the class
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	register_activation_hook( __FILE__, array( 'wc_quick_buy', 'install' ) );
	$wc_quick_buy = new wc_quick_buy; 
}

 
?>