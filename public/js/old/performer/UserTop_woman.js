$(window).load(function(){
	//センタリングを実行する関数
	function centeringModalSyncer(contentId){
		//画面(ウィンドウ)の幅、高さを取得
		var w = window.innerWidth;
		var h = window.innerHeight;
			// コンテンツ(#modal-content)の幅、高さを取得
		var cw = $(contentId).outerWidth();
		var ch = $(contentId).outerHeight();
			//センタリングを実行する
		$(contentId).css({"left": ((w - cw)/2) + "px", "top": ((h - ch)/2) + "px"});
	}

	function showIntroModal(){
	 if($('#modal-content')[0] && $.cookie("intro_invisible")!=1){

 	 //キーボード操作などにより、オーバーレイが多重起動するのを防止する
		$(this).blur();					//ボタンからフォーカスを外す
		if($("#modal-overlay")[0]) return false;	//新しくモーダルウィンドウを起動しない

		//オーバーレイを出現させる
		$("body").append('<div id="modal-overlay"></div>');
		$("#modal-overlay").fadeIn("500");

		//コンテンツをセンタリングする
		centeringModalSyncer('#modal-content');
		//コンテンツをフェードインする
		$("#modal-content").fadeIn("500");

		//リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
		$(window).resize(centeringModalSyncer('#modal-content'));

		
	 }
	}

	if($('#modal-beginner-content')[0] && $.cookie("beginner_invisible")!=1){
	//キーボード操作などにより、オーバーレイが多重起動するのを防止する
		$(this).blur();					//ボタンからフォーカスを外す
		if($("#modal-overlay")[0]) return false;	//新しくモーダルウィンドウを起動しない
		
		//オーバーレイを出現させる
		$("body").append('<div id="modal-overlay"></div>');
		$("#modal-overlay").fadeIn("500");

		//コンテンツをセンタリングする
		centeringModalSyncer('#modal-beginner-content');
		//コンテンツをフェードインする
		$('#modal-beginner-content').fadeIn("500");

		//[#modal-overlay]、または[#modal-close]をクリックしたら
		$("#modal-overlay, #modal-close").unbind().click(function(){
			//[#modal-content]を非表示、[#modal-overlay]を削除する
			$('#modal-beginner-content').hide();
			$('#modal-overlay').remove();

			showIntroModal();
		});
		$("#beginner-close").unbind().click(function(){
			//[.chk_never_disp]にチェックが入っていたら今後非表示にする
			if($('#invisible').prop('checked')){
				$.cookie("beginner_invisible","1", {expires:1000, path:'/'});
			}
			//[#modal-beginner-content]を非表示、[#modal-overlay]を削除する
			$('#modal-beginner-content').hide();
			$('#modal-overlay').remove();
			showIntroModal();
		});

		//リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
		$(window).resize(centeringModalSyncer('#modal-beginner-content'));
	}

	showIntroModal();

});


