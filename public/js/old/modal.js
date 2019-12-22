var currentModal

//モーダルを開く フェードイン無し
var openModal = function(modalName, top, scroll) {
	openModalFadeIn(modalName, 0, top, scroll);
};

// モーダルを開く フェードイン有り
var openModalFadeIn = function(modalName, speed, top, scroll) {
	if ($('.' + modalName).length == 0) return;

	//キーボード操作などにより、オーバーレイが多重起動するのを防止する
	$(this).blur();	// ボタンからフォーカスを外す
	if($("#modal-overlay")[0]) return false;	//新しくモーダルウィンドウを起動しない

	//オーバーレイを出現させる
	$("body").append('<div id="modal-overlay"></div>');
	$("#modal-overlay").fadeIn(speed);
	//コンテンツをセンタリングする
	centeringModalSyncer(modalName, top, scroll);
	//コンテンツをフェードインする
	$('.' + modalName).fadeIn(speed).trigger('openModal');
	//現在開いているモーダルの情報を更新
	currentModal = modalName;

	//[#modal-overlay]、または[.modal-close]、[.button-close]をクリックしたら閉じる
	$("#modal-overlay, .modal-close, .button-close").unbind().click(function() {
		closeModal(modalName);
	});
};

var closeModal = function(modalName){
	if (modalName === undefined) modalName = currentModal;

	//[.modal-content]のheightを初期化
	$('.' + modalName).css({"height": "auto"});
	//[.modal-content]を非表示、[#modal-overlay]を削除する
	$('.' + modalName).hide().trigger('closeModal');
	$('#modal-overlay').remove();
}

//モーダルのセンタリング
var centeringModalSyncer = function (modalName, top, scroll=true){
	//画面(ウィンドウ)の幅、高さを取得
	var w = window.innerWidth;
	var h = window.innerHeight;
	// 対象の幅、高さを取得
	var cw = $('.' + modalName).outerWidth();
	var ch = $('.' + modalName).outerHeight();
	//センタリングを実行する
	if (h*0.9 < ch && scroll){
		$('.' + modalName).css({"height": "80%"});
		if (top === undefined){
			$('.' + modalName).css({"top": "10%"})
		} else {
			$('.' + modalName).css({"top": top + "px"})
		}
		$('.' + modalName).css({"left": ((w - cw)/2) + "px"})
		$('.' + modalName + ' div').css({"overflow-y": "scroll"});
	} else {
		$('.' + modalName).css({"height": "auto"});
		if (top === undefined){
			$('.' + modalName).css({"top": ((h - ch)/2) + "px"})
		} else {
			$('.' + modalName).css({"top": top + "px"})
		}
		$('.' + modalName).css({"left": ((w - cw)/2) + "px"})
		$('.' + modalName + ' div').css({"overflow-y": "visible"});
	}
}