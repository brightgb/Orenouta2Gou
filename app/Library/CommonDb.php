<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CommonDb
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * [update]
     * @param  string  $table      [description]
     * @param  array   $column     [description]
     * @param  string  $updated_by [description]
     * @param  array   $option     [description]
     * @return int     $cnt        Update count
     */
    static public function update( $table, $column, $updated_by, $option)
    {
        //DB::enableQueryLog();
        $query = DB::table($table);
        foreach($option as $key => $val)
        {
            $where = explode(':', $key);
            $query->where( $where[0], empty($where[1])? '=': $where[1], $val);
        }
        $data = self::updateData($column, $updated_by);
        $cnt = $query->update($data);
        //$query_log = DB::getQueryLog();
        return $cnt;
    }

    /**
     * [insert]
     * @param  string  $table      [description]
     * @param  array   $column     [description]
     * @param  string  $created_by [description]
     * @return int     $cnt        Update count
     */
    static public function insert( $table, $column, $created_by)
    {
        //DB::enableQueryLog();
        $query = DB::table($table);
        $data = self::insertData($column, $created_by);
        $cnt = $query->insert($data);

        return DB::getPdo()->lastInsertId();
    }

    /**
     * [updateOrCreate] Eloquent\Model::updateOrCreate
     * @param  string  $table      [description]
     * @param  array   $column     [description]
     * @param  string  $updated_by [description]
     * @param  array   $option     [description]
     * @return int     $cnt        Update count
     */
    static public function updateOrCreate( $table, $column, $updated_by, $option)
    {
        $cnt = CommonDb::update( $table, $column, $updated_by, $option);
        //ないのでインサート
        if (empty($cnt)) {
            foreach ($option as $key => $val) {
                $column[$key] = $val;
            }
            $cnt = CommonDb::insert( $table, $column, $updated_by);
        }
        return $cnt;
    }

    /**
     * アップデートデータの作成
     * @param  array   $column     [description]
     * @param  string  $updated_by [description]
     * @return array   $data
     */
    static public function updateData($column = [], $updated_by = '')
    {
        $column = self::updateColumn( $column, $updated_by);
        $data = [];
        foreach($column as $key => $val) {
            $operation = explode(':', $key);
            if ( empty($operation[1]) ) {
                $data[$key] = $val;
            } else {
                switch($operation[1]){
                    case 'incriment':
                        $data[$operation[0]] = DB::raw( $operation[0].' + ' .$val);
                        break;
                    case 'decriment':
                        $data[$operation[0]] = DB::raw( $operation[0].' - ' .$val);
                        break;
                    case 'bigger':
                        $data[$operation[0]] = DB::raw('IF('. $operation[0]. ' > '. $val. ', '. $operation[0]. ', '. $val. ')');
                        break;
                    case 'smaller':
                        $data[$operation[0]] = DB::raw('IF('. $operation[0]. ' < '. $val. ', '. $operation[0]. ', '. $val. ')');
                        break;
                    case 'now':
                        $data[$operation[0]] = DB::raw('NOW()');
                        break;
                    case 'ifnull':
                        $data[$operation[0]] = DB::raw('IF('. $operation[0]. ' , '. $operation[0]. ', \''. $val. '\')');
                        break;
                    case 'raw':
                        $data[$operation[0]] = DB::raw($val);
                        break;
                    default:
                        $data[$operation[0]] = $val;
                        break;
                }
            }
        }
        return $data;
    }

    /**
     * インサートデータの作成
     * @param  array   $column     [description]
     * @param  string  $created_by [description]
     * @return array   $data
     */
    static public function insertData($column = [], $created_by = '')
    {
        //更新情報
        $column = self::updateColumn( $column, $created_by);
        $column = self::insertColumn( $column, $created_by);

        $data = [];
        foreach($column as $key => $val)
        {
            $operation = explode(':', $key);
            if ( empty($operation[1]) ) {
                $data[$key] = $val;
            } else {
                switch($operation[1]){
                    case 'now':
                        $data[$operation[0]] = DB::raw('NOW()');
                        break;
                    case 'raw':
                        $data[$operation[0]] = DB::raw($val);
                        break;
                    default:
                        $data[$operation[0]] = $val;
                        break;
                }
            }
        }
        return $data;
    }

    /**
     * 更新者情報を追加
     * @param  array   $column     [description]
     * @param  string  $updated_by [description]
     * @return array   $data
     */
     static public function updateColumn($column = [], $updated_by = '')
     {
         if (!array_key_exists( 'updated_at', $column)) {
             $column['updated_at:now'] = '';
         }
         if (!array_key_exists( 'updated_by', $column)) {
             $_by = empty(Auth::user()->userid)? 'guest': Auth::user()->userid;
             $column['updated_by'] = empty($updated_by)? $_by: $updated_by;
         }
         if (!array_key_exists( 'updated_ip', $column)) {
             $column['updated_ip'] = empty(\Request::ip())? '0.0.0.0': \Request::ip();
         }

         return $column;
     }

     /**
      * 更新者情報を追加
      * @param  array   $column     [description]
      * @param  string  $created_by [description]
      * @return array   $data
      */
      static public function insertColumn($column = [], $created_by = '')
      {
          if (!array_key_exists( 'created_at', $column)) {
              $column['created_at:now'] = '';
          }
          if (!array_key_exists( 'created_by', $column)) {
              $_by = empty(Auth::user()->userid)? 'guest': Auth::user()->userid;
              $column['created_by'] = empty($created_by)? $_by: $created_by;
          }
          if (!array_key_exists( 'created_ip', $column)) {
              $column['created_ip'] = empty(\Request::ip())? '0.0.0.0': \Request::ip();
          }

          return $column;
      }

}
