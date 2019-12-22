<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAccountCreateRequest;
use App\Http\Requests\Admin\AdminAccountUpdateRequest;
use Illuminate\Http\Request;
use App\Model\UserQuestion;
use App\Model\AdminInfo;
use App\Model\Admin;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use App\Library\OpenSslCryptor;


class ManagementController extends Controller
{
    /*
     * お問い合わせ・要望（GET）
     */
    public function index1()
    {
        return view('admin.management.request_list');
    }

    /*
     * お問い合わせ・要望（POST）
     */
    public function getList(Request $request)
    {
        $list = UserQuestion::where('status', $request->input('status'))
                            ->orderBy('created_at', 'desc')
                            ->paginate(20)->toArray();
        foreach ($list['data'] as $key => $value) {
            $list['data'][$key]['created_at'] = Carbon::parse($value['created_at'])->format('Y/m/d H:i');
            $list['data']['status'] = $value['status'];
        }
        return response()->json($list);
    }

    /*
     * ステータス変更（対応済み）
     */
    public function accept(Request $request)
    {
        $target = UserQuestion::findOrFail($request->input('data_id'));
        $target->status = 1;  // １：対応済み
        $target->save();
    }

    /*
     * ステータス変更（却下）
     */
    public function reject(Request $request)
    {
        $target = UserQuestion::findOrFail($request->input('data_id'));
        $target->status = 2;  // ２：却下
        $target->save();
    }

    /*
     * ステータス変更（復帰）
     */
    public function back(Request $request)
    {
        $target = UserQuestion::findOrFail($request->input('data_id'));
        $target->status = 0;  // ０：未対応
        $target->save();
    }

    /*
     * ステータス変更（削除）
     */
    public function delete(Request $request)
    {
        $target = UserQuestion::findOrFail($request->input('data_id'));
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
                return redirect('/admin/infomation')->with('success', '新着情報を追加しました。');
            } elseif ($key == 'result' && $value == 'delete') {
                return redirect('/admin/infomation')->with('success', '新着情報を削除しました。');
            }

        }

        $now_year = Carbon::now()->year;
        $years = [$now_year-1, $now_year, $now_year+1];
        $months = $days = [''];
        $hours = $mins = [];
        for ($i=1; $i<=12; $i++) {
            array_push($months, str_pad($i, 2, 0, STR_PAD_LEFT));
            unset($months[0]);
        }
        for ($i=1; $i<=31; $i++) {
            array_push($days, str_pad($i, 2, 0, STR_PAD_LEFT));
            unset($days[0]);
        }
        for ($i=0; $i<=23; $i++) {
            array_push($hours, str_pad($i, 2, 0, STR_PAD_LEFT));
        }
        for ($i=0; $i<=59; $i++) {
            array_push($mins, str_pad($i, 2, 0, STR_PAD_LEFT));
        }
        return view('admin.management.infomation', compact('years', 'months', 'days', 'hours', 'mins'));
    }

    /*
     * 新着情報（POST）
     */
    public function getInfo(Request $request)
    {
        $info = AdminInfo::orderBy('notify_date', 'desc')->paginate(20)->toArray();
        foreach ($info['data'] as $key => $value) {
            $info['data'][$key]['notify_date'] = Carbon::parse($value['notify_date'])->format('Y/m/d H:i');
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

        AdminInfo::create(['notify_date' => $notify_date,
                               'message' => $request->input('message')]);
    }

    /*
     * 新着情報（削除）
     */
    public function deleteInfo(Request $request)
    {
        $target = AdminInfo::findOrFail($request->input('delete_id'));
        $target->delete();
    }

    /*
     * アカウント管理（一覧）
     */
    public function index3()
    {
        $accounts = Admin::orderBy('id', 'asc')->get()->toArray();
        $obj = new OpenSslCryptor('bf-cbc');
        foreach ($accounts as $key => $value) {
            $accounts[$key]['password'] = $obj->decrypt($value['password_org']);
        }
        return view('admin.management.account', compact('accounts'));
    }

    /*
     * アカウント管理（作成）
     */
    public function createAccount()
    {
        return view('admin.management.account_create');
    }

    /*
     * アカウント管理（登録）
     */
    public function storeAccount(AdminAccountCreateRequest $request)
    {
        if (preg_match('/^( |　)+$/', $request->input('name'))) {
            return back()->withInput()
                         ->with('space_error', 'アカウント名は必ず指定してください。');
        }

        $obj = new OpenSslCryptor('bf-cbc');
        Admin::create([
            'name'         => $request->input('name'),
            'userid'       => $request->input('userid'),
            'password'     => bcrypt($request->input('password_org')),
            'password_org' => $obj->encrypt($request->input('password_org'))
        ]);

        return redirect('/admin/account')->with('success', 'アカウントを作成しました。');
    }

    /*
     * アカウント管理（編集）
     */
    public function editAccount($id)
    {
        $account = Admin::findOrFail($id);
        $obj = new OpenSslCryptor('bf-cbc');
        $account->password_org = $obj->decrypt($account->password_org);
        return view('admin.management.account_edit', compact('account'));
    }

    /*
     * アカウント管理（更新）
     */
    public function updateAccount(AdminAccountUpdateRequest $request)
    {
        if (preg_match('/^( |　)+$/', $request->input('name'))) {
            return back()->withInput()
                         ->with('space_error', 'アカウント名は必ず指定してください。');
        }

        $obj = new OpenSslCryptor('bf-cbc');
        $target = Admin::findOrFail($request->input('data_id'));
        $target->update([
            'name'         => $request->input('name'),
            'userid'       => $request->input('userid'),
            'password'     => bcrypt($request->input('password_org')),
            'password_org' => $obj->encrypt($request->input('password_org'))
        ]);

        return redirect('/admin/account')->with('success', 'アカウントを更新しました。');
    }

    /*
    * アカウント管理（削除）
    */
    public function deleteAccount(Request $request)
    {
        $target = Admin::findOrFail($request->input('delete_id'));
        $target->delete();

        return redirect('/admin/account')->with('success', 'アカウントを削除しました。');
    }
}