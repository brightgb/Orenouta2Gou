<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Model\Song;
use App\Model\AdviceList;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class SongController extends Controller
{
    /*
     * 投稿した歌唱曲一覧
     */
    public function songList()
    {
        // １：投稿の最新順　２：投稿の古い順　３：コメントの多い順　４：コメントの少ない順　
        $sort = Input::get('sort', 1);
        if ($sort == 1) {
            $lists = Song::orderBy('created_at', 'desc')->paginate(10)->toArray();
        } elseif ($sort == 2) {
            $lists = Song::orderBy('created_at', 'asc')->paginate(10)->toArray();
        } elseif ($sort == 3) {
            $lists = Song::orderBy('advice_cnt', 'desc')->paginate(10)->toArray();
        } elseif ($sort == 4) {
            $lists = Song::orderBy('advice_cnt', 'asc')->paginate(10)->toArray();
        } else {
            return abort(404);
        }

        foreach ($lists['data'] as $key => $value) {
            $lists['data'][$key]['created_at'] = Carbon::parse($value['created_at'])
                                                       ->format('Y/m/d H:i');
            if (Carbon::parse($value['created_at']) >= Carbon::now()->subDay(7)) {
                $lists['data'][$key]['new_flg'] = true;
            } else {
                $lists['data'][$key]['new_flg'] = false;
            }
            if ($value['advice_cnt'] >= 1000) {
                $lists['data'][$key]['advice_cnt'] = '999+';
            }
        }

        $data = new LengthAwarePaginator(
            $lists['data'],
            $lists['total'],
            $lists['per_page'],
            request()->input('page', 1), array('path' => request()->url())
        );

        $title = '投稿した歌唱曲一覧';
        return view('my_song.song_list', compact('title', 'data', 'sort'));
    }

    /*
     * 投稿した歌唱曲詳細
     */
    public function songDetail($id)
    {
        $song = Song::findOrFail($id);
        $advice_list = AdviceList::where('song_id', $id)->orderBy('created_at', 'desc')
                                 ->get()->toArray();
        if (mb_strlen($song->title) > 15) {
            $song->title = mb_substr($song->title, 0, 14).'...';
        }
        $title = '投稿した歌唱曲詳細';
        return view('my_song.song_detail', compact('title', 'song', 'advice_list'));
    }

    /*
     * アドバイス送信
     */
    public function post(Request $request)
    {
        $song = Song::findOrFail($request->input('song_id'));
        $song->advice_cnt += 1;
        $song->save();
        AdviceList::create([
            'song_id' => $request->input('song_id'),
            'advice'  => nl2br($request->input('advice'))
        ]);
        return redirect('/song_detail/'.$request->input('song_id'));
    }
}