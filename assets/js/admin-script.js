( ( window, $ ) => {

	$( window ).on( 'load', () => {

		let $wcqb                       = {
				styles_wrap: $( 'div#wcqb_button_styles.wponion-element' ),
			},
			$body                       = $( 'body' );
		$wcqb.update_button_style       = () => {
			let $demo_button = $wcqb.styles_wrap.find( 'button#wcqbdemostyles' ),
				$checked     = $( 'div#wcqb_button_styles.wponion-element select' ).val();
			$demo_button.removeAttr( 'class' ).attr( 'class', 'wcqb-preset ' + $checked );
			return $wcqb;
		};
		$wcqb.update_button_label       = () => {
			$wcqb.styles_wrap.find( 'button#wcqbdemostyles' ).html( $( 'input#wcqb_button_label' ).val() );
			return $wcqb;
		};
		$wcqb.update_url_endpoint_value = () => {
			let $value = $( 'div#url_type select' ).find( 'option:checked' ).attr( 'data-url' );
			$( 'div#url_endpoint div.input-group-prepend .input-group-text' ).html( $value );
			return $wcqb;
		};

		$body.on( 'change', 'div#wcqb_button_styles.wponion-element select', () => $wcqb.update_button_style() );
		$body.on( 'keyup', 'input#wcqb_button_label', () => $wcqb.update_button_label() );
		$body.on( 'change', 'div#url_type select', () => $wcqb.update_url_endpoint_value() );
		$wcqb.update_button_style().update_button_label().update_url_endpoint_value();
	} );
} )( window, jQuery );
