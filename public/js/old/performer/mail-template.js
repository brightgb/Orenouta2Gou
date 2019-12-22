$(function(){
	check_input_length([["mail-text-counter", "mail-text"], ["mail-title-counter", "mail-title"]]);

	$('.modal-open-template').on('click', function(){openModal('modal-template')});
	$('.modal-open-copy-template').on('click', function(){openModal('modal-copy-template')});
	$('.modal-open-auto-complete').on('click', function(){openModal('modal-auto-complete')});
});