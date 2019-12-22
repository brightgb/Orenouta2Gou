<?php

namespace App\Library;

use App\Http\Controllers\Controller;
use App\Library\Util;
use Carbon\Carbon;
use App\Model\Member;
use App\Model\PerformerInfo;
use App\Model\PerformerPoint;
use App\Model\PerformerMarketList;
use App\Model\MarketTransactionLog;
// 広告用
use App\Model\AdvertisementCode;
use App\Model\AdvertisementCodePerformerDailyWork;
use App\Model\AdvertisementCodePerformerMonthlyWork;
use App\Model\AdvertisementGroupPerformerDailyWork;
use App\Model\AdvertisementGroupPerformerMonthlyWork;


class PerformerMarketStatusCompleteApi extends Controller
{
    /**
     * マーケット管理画面で購入済み商品に対して、郵便物画像を承認したらステータスを発送済みに変える
     *
     * @param $market_id（マーケット商品のレコードid）
     *
     * @return $result（ＯＫを返す）
     */
    static function PerformerMarketStatusComplete($market_id) {

        $market = PerformerMarketList::where('id', $market_id)->first();
        $transaction = MarketTransactionLog::where('market_id', $market_id)->first();
        $member = Member::where('id', $transaction->member_id)->first();
        $now = Carbon::now();
        $now_date = $now->format('Y-m-d');
        $now_month = $now->format('Y-m');

    	// データの更新
        $market->shipping_approved_at = $now;
        $market->status = config('constKey.MARKET_GOODS_STATUS.COMPLETE');
        $market->updated_at = $now;
        $market->save();
        // 女性情報の更新
        PerformerPoint::addPoint($market->performer_id, $market->get_point, config('constKey.POINT_UPD_MODE.MARKET'),
                                 0, '', $member->userid, $market->use_point, $now);

        //広告コード
        $performer_info = PerformerInfo::where('performer_id', $market->performer_id)->first();
        if (!empty($performer_info->cm_code)) {
            $code = AdvertisementCode::where('cm_code', $performer_info->cm_code)->first();
            $code_id = $code->id;
            $group_id = $code->group_id;

            //コード別稼動集計（日別）
            $code_daily = AdvertisementCodePerformerDailyWork::where('code_id', $code_id)
                                                            ->where('record_day', $now_date)->lockForUpdate()->first();
            if (empty($code_daily)) {
                AdvertisementCodePerformerDailyWork::lockForUpdate()->create(['code_id'    => $code_id,
                                                                              'record_day' => $now_date,
                                                                              'get_point'  => $market->get_point,
                                                                              'created_at' => $now,
                                                                              'updated_at' => $now]);
            } else {
                $code_daily->get_point += $market->get_point;
                $code_daily->updated_at = $now;
                $code_daily->save();
            }
            //コード別稼動集計（月別）
            $code_monthly = AdvertisementCodePerformerMonthlyWork::where('code_id', $code_id)
                                                                ->where('record_month', $now_month)->lockForUpdate()->first();
            if (empty($code_monthly)) {
                AdvertisementCodePerformerMonthlyWork::lockForUpdate()->create(['code_id'      => $code_id,
                                                                                'record_month' => $now_month,
                                                                                'get_point'    => $market->get_point,
                                                                                'created_at'   => $now,
                                                                                'updated_at'   => $now]);
            } else {
                $code_monthly->get_point += $market->get_point;
                $code_monthly->updated_at = $now;
                $code_monthly->save();
            }
            //グループ別稼動集計（日別）
            if ($group_id != 0) {
                $group_daily = AdvertisementGroupPerformerDailyWork::where('group_id', $group_id)
                                                                ->where('record_day', $now_date)->lockForUpdate()->first();
                if (empty($group_daily)) {
                    AdvertisementGroupPerformerDailyWork::lockForUpdate()->create(['group_id'   => $group_id,
                                                                                   'record_day' => $now_date,
                                                                                   'get_point'  => $market->get_point,
                                                                                   'created_at' => $now,
                                                                                   'updated_at' => $now]);
                } else {
                    $group_daily->get_point += $market->get_point;
                    $group_daily->updated_at = $now;
                    $group_daily->save();
                }
            }
            //グループ別稼動集計（月別）
            if ($group_id != 0) {
                $group_monthly = AdvertisementGroupPerformerMonthlyWork::where('group_id', $group_id)
                                                                    ->where('record_month', $now_month)->lockForUpdate()->first();
                if (empty($group_monthly)) {
                    AdvertisementGroupPerformerMonthlyWork::lockForUpdate()->create(['group_id'     => $group_id,
                                                                                     'record_month' => $now_month,
                                                                                     'get_point'    => $market->get_point,
                                                                                     'created_at'   => $now,
                                                                                     'updated_at'   => $now]);
                } else {
                    $group_monthly->get_point += $market->get_point;
                    $group_monthly->updated_at = $now;
                    $group_monthly->save();
                }
            }
        }
    }
}