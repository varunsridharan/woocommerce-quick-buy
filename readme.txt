=== Quick Buy For Woocommerce ===
Contributors: varunms,vaahosttech
Author URI: http://varunsridharan.in/
Plugin URL: https://wordpress.org/plugins/woocommerce-quick-buy/
Tags: Woocommerce,wc,Quick buy,add to cart,affiliate, cart, checkout, commerce, configurable, digital, download, downloadable, e-commerce, ecommerce, inventory, reports, sales, sell, shipping, shop, shopping, stock, store, tax, variable, widgets, woothemes, wordpress ecommerce
Donate link: http://paypal.me/varunsridharan23
Requires at least: 3.0
Tested up to: 5.5
Stable tag: 2.8.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button 

== Description ==
Add Quick buy button to redirect user to checkout / cart immediately when he click quick buy button.
When User Clicks This Button. The Current product Will Be Added To Cart And The User Will Be Redirected To Cart Page

[youtube https://www.youtube.com/watch?v=z_RgdNVZvj4]

**Supported & Tested Product Types**
> 1. <a href="http://woocommerce.com/">WC Simple Product</a>
> 2. <a href="http://woocommerce.com/">WC Grouped Product</a>
> 3. <a href="http://woocommerce.com/">WC Variable / Variation Product</a>
> 4. <a href="https://woocommerce.com/products/product-add-ons/">WooCommerce Product Add-Ons</a>
> 5. <a href="https://woocommerce.com/products/product-bundles/">WooCommerce Product Bundles</a>
> 6. <a href="https://woocommerce.com/products/woocommerce-subscriptions/">Woocommerce Variable / Simple Subscriptions</a>
> 7. <a href="https://wordpress.org/plugins/yith-woocommerce-product-bundles/">YITH Product Bundles</a>
> 8. <a href="https://wordpress.org/plugins/yith-woocommerce-product-add-ons/">YITH WooCommerce Product Add-Ons</a>
> 9. <a href="https://wordpress.org/plugins/yith-woocommerce-subscription/">YITH WooCommerce Subscription</a>
> 10. <a href="https://wordpress.org/plugins/added-to-cart-popup-woocommerce/">WooCommerce added to cart popup (Ajax)</a>


**Settings Available Under**
> Woocommerce Settings ==> Products ==> WC Quick Buy

<h3>Shortcodes</h3>

**`[wc_quick_buy]`**
This can be used anywhere inside the website

> 1. product : product id to generate quick buy button Eg : [wc_quick_buy product="22"]
> 2. label : custom text for generated button Eg : [wc_quick_buy label="Hurry Up!!"]
> 3. hide_in_cart : Enter "yes"  to hide the button if the same product already in cart or enter "no"
> 4. css_class : You can give your custom css class name in shortcode to add it in button.
> 5. qty : Enter custom qty for a html button / link [wc_quick_buy qty="10"]

**`[wc_quick_buy_link]`**
This can be used to generate sharable link
> 1. product : product id to generate quick buy button Eg : [wc_quick_buy_link product="22"]
> 2. qty : Enter custom qty for a html button / link [wc_quick_buy_link qty="10"]

**Example Shortcode To Get Clickable Button**
> [wc_quick_buy product="33"  label="Hurry UP!!" qty="100"]

**Example Shortcode To Get Product's Quick Buy URL**
> [wc_quick_buy_link product="33"  qty="100"]

== Upgrade Notice ==
Dear Users,

I recently published WC Quick Buy V2.0 which is a brand new version developed from the base which also includes Robust WPOnion & VSP Framework to make this plugin run smoothly and add more features on the go.

But due to recent changes to the core. I was unable to migrate settings from the older version into the new version. I apologize for this.

but I made sure that new settings are easy to configure. if you do have any issues please do contact me via this forum or email me directly. I will try my best to get back to you asap.

== Screenshots ==
1. WC Quick Buy Settings
2. WC Quick Buy Settings
3. WC Quick Buy Settings
4. WC Quick Buy Settings
5. WC Quick Buy Settings

== Installation ==

= Minimum Requirements =

* WordPress version 3.8 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater
* WooCommerce version 1.0 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install of Quick Buy For Woocommerce, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "Quick Buy For Woocommerce" and click Search Plugins. Once you've found our plugin you can view details about it such as the the point release, rating and description. Most importantly of course, you can install it by simply clicking "Install Now"

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your Web Server via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

1. Installing alternatives:
 * via Admin Dashboard:
 * Go to 'Plugins > Add New', search for "Quick Buy For Woocommerce", click "install"
 * OR via direct ZIP upload:
 * Upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
 * OR via FTP upload:
 * Upload `woocommerce-quick-buy` folder to the `/wp-content/plugins/` directory
 
2. Activate the plugin through the 'Plugins' menu in WordPress
3. For Settings Look at your `Woocommerce => Settings => Product => WC Quick Buy`

== Frequently Asked Questions ==

**How I Can Get Support For This Plugin**

* https://wordpress.org/support/plugin/woocommerce-quick-buy 
* https://github.com/varunsridharan/woocommerce-quick-buy
* Email : varunsridharan23@gmail.com 

**I have an idea for your plugin!**  
That's great. We are always open to your input, and we would like to add anything we think will be useful to a lot of people. Please send your comment/idea to varunsridharan23@gmail.com

**I found a bug!**  
Oops. Please User github / WordPress to post bugs.  <a href="https://github.com/varunsridharan/woocommerce-quick-buy"> Open an Issue </a>

**How To Call This Plugin in a template File ?**  
This Plugin Can Be Called Using `<?php do_shortcode('[wc_quick_buy]') ?>` short code

**Where Are The Plugin Settings Available ?**
`Woo Commerce Settings ==> WC Quick Buy`

**Where can I request new features**
Please open an issue at <a href="https://github.com/varunsridharan/woocommerce-quick-buy"> GitHub </a> and we will look into it


== Changelog ==

= 2.8.1 01/09/2020 =
* Fixed : Fatal Error When Using Along side with Elementor.
* Tested : WordPress 5.5
* Tested : WooCommerce 4.4.1

= 2.8 - 27/08/2020 =
* Fixed : Long Standing 404 Error !!! 
* Added : Support For Slug Value In Quick Buy URL.
* Tested : WordPress 5.5
* Tested : WooCommerce 4.4.1

= 2.7.5 - 22/08/2020 =
* Fixed : Add To Cart Permalink Issue
* Tested : WordPress 5.5
* Tested : WooCommerce 4.4.1

= 2.7.4 - 03/08/2020 =
* Fixed : Fatal Error When Editing Product Page
* Fixed : AddToCart Button Redirects To Quick Buy Page.
* Updated : WPOnion Framework To 1.5.3.2
* Updated : VSP Framework To 0.8.9.3
* Tested : WordPress 5.4.2
* Tested : WooCommerce 4.3.1

= 2.7.3 - 14/06/2020 =
* Fixed : Fatal Error When Using Along Side Elementor Plugin
* Updated : WPOnion Framework To 1.5.2

= 2.7.2 - 12/06/2020 =
* Improved performance
* Added : Hook to disable quick buy render for each product
* Added : option to set no redirect
* Updated : WPOnion Framework To 1.5.1
* Updated : VSP Framework To 1.8.9.1

= 2.7.1 - 23/04/2020 =
* Updated : WPOnion Framework To 1.4.5.3
* Updated : VSP Framework To 0.8.5

= 2.7 - 16/04/2020 =
* Fixed : Improved Autoload Speed
* Updated : WPOnion Framework To 1.4.5.2
* Updated : VSP Framework To 0.8.4

= 2.6 - 09/04/2020 =
* Fixed : https://wordpress.org/support/topic/button-deletes-cart-items-regardless-option-turned-off/
* Updated : WPOnion Framework To 1.4.5.1
* Updated : VSP Framework To 0.8.2

= 2.5 - 04/04/2020 = 
* Fixed : Integration Issue with WooCommerce added to cart popup (Ajax)
* Fixed : https://wordpress.org/support/topic/quickbuy-button-shortcode/
* Tested : With Latest WooCommerce - 4.0.1
* Tested : With Latest WordPress - 5.4
* Updated : WPOnion Framework To 1.4.5
* Updated : VSP Framework To 0.8.0

= 2.4 - 30/01/2020 = 
* Fixed : Shortcode Issue - https://wordpress.org/support/topic/fatal-error-uncaught-error-call-to-a-member-function-is_in_stock-on-string/
* Fixed : Button Render issue - https://github.com/varunsridharan/woocommerce-quick-buy/issues/27
* Tested : With Latest WooCommerce - 3.9.1
* Tested : With Latest WordPress - 5.3.2

= 2.3 - 05/12/2019 =
* Updated : WPOnion Framework To 1.4.0
* Updated : VSP Framework To 0.7.9
* Fixed : Minor bugs
* Tested : With Latest WooCommerce
* Tested : With Latest WordPress

= 2.2 - 26/09/2019 = 
* Updated WPOnion Framework To 1.3.7
* Fixed : Settings Page Saving Issue
* Fixed Minor bugs.
* Tested : With Latest WordPress 5.2.3
* Tested : With Latest WooCommerce 3.6.5

= 2.1 - 18/09/2019 = 
* Updated VSP Framework To ( 0.7.7 ) which fixes major vulnerability

= 2.0 - 17/09/2019 =
* Plugin Fully Redeveloped
* Added Seo Friendly URL 
* Added Predefined Button Styles
* Added WPOnion Framework ( V 1.3.6 ) 
* Added VSP-Framework ( 0.7.6 )

= 1.9 - 27/03/2018 =
* Added : Option to hide if product already in cart
* Tweaks : Minor Code Change and codecleanup done.
* Tested : With latest WC 3.0
* Tested : With latest WP

= 1.8 - 29/09/2017 =
* Fixed : Add To Cart Issue with latest WooCommerce
* Fixed : Style Loading with ajax.php
* Tested : With Both Latest WP & WC

= 1.7 - 11/07/2017 =
* Fixed : Issue Reported @ https://wordpress.org/support/topic/getting-error-string6-course-above-the-quick-buy-button/

= 1.6 - 11/07/2017 =
* Added Support To : <a href="https://woocommerce.com/products/product-add-ons/">WooCommerce Product Add-Ons</a>
* Added Support To : <a href="https://woocommerce.com/products/product-bundles/">WooCommerce Product Bundles</a>
* Added Support To : <a href="https://woocommerce.com/products/woocommerce-subscriptions/">Woocommerce Variable / Simple Subscriptions</a>
* Added Support To : <a href="https://wordpress.org/plugins/yith-woocommerce-product-add-ons/">YITH WooCommerce Product Add-Ons</a>
* Added Support To : <a href="https://wordpress.org/plugins/yith-woocommerce-subscription/">YITH WooCommerce Subscription</a>
* Fixed Minor Issues
* Updated language File

= 1.5 - 26/04/2017 =
* Fixed : Minor issue in shortcode generator

= 1.4 - 13/04/2017 =
* Fixed : Tested & Fixed Bugs with WC 3.0

= 1.3 - 10/03/2017 =
* Added : Integrated With WPML.
* Minor Bug Fixed.

= 1.2 - 03/09/2016 =
* Fixed Minor Issues.
* Added Option to support YITH Product Bundles.

= 1.1  - 28/06/2016 =
* Fixed Shortcode Generator Issue
* Fixed Settings Page Errors
* Fixed Custom Redirect URL

= 1.0  - 15/06/2016 = 
* Total Plugin Redeveloped
* 3 New feature Added
* Shortcode Generated Added In settings
* Minor Updates Done. 
* Tested With latest WC & WP

= 0.17 - 04/11/2015 = 
* Fixed variation product add to cart error 

= 0.16 - 08/10/2015 = 
* Fixed the reported issue  [https://wordpress.org/support/topic/hide-quick-buy-button?replies=5]

= 0.15 - 06/10/2015 = 
* quick buy button was hidden even if stock exist. fixed
* Minor Bug Fix.

= 0.14 - 06/10/2015 = 
* hide quick buy button when no stock
* Update To latest WooCommerce [WC 2.4.7] And Latest WordPress [WP 4.3.1]
* Minor Bug Fix.

= 0.13 - 11/09/2015 = 
* Added Option To Change Button Label Via Short Code <code>[wc_quick_buy name="Instant Buy"]</code>
* Changed <code>add_to_cart_redirect</code> to <code>woocommerce_add_to_cart_redirect</code> filter
* Update To latest WooCommerce [WC 2.4.6] And Latest WordPress [WP 4.3]
* Minor Bug Fix.

= 0.12.1 - 29/06/2015 =
* Notice in single product page [https://wordpress.org/support/topic/undefined-index-show_js?replies=1]

= 0.12 - 29/06/2015 =
* Fixed Javascript Issue With Variable Product Quick Buy  [Conflict With Some Theme / Other Plugin]
* Update To latest WooCommerce [WC 2.3.11] And Latest WordPress [WP 4.2.2]
* Minor Bug Fix.
* Added Support For i18n <code>Text Domain: woocommerce-quick-buy</code>

= 0.11 - 03/04/2015 =
* Adds Product ID As a html attribute in Quick Buy Button : <code>data-productid</code>
* Adds Dynimic Class Based On Product ID in Quick Buy Button : <code>wc_quick_buy_product_{product_id}</code> & <code> quick_buy_{product_id}</code> 
* Adds Product Id in Form Attribute : <code>data-productid</code> 
* Minor Bug Fix
* Added Paypal Donation Link
* Added Github Link
* Added Report Issue Link
* Added Settings Link

= 0.10 - 01/04/2015 =
* Fixed Quick Buy Button Css Loop [Now Adds At WP FOOTER]
* Minor Bug Fix

= 0.9 - 01/04/2015 =
* Fixed Form Class Issue.
* Added Default Form Class <code>wc_quick_buy_form </code> And <code> wc_quick_buy_form_{product_id}</code>
* Added Option Add CSS Directly
* Minor Bug Fix
* Made Compatible With latest WordPress and Woo Commerce Version

= 0.8 - 23/02/2015  =
* Fixed Short code Display Issue

= 0.7 - 22/02/2015  =
* Fixed Short code Echo Issue.
* Added a new short code option <code>[wc_quick_buy echo="false/true"]</code>

= 0.6 - 22/02/2015 =
* Fixed activation issue.
* Added a new short code option <code>[wc_quick_buy show_js="false/true"]</code>
* Minor bug fixes.

= 0.5 - 16/02/2015 =
* Fixed Short code Issue

= 0.4 - 11/02/2015 =
* Quick Buy Options Is Now Available For Variant Product
* Quick Buy Now Takes Entered Qty and add it to cart.
* Option to configure to show quick buy based on product type [Simple,Variant/Variable]
* Minor Bug Fixes

= 0.3 - 04/02/2015 =
* Code Bug Fix

= 0.2 - 07/12/2014 =
* Option To Configure Redirect [Cart / Checkout Page]

= 0.1 - 04/12/2014 =
* Base Version
