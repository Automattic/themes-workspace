/**
 * File main-navigation.js.
 *
 * Required to open and close the mobile navigation.
 */

( function() {
//	document.getElementById( "toggle-menu" ).onclick = function() {
//		document.body.classList.toggle( "main-navigation-open" );
//	}

	/**
	 * Shows an element by removing a className.
	 *
	 * @param {Element} element
	 */
	function showButton(element) {
		// classList.remove is not supported in IE11
		element.className = element.className.replace('is-hidden', '');
	}

	/**
	 * Hides an element by adding className.
	 *
	 * @param {Element} element
	 */
	function hideButton(element) {
		// classList.add is not supported in IE11
		if (!element.classList.contains('is-hidden')) {
			element.className += ' is-hidden';
		}
	}

	/**
	 * Shows an element by adding a hidden className.
	 *
	 * @param {Element} element
	 */
	function menuToggleUI( toggleButtonID, navOpenClass = 'main-navigation-open' ) {

		var wrapper      = document.body;
		var toggleButton = document.getElementById( toggleButtonID );
		var navOpenClass;

		//console.log(toggleButton, wrapper)

		// On Toggle Click
		toggleButton.onclick = function() {
			// Is menu open already?
			if ( wrapper.classList.contains(navOpenClass)) {
				wrapper.className = wrapper.className.replace(navOpenClass, '');
			} else {
				wrapper.classList.toggle(navOpenClass);
			}
		}
		// classList.remove is not supported in IE11
		// element.className = element.className.replace('is-empty', '');
	}

	/**
	 * Run our menuToggleUI function on load
	 */
	window.addEventListener( 'load', function() {
		menuToggleUI( 'toggle-menu', 'main-navigation-open' );
		menuToggleUI( 'toggle-cart', 'wc-navigation-open' );
	});

} )();