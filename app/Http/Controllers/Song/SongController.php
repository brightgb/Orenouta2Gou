<?php

namespace App\Http\Controllers\Song;

use App\Http\Controllers\Controller;
use App\Http\Requests\Song\SendAdviceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Model\Song;
use App\Model\SongUser;
use App\Model\SongAdviceList;
use App\Model\SongUserAction;
use App\Model\SongUserFavorite;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class SongController extends Controller
{
    /*
     * 他の会員が投稿した歌唱曲の検索画面
     */
    public function songSearchForm()
    {
        $search_data = Input::all();
        if (!empty($search_data)) {
            session()->put('song_search_data', $search_data);
            return redirect()->route('song.search.form');
        }
        $search_data = session()->get('song_search_data', Null);
        session()->forget('song_search_data');
        $title = '歌唱曲を探す';
        return view('song.song_search', compact('title', 'search_data'));
    }

    /*
     * 他の会員が投稿した歌唱曲を探す
     */
    public function songSearchPost(Request $request)
    {
        // session('song_post_data') に選択内容を保存する
        session()->put('song_post_data', $request->all());

        return redirect('/song/song_list');
    }

    /*
     * 他の会員が投稿した歌唱曲を一覧表示
     */
    public function songList()
    {
        $lists = Song::leftjoin('song_users', 'songs.member_id', 'song_users.id')
                ->leftjoin('song_advice_lists', function($join) {
                    $join->on('songs.id', '=', 'song_advice_lists.song_id');
                    $join->where('song_advice_lists.member_id', '=', \Auth::user()->id);
                })
                ->leftjoin('song_user_favorites', function($join) {
                    $join->on('songs.member_id', '=', 'song_user_favorites.target_id');
                    $join->where('song_user_favorites.member_id', '=', \Auth::user()->id);
                })
                ->selectRaw('
                    songs.id AS song_id,
                    songs.title AS song_title,
                    songs.comment,
                    songs.advice_cnt,
                    songs.created_at AS create_date,
                    song_users.nickname,
                    song_user_favorites.id AS fav_flg
                ')->where('songs.member_id', '!=', \Auth::user()->id)
                ->where('song_users.resign_flg', 0);

        // session('song_post_data') から選択内容を取り出して検索
        $request = session()->get('song_post_data', Null);
        // お気に入り登録リストから遷移した場合
        if (Input::has('nickname')) {
            $request = [];  // 検索条件は初期化
            if (Input::get('nickname') == \Auth::user()->nickname) {
                return redirect()->route('account.song.list');
            }
            $request['nickname'] = Input::get('nickname');
        }
        // 検索画面から遷移している場合
        $favorite_flg = $new_flg = $no_advice_flg = $nickname = $song_title = '';
        if (!empty($request['favorite_flg'])) {
            $favorite_flg = 1;
            $lists = $lists->whereNotNull('song_user_favorites.id');
        }
        if (!empty($request['new_flg'])) {
            $new_flg = 1;
            $lists = $lists->where('songs.created_at', '>=', Carbon::now()->subDay(7));
        }
        if (!empty($request['no_advice_flg'])) {
            $no_advice_flg = 1;
            $lists = $lists->whereNull('song_advice_lists.id');
        }
        if (!empty($request['nickname'])) {  // 完全一致
            $nickname = $request['nickname'];
            $lists = $lists->where('song_users.nickname', $request['nickname']);
        }
        if (!empty($request['song_title'])) {  // 部分一致
            $song_title = $request['song_title'];
            $lists = $lists->where('songs.title', 'like', '%'.$request['song_title'].'%');
        }

        // １：投稿の最新順　２：投稿の古い順　３：アドバイスの多い順　４：アドバイスの少ない順
        $sort = Input::get('sort', 1);
        if ($sort == 1) {
            $lists = $lists->orderBy('songs.created_at', 'desc')->paginate(10)->toArray();
        } elseif ($sort == 2) {
            $lists = $lists->orderBy('songs.created_at', 'asc')->paginate(10)->toArray();
        } elseif ($sort == 3) {
            $lists = $lists->orderBy('songs.advice_cnt', 'desc')->paginate(10)->toArray();
        } elseif ($sort == 4) {
            $lists = $lists->orderBy('songs.advice_cnt', 'asc')->paginate(10)->toArray();
        } else {
            return abort(404);
        }

        foreach ($lists['data'] as $key => $value) {
            $lists['data'][$key]['created_at'] = Carbon::parse($value['create_date'])
                                                       ->format('Y/m/d H:i');
            if (!empty($request['new_flg'])) {
                $lists['data'][$key]['new_flg'] = true;
            } elseif (Carbon::parse($value['create_date']) >= Carbon::now()->subDay(7)) {
                $lists['data'][$key]['new_flg'] = true;
            } else {
                $lists['data'][$key]['new_flg'] = false;
            }
            if ($value['advice_cnt'] >= 1000) {
                $lists['data'][$key]['advice_cnt'] = '999+';
            }
            $lists['data'][$key]['comment'] = nl2br($value['comment']);
        }

        $data = new LengthAwarePaginator(
            $lists['data'],
            $lists['total'],
            $lists['per_page'],
            request()->input('page', 1),
            !empty(Input::get('sort'))? array('path' => request()->url().'?sort='.Input::get('sort')): array('path' => request()->url())
        );

        // 検索条件に戻るＵＲＬ
        $url = "/song/song_search?favorite_flg=".$favorite_flg."&new_flg=".$new_flg."&no_advice_flg=".$no_advice_flg."&nickname=".$nickname."&song_title=".$song_title;

        $title = '他の会員の歌唱曲一覧';
        return view('song.song_list', compact('title', 'data', 'sort', 'request', 'url'));
    }

    /*
     * 他の会員が投稿した歌唱曲詳細
     */
    public function songDetail($song_id)
    {
       // 自分の歌でないかチェック
        $song = Song::findOrFail($song_id);
        if ($song->member_id == \Auth::user()->id) {
            return redirect('/song/account/my_song_detail/'.$song->id);
        }
        // 退会した会員でないかチェック
        $user = SongUser::leftjoin('song_user_favorites', function($join) {
                        $join->on('song_users.id', '=', 'song_user_favorites.target_id');
                        $join->where('song_user_favorites.member_id', '=', \Auth::user()->id);
                    })
                    ->selectRaw('song_user_favorites.id AS fav_flg')
                    ->where('song_users.id', $song->member_id)
                    ->where('song_users.resign_flg', 0)
                    ->firstOrFail();
        $fav_flg = !empty($user->fav_flg)? true: false;
        // データ取得
        $advice_list = SongAdviceList::where('song_id', $song->id)
                                     ->orderBy('created_at', 'desc')
                                     ->get()->toArray();
        $no_advice_flg = true;
        foreach ($advice_list as $key => $value) {
            if ($value['member_id'] == \Auth::user()->id) {
                // 既にアドバイス済み
                $no_advice_flg = false;
            }
            $advice_list[$key]['advice'] = nl2br($value['advice']);
        }
        $title = '他の会員の歌唱曲詳細';
        return view('song.song_detail', compact('title', 'song', 'advice_list', 'fav_flg', 'no_advice_flg'));
    }

    /*
     * お気に入り登録／解除の切り替え
     */
    public function favoriteSwitch(Request $request)
    {
        $member_id = $request->input('member_id');
        // 自分を登録していないかチェック
        if ($member_id == \Auth::user()->id) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        // 存在している会員かチェック
        $user = SongUser::where('id', $member_id)->where('resign_flg', 0)->first();
        if (empty($user)) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        $fav = SongUserFavorite::where('member_id', \Auth::user()->id)
                               ->where('target_id', $member_id)->lockForUpdate()->first();
        // 重複登録のチェック
        if (!empty($fav) && $request->input('fav_to_on') == 1) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        // 未登録の会員を解除していないかチェック
        if (empty($fav) && $request->input('fav_to_off') == 1) {
            $response['status'] = 'NG';
            return response()->json($response);
        }

        ### 各テーブルの更新 ###
        // song_user_actions
        $action = SongUserAction::where('member_id', $member_id)
                                ->lockForUpdate()->first();
        if (empty($action)) {
            $response['status'] = 'NG';
            return response()->json($response);
        }
        if ($request->input('fav_to_on')) {
            // song_user_favorites
            SongUserFavorite::create(['member_id' => \Auth::user()->id,
                                      'target_id' => $member_id]);
            $action->get_favorite_cnt += 1;
            $action->save();
        }
        if ($request->input('fav_to_off')) {
            $fav->delete();
            $action->get_favorite_cnt -= 1;
            $action->save();
        }

        $response['result'] = 'OK';
        return response()->json($response);
    }

    /*
     * アドバイス送信
     */
    public function post(SendAdviceRequest $request)
    {
        $song_id = $request->input('song_id');
        // 自分の歌でないかチェック
        $song = Song::where('id', $song_id)->lockForUpdate()->firstOrFail();
        if ($song->member_id == \Auth::user()->id) {
            return abort(404);
        }
        // 退会した会員でないかチェック
        $user = SongUser::where('id', $song->member_id)
                        ->where('song_users.resign_flg', 0)->firstOrFail();
        // 既にアドバイス済かチェック
        $advice = SongAdviceList::where('song_id', $song_id)
                                ->where('member_id', \Auth::user()->id)->first();
        if (!empty($advice)) {
            return abort(404);
        }

        ### 各テーブルの更新 ###
        // songs
        $song->advice_cnt += 1;
        $song->save();
        // song_advice_lists
        SongAdviceList::create([
            'song_id'   => $song_id,
            'member_id' => \Auth::user()->id,
            'advice'    => $request->input('advice')
        ]);
        // song_user_actions
        $action1 = SongUserAction::where('member_id', \Auth::user()->id)
                                ->lockForUpdate()->first();
        $action1->all_advice_cnt += 1;
        $action1->save();
        $action2 = SongUserAction::where('member_id', $song->member_id)
                                ->lockForUpdate()->first();
        $action2->get_advice_cnt += 1;
        $action2->save();

        return redirect('/song/song_detail/'.$song_id);
    }
}