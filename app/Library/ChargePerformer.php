<?php
namespace App\Library;

use App\Model\PointChargeSetting;
use App\Model\PointChargeSettingCall;

/**
 * 会員課金関係
 */
class ChargePerformer {

    /**
     * 出演者報酬ポイント取得
     * @param  int $rank
     * @param  int $mode
     * @return int point
     */
    static public function getChargePoint(int $rank, int $mode, $new)
    {
        $chargeSetting = PointChargeSetting::where('gender', 2)
            ->where('rank_1', $rank)
            ->where('mode', $mode)->first();

        $point = $chargeSetting->normal_charge_point;
        //新人なら
        if($new) {
            $point = $chargeSetting->new_member_charge_point;
        }

        //キャンペーンがあれば TODO

        return  $point;
    }

    /**
     * 出演者通話用の報酬ポイント取得
     *
     * @param int $rank
     * @param $call_type
     * @return mixed
     */
    static public function getChargePointCall(int $rank, int $call_type)
    {
        $chargeSettingCall = PointChargeSettingCall::where('gender', config('constKey.GENDER.PERFORMER'))
            ->where('rank_1', $rank)
            ->where('call_type', $call_type)->first();

        //キャンペーンがあれば TODO

        return $chargeSettingCall;
    }
}