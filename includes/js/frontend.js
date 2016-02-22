jQuery(document).ready(function(){

    jQuery('.wcqb_button').click(function(){
        var product_id = jQuery(this).attr('data-product-id');
        var product_type = jQuery(this).attr('data-product-type');
        
        var selected = jQuery('form.cart input#wc_quick_buy_hook_'+product_id);
        var productform = selected.parent();
        productform.append('<input type="hidden" value="true" name="quick_buy" />');
        productform.find('[type="submit"]').click();
    });
    
});