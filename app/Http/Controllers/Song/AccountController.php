<?php

namespace App\Http\Controllers\Song;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Song\ChangePasswordRequest;
use App\Http\Requests\Song\SingSongRequest;
use Carbon\Carbon;
use App\Library\Util;
use App\Model\Song;
use App\Model\SongUser;
use App\Model\SongUserAction;
use App\Model\SongAdviceList;
use App\Model\SongUserFavorite;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Library\OpenSslCryptor;


class AccountController extends Controller
{
    /*
     * アカウント確認ページ
     */
    public function index()
    {
        $obj = new OpenSslCryptor('bf-cbc');
        $member = SongUser::leftjoin('song_user_actions', 'song_users.id', 'song_user_actions.member_id')
                    ->selectRaw('song_users.nickname,
                                 song_users.userid,
                                 song_users.password_org,
                                 song_users.singer_rank,
                                 song_users.advicer_rank,
                                 song_user_actions.get_advice_cnt,
                                 song_user_actions.sing_song_cnt,
                                 song_user_actions.get_nice_cnt,
                                 song_user_actions.all_advice_cnt,
                                 song_user_actions.get_favorite_cnt')
                    ->where('song_users.id', \Auth::user()->id)
                    ->firstOrFail();
        $member->pw = $obj->decrypt($member->password_org);
        $title = 'マイアカウント';
        return view('song.profile', compact('title', 'member'));
    }

    /*
     * パスワード更新
     */
    public function changePass(ChangePasswordRequest $request)
    {
        $obj = new OpenSslCryptor('bf-cbc');
        $member = SongUser::lockForUpdate()->findOrFail(\Auth::user()->id);
        $member->password = bcrypt($request->input('new_pw'));
        $member->password_org = $obj->encrypt($request->input('new_pw'));
        $member->save();
        return redirect()->route('song.account.index', ['id' => \Auth::user()->id]);
    }

    /*
     * 自分の過去投稿曲
     */
    public function songList()
    {
        // １：投稿の最新順　２：投稿の古い順　３：コメントの多い順　４：コメントの少ない順
        $lists = Song::where('member_id', \Auth::user()->id);
        $sort = Input::get('sort', 1);
        if ($sort == 1) {
            $lists = $lists->orderBy('created_at', 'desc')->paginate(10)->toArray();
        } elseif ($sort == 2) {
            $lists = $lists->orderBy('created_at', 'asc')->paginate(10)->toArray();
        } elseif ($sort == 3) {
            $lists = $lists->orderBy('advice_cnt', 'desc')->paginate(10)->toArray();
        } elseif ($sort == 4) {
            $lists = $lists->orderBy('advice_cnt', 'asc')->paginate(10)->toArray();
        } else {
            return abort(404);
        }

        foreach ($lists['data'] as $key => $value) {
            $lists['data'][$key]['created_at'] = Carbon::parse($value['created_at'])
                                                       ->format('Y/m/d H:i');
            if ($value['advice_cnt'] >= 1000) {
                $lists['data'][$key]['advice_cnt'] = '999+';
            }
            $lists['data'][$key]['comment'] = nl2br($value['comment']);
        }

        $data = new LengthAwarePaginator(
            $lists['data'], $lists['total'], $lists['per_page'], request()->input('page', 1),
            !empty(Input::get('sort'))? array('path' => request()->url().'?sort='.Input::get('sort')): array('path' => request()->url())
        );

        $title = '投稿した歌唱曲一覧';
        return view('song.my_song_list', compact('title', 'data', 'sort'));
    }

    /*
     * 投稿曲へのアドバイス詳細
     */
    public function songDetail($song_id)
    {
        $song = Song::where('id', $song_id)->where('member_id', \Auth::user()->id)
                    ->firstOrFail();
        $advice_list = SongAdviceList::where('song_id', $song_id)->orderBy('created_at', 'desc')
                                     ->get()->toArray();
        $array = [];
        foreach ($advice_list as $key => $value) {
            array_push($array, $value['id']);
            $advice_list[$key]['advice'] = nl2br($value['advice']);
        }
        $last = !empty($array)? max($array): 0;
        $title = '投稿した歌唱曲詳細';
        return view('song.my_song_detail', compact('title', 'song', 'advice_list', 'last', 'song_id'));
    }

    /*
     * 役に立ったアドバイスに、いいねを付ける
     */
    public function sendNice(Request $request)
    {
        $song_id = $request->input('song_id');
        $member_id = $request->input('member_id');
        // 自分に役立ち度を付けようとしてないか？
        if ($member_id == \Auth::user()->id) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        // 自分の投稿した歌唱曲か？
        $song_data = Song::where('member_id', \Auth::user()->id)
                         ->where('id', $song_id)->first();
        if (empty($song_data)) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        // その会員は対象の曲にアドバイスをしているか？ ＋ いいね未認証状態か？
        $advice_data = SongAdviceList::where('song_id', $song_id)
                                     ->where('member_id', $member_id)
                                     ->where('nice_flg', 0)
                                     ->lockForUpdate()->first();
        if (empty($advice_data)) {
            $response['status'] = 'NG';
            return response()->json($response);
        } else {
            $action = SongUserAction::where('member_id', $member_id)
                                    ->where('all_advice_cnt', '>', 0)
                                    ->lockForUpdate()->first();
            if (empty($action)) {
                $response['status'] = 'NG';
                return response()->json($response);
            }
            if ($advice_data->id != $request->input('record_id')) {
                $response['status'] = 'NG';
                return response()->json($response);
            }
        }

        ### 各テーブルの更新 ###
        // song_advice_lists
        $advice_data->nice_flg = 1;
        $advice_data->save();
        // song_user_actions
        $action->get_nice_cnt += 1;
        $action->save();

        $response['result'] = $advice_data->id;
        return response()->json($response);
    }

    /*
     * 歌唱曲の投稿画面
     */
    public function singForm()
    {
        $title = '歌唱曲の投稿';
        return view('song.sing_form', compact('title'));
    }

    /*
     * 歌唱曲を投稿する
     */
    public function singSong(SingSongRequest $request)
    {
        ### 各テーブルの更新 ###
        // songs
        Song::create([
            'member_id' => \Auth::user()->id,
            'title'     => $request->input('name'),
            'comment'   => $request->input('comment'),
            'file_name' => $request->input('youtube'),
        ]);
        // song_user_actions
        $action = SongUserAction::where('member_id', \Auth::user()->id)
                                ->lockForUpdate()->first();
        $action->sing_song_cnt += 1;
        $action->save();

        return redirect()->route('account.song.list');
    }

    /*
     * お気に入り登録リスト
     */
    public function getMyFavorite()
    {
        $lists = SongUserFavorite::leftjoin('song_users', 'song_user_favorites.target_id', 'song_users.id')
            ->leftjoin('song_user_actions', 'song_user_favorites.target_id', 'song_user_actions.id')
            ->selectRaw('
                song_users.id AS member_id,
                song_users.nickname,
                song_user_actions.sing_song_cnt,
                song_user_favorites.created_at AS create_date
            ')->where('song_user_favorites.member_id', \Auth::user()->id)
            ->where('song_users.resign_flg', 0);

        // １：お気に入り追加日の最新順　２：追加日の古い順　３：投稿曲の多い順　４：投稿曲の少ない順
        $sort = Input::get('sort', 1);
        if ($sort == 1) {
            $lists = $lists->orderBy('song_user_favorites.created_at', 'desc')
                           ->paginate(10)->toArray();
        } elseif ($sort == 2) {
            $lists = $lists->orderBy('song_user_favorites.created_at', 'asc')
                           ->paginate(10)->toArray();
        } elseif ($sort == 3) {
            $lists = $lists->orderBy('song_user_actions.sing_song_cnt', 'desc')
                           ->paginate(10)->toArray();
        } elseif ($sort == 4) {
            $lists = $lists->orderBy('song_user_actions.sing_song_cnt', 'asc')
                           ->paginate(10)->toArray();
        } else {
            return abort(404);
        }

        foreach ($lists['data'] as $key => $value) {
            $lists['data'][$key]['created_at'] = Carbon::parse($value['create_date'])
                                                       ->format('Y/m/d H:i');
        }

        $data = new LengthAwarePaginator(
            $lists['data'], $lists['total'], $lists['per_page'], request()->input('page', 1),
            !empty(Input::get('sort'))? array('path' => request()->url().'?sort='.Input::get('sort')): array('path' => request()->url())
        );

        $title = 'お気に入り登録リスト';
        return view('song.my_favorite', compact('title', 'data', 'sort'));
    }

    /*
     * お気に入り登録から外す
     */
    public function favoriteRemove(Request $request)
    {
        $member_id = $request->input('member_id');
        // 解除だけなら、退会した会員データでも取得可能（resign_flgを見ない）
        $member = SongUser::where('id', $member_id)->first();
        if (empty($member)) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        $favorite = SongUserFavorite::where('member_id', \Auth::user()->id)
                                    ->where('target_id', $member->id)->lockForUpdate()->first();
        if (empty($favorite)) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        // 獲得お気に入り数を減らす
        $target = SongUserAction::where('member_id', $member->id)->lockForUpdate()->first();
        if (empty($target)) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        // 解除処理
        $target->get_favorite_cnt -= 1;
        $target->save();
        $favorite->delete();
    }

    /*
     * 退会申請画面
     */
    public function resignForm()
    {
        $title = '退会申請';
        return view('song.resign', compact('title'));
    }

    /*
     * 退会処理
     */
    public function resignComplete(Request $request)
    {
        $member = SongUser::where('id', \Auth::user()->id)->lockForUpdate()->firstOrFail();
        $member->resign_flg = 1;
        $member->save();

        return redirect()->route('song.auth.logout');
    }
}