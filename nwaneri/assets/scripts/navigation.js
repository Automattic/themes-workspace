var navToggleButton = document.querySelector('#nwaneri-toggle-navigation');
var navContainer = document.querySelector('#nwaneri-nav-container');

function toggleNavMenu(){
	var isOpen = navToggleButton.dataset.open;
	if ( isOpen === 'true' ){
		navToggleButton.dataset.open = 'false';
		navContainer.classList.remove('open');
		navToggleButton.innerHTML = 'Menu';
	} else {
		navToggleButton.dataset.open = 'true';
		navContainer.classList.add('open');
		navToggleButton.innerHTML = 'Close';
	}
}

function closeNavMenu(){
	var isOpen = navToggleButton.dataset.open;
	if ( isOpen === 'true' ){
		navToggleButton.dataset.open = 'false';
		navContainer.classList.remove('open');
		navToggleButton.innerHTML = 'Menu';
	} 
}

navToggleButton.addEventListener('click', toggleNavMenu);
document.querySelector('main').addEventListener('click', closeNavMenu);
document.addEventListener('keydown', function(e) {
	if ( e.key === "Escape" ){ 
		closeNavMenu();
	};
});
