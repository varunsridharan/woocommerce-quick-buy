<?php

namespace WC_Quick_Buy\Admin\Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Trait Button_Styling
 *
 * @package WC_Quick_Buy\Admin\Settings
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
trait Button_Styling {
	/**
	 * Generates Button Styleing Field.
	 *
	 * @param \WPO\Container $builder
	 */
	public function button_styling( $builder ) {
		$this->basic_button( $builder );
		$this->presets( $builder );
	}

	/**
	 * Generates Basic Button Options.
	 *
	 * @param \WPO\Container $builder
	 */
	private function basic_button( $builder ) {
		$builder->text( 'button_label', __( 'Button Label', 'wc-quick-buy' ) )
			->field_default( __( 'Quick Buy', 'wc-quick-buy' ) )
			->attribute( 'id', 'wcqb_button_label' )
			->placeholder( __( 'Quick Buy', 'wc-quick-buy' ) );
	}


	/**
	 * Generate Button Preset Options.
	 *
	 * @param \WPO\Container $builder
	 *
	 * @uses \WC_Quick_Buy\Helper::button_presets()
	 */
	private function presets( $builder ) {
		$builder->select( 'button_style_styles', __( 'Button Style', 'wc-quick-buy' ) )
			->wrap_id( 'wcqb_button_styles' )
			->after( '<div class="wcqb-preset-demo"><button id="wcqbdemostyles" type="button">' . __( 'Quick Buy', 'wc-quick-buy' ) . '</button></div>' )
			->options( array( '\WC_Quick_Buy\Helper', 'button_presets' ) )
			->style( 'width:300px' )
			->select_framework( 'select2' )
			->desc_field( __( '**Note** : <span class="wpo-text-danger">The Actual Button Style May Vary Due To Themes Style\'s Interference</span>', 'wc-quick-buy' ) );

		$builder->text( 'css_class', __( 'Button CSS Class', 'wc-quick-buy' ) )
			->style( 'width:300px' )
			->desc_field( 'You can add your own custom class for easy styling. enter multiple class with space separated `class1 class2`' );

		$builder->code_editor( 'custom_css', __( 'Custom CSS', 'wc-quick-buy' ), array(
			'settings' => array(
				'theme' => 'mbo',
				'mode'  => 'css',
			),
			'default'  => '
.quick_buy_a_tag{}

.quick_buy_button_tag{}

.quick_buy_button{}
',
		) )->desc_field( array(
				__( 'You Can Customize Quick Buy Button By Adding Your Custom CSS Styles. Please Refer Below On CSS Class Used In Quick Buy Button.!', 'wc-quick-buy' ),
				__( '**1. `quick_buy_a_tag` :** This class used in button when the button renders as HTML Link {a} Tag', 'wc-quick-buy' ),
				__( '**2. `quick_buy_button_tag` :** This class used in button when the button renders as HTML button Tag', 'wc-quick-buy' ),
				__( '**3. `wcqb_button` :** This class used in all types of button. its general any style applied to this will be applied to all buttons.', 'wc-quick-buy' ),
				__( '**4. `quick_buy_producttype` :** This class is dynamic and each product type gets it own css class. eg : `quick_buy_producttype` replaces with simple if current product type is `quick_buy_simple` ', 'wc-quick-buy' ),
				__( '**5. `quick_buy_productid` :** This class is dynamic and each product gets it own css class. eg : `quick_buy_productid` replaces with simple if current product type is `quick_buy_31` ', 'wc-quick-buy' ),
			) );
	}
}
