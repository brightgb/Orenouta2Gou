$(function(){
	var mailId;
	var protectionFlag;
	var url = $('#data').data('api-url') + '/mail/protection';

	$(".protect, .unprotect").click(function(){
		mailId = $(this).parents('.message').attr('id');
		protectionFlag = $(this).hasClass('protect') ? 0 : 1; // protectクラスがある = 保護ボタンがある = 現在保護状態でない

		jqxhr = $.ajax({
			type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: url,
			data: {
				_token 	: $('meta[name="csrf-token"]').attr('content'),
				id		: mailId,
				value	: !protectionFlag,
			},
		})
		.done(function(ret) {
			switchProtectIcon();
		})
		.fail(function() {
			alert('通信に失敗しました。');
		});
	});

	var switchProtectIcon = function(){
		var protectButton = $('#' + mailId).find('.protect_btn a');
		var protectIcon   = $('#' + mailId).find('.protect_img');

		if (protectionFlag) {
			// 保護 => 解除
			alert('保護を解除しました');
			protectButton.addClass('protect').removeClass('unprotect').text('保護');
			protectIcon.hide();
		} else {
			// 解除 => 保護
			alert('保護しました');
			protectButton.addClass('unprotect').removeClass('protect').text('解除');
			protectIcon.show();
		}
	}
});
