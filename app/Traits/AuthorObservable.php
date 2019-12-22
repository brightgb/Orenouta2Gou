<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 更新者情報(ID,IP)のセット
 */
trait AuthorObservable
{
    public static function bootAuthorObservable()
    {
        /**
         * 登録時
         */
        static::creating(function (Model $model) {
            $_by = empty(\Auth::user()->userid)? 'guest': \Auth::user()->userid;
            $_ip = empty(\Request::ip())? '127.0.0.1': \Request::ip();
            $model->created_by = $_by;
            $model->updated_by = $_by;
            $model->created_ip = $_ip;
            $model->updated_ip = $_ip;
        });

        /**
         * 更新時
         */
        static::updating(function (Model $model) {
            $_by = empty(\Auth::user()->userid)? 'guest': \Auth::user()->userid;
            $_ip = empty(\Request::ip())? '127.0.0.1': \Request::ip();
            $model->updated_by = $_by;
            $model->updated_ip = $_ip;
        });

        /**
         * 保存時
         */
        static::saving(function (Model $model) {
            $_by = empty(\Auth::user()->userid)? 'guest': \Auth::user()->userid;
            $_ip = empty(\Request::ip())? '127.0.0.1': \Request::ip();
            $model->updated_by = $_by;
            $model->updated_ip = $_ip;
        });

        /**
         * 削除時
         */
        static::deleting(function (Model $model) {
            //$_by = empty(\Auth::user()->userid)? 'guest': \Auth::user()->userid;
            //$_ip = empty(\Request::ip())? '127.0.0.1': \Request::ip();
            //$model->updated_by = $_by;
            //$model->updated_ip = $_ip;
        });

    }
}
