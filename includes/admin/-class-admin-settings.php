<?php
/**
 * The admin-specific functionality of the plugin.
 * @package    @TODO
 * @subpackage @TODO
 * @author     Varun Sridharan <varunsridharan23@gmail.com>
 */
if ( ! defined( 'WPINC' ) ) { die; }

class WooCommerce_Quick_Buy_Admin_Settings extends WooCommerce_Quick_Buy_Admin {
    
    public function __construct() {
        $this->redirect_locations = array( 
            'cart' =>  __( 'Cart Page', WCQB_TXT ) , 
            'checkout'=> __( 'Checkout Page', WCQB_TXT ) , 
            'custom' => __('Custom URL', WCQB_TXT)
        );
        
        $this->product_types = array(
            'all' => __("All Product Types", WCQB_TXT), 
            'simple' => __('Simple Products',WCQB_TXT),
            'variable'=>__('Variable Products',WCQB_TXT),
            //'grouped'=>__('Grouped Products',WCQB_TXT),
            //'external'=>__('External Products',WCQB_TXT),
        );
        
        $this->show_position = array(
            'before_form'  => __('Before  Add To Cart Form', WCQB_TXT), 
            'after_form' => __('After Add To Cart Form', WCQB_TXT),
            'after_button'  =>  __('Next To Add To Cart Button', WCQB_TXT), 
            'before_button' =>  __('Prev To Add To Cart Button', WCQB_TXT)
        );
        
        add_filter( 'woocommerce_get_sections_products', array($this,'wc_quick_buy_add_section' ));
        add_filter( 'woocommerce_get_settings_products', array($this,'wc_quick_buy_all_settings'), 10, 2 );
    }
    
    
 	/**
 	 * Creates Woocommerce Section
 	 * @since 0.1
 	 * @param  Array $sections List Of Sections In WC Settings Page
 	 * @return Array  List Of Sections In WC Settings Page
 	 */
 	public function wc_quick_buy_add_section( $sections ) {
		$sections[WCQB_DB.'settings'] = __( 'WC Quick Buy',WCQB_TXT);
		return $sections;
	}
    
    
	/**
	 * Adds Settings Page With Settings UI
	 * @param  String $settings        Refer WC.ORG
	 * @param  String $current_section Refer WC.ORG
	 * @return String Refer WC.ORG
	 */
	public function wc_quick_buy_all_settings( $settings, $current_section ) {
		if ( $current_section == WCQB_DB.'settings') {    
            $wc_quick_buy = array();
            
            $wc_quick_buy[] = array( 'name' => __( 'WC Quick Buy Settings', WCQB_TXT ),'type' => 'title', 'desc' => __( 'The following options are used to configure WC Quick Buy Actions',WCQB_TXT ), 
            'id' => WCQB_DB.'settings_start' );
            
            $wc_quick_buy[] = array(
                'name' => __( 'Redirect Location', WCQB_TXT ),
                'desc_tip' => __( 'After Add To Cart Where To Redirect The user',WCQB_TXT ),
                'id' => WCQB_DB.'redirect',
                'type' => 'select', 
                'class' =>'chosen_select',
                'options' => $this->redirect_locations
            );
            
            $wc_quick_buy[] = array(
                'name' => __( 'Custom Redirect Location', WCQB_TXT ),
                'desc' => __( 'Enter a full url if custom selected in redirect location',WCQB_TXT ),
                'id' => WCQB_DB.'custom_redirect',
                'type' => 'text',  
                'placeholder' => get_site_url().'/custom-add-to-cart/', 
            );
            
            $wc_quick_buy[] = array(
                'name' => __( 'Show Quick Buy Button For ', WCQB_TXT ),
                'desc_tip' => __( 'For Which Products To Show Quick Buy Button [eg to show for simple products select only simple products]',WCQB_TXT ),
                'id' => WCQB_DB.'product_types',
                'type' => 'multiselect', 
                'class' =>'chosen_select',
                'options' => $this->product_types
            );	   
            
			$wc_quick_buy[] = array(
				'name' => __( 'Automatically Add Button ', WCQB_TXT ),
				'desc_tip' => __( 'Automaticaly Adds Button After Add To Cart In Single Product View', WCQB_TXT ),
				'id' => WCQB_DB.'auto',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => array('true' => __("Yes",WCQB_TXT) , 'false' => __("No",WCQB_TXT) )
			);	
			$wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Position', WCQB_TXT ),
				'desc_tip' => __( 'Where the button need to be added in single page .. before / after',WCQB_TXT ),
				'id' => WCQB_DB.'position',
				'type' => 'select', 
				'class' =>'chosen_select',
				'options' => $this->show_position
			);	            
            
            $wc_quick_buy[] = array( 'type' => 'sectionend', 'id' => WCQB_DB.'settings_end'  );
            
            
            $wc_quick_buy[] = array( 'name' => __( 'Quick Buy Button Settings', WCQB_TXT ),'type' => 'title', 'desc' => __( 'The following options are used to configure WC Quick Buy Button',WCQB_TXT ), 
            'id' => WCQB_DB.'settings_button_start' );
            
            
            $wc_quick_buy[] = array(
                'name' => __( 'Quick Buy Button Text',WCQB_TXT ),
                'desc_tip' => __( 'You Can Change The Quick Buy Button Lable',WCQB_TXT ),
                'id' => WCQB_DB.'lable',
                'type' => 'text', 
            );
            
			$wc_quick_buy[] = array(
				'name' => __( 'Quick Buy Button Class',WCQB_TXT ),
				'desc_tip' => __( 'You can add your own custom class for easy styling', WCQB_TXT ),
				'id' => WCQB_DB.'class',
				'type' => 'text', 
			);
            
            $wc_quick_buy[] = array(
                'name' => __( 'Quick Buy Button Style', WCQB_TXT),
                'desc_tip' => __( 'Directly Add Button CSS', WCQB_TXT),
                'id' => WCQB_DB.'btn_css',
                'type' => 'textarea',
                'class'=>'',
                'css'=>'height:100px; width:400px;'
            ); 
            
            $wc_quick_buy[] = array( 'type' => 'sectionend', 'id' => WCQB_DB.'settings_button_end'  );
            return $wc_quick_buy;
        } else {
            return $settings;
        }
    }
        
}

return new WooCommerce_Quick_Buy_Admin_Settings();

?>