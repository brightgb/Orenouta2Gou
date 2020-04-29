<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Song;
use App\Model\AdviceList;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;


class SongUserController extends Controller
{
    /*
     * 会員検索
     */
    public function index1()
    {
        return view('admin.song.user_list');
    }










    /*
     * 歌唱曲一覧（GET）
     */
    public function index()
    {
        return view('admin.song.song_list');
    }

    /*
     * 歌唱曲一覧（POST）
     */
    public function getList(Request $request)
    {
        $song = new Song;
        if ($request->input('title') != '') {
            $song = $song->where('title', 'like', '%'.$request->input('title').'%');
        }
        switch ($request->input('sort')) {
            case 1:
                $list = $song->orderBy('updated_at', 'desc')->paginate(20)->toArray();
                break;
            case 2:
                $list = $song->orderBy('updated_at', 'asc')->paginate(20)->toArray();
                break;
            case 3:
                $list = $song->orderBy('advice_cnt', 'desc')->paginate(20)->toArray();
                break;
            case 4:
                $list = $song->orderBy('advice_cnt', 'asc')->paginate(20)->toArray();
                break;
            default:  // 選択肢以外の数字が不正入力された場合
                return abort(404);
                break;
        }
        foreach ($list['data'] as $key => $value) {
            $list['data'][$key]['created_at'] = Carbon::parse($value['created_at'])->format('Y/m/d H:i');
            $list['data'][$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('Y/m/d H:i');
            if (mb_strlen($value['title']) > 21) {
                $list['data'][$key]['title'] = mb_substr($value['title'], 0, 20).'...';
            }
        }
        return response()->json($list);
    }

    /*
     * コメント一覧（GET）
     */
    public function index2()
    {
        $id = Input::get('id', Null);
        $title = Input::get('title', Null);
        return view('admin.song.comment_list', compact('id', 'title', 'song'));
    }

    /*
     * コメント一覧（POST）
     */
    public function getComment(Request $request)
    {
        $song = Song::leftjoin('advice_lists', 'songs.id', 'advice_lists.song_id')
                    ->selectRaw('songs.id AS id,
                                 songs.title,
                                 songs.file_name,
                                 advice_lists.id AS advice_id,
                                 advice_lists.advice,
                                 advice_lists.created_at');
        if (!empty($request->input('song_id'))) {
            $song = $song->where('songs.id', $request->input('song_id'));
        }
        elseif (!empty($request->input('title'))) {
            $title = Song::where('songs.title', 'like', '%'.$request->input('title').'%')->first();
            if (!empty($title)) {
                $song = $song->where('songs.title', $title->title);
            } else {
                $song = $song->whereNull('songs.id')->whereNull('songs.title');
            }
        } else {
            $song = $song->whereNull('songs.id')->whereNull('songs.title');
        }
        $list = $song->orderBy('advice_lists.created_at', 'desc')->paginate(20)->toArray();

        foreach ($list['data'] as $key => $value) {
            $list['data'][$key]['created_at'] = Carbon::parse($value['created_at'])->format('Y/m/d H:i');
            $list['data']['id'] = $value['id'];
            $list['data']['title'] = $value['title'];
            $list['data']['file'] = $value['file_name'];
        }
        return response()->json($list);
    }

    /*
     * コメントの削除
     */
    public function deleteComment(Request $request)
    {
        $song = Song::findOrFail($request->input('song_id'));
        $song->advice_cnt -= 1;
        $song->save();
        $target = AdviceList::findOrFail($request->input('delete_id'));
        $target->delete();
    }
}