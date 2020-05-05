<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\SongUserQuestion;
use App\Model\AdminInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;


class SongManagementController extends Controller
{
    /*
     * お問い合わせ・要望（GET）
     */
    public function index1()
    {
        return view('admin.song.request_list');
    }

    /*
     * お問い合わせ・要望（POST）
     */
    public function getList(Request $request)
    {
        $list = SongUserQuestion::leftjoin('song_users', 'song_user_questions.member_id', 'song_users.id')->selectRaw('song_users.nickname,
                                        song_user_questions.id AS id,
                                        song_user_questions.question,
                                        song_user_questions.status,
                                        song_user_questions.created_at,
                                        song_user_questions.updated_at')
                           ->where('song_user_questions.status', $request->input('status'))
                           ->orderBy('song_user_questions.created_at', 'desc')
                           ->paginate(20)->toArray();
        foreach ($list['data'] as $key => $value) {
            $list['data'][$key]['created_at'] = Carbon::parse($value['created_at'])->format('Y/m/d H:i');
            $list['data'][$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('Y/m/d H:i');
            $list['data'][$key]['question'] = nl2br($value['question']);
            $list['data']['status'] = $value['status'];
        }
        return response()->json($list);
    }

    /*
     * ステータス変更（対応中）
     */
    public function accept(Request $request)
    {
        $target = SongUserQuestion::lockForUpdate()->findOrFail($request->input('data_id'));
        $target->status = 1;  // １：対応中
        $target->save();
    }

    /*
     * ステータス変更（却下）
     */
    public function reject(Request $request)
    {
        $target = SongUserQuestion::lockForUpdate()->findOrFail($request->input('data_id'));
        $target->status = 3;  // ３：却下
        $target->save();
    }

    /*
     * ステータス変更（対応完了）
     */
    public function complete(Request $request)
    {
        $target = SongUserQuestion::lockForUpdate()->findOrFail($request->input('data_id'));
        $target->status = 2;  // ２：対応完了
        $target->save();
    }

    /*
     * ステータス変更（復帰）
     */
    public function back(Request $request)
    {
        $target = SongUserQuestion::lockForUpdate()->findOrFail($request->input('data_id'));
        $target->status = 0;  // ０：未対応
        $target->save();
    }

    /*
     * ステータス変更（削除）
     */
    public function delete(Request $request)
    {
        $target = SongUserQuestion::lockForUpdate()->findOrFail($request->input('data_id'));
        $target->delete();
    }

    /*
     * 新着情報（GET）
     */
    public function index2()
    {
        // GETパラメータのチェック
        $params = Input::all();
        foreach ($params as $key => $value) {
            if ($key == 'result' && $value == 'success') {
                return redirect('/admin/orenouta/infomation')->with('success', '新着情報を追加しました。');
            } elseif ($key == 'result' && $value == 'delete') {
                return redirect('/admin/orenouta/infomation')->with('success', '新着情報を削除しました。');
            }
        }

        $now_year = Carbon::now()->year;
        $years = [$now_year-1, $now_year, $now_year+1];
        $months = $hours = $mins = [];
        for ($i=1; $i<=12; $i++) {
            $months[$i] = str_pad($i, 2, 0, STR_PAD_LEFT);
        }
        for ($i=0; $i<=23; $i++) {
            array_push($hours, str_pad($i, 2, 0, STR_PAD_LEFT));
        }
        for ($i=0; $i<=59; $i++) {
            array_push($mins, str_pad($i, 2, 0, STR_PAD_LEFT));
        }
        return view('admin.song.infomation', compact('years', 'months', 'hours', 'mins'));
    }

    /*
     * 新着情報（POST）
     */
    public function getInfo(Request $request)
    {
        $info = AdminInfo::where('notify_type', 1)
                         ->orderBy('notify_date', 'desc')->paginate(20)->toArray();
        foreach ($info['data'] as $key => $value) {
            $info['data'][$key]['notify_date'] = Carbon::parse($value['notify_date'])->format('Y/m/d H:i');
            $info['data'][$key]['message'] = nl2br($value['message']);
        }
        return response()->json($info);
    }

    /*
     * 新着情報（追加）
     */
    public function addInfo(Request $request)
    {
        $year = $request->input('year');
        $month = str_pad($request->input('month'), 2, 0, STR_PAD_LEFT);
        $day = str_pad($request->input('day'), 2, 0, STR_PAD_LEFT);
        $hour = str_pad($request->input('hour'), 2, 0, STR_PAD_LEFT);
        $min = str_pad($request->input('min'), 2, 0, STR_PAD_LEFT);
        $notify_date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':00';

        AdminInfo::create(['notify_type' => 1,
                           'notify_date' => $notify_date,
                               'message' => $request->input('message')]);
    }

    /*
     * 新着情報（削除）
     */
    public function deleteInfo(Request $request)
    {
        $target = AdminInfo::lockForUpdate()->findOrFail($request->input('delete_id'));
        $target->delete();
    }
}