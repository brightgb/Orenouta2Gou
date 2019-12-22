<?php
namespace App\Library;

use App\Model\Member;
use App\Model\MemberPoint;
use App\Model\PointChargeSetting;
use App\Model\PointChargeSettingCall;

/**
 * 会員課金関係
 */
class ChargeMember {

    /**
     * 会員消費ポイント取得
     * @param  int $rank
     * @param  int $mode
     * @return int point
     */
    static public function getChargePoint(int $rank, int $mode, $new)
    {
        $chargeSetting = PointChargeSetting::where('gender', 1)
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
     * 会員通話用消費ポイント取得
     *
     * @param int $rank
     * @param int $call_type
     * @return mixed
     */
    static public function getChargePointCall(int $rank, int $call_type)
    {
        $chargeSettingCall = PointChargeSettingCall::where('gender', config('constKey.GENDER.MEMBER'))
            ->where('rank_1', $rank)
            ->where('call_type', $call_type)->first();

        //キャンペーンがあれば TODO

        return $chargeSettingCall;
    }

    /**
     * 男性が最大通話可能の秒数
     *
     * @param $member_id
     * @param $call_type
     * @return int
     */
    static public function getCallTimeLimit($member_id, $call_type)
    {
        $member = Member::where('id', $member_id)->first();
        if (is_null($member)) { return 0; }

        $member_point = MemberPoint::where('member_id', $member_id)->firstOrFail();

        $chargeSettingCall = PointChargeSettingCall::where('gender', config('constKey.GENDER.MEMBER'))
            ->where('rank_1', $member->rank_1)
            ->where('call_type', $call_type)->first();

        $point_per_unit = $chargeSettingCall->normal_charge_point;
        if (!$member->app_use_flg && $member->free_dial_flg) {
            $point_per_unit += $chargeSettingCall->free_dial_point;
        }

        $max_limit = floor($member_point->point / $point_per_unit) * $chargeSettingCall->call_sec;

        return (int)$max_limit;
    }
}