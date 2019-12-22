{{-- 画像アップロード用 --}}
<form method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="image">
    <input type="submit" name="upload">
</form>

{{--　単純に表示と非表示を切り替えるメニュー
    #acordion {
        border-style: solid;
        width: 300px;
        clear: both;
        float: right;
        position: relative; top: -10px; right: 0px;
        z-index: 9999;
        background-color: gray;
    }
    .show {
        opacity: 1;
        transform: translateY(10px);
        transition: 100ms;
        
    }
    .hide {
        opacity: 0;
        transition: 100ms;
    }
    .menu_table {
        text-align: center;
        border: black;
        border-collapse: collapse;
        width: 300px;
    }
<input type="button" onclick="func1()" value="メニュー" id="btn"></button>
<div id="acordion" class="hide">
    <table border="1" class="menu_table">
        <tr style="height: 50px;"><td></td></tr>
        <tr style="height: 50px;"><td></td></tr>
        <tr style="height: 50px;"><td></td></tr>
    </table>
</div>
<script language="javascript" type="text/javascript">
    function func1() {
        var elem1 = document.getElementById('btn');
        if (elem1.value == 'メニュー') {
            elem1.value = '閉じる';
        } else {
            elem1.value = 'メニュー';
        }
        var elem2 = document.getElementById("acordion");
        elem2.classList.toggle('show');
        elem2.classList.toggle('hide');
    }
</script>--}}