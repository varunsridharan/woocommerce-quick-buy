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

class WooCommerce_Quick_Buy_FrontEnd {
    /**
     * Class Constructor
     */
    public function __construct() {
        $this->settings = array();
        $this->get_settings();
        
        if(isset($this->settings['auto']) && $this->settings['auto'] == 'true'){
            if(! empty($this->settings['position']) && ! $this->settings['position'] == null){
                $pos = '';
                if($this->settings['position'] == 'before_form'){$pos = 'woocommerce_before_add_to_cart_form';}
                if($this->settings['position'] == 'after_form'){$pos = 'woocommerce_after_add_to_cart_form';}
                if($this->settings['position'] == 'after_button'){$pos = 'woocommerce_after_add_to_cart_button';}
                if($this->settings['position'] == 'before_button'){$pos = 'woocommerce_before_add_to_cart_button';}
                add_action($pos,array($this,'add_quick_buy_button'),99);
            }	
        }
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_style_script') );
        add_action('woocommerce_before_add_to_cart_button',array($this,'add_wc_quick_buy_chain'));
        add_filter( 'woocommerce_add_to_cart_redirect',array($this,'quick_buy_redirect'));
    }
    
    public function add_wc_quick_buy_chain(){
        global $product;
        if($product != null){
            echo '<input type="hidden" id="wc_quick_buy_hook_'.$product->id.'" value="'.$product->id.'"  />';
        }
    }
    
    /**
     * Adds Plugins Script To Site Front End
     */
    public function enqueue_style_script(){
        wp_enqueue_script(WCQB_DB.'_frontend', WCQB_JS.'frontend.js', array( 'jquery'),WCQB_V );
    }

    
    public function get_settings(){
        $this->settings['redirect'] = get_option(WCQB_DB.'redirect');
        $this->settings['custom_redirect'] = get_option(WCQB_DB.'custom_redirect');
        $this->settings['product_types'] = get_option(WCQB_DB.'product_types');
        $this->settings['auto'] = get_option(WCQB_DB.'auto');
        $this->settings['position'] = get_option(WCQB_DB.'position');
        $this->settings['lable'] = get_option(WCQB_DB.'lable');
        $this->settings['class'] = get_option(WCQB_DB.'class');
        $this->settings['btn_css'] = get_option(WCQB_DB.'btn_css');
    }
    
    public function add_quick_buy_button(){ 
        global $product;
        $args = array( 'product' => $product );
        echo $this->generate_button($args);
    }
    
    
    
    public function generate_button($args){
        $default_args = array(
            'product' => null,
            'lable' => $this->settings['lable'],
            'class' => $this->settings['class'],
        );
        
        $args = wp_parse_args( $args, $default_args );
        extract($args);
        if($product == null){return;}
        $return = '';
        $type = $product->product_type;

        if(!in_array('all',$this->settings['product_types']) && !in_array($type,$this->settings['product_types'])){return;}
        
        $pid = $product->id;
        $return .= '<div class="quick_buy_container quick_buy_'.$pid.'_container" id="quick_buy_'.$pid.'_container" >';
        $return .= '<input 
        value="'.$lable.'" 
        type="button"
        name="" 
        id="quick_buy_'.$pid.'_button"
        data-product-type="'.$type.'"
        data-product-id="'.$pid.'" 
        class="wcqb_button wc_quick_buy_button quick_buy_button quick_buy_'.$pid.'_button quick_buy_'.$pid.' '.$class.'"
        >';
        
        $return .= '</div>';
        return $return;
    }
    
	/**
	 * Function to redirect user after qucik buy button is submitted
	 * @since 0.1
	 * @updated 0.2
	 * @return string [[Description]]
	 */
	public function quick_buy_redirect($url){
		if(isset($_REQUEST['quick_buy']) && $_REQUEST['quick_buy'] == true){
            if($this->settings['redirect'] == 'cart'){
                return WC()->cart->get_cart_url();
            } else if($this->settings['redirect'] == 'checkout'){
                return WC()->cart->get_checkout_url();
            } else if($this->settings['redirect'] == 'custom'){
                if(!empty($this->settings['custom_redirect'])){
                    return $this->settings['custom_redirect'];
                }
            }
		}
		return $url;
	}	

}







