<?php

namespace App\Http\Controllers\Song;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Song\SongUserCreateRequest;
use App\Http\Requests\Song\QuestionRequest;
use Carbon\Carbon;
use App\Library\Util;
use App\Model\SongUser;
use App\Model\SongUserAction;
use App\Model\AdminInfo;
use App\Model\SongUserQuestion;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use App\Library\OpenSslCryptor;


class IndexController extends Controller
{
    /*
     * トップ画面
     */
    public function index()
    {
        $now_month = Carbon::now()->month;
        $device = Util::getUserDevice();

        if ($now_month >= 3 && $now_month <=5) {
            if ($device == config('constKey.DEVICE_TYPE.ANDROID') ||
                $device == config('constKey.DEVICE_TYPE.IOS')) {
                $image = '/storage/image/Admin/bXOztui65t_sp.jpg';
            } else {
                $image = '/storage/image/Admin/bXOztui65t_pc.jpg';
            }
        } elseif ($now_month >= 6 && $now_month <=8) {
            if ($device == config('constKey.DEVICE_TYPE.ANDROID') ||
                $device == config('constKey.DEVICE_TYPE.IOS')) {
                $image = '/storage/image/Admin/eRWziIxI2K_sp.jpg';
            } else {
                $image = '/storage/image/Admin/eRWziIxI2K_pc.jpg';
            }
        } elseif ($now_month >= 9 && $now_month <=11) {
            if ($device == config('constKey.DEVICE_TYPE.ANDROID') ||
                $device == config('constKey.DEVICE_TYPE.IOS')) {
                $image = '/storage/image/Admin/mlPAjEl6Zg_sp.jpg';
            } else {
                $image = '/storage/image/Admin/mlPAjEl6Zg_pc.jpg';
            }
        } else {
            if ($device == config('constKey.DEVICE_TYPE.ANDROID') ||
                $device == config('constKey.DEVICE_TYPE.IOS')) {
                $image = '/storage/image/Admin/x7dXTjJoNy_sp.jpg';
            } else {
                $image = '/storage/image/Admin/x7dXTjJoNy_pc.jpg';
            }
        }

        $title = '俺の歌を育てろ';
        return view('song.index', compact('title', 'image', 'device'));
    }

    /*
     * 新着情報
     */
    public function info()
    {
        $infos = AdminInfo::where('notify_type', 1)
                          ->where('notify_date', '<=', Carbon::now())
                          ->orderBy('notify_date', 'desc')->paginate(10)->toArray();
        foreach ($infos['data'] as $key => $value) {
            $infos['data'][$key]['notify_date'] = Carbon::parse($value['notify_date'])->format('Y/m/d H:i');
        }
        $data = new LengthAwarePaginator(
            $infos['data'], $infos['total'], $infos['per_page'],
            request()->input('page', 1), array('path' => request()->url())
        );
        $title = '新着情報';
        return view('song.info', compact('data', 'title'));
    }

    /*
     * サイトについて
     */
    public function help()
    {
        $title = 'サイトについて';
        return view('song.help', compact('title'));
    }

    /*
     * 会員登録フォーム
     */
    public function registForm()
    {
        // ログイン後は接続できない
        if (\Auth::check()) {
            return redirect('/song');
        }

        $title = '無料会員登録';
        return view('song.regist', compact('title'));
    }

    /*
     * 会員登録の情報送信（API）
     */
    public function registPost(SongUserCreateRequest $request)
    {
        // ランダムな文字列を作成する
        $length = 5;  // 文字数を指定
        $str = array_merge(range('a', 'z'), range('A', 'Z'));
        $r_str = Null;
        for ($i=0; $i<$length; $i++) {
            $r_str .= $str[rand(0, count($str)-1)];
        }

        // テーブルをロックして、最新の userid を生成
        $obj = new OpenSslCryptor('bf-cbc');
        $member = SongUser::lockForUpdate()->create([
            'nickname'     => $request->input('nickname'),
            'password'     => bcrypt($request->input('password_org')),
            'password_org' => $obj->encrypt($request->input('password_org'))
        ]);
        $member->userid = $r_str.$member->id;
        $member->save();

        // 関連テーブルの作成
        SongUserAction::create([
            'member_id' => $member->id
        ]);

        $response['userid'] = '/success?userid='.$member->userid;
        return response()->json($response);
    }

    /*
     * 会員登録後のユーザーID確認ページ
     */
    public function registSuccess()
    {
        // ログイン後は接続できない
        if (\Auth::check()) {
            return redirect('/song');
        }

        // セッションのチェック
        if (!empty(session()->get('userid_check_page'))) {
            $userid = session()->get('userid_check_page');
        } else {
            // セッションの保存
            $userid = Input::get('userid', Null);
            if (empty($userid)) {
                return abort(404);
            }
            session()->put('userid_check_page', $userid);
            return redirect('/song/regist/success');
        }

        // 存在チェック
        $member = SongUser::where('userid', $userid)->firstOrFail();
        $obj = new OpenSslCryptor('bf-cbc');
        $password = $obj->decrypt($member->password_org);

        $title = '会員登録完了';
        return view('song.userid_check_page', compact('title', 'userid', 'password'));
    }

    /*
     * お問い合わせ・要望フォーム
     */
    public function requestForm()
    {
        $title = 'お問い合わせ・要望';
        return view('song.request', compact('title'));
    }

    /*
     * お問い合わせ・要望送信
     */
    public function requestPost(QuestionRequest $request)
    {
        SongUserQuestion::create([
            'member_id' => \Auth::user()->id,
            'question'  => nl2br($request->input('question'))
        ]);
        return redirect()->route('song.request.form')->with('success', '送信完了しました');
    }

    /*
     * Ｑ＆Ａについて
     */
    public function requestAbout()
    {
        $title = 'よくある質問';
        return view('song.about_request', compact('title'));
    }
}