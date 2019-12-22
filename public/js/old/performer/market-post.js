$(function() {
    $('input[type=file]').on('change', function(){
        var preview = $(this).parents('.imgPhoto').children('.image-preview');
        var rotate = $(this).parents('.imgPhoto').children('.rotatePhoto');

        preview.children('img').prop('src', URL.createObjectURL($(this).prop('files')[0]));
        preview.show();
        rotate.children('select').val(0);
        rotate.show();
    })
    // ��]����
    $('.rotatePhoto select').on('change', function(){
        $(this).parents('.imgPhoto').find('.image-preview img').css({
            '-webkit-transform' : `rotate(${$(this).val()}deg)`,
            'transform'         : `rotate(${$(this).val()}deg)`
        });
    });

    // ���͍��ڂ̃o���f�[�V����
    $('form').on('submit', function() {
        $('.caution').children().hide();
        var isOK = true;

        if ($('input[name=title]').val() == "") { // ���i�����K�v
            $('.caution').children('#tit_emp').show();
            isOK = false;
        }

        if ($('select[name=category]').val() == 0) { // �J�e�S����I�����Ă�������
            $('.caution').children('#cat_nsl').show();
            isOK = false;
        }
        if (!$.isNumeric($('input[name=point]').val()) || $('input[name=price]').val() <= 0) { // ���i�͐��� & 0�~�ȉ��͕s��
            $('.caution').children('#prc_sht').show();
            isOK = false;
        }

        if ($('textarea[name=comment]').val() == "") { // ���i�����͕K�v
            $('.caution').children('#com_emp').show();
            isOK = false;
        }

        return isOK;
    });
});