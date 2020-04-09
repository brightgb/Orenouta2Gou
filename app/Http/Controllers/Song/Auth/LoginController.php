<?php

namespace App\Http\Controllers\Song\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use App\Model\SongUser;
use App\Library\OpenSslCryptor;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    protected $maxAttempts = 5;    // ログイン試行回数
    protected $decayMinutes = 5;   // ログインロックタイム

    protected $redirectTo = '/song';

    public function __construct()
    {
        $this->middleware('guest:song')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('song');
    }

    /**
     * 認証カラム
     */
    public function username()
    {
        return 'userid';
    }

    /*
     * ログアウト
     */
    protected function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect($this->redirectTo);
    }

    /*
     * 認証失敗時のエラーメッセージをオーバーライド
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->has('resign_flg')) {
            throw ValidationException::withMessages([
                $this->username() => ['既に退会済みのアカウントです。']
            ]);
        } else {
            throw ValidationException::withMessages([
                $this->username() => ['ログインに失敗しました。ユーザーID もしくは パスワードが正しくありません。']
            ]);
        }
    }

    /*
     * ログインフォーム
     */
    public function showLoginForm()
    {
        $userid = Input::get('userid', Null);
        $password = Input::get('password', Null);
        $title = '俺の歌を育てろ - ログイン';
        return view('song_auth.login', compact('title', 'userid', 'password'));
    }

    /*
     * ログイン
     */
    public function login(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [], [
            'userid' => 'ユーザーID',
            'password' => 'パスワード'
        ]);

        // 退会済みのユーザーはログイン出来ない
        $obj = new OpenSslCryptor('bf-cbc');
        $password = $obj->encrypt($request->input('password'));
        $member = SongUser::where('userid', $request->input('userid'))
                          ->where('password_org', $password)
                          ->first();
        if (!empty($member)) {
            if ($member->resign_flg == 1) {
                $request['resign_flg'] = 1;
                return $this->sendFailedLoginResponse($request);
            }
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            session()->forget('userid_check_page');
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
}