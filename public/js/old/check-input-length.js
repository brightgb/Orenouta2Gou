
var check_input_length = function (target_list) {
	if (!Array.isArray(target_list[0])) target_list = [target_list];

	target_list.forEach(element => {
		var label = $('#' + element[0]); // 文字数カウンタ
		var input = $('#' + element[1]); // カウントするフォーム
        var lengthLimit = input.data('limit'); // フォームの文字数上限

        label.append(`(残<span id="countdown-${label.attr('id')}">${lengthLimit - input.val().length}</span>文字)`);
        var counter =  $('#countdown-' + label.attr('id'));

		$(input).on("keyup change",function(){
            counter.text(lengthLimit - input.val().length);
            if(input.val().length > lengthLimit) {
                if (counter.hasClass('alert')) return;
                alert("文字数がオーバーしました");
                counter.addClass('alert');
            } else if(counter.hasClass('alert')) {
                counter.removeClass('alert');
            }
        });
        input.change();
	});
}
