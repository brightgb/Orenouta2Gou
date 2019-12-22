
$(function(){
	$("#tv").on('click', function(){
		$("#tv-option").show();
		$("#voice-option").hide();
		$("#detail-text").show();
	});
	$("#voice").on('click', function(){
		$("#tv-option").hide();
		$("#voice-option").show();
		$("#detail-text").show();
	});

	$("form").on('submit', function(){
		var errors = [];

		if(!$("input[name='name']").val()) errors.push('error-name');
		if(!$("input[name='tushin']:checked").val()) errors.push('error-tushin');
		if(!$("input[name='mvno']:checked").val()) errors.push('error-mvno');
		if(!$("input[name='denpa']:checked").val()) errors.push('error-denpa');
		if(!$("input[name='tuuwa']:checked").val()) errors.push('error-tuuwa');
		if(!$("input[name='trouble']:checked").val()) errors.push('error-trouble');
		if(!$("textarea[name='detail']").val() && $("input[name='trouble']:checked").val() == "その他") errors.push('error-detail');

		if(errors.length > 0){
			$('.modal-error p').each(function(){
				if (errors.indexOf($(this).attr('class')) != -1){
					$(this).show();
				} else {
					$(this).hide();
				}
			});

			openModal('modal-error');
			return false;
		}
	});
});
