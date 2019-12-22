$(function(){
    // 編集モード 切り替え
    $("#title .edit").on('click', function(){
        $('#title .edit').hide();
        $('#title .back').show();
        $('.group-list').hide();
        $('.group-edit').show();
    });
    $("#title .back").on('click', function(){
        $('#title .edit').show();
        $('#title .back').hide();
        $('.group-list').show();
        $('.group-edit').hide();
    });

    // グループ追加
    $("#title .create").on('click', function(){
        openModal('modal-create');
    });
    $('.modal-create button').on('click', function(){
        var name = $('.modal-create input[name=name]').val();
        if (name.length == 0) {
            $('.modal-create .error-msg').text('グループ名を入力して下さい').show();
            return;
        } else if (name.length > 20){
            $('.modal-create .error-msg').text('グループ名は20文字以内です').show();
            return;
        }
        $.ajax({
            type: "POST",
            url: $('#data').data('api') + '/create',
            data: { name : name },
        })
        .done(function(ret) {
            if (ret.status == 9) {
				alert('「'+ret.ng_word+'」の単語が不正です。');
			} else {
				location.reload();
			}
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    });

    // グループ編集
    var selectedId;
    $(".group-edit a.edit").on('click', function(){
        selectedId = $(this).parent().data('id');
        $('.modal-edit input[name=name]').val($(this).siblings('a.name').text());
        $('.error-msg').hide();
        openModal('modal-edit');
    });
    $('.modal-edit button').on('click', function(){
        var name = $('.modal-edit input[name=name]').val();
        if (name.length == 0) {
            $('.modal-edit .error-msg').text('グループ名を入力して下さい').show();
            return;
        } else if (name.length > 20){
            $('.modal-edit .error-msg').text('グループ名は20文字以内です').show();
            return;
        }
        $.ajax({
            type: "POST",
            url: $('#data').data('api') + '/edit',
            data: { group_id : selectedId, name : name },
        })
        .done(function(ret) {
            if (ret.status == 9) {
				alert('「'+ret.ng_word+'」の単語が不正です。');
			} else {
				location.reload();
			}
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    });

    // グループ削除
    $(".group-edit a.del").on('click', function(){
        var name = $(this).siblings('a.name').text();
        if(!confirm(`「${name}」を削除します。\r「${name}」に登録されているユーザーも同時に削除されます。\r二度と戻すことは出来ませんがよろしいですか？`)) return;
        $.ajax({
            type: "POST",
            url: $('#data').data('api') + '/delete',
            data: { group_id : $(this).parent().data('id') },
        })
        .done(function(ret) {
            location.reload();
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    });
});