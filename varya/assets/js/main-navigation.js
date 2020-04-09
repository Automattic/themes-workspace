/**
 * File main-navigation.js.
 *
 * Required to open and close the mobile navigation.
 */

( function() {
	/**
	 * Menu Toggle Behaviors
	 *
	 * @param {Element} element
	 */
	function menuToggleUI( toggleButtonID, navOpenClass = 'main-navigation-open' ) {

		var wrapper         = document.body;
		var toggleButton    = document.getElementById( toggleButtonID );
		var lockScrollClass = 'lock-scrolling';
		var navOpenClass;

		// On Toggle Click
		toggleButton.onclick = function() {
			wrapper.classList.toggle(navOpenClass);
			wrapper.classList.toggle(lockScrollClass);
		}
	}
} )();