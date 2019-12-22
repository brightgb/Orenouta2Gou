
$(function() {
    $('input#upload-image').on('change', function(){
        scaleX = 1;
        rotate = 0;
        if ($('.modal-cropper').length != 0){
            $('.modal-cropper-area img').prop('src', URL.createObjectURL($(this).prop('files')[0]));
            openModal('modal-cropper', 15, false);
        } else if ($('.modal-confirm').length != 0){
            $('.modal-confirm-area img').prop('src', URL.createObjectURL($(this).prop('files')[0]));
            openModal('modal-confirm', 15, false);
        } else {
            $('#image-data img').prop('src', URL.createObjectURL($(this).prop('files')[0])).show();
            $('.modal-spinner-area img').prop('src', URL.createObjectURL($(this).prop('files')[0]));
        }
    })

    $('.modal-cropper').on('openModal', function(){
        initCropper($('.modal-cropper-area img').get(0));
    });

    $('.modal-cropper-submit').on('click', function(){
        $('form#cropper-form').submit();
    });

    $('.modal-confirm-submit').on('click', function(){
        $('form#confirm-form').submit();
    });

    // 切り抜き処理
    var cropper;
    var initCropper = function(target) {
        if (cropper !== undefined) cropper.destroy();
        cropper = new Cropper(target, {
            aspectRatio: 1,
            guides: false,
            center: false,
            highlight: false,
            restore: false,
            movable: false,
            zoomable: false,
            // rotatable: false,
            // scalable: false,
            cropBoxResizable: false,
            dragMode: false,
            toggleDragModeOnDblclick: false,
            ready() {
                var canvas_data = cropper.getCanvasData();
                var size = (canvas_data.width >= canvas_data.height) ? canvas_data.height : canvas_data.width;
                var top  = parseInt((canvas_data.height - size) / 2);
                var left = parseInt((canvas_data.width - size) / 2);
                cropper.setCropBoxData({
                    top: top,
                    left: left,
                    width: size,
                    height: size
                });
            },
            crop(event) {
                $('input#crop-x').val(event.detail.x);
                $('input#crop-y').val(event.detail.y);
                $('input#crop-width').val(event.detail.width);
                $('input#crop-height').val(event.detail.height);
            },
        });
    };

    // 回転・反転処理
    var scaleX = 1;
    var rotate = 0;
    $('.modal-spinner-content button').on('click', function(){
        if($(this).data('scalex') !== undefined){
            $('input[name=scaleX]').val(-$('input[name=scaleX]').val());
            scaleX = $('input[name=scaleX]').val();
        }
        if($(this).data('rotate') !== undefined){
            $('input[name=rotate]').val((Number($('input[name=rotate]').val()) + Number($(this).data('rotate'))) % 360);
            rotate = $('input[name=rotate]').val();
        }

        var images = [$('#image-data img'), $('.modal-spinner-area img')];
        images.forEach(function(element){
            element.css({
                '-webkit-transform' : `scaleX(${scaleX}) rotate(${rotate}deg)`,
                'transform'         : `scaleX(${scaleX}) rotate(${rotate}deg)`});
        });
    });
})