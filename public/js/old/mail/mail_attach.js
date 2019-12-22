$(function(){
	$('.rdoAttach0').css('cursor', 'pointer').click(function() {
		$('input#rdoAttach0').attr('checked','checked');
		$('input#rdoAttach1').removeAttr('checked','checked');
		$('input#rdoAttach2').removeAttr('checked','checked');
	});

	$('.rdoAttach1').css('cursor', 'pointer').click(function() {
		$('input#rdoAttach1').attr('checked','checked');
		$('input#rdoAttach0').removeAttr('checked','checked');
		$('input#rdoAttach2').removeAttr('checked','checked');
	});

	$('.rdoAttach2').css('cursor', 'pointer').click(function() {
		$('input#rdoAttach2').attr('checked','checked');
		$('input#rdoAttach1').removeAttr('checked','checked');
		$('input#rdoAttach0').removeAttr('checked','checked');
	});
	
	if ($('#lblErrorMessage').size() > 0 && $('#lblErrorMessage').html() !== '') {
		alert($('#lblErrorMessage').html().replace('<br>', '').replace(/└(.*)/, ''));
    }
});

