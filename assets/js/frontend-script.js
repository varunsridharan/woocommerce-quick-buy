( ( window, document, $ ) => {
	const $wcqb = {
		unblock_button: ( $product_id ) => {
			let $button = $( document ).find( '#quick_buy_' + $product_id + '_button' );
			if( $button.length > 0 ) {
				$button.removeAttr( 'disabled' );
				$button.parent().show();
			}
		},
	};
	$( () => {
		const $document  = $( document );
		let $submit_name = false;

		$document.on( 'click', '.wcqb_button', function() {
			let product_id  = $( this ).attr( 'data-product-id' ),
				selected    = $( 'form.cart input#wc_quick_buy_hook_' + product_id ),
				productform = selected.parent(),
				submit_btn  = productform.find( '[type="submit"]' );
			productform.find( 'input[name=quick_buy]' ).remove();
			productform.append( '<input type="hidden" value="true" name="quick_buy" />' );

			if( false === $submit_name ) {
				$submit_name = submit_btn.attr( 'name' );
			}

			if( submit_btn.is( ':disabled' ) ) {
				$( 'html, body' ).animate( { scrollTop: submit_btn.offset().top - 200 }, 900 );
			} else {
				submit_btn.attr( 'name', 'wcqb-' + $submit_name );
				submit_btn.click();
			}
		} );

		$document.on( 'change', 'form.cart', function() {
			let $button = $( '.wcqb_button' );
			if( $( this ).find( '[type="submit"]' ).is( ':disabled' ) ) {
				$button.attr( 'disabled', 'disable' );
			} else if( !$button.hasClass( 'wcqb-product-in-cart' ) ) {
				$button.removeAttr( 'disabled' );
			}
		} );

		$document.on( 'click', '.quick_buy_a_tag[disabled="disabled"]', ( e ) => e.preventDefault() );

		$document.on( 'removed_from_cart', ( $e, $r, $h, $btn ) => $wcqb.unblock_button( $btn.attr( 'data-product_id' ) ) );
	} );
} )( window, document, jQuery );
