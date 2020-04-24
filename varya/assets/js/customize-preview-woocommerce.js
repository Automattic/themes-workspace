/**
 * woocommerce-customizer.js.
 *
 * Required to prevent duplicate mini-cart instances when updating the menu in the customizer.
 */

jQuery( function( $ ) {

	// Remove mini-cart
	function resetWooMiniCart( container ) {
		var wooMenuContainer = container.siblings( ".woocommerce-menu-container[title|='Shift']" );
		var wooMenuButton    = container.siblings( "#toggle-cart[title|='Shift']" );

		wooMenuContainer.remove();
		wooMenuButton.remove();
	}

	$( document ).on( 'customize-preview-menu-refreshed', function( e, params ) {
		if ( 'primary' === params.wpNavMenuArgs.theme_location ) {
			resetWooMiniCart( params.newContainer );
		}
	});
});
