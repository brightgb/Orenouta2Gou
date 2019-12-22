<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ProfileImg;

class TestController extends Controller
{
    public function upload(Request $request)
    {
        // ランダムな文字列を作成する
        $length = 10;  // 文字数を指定
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }

        if (file_exists($_FILES['image']['tmp_name']) &&
            exif_imagetype($_FILES['image']['tmp_name'])) {
            // 拡張子判断
            $ext = getimagesize($_FILES['image']['tmp_name']);
            $r_ext = substr($ext['mime'], strrpos($ext['mime'], '/') + 1);

            if ($r_ext == 'png') {
                $request->image->storeAs('image/Admin', $r_str.'.png', 'public');
            } elseif ($r_ext == 'jpeg') {
                $request->image->storeAs('image/Admin', $r_str.'.jpg', 'public');
            }
        } else {
            session()->put('message', '拡張子は PNG or JPEG');
            return redirect('/*');
            /*　遷移先のコントローラに持たせる
            if (!empty(session()->get('message'))) {
            session()->forget('message');
            return "<script>
                        alert('PNG または JPEG 形式の画像をアップしてください');
                        location.href='/index';
                   </script>";
            }*/
        }

        //ProfileImg::create('image' => $request->image);
        return redirect('/index');
    }
}