=== Woocommerce Quick Buy ===
Contributors: varunms
Author URI: http://varunsridharan.in/
Plugin URL: https://wordpress.org/plugins/woocommerce-quick-buy/
Tags: Woocommerce,wc,Quick buy,add to cart
Donate link: http://varunsridharan.in
Requires at least: 3.0
Tested up to: 4.1.1
WC requires at least: 1.0
WC tested up to: 2.3.5
Stable tag: 0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html 

Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button 

== Description ==
Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button 

When User Clicks This Button. The Current product Will Be Added To Cart And The User Will Be Redirected To Cart Page

**Settings Available Under**
`Woocommerce Settings ==> Products ==> WC Quick Buy`

**Short Code While In Product Loop**
`[wc_quick_buy]`

**Short Code With Product ID**
`[wc_quick_buy product="1"]`

**Short Code Without js embeded**
`[wc_quick_buy product="1" show_js="false"]`

**Short Code with echo **
`[wc_quick_buy product="1" echo="true"]`

**Short Code with return {To Save Value In A Variable} **
`[wc_quick_buy product="1" echo="false"]`

We would like to thank <strong> <a href="https://profiles.wordpress.org/pshekas" >Ernestas Zekas</a> </strong> for Suggesting below features

* Quick Buy For Product Variations
* Quick Buy With Product Quantity


= Plugin Contributers =
* <a href="https://profiles.wordpress.org/pshekas" >Ernestas Zekas</a>
* <a href="https://github.com/robertbobmattocks">Robert Mattocks </a>


== Upgrade Notice ==
Please update the settings once you have updated the plugin. if not this plugin many not work.


== Screenshots ==
1. WC Quick Buy Settings

== Installation ==

= Minimum Requirements =

* WordPress 3.8 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install of WooCommerce Quick Buy, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "WooCommerce Quick Buy" and click Search Plugins. Once you've found our plugin you can view details about it such as the the point release, rating and description. Most importantly of course, you can install it by simply clicking "Install Now"

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your Web Server via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

1. Installing alternatives:
 * via Admin Dashboard:
 * Go to 'Plugins > Add New', search for "WooCommerce Quick Buy", click "install"
 * OR via direct ZIP upload:
 * Upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
 * OR via FTP upload:
 * Upload `woocommerce-quick-buy` folder to the `/wp-content/plugins/` directory
 
2. Activate the plugin through the 'Plugins' menu in WordPress
3. For Settings Look at your `Woocommerce => Settings => Product => WC Quick Buy`

== Frequently Asked Questions ==
**I have an idea for your plugin!**  
That's great. We are always open to your input, and we would like to add anything we think will be useful to a lot of people. Please send your comment/idea to varunsridharan23@gmail.com

**I found a bug!**  
Oops. Please User github / WordPress to post bugs.  <a href="https://github.com/technofreaky/woocomerce-quick-buy/"> Open an Issue </a>

**How To Call This Plugin in a template ?**  
This Plugin Can Be Called Using `[wc_quick_buy]` shortcode


**Where can I request new features**
Please open an issue at <a href="https://github.com/technofreaky/woocomerce-quick-buy"> GitHub </a> and we will look into it


== Changelog ==
= 0.7 =
* Fixed Shortcode Echo Issue.
* Added a new shortcode option <code>[wc_quick_buy echo="false/true"]</code>

= 0.6 =
* Fixed activation issue.
* Added a new shortcode option <code>[wc_quick_buy show_js="false/true"]</code>
* Minor bug fixes.

= 0.5 =
* Fixed Shortcode Issue

= 0.4 =
* Quick Buy Options Is Now Available For Variant Product
* Quick Buy Now Takes Entered Qty and add it to cart.
* Option to configure to show quick buy based on product type [Simple,Variant/Variable]
* Minor Bug Fixes

= 0.3 =
* Code Bug Fix

= 0.2. =
* Option To Configure Redirect [Cart / Checkout Page]

= 0.1 =
* Base Version
