<br/>

<table id="wcqb_shortcodegen" class="widefat striped">
    <thead>
    <tr>
        <th colspan="2">
            <h4 class="wc_qb_table_head"><?php _e( "WC Quick Buy Shortcode Generator" ); ?></h4></th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <th>
			<?php _e( "Shortcode Type : ", WCQB_TXT ); ?>
        </th>
        <td>
            <select id="shortcode_type" name="shortcode_type" style="width: 50%;" class="wc-enhanced-select">
                <option value='wc_quick_buy'>
					<?php _e( 'wc_quick_buy - Used in Product Loop' ); ?>
                </option>
                <option value='wc_quick_buy_link'>
					<?php _e( 'wc_quick_buy_link - Can be used anywhere' ); ?>
                </option>
            </select>
        </td>
    </tr>
    <tr>
        <th>
			<?php _e( "Product : ", WCQB_TXT ); ?>
        </th>
        <td>
            <select name="selected_product" class="wc-product-search"
                    data-placeholder="<?php _e( " Search For Product ", WCQB_TXT ); ?>"
                    data-action="woocommerce_json_search_products" data-multiple="true" data-selected=""
                    style="width: 50%;" id="product_id"></select>
        </td>
    </tr>
    <tr>
        <th>
			<?php _e( "Button Label : ", WCQB_TXT ); ?>
        </th>
        <td>
            <input type="text" style="width: 50%;" id="button_label" name="button_label"
                   value="<?php _e( " Quick Buy ", WCQB_TXT ); ?>"/>
        </td>
    </tr>
    <tr class="show_if_wc_quick_buy_link">
        <th>
			<?php _e( "Product Qty: ", WCQB_TXT ); ?>
        </th>
        <td>
            <input id="product_qty" type="number" min='1' max="99" step="1" style="width: 20%;" name="product_qty"
                   value="1"/>
        </td>
    </tr>

    <tr class="show_if_wc_quick_buy_link">
        <th>
			<?php _e( "Custom CSS Class: ", WCQB_TXT ); ?>
        </th>
        <td>
            <input id="product_class" type="text" style="width: 20%;" name="product_class" value=""/>
        </td>
    </tr>


    <tr class="show_if_wc_quick_buy_link">
        <th>
			<?php _e( "Render Type : ", WCQB_TXT ); ?>
        </th>
        <td>
            <select name="render_type" id="render_type" style="width: 50%;" class="wc-enhanced-select">
                <option value='button'>
					<?php _e( 'HTML Link Tag (<\a>)' ); ?>
                </option>
                <option value='link'>
					<?php _e( 'Plain Web Link' ); ?>
                </option>
            </select>
        </td>
    </tr>

    <tr>
        <th></th>
        <td>
            <button type="button" id="gen_shortcode" class="button button-primary">
				<?php _e( "Generate Shortcode :-)", WCQB_TXT ); ?>
            </button>
        </td>
    </tr>
    <tr>
        <th></th>
        <td colspan="">
            <textarea name="result"
                      id="wcshortcoderesult"> <?php _e( "Generated Shortcode will be updated here", WCQB_TXT ); ?> </textarea>
        </td>
    </tr>
    </tbody>

    <tfoot>
    <tr>
        <th colspan="2">
            <h4 class="wc_qb_table_head"><?php _e( "WC Quick Buy Shortcode Generator" ); ?></h4></th>
    </tr>
    </tfoot>
</table>

<style>
    #wcqb_shortcodegen {
        width : 70%;
    }

    #wcqb_shortcodegen th {
        font-weight : bold;
    }

    .wc_qb_table_head {
        margin     : 5px 0;
        text-align : center;
        display    : block;
        font-size  : 17px;
    }

    #wcshortcoderesult {
        height     : 65px;
        margin     : 0 auto;
        padding    : 10px;
        text-align : center;
        width      : 50%;
    }
</style>

<script>
    jQuery(document).ready(function () {
        jQuery('.show_if_wc_quick_buy_link').hide();
        jQuery('#shortcode_type').change(function () {
            if ( jQuery(this).val() == 'wc_quick_buy' ) {
                jQuery('.show_if_wc_quick_buy_link').fadeOut();
            } else {
                jQuery('.show_if_wc_quick_buy_link').fadeIn();
            }

        });

        jQuery('#gen_shortcode').click(function () {
            var type_shortcode = jQuery('#shortcode_type').val();
            var gen_code = '';
            if ( type_shortcode == 'wc_quick_buy' ) {
                var button_label = jQuery('#button_label').val();
                var product_id = jQuery('#product_id').val();

                gen_code = '[' + type_shortcode + ' ';
                if ( button_label !== '' ) {
                    gen_code = gen_code + ' label="' + button_label + '"';
                }
                if ( product_id !== '' ) {
                    gen_code = gen_code + ' product="' + product_id + '"';
                }
                gen_code = gen_code + ']';
            }

            if ( type_shortcode == 'wc_quick_buy_link' ) {
                var button_label = jQuery('#button_label').val();
                var product_id = jQuery('#product_id').val();
                var product_qty = jQuery('#product_qty').val();
                var render_type = jQuery("#render_type").val();
                var product_class = jQuery("#product_class").val();


                gen_code = '[' + type_shortcode + ' ';

                if ( product_id !== '' ) {
                    gen_code = gen_code + ' product="' + product_id + '"';
                }
                if ( button_label !== '' ) {
                    gen_code = gen_code + ' label="' + button_label + '"';
                }
                if ( product_qty !== '' ) {
                    gen_code = gen_code + ' qty="' + product_qty + '"';
                }
                if ( render_type !== '' ) {
                    gen_code = gen_code + ' type="' + render_type + '"';
                }

                if ( product_class !== '' ) {
                    gen_code = gen_code + ' htmlclass="' + product_class + '"';
                }


                gen_code = gen_code + ']';

            }
            jQuery('#wcshortcoderesult').val(gen_code);
        });
    })
</script>