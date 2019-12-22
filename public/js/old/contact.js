$(function(){
	$('button#confirm').click(function(){
		var body = $('textarea#body').val();
		if (body == ""){
			openModal('modal-error');
		} else {
			$('.con_main').html(htmlEscape(body));
			openModal('modal-confirm');
		}
	})

	$('button#modify').on('click', function(){
		closeModal();
	})

	$('button#send').on('click', function(){
        $.ajax({
            type: "POST",
            url:  $('#data').data('api'),
            data: { body : $('textarea#body').val(), type : $('#data').data('type') },
        })
        .done(function(ret) {
			if (ret.status == 9) {
				alert('「'+ret.ng_word+'」の単語が不正です。');
			} else {
				closeModal();
				openModal('modal-complete');
			}
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
	})

	// 送信完了モーダルが閉じたときにページをリロード
	$('.modal-complete').on('closeModal', function(){
		location.reload();
	});

	var htmlEscape = function(string){
		return string
		.replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
		.replace(/'/g, '&#39;')
		.replace(/\r?\n/g, '<br>')
		.replace(/ /g, '&nbsp;');
	}
});