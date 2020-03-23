var wcNavToggleButton = document.querySelector('#nwaneri-toggle-minicart');
var wcNavContainer = document.querySelector('#nwaneri-minicart');

function wcToggleNavMenu(){
	var isOpen = wcNavToggleButton.dataset.open;
	if ( isOpen === 'true' ){
		wcNavToggleButton.dataset.open = 'false';
		wcNavContainer.classList.remove('open');
	//	wcNavToggleButton.innerHTML = 'Cart';
	} else {
		wcNavToggleButton.dataset.open = 'true';
		wcNavContainer.classList.add('open');
	//	wcNavToggleButton.innerHTML = 'Close';
	}
}

function closeNavMenu(){
	var isOpen = wcNavToggleButton.dataset.open;
	if ( isOpen === 'true' ){
		wcNavToggleButton.dataset.open = 'false';
		wcNavContainer.classList.remove('open');
	}
}

wcNavToggleButton.addEventListener('click', wcToggleNavMenu);
