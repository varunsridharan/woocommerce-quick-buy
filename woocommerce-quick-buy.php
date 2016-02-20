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
    Version: 0.15
    Author: Varun Sridharan
    Author URI: http://varunsridharan.in/
    License: GPL2
    Text Domain: woocommerce-quick-buy
    GitHub Plugin URI: https://github.com/technofreaky/woocomerce-quick-buy
*/
defined('ABSPATH') or die("No script kiddies please!");  
define('lang_dom','woocommerce-quick-buy',true); #plugin lang Domain

class wc_quick_buy {
	private $settings;
    public  $product_types;
	
	/**
	 * Base Call Construct
	 */
	function __construct() {
        $this->product_types = array('simple' => 'Simple Products','variable'=>'Variable Products');
        register_activation_hook( __FILE__, array( 'wc_quick_buy', 'install' ) );
        
		add_filter( 'woocommerce_get_sections_products', array($this,'wc_quick_buy_add_section' ));
		add_filter( 'woocommerce_get_settings_products', array($this,'wc_quick_buy_all_settings'), 10, 2 );
		add_filter( 'woocommerce_add_to_cart_redirect',array($this,'wc_quick_buy_add_to_cart_redirect_check'));
        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_links' ), 10, 2 );
        
		add_action( 'woocommerce_update_options_settings_tab_demo', array($this,'update_settings' ));
		add_shortcode( 'wc_quick_buy', array($this,'wc_quick_buy_shortcode_handler' )); 
        
        add_action('plugins_loaded', array( $this, 'langs' ));
        add_filter('load_textdomain_mofile',  array( $this, 'replace_my_plugin_default_language_files' ), 10, 2);
        
		$this->settings = array();
		$this->get_db_data();
	}
	
    public function langs(){
        load_plugin_textdomain(lang_dom, false, dirname(plugin_basename(__FILE__)).'/lang/' );
    }
    
    public function replace_my_plugin_default_language_files($mofile, $domain) {
        if (lang_dom === $domain)
            return dirname(plugin_basename(__FILE__)).'/lang/'.get_locale().'.mo';

        return $mofile;
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
       echo  __( '<div class="error"><p><strong> Woocommerce Quick Buy </strong> Settings Is Not Configured...  <a href="'.admin_url( 'admin.php?page=wc-settings&tab=products&section=wc_quick_buy').'"> <strong> <u>click here</u></strong>  </a> to configure </p></div>',lang_dom) ;
	} 
	
 	/**
 	 * Creates Woocommerce Section
 	 * @since 0.1
 	 * @param  Array $sections List Of Sections In WC Settings Page
 	 * @return Array  List Of Sections In WC Settings Page
 	 */
 	public function wc_quick_buy_add_section( $sections ) {
		$sections['wc_quick_buy'] = __( 'WC Quick Buy',lang_dom);
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
		add_option('wc_quick_buy_product_types',array('simple','variable'));
		add_option('wc_quick_buy_simple_product_form_class',' form.cart[data-product_id={product_id}]');
		add_option('wc_quick_buy_variable_product_form_class','   form.variations_form[data-product_id={product_id}]');
        add_option('wc_quick_buy_btn_css','.wc_quick_buy_btn {}
.wc_quick_buy_btn:hover {}'); 
       
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
			$wc_quick_buy[] = array( 'name' => __( 'WC Quick Buy Settings', lang_dom ), 
									   	'type' => 'title',
									   	'desc' => __( 'The following options are used to configure WC Quick Buy',lang_dom ), 
									   	'id' => 'wc_quick_buy' );
            $wc_quick_buy[] = array(
				'name' => __( 'Redirect Location', lang_dom ),
				'desc_tip' => __( 'After Add To Cart Where To Redirect The user',lang_dom ),
				'id' => 'wc_quick_buy_redirect',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => array('cart' =>  __( 'Cart Page', lang_dom ) ,'checkout'=> __( 'Checkout Page', lang_dom ) )
			);
            
			$wc_quick_buy[] = array(
				'name' => __( 'Automatically Add Button ', lang_dom ),
				'desc_tip' => __( 'Automaticaly Adds Button After Add To Cart In Single Product View', lang_dom ),
				'id' => 'wc_quick_buy_auto',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => array('true' => 'Yes','false'=>'No')
			);	
			$wc_quick_buy[] = array(
				'name' => __( 'Position', lang_dom ),
				'desc_tip' => __( 'Where the button need to be added in single page .. before / after',lang_dom ),
				'id' => 'wc_quick_buy_position',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => array('after' => 'After Add To Cart','before'=>'Before Add To Cart')
			);	
			$wc_quick_buy[] = array(
				'name' => __( 'Show Quick Buy Button For ', lang_dom ),
				'desc_tip' => __( 'For Which Products To Show Quick Buy Button [eg to show for simple products select only simple products]',lang_dom ),
				'id' => 'wc_quick_buy_product_types',
				'type' => 'multiselect', 
				'class' =>'chosen_select',
				'options' => $this->product_types
			);	
            
            $wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Button Style', lang_dom),
				'desc_tip' => __( 'Directly Add Button CSS', lang_dom),
				'id' => 'wc_quick_buy_btn_css',
				'type' => 'textarea',
                'class'=>'large-text',
                'css'=>'height:100px;'
			); 
            
			$wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Button Text',lang_dom ),
				'desc_tip' => __( 'You Can Change The Quick Buy Button Lable',lang_dom ),
				'id' => 'wc_quick_buy_lable',
				'type' => 'text', 
			);
			$wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Button Class',lang_dom ),
				'desc_tip' => __( 'You Can Change The Quick Buy Button Class', lang_dom ),
				'id' => 'wc_quick_buy_class',
				'type' => 'text', 
			); 		
            
            $wc_quick_buy[] = array( 'type' => 'sectionend', 'id' => 'wc_quick_buy' );
            
			$wc_quick_buy[] = array( 'name' => __( 'Debug / Troubleshoot', lang_dom ), 
									'type' => 'title',
									'desc' => __( 'if JS is not running please use the below fields to fix it.', lang_dom ), 
									'id' => 'wc_quick_buy_troubleshoot' );

			$wc_quick_buy[] = array(
				'name' => __( 'Simple Product Form Class',lang_dom ),
				'desc_tip' => __( 'Enter The Form Class for simple product add to cart form',lang_dom ),
				'id' => 'wc_quick_buy_simple_product_form_class',
				'type' => 'text', 
			); 
			
			
			$wc_quick_buy[] = array(
				'name' => __( 'Variable Product Form Class', lang_dom ),
				'desc_tip' => __( 'Enter The Form Class for Variable product add to cart form', lang_dom ),
				'id' => 'wc_quick_buy_variable_product_form_class',
				'type' => 'text', 
			);	
			
			$wc_quick_buy[] = array( 'type' => 'sectionend', 'id' => 'wc_quick_buy' );
            
			$wc_quick_buy[] = array( 'name' => __( 'WC Quick Buy Short Code', lang_dom ), 
									   	'type' => 'title',
									   	'desc' => __( '<code>[wc_quick_buy]</code> Use Inside of product loop 
                                                       <code>[wc_quick_buy product="2"]</code> Outside loop With manual Product ID  <br/> To remove the js embeded by shortcode use  <code> [wc_quick_buy product="2" show_js="false"] </code> <br/> <h3>Note : <small>  Do not add this shortcode in a form. as this shortcode itself generates a html form </small></h3>.', lang_dom ), 
									   	'id' => 'wc_quick_buy_shortcode' ); 
			 
			 
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
	public function wc_quick_buy_add_to_cart_redirect_check($url){
		if(isset($_REQUEST['quick_buy']) && $_REQUEST['quick_buy'] == true){
            $redirect_op = get_option('wc_quick_buy_redirect');
            if($redirect_op == 'cart'){
                return WC()->cart->get_cart_url();
            } else if($redirect_op == 'checkout'){
                return WC()->cart->get_checkout_url();
            }
			 
		}
		return $url;
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
        $show_button = false;
		$prod = shortcode_atts(array('product' => null, 'show_js' => false, 'name' => null), $attrs );
		if($prod['product'] == null){ global $product; $shortcode_product = $product;} else {$shortcode_product = get_product($prod['product']); } 
 
        if($product->is_in_stock()){
            $show_button = true;
        }

        if($show_button){
            if($shortcode_product->is_type( 'simple' )){ 
                $output =  $this->wc_quick_buy_add_form_simple_product($shortcode_product->id, $prod['show_js'],$prod['name']);  
            }	

            if($shortcode_product->is_type( 'variable' )){ 
                $output =  $this->wc_quick_buy_add_form_variable_product($shortcode_product->id, $prod['show_js'],$prod['name']);  
            }	
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
	public function wc_quick_buy_add_form_simple_product($productid,$add_js=true,$btn_name=null){
		$button_name = $this->settings['lable'];
        
        if($btn_name != null){
            $button_name = $btn_name;
        }
		$form = '<form data-productid="'.$productid.'" id="wc_quick_buy_'.$productid.'" class="wc_quick_buy_form wc_quick_buy_form_'.$productid.'" method="post" enctype="multipart/form-data">
		<input  type="hidden" value="1" name="quantity" id="quantity">
		<input  type="hidden" value="true" name="quick_buy" />
		<input  type="hidden" name="add-to-cart" value="'.esc_attr($productid).'" />
		<button data-productid="'.$productid.'" type="submit" class="wc_quick_buy_product_'.$productid.' quick_buy_'.$productid.'  
                                                                     wc_quick_buy_btn '.$this->settings['class'].'">'.$button_name.'</button>';
		$form .= '</form>';
        
        add_action('wp_footer',array($this,'wc_quick_buy_button_style'));
		
        if($add_js === true){
            
            $simple_form_class = str_replace('{product_id}',$productid,$this->settings['simple_product_form_class']);
            
            $form .= '	<script>
				jQuery("document").ready(function(){
					jQuery("'.$simple_form_class.' input[name=quantity]").change(function(){
						var value = jQuery("'.$simple_form_class.' input.input-text.qty.text").val();
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
	public function wc_quick_buy_add_form_variable_product($productid,$add_js=true,$btn_name = null){
		$button_name = $this->settings['lable'];
        
        if($btn_name != null){
            $button_name = $btn_name;
        }  
        
		$form = '<form data-productid="'.$productid.'" id="wc_quick_buy_'.$productid.'" 
                  class="wc_quick_buy_form wc_quick_buy_form_'.$productid.'" method="post" enctype="multipart/form-data">
		<input  type="hidden" value="1" name="quantity" id="quantity">
		<input  type="hidden" value="true" name="quick_buy" />
		<input  type="hidden" name="add-to-cart" value="'.esc_attr($productid).'" />
		<button data-productid="'.$productid.'" type="submit" class="wc_quick_buy_product_'.$productid.' quick_buy_'.$productid.'  
        wc_quick_buy_btn '.$this->settings['class'].'">'.$button_name.'</button>';
        
		if($add_js === true){ $form .= '<div class="variable_details" id="variable_details" ></div>'; }
		
        $form .= '</form> ';
        
        add_action('wp_footer',array($this,'wc_quick_buy_button_style'));
			if($add_js === true){
                $variable_form_class = str_replace('{product_id}',$productid,$this->settings['variable_product_form_class']);
                
                $form .= '<script>
				jQuery("document").ready(function(){ 
					jQuery("'.$variable_form_class.'").change(function(){
                        jQuery("form#wc_quick_buy_'.$productid.'").show();
                        var wc_qb_product_variations = jQuery("'.$variable_form_class.'").attr("data-product_variations");
                        wc_qb_product_variations = JSON.parse(wc_qb_product_variations);
                        var wc_qb_product_id = jQuery("'.$variable_form_class.' input[name=\"variation_id\"").val();

                        for(var i = 0; i < wc_qb_product_variations.length; i++){
                            if(wc_qb_product_id == wc_qb_product_variations[i]["variation_id"]){
                            console.log(wc_qb_product_variations[i]["is_in_stock"]);
                                if(wc_qb_product_variations[i]["is_in_stock"] === false){
                                    jQuery("form#wc_quick_buy_'.$productid.'").hide();
                                }
                            }
                            
                        }
                    
                    
                    
						var value = jQuery("input.input-text.qty.text").val();
						jQuery("form#wc_quick_buy_'.$productid.' > #quantity").val(value);
						var datas = jQuery("'.$variable_form_class.'").serializeArray();
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
            
            $plugin_meta[ ] = sprintf(
				'<a href="%s">%s</a>',
				'http://varunsridharan.in/plugin-support/',
				'Contact Author'
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
	$wc_quick_buy = new wc_quick_buy; 
} else {
	add_action( 'admin_notices', 'wc_quick_buy_notice' );
}

function wc_quick_buy_notice() {
	echo '<div class="error"><p><strong> <i> Woocommerce Quick Buy </i> </strong> Requires <a href="'.admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce').'"> <strong> <u>Woocommerce</u></strong>  </a> To Be Installed And Activated </p></div>';
} 
?>