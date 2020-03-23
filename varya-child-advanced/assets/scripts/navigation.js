var navToggleButton = document.querySelector('#nwaneri-toggle-navigation');
var navContainer = document.querySelector('#nwaneri-site-navigation');

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
	}
}

navToggleButton.addEventListener('click', toggleNavMenu);
