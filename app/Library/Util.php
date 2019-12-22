<?php
namespace App\Library;

use Carbon\Carbon;

/**
 * 関数まとめ
 */
class Util {

    /**
     * encodeId 10進数を可逆可変更する
     * @param  int $id
     * @return string
     */
    static public function encodeId(int $id)
    {
        $tmp_array = str_split($id,2);
        $deki = "";
        foreach($tmp_array as $val) {
            $deki .= rand(1,9). $val;
        }
        $tmp = base_convert( $deki, 10, 36);

        return  $tmp. substr( md5($tmp), 3, 2);
    }

    /**
     * decodeId 10進数を可逆可変更する
     * @param  string $str
     * @return int
     */
    static function decodeId(string $str){
        if(empty($str))
            return 0;

        $dej = substr($str, -2, 2);
        $str = substr($str, 0, strlen($str)-2);
        $dej2 = substr( md5($str), 3, 2);
        if($dej != $dej2) {
            return 0;
        }
        $key = base_convert( $str, 36, 10);
        $tmp_array = str_split( $key, 3);

        $int_val = "";
        foreach($tmp_array as $val) {
            $int_val .= substr( $val, 1, 2);
        }
        return $int_val;
    }

    /**
     * getMonthEnd その月の最終日を取得
     * @param  int $year
     * @param  int $month
     * @return int
     */
    static function getMonthEnd(int $year, int $month){
        if(Carbon::now()->year == $year && Carbon::now()->month == $month) {
            //未来日付は表示しない
            $day = Carbon::now()->day;
        } else {
            $day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        }
        return $day;
    }

    /**
     * getLoginStat ユーザーのログイン状態取得
     * @param $login_last_date
     * @param $wait_status
     * @param $call_wait_type
     * @return int
     */
    static function getLoginStatus($login_last_date, $wait_status, $call_wait_type, $jealousy_login = 1, $jealousy_talking = 2){
        //通話中
        if($wait_status == 1){
            if ($jealousy_talking === 0) {   //ヤキモチ防止設定でオフラインと設定
                return 0;
            }
            if ($jealousy_talking === 1) {   //ヤキモチ防止設定でログイン中と設定
                return 1;
            }
            return 2;
        }
        //待機中/音声
        if($wait_status == 0 && $call_wait_type == config('constKey.CALL_WAIT_TYPE.VOICE_WAIT')){
            if ($jealousy_talking === 0) {   //ヤキモチ防止設定でオフラインと設定
                return 0;
            }
            if ($jealousy_talking === 1) {   //ヤキモチ防止設定でログイン中と設定
                return 1;
            }
            return 3;
        }
        //待機中/TV
        if($wait_status == 0 && $call_wait_type == config('constKey.CALL_WAIT_TYPE.TV_WAIT')){
            if ($jealousy_talking === 0) {   //ヤキモチ防止設定でオフラインと設定
                return 0;
            }
            if ($jealousy_talking === 1) {   //ヤキモチ防止設定でログイン中と設定
                return 1;
            }
            return 4;
        }
        //待機中/音声・TV
        if($wait_status == 0 && $call_wait_type == config('constKey.CALL_WAIT_TYPE.VOICE_TV_WAIT')){
            if ($jealousy_talking === 0) {   //ヤキモチ防止設定でオフラインと設定
                return 0;
            }
            if ($jealousy_talking === 1) {   //ヤキモチ防止設定でログイン中と設定
                return 1;
            }
            return 5;
        }
        //ログイン中
        if($login_last_date >= Carbon::now()->subMinute(config('constKey.LOGGING_IN_PERIOD_MINUIT'))){
            if ($jealousy_login === 0) {     //ヤキモチ防止設定でオフラインと設定
                return 0;
            }
            return 1;
        }
        //オフライン
        return 0;
    }

    /**
     * getUserDevice ユーザーのデバイス取得
     *
     * @return int
     */
    static function getUserDevice(){
        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            $ua = $_SERVER['HTTP_USER_AGENT'];
            //android
            if( (strpos($ua,'Android')) !== false) {
                return config('constKey.DEVICE_TYPE.ANDROID');
            }
            //ios
            if((strpos($ua,'iPhone') !== false)  || (strpos($ua,'iPod') !== false)) {
                return config('constKey.DEVICE_TYPE.IOS');
            }
            //ガラケー
            if((strpos($ua,'DoCoMo') !== false || strpos($ua,'SoftBank') !== false || strpos($ua,'KDDI') !== false)) {
                return config('constKey.DEVICE_TYPE.FEATUREPHONE');
            }
        }
        //その他
        return config('constKey.DEVICE_TYPE.ETC');
    }

    /**
     * 祝日API
     *
     * @param $year
     * @return array
     */
    static function getHolidays($year) {
        $ch = curl_init();

        $options = array(
            CURLOPT_URL => "https://holidays-jp.github.io/api/v1/{$year}/date.json",
            CURLOPT_RETURNTRANSFER => true,
        );

        curl_setopt_array($ch, $options);

        $res = curl_exec($ch);

        return array_keys((array)json_decode($res));
    }
}
