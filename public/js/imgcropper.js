
var crop_size = 320;
var $canvasId = 'jsi-canvas';
var $image_trimId = 'cropper_img';
var $image_orignId = 'original_img';
var $image_prev = $('#'+$image_orignId);
var $image_trim = $('#'+$image_trimId);
var $canvasElement = document.getElementById($canvasId);
var $canvasW = $canvasElement.width;
var $canvasH = $canvasElement.height;

var $previewBox = $(".originalImg_box");
var $trimmingBox = $('.img_trimming_box');
var $afterImgBox = $(".img_trim_after");

var $crop_opneBtn = $("#crop_open_btn");
var $crop_rotaBtn = $("#crop_rota_btn");

var $crop_trimBtn = $('#crop_trim_btn');

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
            return function(e){
                $image_prev.attr("src", e.target.result);
            };
        })(file);

        reader.readAsDataURL(file);
        $afterImgBox.css("display",'none');
        $previewBox.css("display",'block');
        $crop_opneBtn.css("display",'block');
        $crop_rotaBtn.css("display",'block');
    });
});

/**
 * トリミングボックス表示
 */
function loadjcrop()
{
    $previewBox.css("display",'none');
    $afterImgBox.css("display",'none');
    $crop_opneBtn.css("display",'none');
    $crop_rotaBtn.css("display",'none');

    $trimmingBox.css("display",'block');
    $crop_trimBtn.css("display",'block');

    $trimmingBox.html('');

    $trimmingBox.append('<img id="'+$image_trimId+'" />');
    $image_trim = $('#'+$image_trimId);
    $image_trim.width(crop_size);
    $trimmingBox.width(crop_size);
    $image_trim.attr('src', $image_prev.attr('src'));
    $image_trim.cropper({
        dragMode: 'move',
        aspectRatio: 1 / 1,
        restore: false,
        guides: false,
        cropBoxMovable: true,
        cropBoxResizable: false,
        toggleDragModeOnDblclick: false,
        zoomOnWheel: false,
        minCropBoxWidth: crop_size,
        minCropBoxHeight: crop_size,
        bgColor: 'white',
        ready: function () {
            croppable = true;
        },
    });
    var cropper = $image_prev.data('cropper');
}

/**
 * 加工後の画像表示
 */
function trimingcrop(){

    $('#'+$canvasId).css("display",'block');
    $crop_opneBtn.css("display",'block');
    $crop_rotaBtn.css("display",'block');

    $trimmingBox.css("display",'none');
    $crop_trimBtn.css("display",'none');

    $afterImgBox.css("display",'block');

    var data = $image_trim.cropper('getData');
    let x_data = Math.round(data.x);
    let y_data = Math.round(data.y);
    let w_data = Math.round(data.width);
    let h_data = Math.round(data.height);

    img = new Image();
    img.src = $image_prev.attr('src');
    context = $canvasElement.getContext('2d');
    context.clearRect(0, 0, $canvasW, $canvasH);
    context.drawImage(
        img,
        x_data,
        y_data,
        w_data,
        h_data,
        0, 0,
        360,
        360
    );
    $('#trim_img_x').val(x_data);
    $('#trim_img_y').val(y_data);
    $('#trim_img_w').val(w_data);
    $('#trim_img_h').val(h_data);
}

/**
 * [rotateCanvas description]
 * @param  {[type]} w [description]
 * @param  {[type]} h [description]
 * @return {[type]}   [description]
 */
function rotateCanvas(w_data, h_data){

    x_data = $('#trim_img_x').val();
    y_data = $('#trim_img_y').val();
    if($('#trim_img_w').val() > 0)
        w_data = $('#trim_img_w').val();
    if($('#trim_img_h').val() > 0)
        h_data = $('#trim_img_h').val();

    context = $canvasElement.getContext('2d');
    context.clearRect(0, 0, $canvasW, $canvasH);
    context.translate( $canvasW/2, $canvasH/2 );
    context.rotate( 90 * Math.PI / 180 );
    context.translate( -$canvasW/2, -$canvasH/2 );

    var img = new Image();
    img.src = $image_trim.attr('src');

    img.onload = function() {
        context.drawImage(
            img,
            x_data,
            y_data,
            w_data,
            h_data,
            0, 0,
            360,
            360
        );
    }
    let r_data = Number($('#img_rotation').val())+90;
    if (r_data >= 360) {
        r_data = 0;
    }
    $('#img_rotation').val(r_data);
}

/**
 * 現在の画像ロードしてキャンバスに表示
 */
function loadCanvas(w_data, h_data){
    context = $canvasElement.getContext('2d');
    var img = new Image();
    img.src = $image_trim.attr('src');

    img.onload = function() {
        context.drawImage(
            img,
            0,
            0,
            w_data,
            h_data,
            0, 0,
            360,
            360
        );
     }
}
