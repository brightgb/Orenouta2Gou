var $previewBox = $(".originalImg_box");
$(function(){
    $('#upload_fileImg').change(function(e){
        var file = e.target.files[0];
        var reader = new FileReader();
        //画像でない場合は処理終了
        if(file.type.indexOf("image") < 0){
            alert("画像ファイルを指定してください。");
            return false;
        }
        //アップロードした画像を設定する
        reader.onload = (function(file){
            $('#cropper').css("display", 'none');
            $('#preview').attr("style", "display:block;");
            return function(e){
                $('#crop-img').attr("src", e.target.result);
                $('#preview-img').attr("src", e.target.result);
            };
        })(file);
        reader.readAsDataURL(file);
        $previewBox.css("display",'block');
    });
});
function loadCropper(){
    $('#cropper').css("display", 'block');
    $('#preview').css("display", 'none');
    return false;
}
function rotate(){
    let r_data = Number($('#img_rotation').val())+90;
    if (r_data >= 360) {
        r_data = 0;
    }
    $('#previous-img').css({'transform': 'rotate(' + r_data + 'deg)'});
    $('#preview-img').css({'transform': 'rotate(' + r_data + 'deg)'});
    $('#img_rotation').val(r_data);
}

Vue.use(Croppa);
const app = new Vue({
    el: '#croppa',
    data: {
        croppa: null,
        imgUrl: '',
        imgUrl_show: '',
        showModal: false
    },
    methods: {
        generatePreview: function () {
            let url = this.croppa.generateDataUrl();
            if (!url) {
                alert('画像ファイルを指定してください。');
                return
            }
            this.imgUrl = url;
            $('.previous-img').css("display", "none");
            $('#cropper').css("display", 'none');
            $('#preview').css("display", 'block');

            var data = this.croppa.getMetadata();
            var canvas_size = this.croppa.getCanvas().height;

            $('#trim_img_x').val(Math.round((data.startX * -1) / data.scale));
            $('#trim_img_y').val(Math.round((data.startY * -1) / data.scale));
            $('#trim_img_w').val(Math.round(canvas_size / data.scale));
            $('#trim_img_h').val(Math.round(canvas_size / data.scale));
        }
    }
});