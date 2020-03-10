var nav = document.querySelector('nav');
var modalToggleButton = document.querySelector('#montichello-toggle-nav-modal');
var modal = document.querySelector('#montichello-nav-modal');

function toggleModal(){
	var isOpen = modalToggleButton.dataset.open;
	if ( isOpen === 'true' ){
		modalToggleButton.dataset.open = 'false';
		modal.classList.remove('open');
		nav.classList.remove('open');
		modalToggleButton.innerHTML = 'Navigation';
	} else {
		modalToggleButton.dataset.open = 'true';
		modal.classList.add('open');
		nav.classList.add('open');
		modalToggleButton.innerHTML = 'Close Navigation';
	}
}

function closeModal(){
	var isOpen = modalToggleButton.dataset.open;
	if ( isOpen === 'true' ){
		modalToggleButton.dataset.open = 'false';
		modal.classList.remove('open');
		nav.classList.remove('open');
		modalToggleButton.innerHTML = 'Navigation';
	} 
}

modalToggleButton.addEventListener('click', toggleModal);
document.addEventListener('keydown', function(e) {
	if ( e.key === "Escape" ){ 
		closeModal();
	};
});
