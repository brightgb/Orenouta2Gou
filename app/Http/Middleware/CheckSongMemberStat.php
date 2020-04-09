<?php

namespace App\Http\Middleware;

use Closure;

class CheckSongMemberStat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            $resign_flg = \Auth::user()->resign_flg;
            // 退会済みの場合は会員登録画面に遷移
            if ($resign_flg == 1) {
                \Auth::guard()->logout();
                return redirect('/song');
            }
        }
        return $next($request);
    }
}