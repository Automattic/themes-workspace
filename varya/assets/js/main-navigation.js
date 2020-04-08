/**
 * File main-navigation.js.
 *
 * Required to open and close the mobile navigation.
 */

( function() { 
	document.getElementById( "toggle-menu" ).onclick = function() {
		document.body.classList.toggle( "main-navigation-open" );
	}
} )();