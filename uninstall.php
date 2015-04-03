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
 
    * Fired when the plugin is uninstalled.
    * @package  Woocommerce Quick Buy
    * @author Varun Sridharan <varunsridharan23@gmail.com>
    * @license GPL-2.0+
    * @link https://wordpress.org/plugins/woocommerce-quick-buy/
    * @copyright 2015 Varun Sridharan [TechNoFreaky]
*/

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
exit;
} 
$options = array('wc_quick_buy_auto','wc_quick_buy_position','wc_quick_buy_lable','wc_quick_buy_class','wc_quick_buy_redirect','wc_quick_buy_product_types','wc_quick_buy_simple_product_form_class','wc_quick_buy_variable_product_form_class','wc_quick_buy_btn_css');
foreach($options as $option_name){
	delete_option( $option_name );
	delete_site_option( $option_name );  
}
?>


