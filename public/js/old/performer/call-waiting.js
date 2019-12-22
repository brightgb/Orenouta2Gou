$(function() {
	check_input_length(["waiting-comment-counter", "waiting-comment"]);

	if (Cookies.get('app_apollo1.3_invisible') != '1') openModalFadeIn('modal-app-popup', 500);
	$('input#invisible').change(function(){
		if ($(this).prop('checked')){
			Cookies.set('app_apollo1.3_invisible', '1', {expires : 730});
		} else {
			Cookies.remove('app_apollo1.3_invisible');
		}
	});
});