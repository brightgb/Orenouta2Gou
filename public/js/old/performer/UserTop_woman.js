$(window).load(function(){
	//�Z���^�����O�����s����֐�
	function centeringModalSyncer(contentId){
		//���(�E�B���h�E)�̕��A�������擾
		var w = window.innerWidth;
		var h = window.innerHeight;
			// �R���e���c(#modal-content)�̕��A�������擾
		var cw = $(contentId).outerWidth();
		var ch = $(contentId).outerHeight();
			//�Z���^�����O�����s����
		$(contentId).css({"left": ((w - cw)/2) + "px", "top": ((h - ch)/2) + "px"});
	}

	function showIntroModal(){
	 if($('#modal-content')[0] && $.cookie("intro_invisible")!=1){

 	 //�L�[�{�[�h����Ȃǂɂ��A�I�[�o�[���C�����d�N������̂�h�~����
		$(this).blur();					//�{�^������t�H�[�J�X���O��
		if($("#modal-overlay")[0]) return false;	//�V�������[�_���E�B���h�E���N�����Ȃ�

		//�I�[�o�[���C���o��������
		$("body").append('<div id="modal-overlay"></div>');
		$("#modal-overlay").fadeIn("500");

		//�R���e���c���Z���^�����O����
		centeringModalSyncer('#modal-content');
		//�R���e���c���t�F�[�h�C������
		$("#modal-content").fadeIn("500");

		//���T�C�Y���ꂽ��A�Z���^�����O������֐�[centeringModalSyncer()]�����s����
		$(window).resize(centeringModalSyncer('#modal-content'));

		
	 }
	}

	if($('#modal-beginner-content')[0] && $.cookie("beginner_invisible")!=1){
	//�L�[�{�[�h����Ȃǂɂ��A�I�[�o�[���C�����d�N������̂�h�~����
		$(this).blur();					//�{�^������t�H�[�J�X���O��
		if($("#modal-overlay")[0]) return false;	//�V�������[�_���E�B���h�E���N�����Ȃ�
		
		//�I�[�o�[���C���o��������
		$("body").append('<div id="modal-overlay"></div>');
		$("#modal-overlay").fadeIn("500");

		//�R���e���c���Z���^�����O����
		centeringModalSyncer('#modal-beginner-content');
		//�R���e���c���t�F�[�h�C������
		$('#modal-beginner-content').fadeIn("500");

		//[#modal-overlay]�A�܂���[#modal-close]���N���b�N������
		$("#modal-overlay, #modal-close").unbind().click(function(){
			//[#modal-content]���\���A[#modal-overlay]���폜����
			$('#modal-beginner-content').hide();
			$('#modal-overlay').remove();

			showIntroModal();
		});
		$("#beginner-close").unbind().click(function(){
			//[.chk_never_disp]�Ƀ`�F�b�N�������Ă����獡���\���ɂ���
			if($('#invisible').prop('checked')){
				$.cookie("beginner_invisible","1", {expires:1000, path:'/'});
			}
			//[#modal-beginner-content]���\���A[#modal-overlay]���폜����
			$('#modal-beginner-content').hide();
			$('#modal-overlay').remove();
			showIntroModal();
		});

		//���T�C�Y���ꂽ��A�Z���^�����O������֐�[centeringModalSyncer()]�����s����
		$(window).resize(centeringModalSyncer('#modal-beginner-content'));
	}

	showIntroModal();

});


