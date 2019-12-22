<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\AdminInfo;
use App\Model\UserQuestion;
use Illuminate\Pagination\LengthAwarePaginator;


class IndexController extends Controller
{
    /*
     * トップ画面
     */
    public function index()
    {
        $now_month = Carbon::now()->month;
        if ($now_month >= 3 && $now_month <=5) {
            $image = '/storage/image/Admin/bXOztui65t.jpg';
        } elseif ($now_month >= 6 && $now_month <=8) {
            $image = '/storage/image/Admin/eRWziIxI2K.jpg';
        } elseif ($now_month >= 9 && $now_month <=11) {
            $image = '/storage/image/Admin/mlPAjEl6Zg.jpg';
        } else {
            $image = '/storage/image/Admin/x7dXTjJoNy.jpg';
        }

        $title = '俺の歌を育てろ';
        return view('my_song.index', compact('title', 'image'));
    }

    /*
     * 新着情報
     */
    public function info()
    {
        $infos = AdminInfo::where('notify_date', '<=', Carbon::now())
                          ->orderBy('notify_date', 'desc')->paginate(10)->toArray();
        foreach ($infos['data'] as $key => $value) {
            $infos['data'][$key]['notify_date'] = Carbon::parse($value['notify_date'])->format('Y/m/d H:i');
        }
        $data = new LengthAwarePaginator(
            $infos['data'],
            $infos['total'],
            $infos['per_page'],
            request()->input('page', 1), array('path' => request()->url())
        );
        $title = '新着情報';
        return view('my_song.info', compact('data', 'title'));
    }

    /*
     * サイトについて
     */
    public function help()
    {
        $title = 'サイトについて';
        return view('my_song.help', compact('title'));
    }

    /*
     * 管理人プロフィール
     */
    public function profile()
    {
        $title = '管理人プロフィール';
        return view('my_song.profile', compact('title'));
    }

    /*
     * お問い合わせ・要望フォーム
     */
    public function requestForm()
    {
        $title = 'お問い合わせ・要望';
        return view('my_song.request', compact('title'));
    }

    /*
     * お問い合わせ・要望送信
     */
    public function requestPost(Request $request)
    {
        UserQuestion::create(['question' => nl2br($request->input('question'))]);
        return redirect()->route('my_song.request.form')->with('success', '送信完了しました');
    }

    /*
     * Ｑ＆Ａについて
     */
    public function requestAbout()
    {
        $title = 'よくある質問';
        return view('my_song.about_request', compact('title'));
    }
}