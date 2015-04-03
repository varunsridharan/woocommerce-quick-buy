<?php
/*  Copyright 2015  Varun Sridharan  (email : varunsridharan23@gmail.com)

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
    Description: Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button 
    Version: 0.11
    Author: Varun Sridharan
    Author URI: http://varunsridharan.in/
    License: GPL2
    GitHub Plugin URI: https://github.com/technofreaky/woocomerce-quick-buy
*/
defined('ABSPATH') or die("No script kiddies please!"); 
 


class wc_quick_buy {
	private $settings;
	
	/**
	 * Base Call Construct
	 */
	function __construct() {
		add_filter( 'woocommerce_get_sections_products', array($this,'wc_quick_buy_add_section' ));
		add_filter( 'woocommerce_get_settings_products', array($this,'wc_quick_buy_all_settings'), 10, 2 );
		add_filter('add_to_cart_redirect',array($this,'wc_quick_buy_add_to_cart_redirect_check'));
		add_action( 'woocommerce_update_options_settings_tab_demo', array($this,'update_settings' ));
		add_shortcode( 'wc_quick_buy', array($this,'wc_quick_buy_shortcode_handler' ));
        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_links' ), 10, 2 );
		$this->settings = array();
		$this->get_db_data();
	}
	
	/**
	 * Retrives Stored Values From DB
	 */
	private function get_db_data(){
		$this->settings['lable'] = get_option('wc_quick_buy_lable');
		$this->settings['position'] = get_option('wc_quick_buy_position');
		$this->settings['class'] = get_option('wc_quick_buy_class');
		$this->settings['automatic'] = get_option('wc_quick_buy_auto');
		$this->settings['where_to_show'] = get_option('wc_quick_buy_product_types');
		$this->settings['simple_product_form_class'] = get_option('wc_quick_buy_simple_product_form_class');
		$this->settings['variable_product_form_class'] = get_option('wc_quick_buy_variable_product_form_class');
        $this->settings['wc_quick_buy_btn_css'] = get_option('wc_quick_buy_btn_css');
        
		if(isset($this->settings['automatic']) && $this->settings['automatic'] == 'true'){
			if(! empty($this->settings['position']) && ! $this->settings['position'] == null){
				add_action ('woocommerce_'.$this->settings['position'].'_add_to_cart_form',array($this,'wc_quick_buy_after_add_to_cart_form_add'),99);
			}	
		}
		if(empty($this->settings['where_to_show'])){
			add_action( 'admin_notices', array($this,'wc_quick_buy_failed_settings' ));	
		}
		
	}
	
	/**
	 * Plugin Settings Config Issue
	 * @since 0.4
	 */
	function wc_quick_buy_failed_settings() {
	echo '<div class="error"><p><strong> Woocommerce Quick Buy </strong> Settings Is Not Configured...  <a href="'.admin_url( 'admin.php?page=wc-settings&tab=products&section=wc_quick_buy').'"> <strong> <u>click here</u></strong>  </a> to configure </p></div>';
	} 
	
 	/**
 	 * Creates Woocommerce Section
 	 * @since 0.1
 	 * @param  Array $sections List Of Sections In WC Settings Page
 	 * @return Array  List Of Sections In WC Settings Page
 	 */
 	public function wc_quick_buy_add_section( $sections ) {
		$sections['wc_quick_buy'] = __( 'WC Quick Buy', 'text-domain' );
		return $sections;
	} 	
	
	/**
	 * Function Called When Install Hook Is Called
     * @updated 0.6
	 */
	public static function install(){
		add_option('wc_quick_buy_auto','true');
		add_option('wc_quick_buy_position','after');
		add_option('wc_quick_buy_lable','Quick Buy');
		add_option('wc_quick_buy_class','quick_buy_button'); 
        add_option('wc_quick_buy_redirect','checkout'); 
		add_option('wc_quick_buy_product_types','');
		add_option('wc_quick_buy_simple_product_form_class','form.cart');
		add_option('wc_quick_buy_variable_product_form_class','form.variations_form');
        add_option('wc_quick_buy_btn_css','.wc_quick_buy_btn {} 
                                           .wc_quick_buy_btn:hover {}
        ');
		return true;
	}
	
	
	/**
	 * Adds Settings Page With Settings UI
	 * @param  String $settings        Refer WC.ORG
	 * @param  String $current_section Refer WC.ORG
	 * @return String Refer WC.ORG
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
				'name' => __( 'Show Quick Buy Button For ', 'text-domain' ),
				'desc_tip' => __( 'For Which Products To Show Quick Buy Button [eg to show for simple products select only simple products]', 'text-domain' ),
				'id' => 'wc_quick_buy_product_types',
				'type' => 'multiselect', 
				'class' =>'chosen_select',
				'options' => array('simple' => 'Simple Products','variable'=>'Variable Products')
			);	
            
            $wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Button Style', 'text-domain' ),
				'desc_tip' => __( 'Directly Add Button CSS', 'text-domain' ),
				'id' => 'wc_quick_buy_btn_css',
				'type' => 'textarea',
                'class'=>'large-text',
                'css'=>'height:200px;'
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
									   	'desc' => __( 'You can also use <code>[wc_quick_buy]</code> short code to call where ever you want in your template <br/> 
                                                       You can also set product id manually by <code>[wc_quick_buy product="2"]</code> <br/>
                                                       To remove the js embeded by shortcode use  <code> [wc_quick_buy product="2" show_js="false"] </code> <br/>
                                                        <h3>Note <small>  Do not add this shortcode in a form. as this shortcode itself generates a html form </small></h3>.
                                                       
										
										', 'text-domain' ), 
									   	'id' => 'wc_quick_buy_shortcode' );
			
			$wc_quick_buy[] = array( 'name' => '','type' => 'title','desc' => '<hr style="margin-top:25px;" />', 'id' => 'wc_quick_buy_troubleshoot' );
			$wc_quick_buy[] = array( 'type' => 'sectionstart', 'id' => 'wc_quick_buy' );
			$wc_quick_buy[] = array( 'name' => 'Debug / Troubleshoot', 
									'type' => 'title',
									'desc' => 'if JS is not running please use the below fields to fix it.', 
									'id' => 'wc_quick_buy_troubleshoot' );

			$wc_quick_buy[] = array(
				'name' => __( 'Simple Product Form Class', 'text-domain' ),
				'desc_tip' => __( 'Enter The Form Class for simple product add to cart form', 'text-domain' ),
				'id' => 'wc_quick_buy_simple_product_form_class',
				'type' => 'text', 
			); 
			
			
			$wc_quick_buy[] = array(
				'name' => __( 'Variable Product Form Class', 'text-domain' ),
				'desc_tip' => __( 'Enter The Form Class for Variable product add to cart form', 'text-domain' ),
				'id' => 'wc_quick_buy_variable_product_form_class',
				'type' => 'text', 
			);
			$wc_quick_buy[] = array( 'type' => 'sectionend', 'id' => 'wc_quick_buy' );
			 
			return $wc_quick_buy;
		} else {
			return $settings;
		}
	} 
	

	/**
	 * Function to redirect user after qucik buy button is submitted
	 * @since 0.1
	 * @updated 0.2
	 * @return string [[Description]]
	 */
	public function wc_quick_buy_add_to_cart_redirect_check(){
		if(isset($_REQUEST['quick_buy']) && $_REQUEST['quick_buy'] == true){
            $redirect_op = get_option('wc_quick_buy_redirect');
            if($redirect_op == 'cart'){
                wp_safe_redirect(WC()->cart->get_cart_url() );
            } else if($redirect_op == 'checkout'){
                wp_safe_redirect(WC()->cart->get_checkout_url() );
            }
			
			exit;
		}
		return '';
	}	
	
	/**
	 * Function to redirect user after qucik buy button is submitted
	 * @since 0.1
	 * @updated 0.2
	 * @return string [[Description]]
	 */
	public function wc_quick_buy_after_add_to_cart_form_add(){
		global $product; 
		if($product->is_type( 'simple' ) && in_array('simple',$this->settings['where_to_show'])){
			echo $this->wc_quick_buy_add_form_simple_product($product->id); 
		} 
		if($product->is_type( 'variable' ) && in_array('variable',$this->settings['where_to_show'])){
			echo $this->wc_quick_buy_add_form_variable_product($product->id); 
		}
		
	}
	
	
	/**
	 * Short Code Handler
	 * @since 0.1
	 * @updated 0.7
	 * @param [[Type]] $product [[Description]]
	 */
	public function wc_quick_buy_shortcode_handler($attrs) {
        $output = '';
		$prod = shortcode_atts( array(
            'product' => null,
            'show_js' => false,
            'echo' => true
        ), $attrs );
        
		if($prod['product'] == null){
			global $product;
			if($product->is_type( 'simple' )){ $output =  $this->wc_quick_buy_add_form_simple_product($product->id, $prod['show_js']);  }	
			if($product->is_type( 'variable' )){ $output =  $this->wc_quick_buy_add_form_variable_product($product->id, $prod['show_js']);  }				
		} else {			
			$product = get_product($prod['product']);
			if($product->is_type( 'simple' )){$output =  $this->wc_quick_buy_add_form_simple_product($product->id, $prod['show_js']);}
			if($product->is_type( 'variable' )){$output =  $this->wc_quick_buy_add_form_variable_product($product->id, $prod['show_js']); }
		} 
        
        if($prod['echo'] === true){
            echo $output;
            return true;
        }
        return $output;
	}
	
    /**
     * Returns if any style in db.
     * @since 0.9
     * @return null / value
     */
    public function wc_quick_buy_button_style(){
        if(!empty($this->settings['wc_quick_buy_btn_css'])){
            echo '<style> '.html_entity_decode( $this->settings['wc_quick_buy_btn_css']).'</style>';
            
        }
    }
    
	/**
	 * Custom form For Simple product
	 * @since 0.4
     * @updated 0.11
	 * @param  String $productid [[Description]]
	 * @return String [[Description]]
	 */
	public function wc_quick_buy_add_form_simple_product($productid,$add_js=true){
		
		$form = '<form data-productid="'.$productid.'" id="wc_quick_buy_'.$productid.'" class="wc_quick_buy_form wc_quick_buy_form_'.$productid.'" method="post" enctype="multipart/form-data">
		<input  type="hidden" value="1" name="quantity" id="quantity">
		<input  type="hidden" value="true" name="quick_buy" />
		<input  type="hidden" name="add-to-cart" value="'.esc_attr($productid).'" />
		<button data-productid="'.$productid.'" type="submit" class="wc_quick_buy_product_'.$productid.' quick_buy_'.$productid.'  wc_quick_buy_btn '.$this->settings['class'].'">'.$this->settings['lable'].'</button>';
        if($add_js === true){$form .= '<div class="variable_details" id="variable_details" ></div>';}
		$form .= '</form>';
        add_action('wp_footer',array($this,'wc_quick_buy_button_style'));
		if($add_js === true){$form .= '	<script>
				jQuery("document").ready(function(){
					jQuery("'.$this->settings['simple_product_form_class'].' input[name=quantity]").change(function(){
						var value = jQuery("input.input-text.qty.text").val();
						jQuery("form#wc_quick_buy_'.$productid.' > #quantity").val(value);
					}); 
				});
					
			</script>
		'; }
		return $form;
	}	
	
	
	/**
	 * Custom Quick Buy Form For Variable Product
	 * @since 0.4
     * @updated 0.11
	 * @param  String $productid [[Description]]
	 * @return String [[Description]]
	 */
	public function wc_quick_buy_add_form_variable_product($productid,$add_js=true){
		
		$form = '<form data-productid="'.$productid.'" id="wc_quick_buy_'.$productid.'" class="wc_quick_buy_form wc_quick_buy_form_'.$productid.'" method="post" enctype="multipart/form-data">
		<input  type="hidden" value="1" name="quantity" id="quantity">
		<input  type="hidden" value="true" name="quick_buy" />
		<input  type="hidden" name="add-to-cart" value="'.esc_attr($productid).'" />
		<button data-productid="'.$productid.'" type="submit" class="wc_quick_buy_product_'.$productid.' quick_buy_'.$productid.'  wc_quick_buy_btn '.$this->settings['class'].'">'.$this->settings['lable'].'</button>';
		if($add_js === true){$form .= '<div class="variable_details" id="variable_details" ></div>';}
		$form .= '</form> ';
        add_action('wp_footer',array($this,'wc_quick_buy_button_style'));
			if($add_js === true){$form .= '<script>
				jQuery("document").ready(function(){ 
					jQuery("'.$this->settings['variable_product_form_class'].'").change(function(){
						var value = jQuery("input.input-text.qty.text").val();
						jQuery("form#wc_quick_buy_'.$productid.' > #quantity").val(value);
						var datas = jQuery(".variations_form").serializeArray();
						jQuery("form#wc_quick_buy_'.$productid.' > div#variable_details").html(\'\');
						jQuery.each( datas, function( key, value ) { 
						 		if(value["name"] != "quantity" && value["name"] != "add-to-cart"){
								jQuery("form#wc_quick_buy_'.$productid.' > div#variable_details").append(\'<input type="hidden" name="\' +value["name"] +\'"  value="\' +value["value"] +\'" /> \');
								}
						});
					});
				});					
			</script>
		'; }
		return $form;
	}		
	
    
    /**
     * Saves WC Settings In DB
     * @since 0.1
     * @access public
     */
	public function update_settings() {
		woocommerce_update_options( get_settings() );
	}
    
    
	/**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( plugin_basename( __FILE__ ) == $plugin_file ) {
            $plugin_meta[ ] = sprintf(
                ' <a href="%s">%s</a>',
                admin_url('admin.php?page=wc-settings&tab=products&section=wc_quick_buy'),
                'Settings'
            );
            
            $plugin_meta[ ] = sprintf(
				'<a href="%s">%s</a>',
				'https://wordpress.org/plugins/woocommerce-quick-buy/faq/',
				'F.A.Q'
			);
            $plugin_meta[ ] = sprintf(
				'<a href="%s">%s</a>',
				'https://github.com/technofreaky/woocomerce-quick-buy',
				'View On Github'
			);
            
            $plugin_meta[ ] = sprintf(
				'<a href="%s">%s</a>',
				'https://github.com/technofreaky/woocomerce-quick-buy/issues/new',
				'Report Issue'
			);
            $plugin_meta[ ] = sprintf(
				'&hearts; <a href="%s">%s</a>',
				'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YUBNEPWZMGTTQ',
				'Donate'
			);
		}
		return $plugin_meta;
	}	
}





/**
 * Check if WooCommerce is active 
 * if yes then call the class
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	register_activation_hook( __FILE__, array( 'wc_quick_buy', 'install' ) );
	$wc_quick_buy = new wc_quick_buy; 
} else {
	add_action( 'admin_notices', 'wc_quick_buy_notice' );
}

function wc_quick_buy_notice() {
	echo '<div class="error"><p><strong> <i> Woocommerce Quick Buy </i> </strong> Requires <a href="'.admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce').'"> <strong> <u>Woocommerce</u></strong>  </a> To Be Installed And Activated </p></div>';
} 
?>