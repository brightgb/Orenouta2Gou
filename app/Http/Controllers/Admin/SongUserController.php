<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SingerSearchRequest;
use Illuminate\Http\Request;
use App\Model\Song;
use App\Model\SongUser;
use App\Model\SongAdviceList;
use App\Model\SongUserAction;
use App\Model\SongUserFavorite;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;


class SongUserController extends Controller
{
    /*
     * 会員検索（GET）
     */
    public function index1()
    {
        return view('admin.song.user_list');
    }

    /*
     * 会員検索（POST）
     */
    public function search(SingerSearchRequest $request)
    {
        $members = SongUser::leftjoin('song_user_actions', 'song_users.id', 'song_user_actions.member_id')
                            ->selectRaw('song_users.userid,
                                         song_users.nickname,
                                         song_users.singer_rank,
                                         song_users.advicer_rank,
                                         song_users.resign_flg,
                                         song_users.created_at AS create_date,
                                         song_user_actions.get_advice_cnt,
                                         song_user_actions.sing_song_cnt,
                                         song_user_actions.get_nice_cnt,
                                         song_user_actions.all_advice_cnt,
                                         song_user_actions.get_favorite_cnt')
                            ->getQuery();
        // ユーザーID
        if ($request->input('userid') != '') {
            $members->where('song_users.userid', 'like', '%'.$request->input('userid').'%');
        }
        // ニックネーム
        if ($request->input('nickname') != '') {
            $members->where('song_users.nickname', 'like', '%'.$request->input('nickname').'%');
        }
        // 歌い手ランク
        $members->whereIn('song_users.singer_rank', $request->input('singer_rank'));
        // 登録日
        if ($request->input('regist_from') != '') {
            $regist_from = Carbon::parse($request->input('regist_from'))->format('Y-m-d 00:00:00');
            $members->where('song_users.created_at', '>=', $regist_from);
        }
        if ($request->input('regist_to') != '') {
            $regist_to = Carbon::parse($request->input('regist_to'))->format('Y-m-d 23:59:59');
            $members->where('song_users.created_at', '<=', $regist_to);
        }
        // アドバイザーランク
        $members->whereIn('song_users.advicer_rank', $request->input('advicer_rank'));
        // 獲得アドバイス数
        if ($request->input('get_advice_from') != '') {
            $members->where('song_user_actions.get_advice_cnt', '>=', $request->input('get_advice_from'));
        }
        if ($request->input('get_advice_to') != '') {
            $members->where('song_user_actions.get_advice_cnt', '<=', $request->input('get_advice_to'));
        }
        // 投稿曲数
        if ($request->input('song_cnt_from') != '') {
            $members->where('song_user_actions.sing_song_cnt', '>=', $request->input('song_cnt_from'));
        }
        if ($request->input('song_cnt_to') != '') {
            $members->where('song_user_actions.sing_song_cnt', '<=', $request->input('song_cnt_to'));
        }
        // 獲得いいね数
        if ($request->input('get_nice_from') != '') {
            $members->where('song_user_actions.get_nice_cnt', '>=', $request->input('get_nice_from'));
        }
        if ($request->input('get_nice_to') != '') {
            $members->where('song_user_actions.get_nice_cnt', '<=', $request->input('get_nice_to'));
        }
        // アドバイス送信数
        if ($request->input('send_advice_from') != '') {
            $members->where('song_user_actions.all_advice_cnt', '>=', $request->input('send_advice_from'));
        }
        if ($request->input('send_advice_to') != '') {
            $members->where('song_user_actions.all_advice_cnt', '<=', $request->input('send_advice_to'));
        }
        // 獲得お気に入り数
        if ($request->input('get_favorite_from') != '') {
            $members->where('song_user_actions.get_favorite_cnt', '>=', $request->input('get_favorite_from'));
        }
        if ($request->input('get_favorite_to') != '') {
            $members->where('song_user_actions.get_favorite_cnt', '<=', $request->input('get_favorite_to'));
        }
        // 管理メモ
        if ($request->input('admin_memo') != '') {
            $members->where('song_users.admin_memo', 'like', '%'.$request->input('admin_memo').'%');
        }
        // 会員種別
        if ($request->input('member_type') == 0) {  // 退会済みを含まない
            $members->where('song_users.resign_flg', 0);
        } elseif ($request->input('member_type') == 1) {  // 退会のみ
            $members->where('song_users.resign_flg', 1);
        }

        $members = $members->orderBy('song_users.id', 'asc')->paginate(20)->toArray();
        foreach ($members['data'] as $key => $value) {
            $members['data'][$key]->created_at = Carbon::parse($value->create_date)->format('Y/m/d H:i');
            $members['data'][$key]->singer_rank = config('constSong.singer_rank_label.'.$value->singer_rank);
            $members['data'][$key]->advicer_rank = config('constSong.advicer_rank_label.'.$value->advicer_rank);
        }
        return response()->json($members);
    }

    /*
     * 会員詳細（GET検索）
     */
    public function detail()
    {
        $userid = Input::get('userid', Null);
        $nickname = Input::get('nickname', Null);
        $member_data = $error = Null;
        $flg = false;
        // 最初のアクセス
        if (!Input::has('userid') && !Input::has('nickname')) {
            return view('admin.song.user_detail', compact('userid', 'nickname', 'member_data', 'error', 'flg'));
        }
        // 検索項目なし
        if (empty($userid) && empty($nickname)) {
            $error = 'ユーザーID または ニックネームを指定してください。';
            return view('admin.song.user_detail', compact('userid', 'nickname', 'member_data', 'error', 'flg'));
        }
        // 検索
        $member = SongUser::leftjoin('song_user_actions', 'song_users.id', 'song_user_actions.member_id')
                            ->selectRaw('song_users.userid,
                                         song_users.nickname,
                                         song_users.singer_rank,
                                         song_users.advicer_rank,
                                         song_users.admin_memo,
                                         song_users.resign_flg,
                                         song_users.created_at AS create_date,
                                         song_user_actions.get_advice_cnt,
                                         song_user_actions.sing_song_cnt,
                                         song_user_actions.get_nice_cnt,
                                         song_user_actions.all_advice_cnt,
                                         song_user_actions.get_favorite_cnt');
        if (!empty($userid)) { $member->where('song_users.userid', $userid); }
        if (!empty($nickname)) { $member->where('song_users.nickname', $nickname); }
        $member_data = $member->first();
        // 検索結果
        if (!empty($member_data)) {
            $userid = $member_data->userid;
            $nickname = $member_data->nickname;
            $member_data->create_date = Carbon::parse($member_data->create_date)->format('Y/m/d H:i');
            $member_data->singer_rank = config('constSong.singer_rank_label.'.$member_data->singer_rank);
            $member_data->advicer_rank = config('constSong.advicer_rank_label.'.$member_data->advicer_rank);
            $flg = true;
            return view('admin.song.user_detail', compact('userid', 'nickname', 'member_data', 'error', 'flg'));
        }
        // 該当なし
        $error = '該当するデータなし';
        return view('admin.song.user_detail', compact('userid', 'nickname', 'member_data', 'error', 'flg'));
    }

    /*
     * 会員詳細の更新
     */
    public function update(Request $request)
    {
        SongUser::where('userid', $request->input('member_userid'))
                ->update(['admin_memo' => $request->input('admin_memo')]);
        return redirect('/admin/orenouta/user_detail?userid='.$request->input('member_userid'))
                ->with('success', '更新しました。');
    }

    /*
     * 特定会員のお気に入り登録状況
     */
    public function favoriteList(Request $request)
    {
        $member_id = SongUser::where('userid', $request->input('userid'))->first()->id;
        // 対象の男性がお気に入り登録している会員リスト
        $list1 = SongUserFavorite::leftjoin('song_users', 'song_user_favorites.target_id', 'song_users.id')->selectRaw('song_users.nickname AS target_name,
                                        song_user_favorites.target_id')
                           ->where('song_user_favorites.member_id', $member_id)
                           ->orderBy('song_user_favorites.target_id', 'asc')->get()->toArray();
        // 対象の男性をお気に入り登録している会員リスト
        $list2 = SongUserFavorite::leftjoin('song_users', 'song_user_favorites.member_id', 'song_users.id')->selectRaw('song_users.nickname AS target_name,
                                        song_user_favorites.member_id AS target_id')
                           ->where('song_user_favorites.target_id', $member_id)
                           ->orderBy('song_user_favorites.member_id', 'asc')->get()->toArray();
        // データ整形
        $data = [];
        $full1 = $full2 = false;
        $key = $key1 = $key2 = 0;
        // どちらかに未検証キーがある限り続行
        while (!$full1 || !$full2) {
            // 値の存在判定
            if (!array_key_exists($key1, $list1)) { $full1 = true; }
            if (!array_key_exists($key2, $list2)) { $full2 = true; }
            if ($full1 && $full2) { break; }
            // それぞれの最小IDを比べる
            $min_id1 = (!$full1)? $list1[$key1]['target_id']: 0;
            $min_id2 = (!$full2)? $list2[$key2]['target_id']: 0;
            // １のリストが小さいとき
            if (($min_id1 != 0 && ($min_id1 < $min_id2)) ||
                ($min_id1 != 0 && $min_id2 == 0)) {
                $data[$key]['nickname'] = $list1[$key1]['target_name'];
                $data[$key]['fav_send'] = true;
                $data[$key]['fav_receive'] = false;
                ++$key;
                ++$key1;
            }
            // ２のリストが小さいとき
            if (($min_id2 != 0 && ($min_id1 > $min_id2)) ||
                ($min_id1 == 0 && $min_id2 != 0)) {
                $data[$key]['nickname'] = $list2[$key2]['target_name'];
                $data[$key]['fav_send'] = false;
                $data[$key]['fav_receive'] = true;
                ++$key;
                ++$key2;
            }
            // １のリストと２のリストが同じ
            if ($min_id1 == $min_id2) {
                $data[$key]['nickname'] = $list1[$key1]['target_name'];
                $data[$key]['fav_send'] = true;
                $data[$key]['fav_receive'] = true;
                ++$key;
                ++$key1;
                ++$key2;
            }
        }

        // ページネート
        $response = [
            "current_page" => $request->input('page'),
            "data" => array_slice($data, 20*$request->input('page')-20, 20),
            "first_page_url" => "/admin/api/orenouta/user_fav_list?page=1",
            "from" => (count($data) == 0)? 0: 20*$request->input('page')-19,
            "last_page" => $last_page = ceil(count($data) / 20),
            "last_page_url" => "/admin/api/orenouta/user_fav_list?page=".$last_page,
            "next_page_url" => "/admin/api/orenouta/user_fav_list?page=".((int)$request->input('page')+1),
            "path" => "/admin/api/orenouta/user_fav_list",
            "per_page" => 20,
            "prev_page_url" => null,
            "to" => ($last_page == 0 || $request->input('page') == $last_page)? count($data): 20*$request->input('page'),
            "total" => count($data)
        ];
        return response()->json($response);
    }

    /*
     * 歌唱曲一覧（GET）
     */
    public function index2()
    {
        return view('admin.song.song_list');
    }

    /*
     * 歌唱曲一覧（POST）
     */
    public function getList(Request $request)
    {
        $songs = Song::leftjoin('song_users', 'songs.member_id', 'song_users.id')
                     ->selectRaw('songs.id,
                                  songs.title,
                                  songs.comment,
                                  songs.advice_cnt,
                                  songs.created_at AS create_date,
                                  song_users.userid,
                                  song_users.nickname')
                     ->getQuery();
        if ($request->input('userid') != '') {
            $songs->where('song_users.userid', 'like', '%'.$request->input('userid').'%');
        }
        if ($request->input('nickname') != '') {
            $songs->where('song_users.nickname', 'like', '%'.$request->input('nickname').'%');
        }
        if ($request->input('song_title') != '') {
            $songs->where('songs.title', 'like', '%'.$request->input('song_title').'%');
        }
        if ($request->input('create_from') != '') {
            $create_from = Carbon::parse($request->input('create_from'))->format('Y-m-d 00:00:00');
            $songs->where('songs.created_at', '>=', $create_from);
        }
        if ($request->input('create_to') != '') {
            $create_to = Carbon::parse($request->input('create_to'))->format('Y-m-d 23:59:59');
            $songs->where('songs.created_at', '<=', $create_to);
        }
        switch ($request->input('sort')) {
            case 1:
                $list = $songs->orderBy('songs.created_at', 'desc')->paginate(20)->toArray();
                break;
            case 2:
                $list = $songs->orderBy('songs.created_at', 'asc')->paginate(20)->toArray();
                break;
            case 3:
                $list = $songs->orderBy('songs.advice_cnt', 'desc')->paginate(20)->toArray();
                break;
            case 4:
                $list = $songs->orderBy('songs.advice_cnt', 'asc')->paginate(20)->toArray();
                break;
            default:  // 選択肢以外の数字が不正入力された場合
                return abort(404);
        }
        foreach ($list['data'] as $key => $value) {
            $list['data'][$key]->created_at = Carbon::parse($value->create_date)->format('Y/m/d H:i');
            $list['data'][$key]->comment = nl2br($value->comment);
        }
        return response()->json($list);
    }

    /*
     * コメント一覧（GET）
     */
    public function index3()
    {
        $song_id = Input::get('song_id', Null);
        $song_title = Input::get('song_title', Null);
        return view('admin.song.comment_list', compact('song_id', 'song_title'));
    }

    /*
     * コメント一覧（POST）
     */
    public function getComment(Request $request)
    {
        $advices = SongAdviceList::leftjoin('songs', 'song_advice_lists.song_id', 'songs.id')
                                 ->leftjoin('song_users', 'song_advice_lists.member_id', 'song_users.id')
                                 ->selectRaw('songs.id AS song_id,
                                              songs.title AS song_title,
                                              songs.file_name,
                                              song_users.nickname,
                                              song_users.id AS member_id,
                                              song_advice_lists.id AS advice_id,
                                              song_advice_lists.advice,
                                              song_advice_lists.nice_flg,
                                              song_advice_lists.created_at')
                                 ->getQuery();
        if ($request->input('song_id') != '') {
            $advices->where('songs.id', $request->input('song_id'));
        }
        if ($request->input('song_title') != '') {
            $advices->where('songs.title', $request->input('song_title'));
        }
        $list = $advices->orderBy('song_advice_lists.created_at', 'desc')->paginate(20)->toArray();

        if (empty($list['data'])) {
            $list['data']['song_id'] = $request->input('song_id');
            $list['data']['song_title'] = $request->input('song_title');
            return response()->json($list);
        }
        foreach ($list['data'] as $key => $value) {
            $list['data'][$key]->created_at = Carbon::parse($value->created_at)->format('Y/m/d H:i');
            $list['data'][$key]->advice = nl2br($value->advice);
            $list['data']['song_id'] = $value->song_id;
            $list['data']['song_title'] = $value->song_title;
            $list['data']['file'] = $value->file_name;
        }
        return response()->json($list);
    }

    /*
     * コメントの削除
     */
    public function deleteComment(Request $request)
    {
        // songs
        $song = Song::where('id', $request->input('song_id'))->lockForUpdate()->firstOrFail();
        // song_advice_lists
        $advice = SongAdviceList::where('id', $request->input('advice_id'))
                                ->where('song_id', $request->input('song_id'))
                                ->where('member_id', $request->input('member_id'))
                                ->lockForUpdate()->firstOrFail();
        $nice_flg = ($advice->nice_flg == 1)? true: false;
        // song_user_actions
        $action1 = SongUserAction::where('member_id', $song->member_id)
                                 ->lockForUpdate()->firstOrFail();
        $action2 = SongUserAction::where('member_id', $request->input('member_id'))
                                 ->lockForUpdate()->firstOrFail();
        // データ処理
        $song->advice_cnt -= 1;
        $song->save();
        $advice->delete();
        $action1->get_advice_cnt -= 1;
        $action1->save();
        $action2->all_advice_cnt -= 1;
        if ($nice_flg) { $action2->get_nice_cnt -= 1; }
        $action2->save();
    }
}