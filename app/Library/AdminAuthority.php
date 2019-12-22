<?php

namespace App\Library;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class AdminAuthority extends Controller
{

    /**
     * Check a botton permission.
     *
     * @param string
     * @return list[ isCreate, isEdit, isDestory]
     */
    static public function permissionCheck(string $permission)
    {
        if ( !Gate::allows('developer') && !Gate::allows('all_allow') && !Gate::allows($permission)) {
            return false;
        }

        return true;
    }


    /**
     * Check a CURD botton role.
     *
     * @param string
     * @return array[ isShow, isEdit, isCreate, isDestory]
     */
    static public function AuthorityCURD(string $model)
    {
        $create = false;
        if ( Gate::allows('developer') || Gate::allows('all_allow') || Gate::allows($model.'.create')) {
            $create = true;
        }

        $edit = false;
        if ( Gate::allows('developer') || Gate::allows('all_allow') || Gate::allows($model.'.edit')) {
            $edit = true;
        }

        $show = false;
        if ( Gate::allows('developer') || Gate::allows('all_allow') || Gate::allows($model.'.show')) {
            $show = true;
        }

        $delete = false;
        if ( Gate::allows('developer') || Gate::allows('all_allow') || Gate::allows($model.'.destory')) {
            $delete = true;
        }

        return [
            'createPermit' => $create,
            'editPermit'   => $edit,
            'showPermit'   => $show,
            'deletePermit' => $delete,
        ];

    }

}
