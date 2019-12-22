<?php

namespace App\Library;

use App\Http\Controllers\Controller;
use App\Library\Util;
use Carbon\Carbon;
use App\Model\Member;
use App\Model\MemberInfo;
use App\Model\MemberPoint;
use App\Model\MemberRegistApplication;
use App\Model\Performer;
use App\Model\PerformerInfo;
use App\Model\PerformerPoint;
use App\Model\PurchaseSetting;
use App\Model\PerformerInvitation;
use App\Model\InvitationPointLog;
use App\Model\TelecomCreditTransaction;
use App\Model\EDreamCreditTransaction;
use App\Model\BitcashTransaction;
use App\Model\MetappusuCCheckTransaction;
use App\Model\MetappusuConvenienceTransaction;
use App\Model\GreatSMoneyTransaction;
use App\Model\GreatGMoneyTransaction;
use App\Model\InternetEdyTransaction;
// アクセスログ用
use App\Model\RealtimeDailyAuthCount;
use App\Model\RealtimeMonthlyAuthCount;
use App\Model\ApartFirstDepositLog;
use App\Model\RealtimeDailyFirstDepositCount;
use App\Model\RealtimeMonthlyFirstDepositCount;
use App\Model\DepositLog;
use App\Model\PurchaseLog;
use App\Model\RealtimeDailyPurchaseCount;
use App\Model\RealtimeMonthlyPurchaseCount;
use App\Model\RealtimeDailyAffiliateCount;
use App\Model\RealtimeMonthlyAffiliateCount;
// 広告用
use App\Model\AdvertisementCode;
use App\Model\AdvertisementCodeMemberDailyWork;
use App\Model\AdvertisementCodeMemberMonthlyWork;
use App\Model\AdvertisementGroupMemberDailyWork;
use App\Model\AdvertisementGroupMemberMonthlyWork;
use App\Model\AdvertisementCodePerformerDailyWork;
use App\Model\AdvertisementCodePerformerMonthlyWork;
use App\Model\AdvertisementGroupPerformerDailyWork;
use App\Model\AdvertisementGroupPerformerMonthlyWork;
use App\Model\AdvertisementSale;


class PurchaseExecutionApi extends Controller
{
    /**
     * 管理画面で決済処理を実行して、各種テーブルを更新
     *
     * @param $member_id（男性のレコードid）
     * @param $pay_method （決済方法）
     * @param $company_id（決済会社テーブルのid）
     * @param $price（購入金額）
     * @param $purchase_number（決済ID）※Unique
     *
     * @return $result（ＯＫを返す）
     */
    static function purchaseExecute($member_id, $pay_method, $company_id, $price, $purchase_number)
    {
        // 必要な検索条件を準備
        $now = Carbon::now();
        $start_date1 = $now->format('Y-m-d 00:00:00');
        $end_date1 = $now->format('Y-m-d 23:59:59');
        $year = $now->year;
        $month = str_pad($now->month, 2, 0, STR_PAD_LEFT);
        $last_day = Util::getMonthEnd($year, $month);
        $start_date2 = $now->format('Y-m-01 00:00:00');
        $end_date2 = $now->format('Y-m-'.$last_day.' 23:59:59');
        $now_date = $now->format('Y-m-d');
        $now_month = $now->format('Y-m');
        $member = Member::where('id', $member_id)->first();

        // 日別と月別で購入履歴を探す（ポイントアフリ以外の決済）
        if ($pay_method != config('constKey.PAY_METHOD.AFFILIATE')) {
            $daily_log1 = DepositLog::where('created_at', '>=', $start_date1)
                                    ->where('created_at', '<=', $end_date1)
                                    ->where('member_id', $member->id)
                                    ->first();
            $daily_log2 = PurchaseLog::where('created_at', '>=', $start_date1)
                                     ->where('created_at', '<=', $end_date1)
                                     ->where('member_id', $member->id)
                                     ->where('purchase_status', config('constKey.PAY_STATUS.COMPLETE'))
                                     ->where('pay_method', '!=', config('constKey.PAY_METHOD.AFFILIATE'))
                                     ->first();
            $daily_count = RealtimeDailyPurchaseCount::where('created_at', '>=', $start_date1)
                                                     ->where('created_at', '<=', $end_date1)
                                                     ->lockForUpdate()
                                                     ->first();
            $monthly_log1 = DepositLog::where('created_at', '>=', $start_date2)
                                      ->where('created_at', '<=', $end_date2)
                                      ->where('member_id', $member->id)
                                      ->first();
            $monthly_log2 = PurchaseLog::where('created_at', '>=', $start_date2)
                                       ->where('created_at', '<=', $end_date2)
                                       ->where('member_id', $member->id)
                                       ->where('purchase_status', config('constKey.PAY_STATUS.COMPLETE'))
                                       ->where('pay_method', '!=', config('constKey.PAY_METHOD.AFFILIATE'))
                                       ->first();
            $monthly_count = RealtimeMonthlyPurchaseCount::where('created_at', '>=', $start_date2)
                                                         ->where('created_at', '<=', $end_date2)
                                                         ->lockForUpdate()
                                                         ->first();
            if (empty($daily_log1) && empty($daily_log2)) {
                // 日別リアルタイム
                if (empty($daily_count)) {
                    RealtimeDailyPurchaseCount::lockForUpdate()->create(['today_purchase_cnt' => 1,
                                                                         'created_at' => $now,
                                                                         'updated_at' => $now]);
                } else {
                    $daily_count->today_purchase_cnt += 1;
                    $daily_count->updated_at = $now;
                    $daily_count->save();
                }
            }
            if (empty($monthly_log1) && empty($monthly_log2)) {
                // 月別リアルタイム
                if (empty($monthly_count)) {
                    RealtimeMonthlyPurchaseCount::lockForUpdate()->create(['this_month_purchase_cnt' => 1,
                                                                           'created_at' => $now,
                                                                           'updated_at' => $now]);
                } else {
                    $monthly_count->this_month_purchase_cnt += 1;
                    $monthly_count->updated_at = $now;
                    $monthly_count->save();
                }
            }
        }

        // 日別と月別で購入履歴を探す（ポイントアフリ）
        else {
            $daily_log = PurchaseLog::where('created_at', '>=', $start_date1)
                                    ->where('created_at', '<=', $end_date1)
                                    ->where('member_id', $member->id)
                                    ->where('purchase_status', config('constKey.PAY_STATUS.COMPLETE'))
                                    ->where('pay_method', '=', config('constKey.PAY_METHOD.AFFILIATE'))
                                    ->first();
            $daily_count = RealtimeDailyAffiliateCount::where('created_at', '>=', $start_date1)
                                                      ->where('created_at', '<=', $end_date1)
                                                      ->lockForUpdate()
                                                      ->first();
            $monthly_log = PurchaseLog::where('created_at', '>=', $start_date2)
                                      ->where('created_at', '<=', $end_date2)
                                      ->where('member_id', $member->id)
                                      ->where('purchase_status', config('constKey.PAY_STATUS.COMPLETE'))
                                      ->where('pay_method', '=', config('constKey.PAY_METHOD.AFFILIATE'))
                                      ->first();
            $monthly_count = RealtimeMonthlyAffiliateCount::where('created_at', '>=', $start_date2)
                                                          ->where('created_at', '<=', $end_date2)
                                                          ->lockForUpdate()
                                                          ->first();
            if (empty($daily_log)) {
                // 日別リアルタイム
                if (empty($daily_count)) {
                    RealtimeDailyAffiliateCount::lockForUpdate()->create(['today_affiliate_cnt' => 1,
                                                                          'created_at' => $now,
                                                                          'updated_at' => $now]);
                } else {
                    $daily_count->today_affiliate_cnt += 1;
                    $daily_count->updated_at = $now;
                    $daily_count->save();
                }
            }
            if (empty($monthly_log)) {
                // 月別リアルタイム
                if (empty($monthly_count)) {
                    RealtimeMonthlyAffiliateCount::lockForUpdate()->create(['this_month_affiliate_cnt' => 1,
                                                                            'created_at' => $now,
                                                                            'updated_at' => $now]);
                } else {
                    $monthly_count->this_month_affiliate_cnt += 1;
                    $monthly_count->updated_at = $now;
                    $monthly_count->save();
                }
            }
        }

        //　購入設定の金額とポイントを参照（アフリは、レコード作成時にポイントあり）
        if ($pay_method != config('constKey.PAY_METHOD.AFFILIATE')) {
            $get_point = round($price / 10);
            $setting = PurchaseSetting::where('pay_method', $pay_method)
                                      ->where('price', $price)
                                      ->first();
            if (!empty($setting)) {
                $get_point = $setting->point + $setting->first_bonus;
            }
            $log = PurchaseLog::where('member_id', $member->id)
                              ->where('pay_method', $pay_method)
                              ->where('company_id', $company_id)
                              ->where('purchase_number', $purchase_number)
                              ->where('price', $price)
                              ->first();
            $log->purchase_status = config('constKey.PAY_STATUS.COMPLETE');
            $log->point = $get_point;
            $log->updated_at = $now;
            $log->save();
        } else {
            $log = PurchaseLog::where('member_id', $member->id)
                              ->where('pay_method', $pay_method)
                              ->where('company_id', $company_id)
                              ->where('purchase_number', $purchase_number)
                              ->where('price', $price)
                              ->first();
            $log->purchase_status = config('constKey.PAY_STATUS.COMPLETE');
            $log->updated_at = $now;
            $log->save();
            $get_point = $log->point;
            $mode = config('constKey.POINT_UPD_MODE.PAY_AFFILIATE');
        }

        // トランザクションの更新
        if ($company_id == config('constKey.PAY_COMPANY.TELECOM') && $pay_method == config('constKey.PAY_METHOD.CREDIT'))
        {
            $transaction = TelecomCreditTransaction::where('member_id', $member->id)
                                                   ->where('purchase_number', $purchase_number)
                                                   ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_CREDIT');
        }
        elseif ($company_id == config('constKey.PAY_COMPANY.E-DREAM') && $pay_method == config('constKey.PAY_METHOD.CREDIT'))
        {
            $transaction = EDreamCreditTransaction::where('member_id', $member->id)
                                                  ->where('purchase_number', $purchase_number)
                                                  ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_CREDIT');
        }
        elseif ($company_id == config('constKey.PAY_COMPANY.BITCASH') && $pay_method == config('constKey.PAY_METHOD.BITCASH'))
        {
            $transaction = BitcashTransaction::where('member_id', $member->id)
                                             ->where('purchase_number', $purchase_number)
                                             ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_BITCASH');
        }
        elseif ($company_id == config('constKey.PAY_COMPANY.METAPPUSU') && $pay_method == config('constKey.PAY_METHOD.CCHECK'))
        {
            $transaction = MetappusuCCheckTransaction::where('member_id', $member->id)
                                                     ->where('purchase_number', $purchase_number)
                                                     ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_CCHECK');
        }
        elseif ($company_id == config('constKey.PAY_COMPANY.METAPPUSU') && $pay_method == config('constKey.PAY_METHOD.CONVENIENCE'))
        {
            $transaction = MetappusuConvenienceTransaction::where('member_id', $member->id)
                                                          ->where('purchase_number', $purchase_number)
                                                          ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_CONVENIENCE');
        }
        elseif ($company_id == config('constKey.PAY_COMPANY.GREAT') && $pay_method == config('constKey.PAY_METHOD.SMONEY'))
        {
            $transaction = GreatSMoneyTransaction::where('member_id', $member->id)
                                                 ->where('purchase_number', $purchase_number)
                                                 ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_SMONEY');
        }
        elseif ($company_id == config('constKey.PAY_COMPANY.GREAT') && $pay_method == config('constKey.PAY_METHOD.GMONEY'))
        {
            $transaction = GreatGMoneyTransaction::where('member_id', $member->id)
                                                 ->where('purchase_number', $purchase_number)
                                                 ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_GMONEY');
        }
        elseif ($company_id == config('constKey.PAY_COMPANY.INTERNET') && $pay_method == config('constKey.PAY_METHOD.EDY'))
        {
            $transaction = InternetEdyTransaction::where('member_id', $member->id)
                                                 ->where('purchase_number', $purchase_number)
                                                 ->first();
            $transaction->transaction_status = config('constKey.TRANSACTION_STATUS.COMPLETE');
            $transaction->updated_at = $now;
            $transaction->save();
            $mode = config('constKey.POINT_UPD_MODE.PAY_EDY');
        }

        // 男性情報の更新（ポイントアフリは課金ではなく、マイレージ扱い）
        if ($pay_method != config('constKey.PAY_METHOD.AFFILIATE')) {
            $info = MemberInfo::where('member_id', $member->id)->first();
            if (empty($info->purchase_first_date)) {
                $info->purchase_first_date = $now;
            }
            $info->purchase_last_date = $now;
            $info->total_purchase += $price;
            $info->updated_at = $now;
            $info->save();
        }

        // 男性ポイントの更新
        $member_point = MemberPoint::where('member_id', $member->id)->first();
        $member_point->mode = $mode;
        $member_point->point += $get_point;
        $member_point->target_performer = '';
        $member_point->service_flg = 0;
        $member_point->memo = '';
        $member_point->updated_at = $now;
        $member_point->save();

        // 男性ランクの更新
        if ($pay_method == config('constKey.PAY_METHOD.AFFILIATE') && $member->rank_1 != 2) {
            $member->rank_1 = 1;
        } else {
            $member->rank_1 = 2;
        }
        $member->updated_at = $now;
        $member->save();

        // 初入金者かどうかを調べる（アフィリエイトは対象外）
        $first_flg = false;
        if ($pay_method != config('constKey.PAY_METHOD.AFFILIATE'))
        {
            $first_log = ApartFirstDepositLog::where('member_id', $member->id)->first();
            $daily_count = RealtimeDailyFirstDepositCount::where('created_at', '>=', $start_date1)
                                                         ->where('created_at', '<=', $end_date1)
                                                         ->lockForUpdate()
                                                         ->first();
            $monthly_count = RealtimeMonthlyFirstDepositCount::where('created_at', '>=', $start_date2)
                                                             ->where('created_at', '<=', $end_date2)
                                                             ->lockForUpdate()
                                                             ->first();
            if (empty($first_log)) {
                ApartFirstDepositLog::create(['member_id' => $member->id,
                                              'created_at' => $now,
                                              'updated_at' => $now]);
                $first_flg = true;
                // 日別リアルタイム
                if (empty($daily_count)) {
                    RealtimeDailyFirstDepositCount::lockForUpdate()->create(['today_first_deposit_cnt' => 1,
                                                                             'created_at' => $now,
                                                                             'updated_at' => $now]);
                } else {
                    $daily_count->today_first_deposit_cnt += 1;
                    $daily_count->updated_at = $now;
                    $daily_count->save();
                }
                // 月別リアルタイム
                if (empty($monthly_count)) {
                    RealtimeMonthlyFirstDepositCount::lockForUpdate()->create(['this_month_first_deposit_cnt' => 1,
                                                                               'created_at' => $now,
                                                                               'updated_at' => $now]);
                } else {
                    $monthly_count->this_month_first_deposit_cnt += 1;
                    $monthly_count->updated_at = $now;
                    $monthly_count->save();
                }
            }
        }

        // キックバック確認
        $member_regist = MemberRegistApplication::where('member_id', $member->id)
                                                ->where('invitor_gender', config('constKey.GENDER.PERFORMER'))
                                                ->first();
        if (!empty($member_regist)) {
            $performer_id = $member_regist->invitor_id;
            $performer_point = PerformerPoint::where('performer_id', $performer_id)->lockForUpdate()->first();
            $performer_point->point += round($log->price / 10);
            $performer_point->total_point += round($log->price / 10);
            $performer_point->mode = config('constKey.POINT_UPD_MODE.KICK_BACK');
            $performer_point->member_mail_use = 0;
            $performer_point->member_web_use = 0;
            $performer_point->service_flg = 0;
            $performer_point->memo = '';
            $performer_point->updated_at = $now;
            $performer_point->save();

            // 友達紹介記録を作成
            $data = [
                'invitor_id'     => $performer_id,
                'invitor_gender' => config('constKey.GENDER.PERFORMER'),
                'invitor_userid' => Performer::where('id', $performer_id)->first()->userid,
                'invited_id'     => $member->id,
                'invited_gender' => config('constKey.GENDER.MEMBER'),
                'invited_userid' => $member->userid,
                'mode'           => config('constKey.POINT_UPD_MODE.KICK_BACK'),
                'before_point'   => $performer_point->point - round($log->price / 10),
                'point'          => round($log->price / 10),
                'after_point'    => $performer_point->point,
                'created_at'     => $now,
                'updated_at'     => $now
            ];
            InvitationPointLog::create($data);
            $performer_invitation = PerformerInvitation::where('performer_id', $performer_id)
                                                       ->where('user_id', $member->id)
                                                       ->where('gender', config('constKey.GENDER.MEMBER'))
                                                       ->lockForUpdate()->first();
            $performer_invitation->invitation_point += round($log->price / 10);
            $performer_invitation->updated_at = $now;
            $performer_invitation->save();

            // 女性広告コード
            $performer_info = PerformerInfo::where('performer_id', $performer_id)->first();
            if (!empty($performer_info->cm_code)) {
                $code = AdvertisementCode::where('cm_code', $performer_info->cm_code)->first();
                $code_id = $code->id;
                $group_id = $code->group_id;

                //コード別稼動集計（日別）
                $code_daily = AdvertisementCodePerformerDailyWork::where('code_id', $code_id)
                                                                 ->where('record_day', $now_date)
                                                                 ->lockForUpdate()
                                                                 ->first();
                if (empty($code_daily)) {
                    AdvertisementCodePerformerDailyWork::lockForUpdate()->create(['code_id'    => $code_id,
                                                                                  'record_day' => $now_date,
                                                                                  'get_point'  => round($log->price / 10),
                                                                                  'created_at' => $now,
                                                                                  'updated_at' => $now]);
                } else {
                    $code_daily->get_point += round($log->price / 10);
                    $code_daily->updated_at = $now;
                    $code_daily->save();
                }
                //コード別稼動集計（月別）
                $code_monthly = AdvertisementCodePerformerMonthlyWork::where('code_id', $code_id)
                                                                     ->where('record_month', $now_month)
                                                                     ->lockForUpdate()
                                                                     ->first();
                if (empty($code_monthly)) {
                    AdvertisementCodePerformerMonthlyWork::lockForUpdate()->create(['code_id'      => $code_id,
                                                                                    'record_month' => $now_month,
                                                                                    'get_point'    => round($log->price / 10),
                                                                                    'created_at'   => $now,
                                                                                    'updated_at'   => $now]);
                } else {
                    $code_monthly->get_point += round($log->price / 10);
                    $code_monthly->updated_at = $now;
                    $code_monthly->save();
                }
                //グループ別稼動集計（日別）
                if ($group_id != 0) {
                    $group_daily = AdvertisementGroupPerformerDailyWork::where('group_id', $group_id)
                                                                       ->where('record_day', $now_date)
                                                                       ->lockForUpdate()
                                                                       ->first();
                    if (empty($group_daily)) {
                        AdvertisementGroupPerformerDailyWork::lockForUpdate()->create(['group_id'   => $group_id,
                                                                                       'record_day' => $now_date,
                                                                                       'get_point'  => round($log->price / 10),
                                                                                       'created_at' => $now,
                                                                                       'updated_at' => $now]);
                    } else {
                        $group_daily->get_point += round($log->price / 10);
                        $group_daily->updated_at = $now;
                        $group_daily->save();
                    }
                }
                //グループ別稼動集計（月別）
                if ($group_id != 0) {
                    $group_monthly = AdvertisementGroupPerformerMonthlyWork::where('group_id', $group_id)
                                                                           ->where('record_month', $now_month)
                                                                           ->lockForUpdate()
                                                                           ->first();
                    if (empty($group_monthly)) {
                        AdvertisementGroupPerformerMonthlyWork::lockForUpdate()->create(['group_id'     => $group_id,
                                                                                         'record_month' => $now_month,
                                                                                         'get_point'    => round($log->price / 10),
                                                                                         'created_at'   => $now,
                                                                                         'updated_at'   => $now]);
                    } else {
                        $group_monthly->get_point += round($log->price / 10);
                        $group_monthly->updated_at = $now;
                        $group_monthly->save();
                    }
                }
            }
        }

        // 男性広告コード
        $member_info = MemberInfo::where('member_id', $member->id)->first();
        $member_regsit_app = MemberRegistApplication::where('member_id', $member->id)->first();
        if (!empty($member_info->cm_code)) {
            $code = AdvertisementCode::where('cm_code', $member_info->cm_code)->first();
            $code_id = $code->id;
            $group_id = $code->group_id;

            //ガラケー男性の認証タイミングがある（アフリ以外でポイント初購入）
            if ($code->featurephone_timing == config('constKey.AUTH_TIMING.FIRST_PURCHASE') && $first_flg == true &&
                ($member_regsit_app->device_type == config('constKey.DEVICE_TYPE.FEATUREPHONE') ||
                 $member_regsit_app->device_type == config('constKey.DEVICE_TYPE.ETC'))) {
                //日別リアルタイムカウント
                $daily_count = RealtimeDailyAuthCount::where('created_at', '>=', $start_date1)
                                                     ->where('created_at', '<=', $end_date1)
                                                     ->where('gender', config('constKey.GENDER.MEMBER'))
                                                     ->lockForUpdate()
                                                     ->first();
                if (!empty($daily_count)) {
                    $daily_count->today_auth_cnt += 1;
                    $daily_count->updated_at = $now;
                    $daily_count->save();
                } else {
                    RealtimeDailyAuthCount::lockForUpdate()->create(['today_auth_cnt' => 1,
                                                                     'gender' => config('constKey.GENDER.MEMBER'),
                                                                     'created_at' => $now,
                                                                     'updated_at' => $now]);
                }
                //月別リアルタイムカウント
                $monthly_count = RealtimeMonthlyAuthCount::where('created_at', '>=', $start_date2)
                                                         ->where('created_at', '<=', $end_date2)
                                                         ->where('gender', config('constKey.GENDER.MEMBER'))
                                                         ->lockForUpdate()
                                                         ->first();
                if (!empty($monthly_count)) {
                    $monthly_count->this_month_auth_cnt += 1;
                    $monthly_count->updated_at = $now;
                    $monthly_count->save();
                } else {
                    RealtimeMonthlyAuthCount::lockForUpdate()->create(['this_month_auth_cnt' => 1,
                                                                       'gender' => config('constKey.GENDER.MEMBER'),
                                                                       'created_at' => $now,
                                                                       'updated_at' => $now]);
                }

                //コード別稼動集計（日別）
                $code_daily = AdvertisementCodeMemberDailyWork::where('code_id', $code_id)
                                                              ->where('record_day', $now_date)
                                                              ->lockForUpdate()
                                                              ->first();
                if (empty($code_daily)) {
                    AdvertisementCodeMemberDailyWork::lockForUpdate()->create(['code_id'     => $code_id,
                                                                               'record_day'  => $now_date,
                                                                               'auth_cnt'    => 1,
                                                                               'normal_sale' => $price,
                                                                               'total_sale'  => $price,
                                                                               'created_at'  => $now,
                                                                               'updated_at'  => $now]);
                } else {
                    $code_daily->auth_cnt += 1;
                    $code_daily->normal_sale += $price;
                    $code_daily->total_sale += $price;
                    $code_daily->updated_at = $now;
                    $code_daily->save();
                }
                //コード別稼動集計（月別）
                $code_monthly = AdvertisementCodeMemberMonthlyWork::where('code_id', $code_id)
                                                                  ->where('record_month', $now_month)
                                                                  ->lockForUpdate()
                                                                  ->first();
                if (empty($code_monthly)) {
                    AdvertisementCodeMemberMonthlyWork::lockForUpdate()->create(['code_id'      => $code_id,
                                                                                 'record_month' => $now_month,
                                                                                 'auth_cnt'     => 1,
                                                                                 'normal_sale'  => $price,
                                                                                 'total_sale'   => $price,
                                                                                 'created_at'   => $now,
                                                                                 'updated_at'   => $now]);
                } else {
                    $code_monthly->auth_cnt += 1;
                    $code_monthly->normal_sale += $price;
                    $code_monthly->total_sale += $price;
                    $code_monthly->updated_at = $now;
                    $code_monthly->save();
                }
                //グループ別稼動集計（日別）
                if ($group_id != 0) {
                    $group_daily = AdvertisementGroupMemberDailyWork::where('group_id', $group_id)
                                                                    ->where('record_day', $now_date)
                                                                    ->lockForUpdate()
                                                                    ->first();
                    if (empty($group_daily)) {
                        AdvertisementGroupMemberDailyWork::lockForUpdate()->create(['group_id'    => $group_id,
                                                                                    'record_day'  => $now_date,
                                                                                    'auth_cnt'    => 1,
                                                                                    'normal_sale' => $price,
                                                                                    'total_sale'  => $price,
                                                                                    'created_at'  => $now,
                                                                                    'updated_at'  => $now]);
                    } else {
                        $group_daily->auth_cnt += 1;
                        $group_daily->normal_sale += $price;
                        $group_daily->total_sale += $price;
                        $group_daily->updated_at = $now;
                        $group_daily->save();
                    }
                }
                //グループ別稼動集計（月別）
                if ($group_id != 0) {
                    $group_monthly = AdvertisementGroupMemberMonthlyWork::where('group_id', $group_id)
                                                                        ->where('record_month', $now_month)
                                                                        ->lockForUpdate()
                                                                        ->first();
                    if (empty($group_monthly)) {
                        AdvertisementGroupMemberMonthlyWork::lockForUpdate()->create(['group_id'     => $group_id,
                                                                                      'record_month' => $now_month,
                                                                                      'auth_cnt'     => 1,
                                                                                      'normal_sale'  => $price,
                                                                                      'total_sale'   => $price,
                                                                                      'created_at'   => $now,
                                                                                      'updated_at'   => $now]);
                    } else {
                        $group_monthly->auth_cnt += 1;
                        $group_monthly->normal_sale += $price;
                        $group_monthly->total_sale += $price;
                        $group_monthly->updated_at = $now;
                        $group_monthly->save();
                    }
                }
            }

            //スマホ男性の認証タイミングがある（アフリ以外でポイント初購入）
            elseif ($code->smartphone_timing == config('constKey.AUTH_TIMING.FIRST_PURCHASE') && $first_flg == true &&
                ($member_regsit_app->device_type == config('constKey.DEVICE_TYPE.ANDROID') ||
                 $member_regsit_app->device_type == config('constKey.DEVICE_TYPE.IOS'))) {
                //日別リアルタイムカウント
                $daily_count = RealtimeDailyAuthCount::where('created_at', '>=', $start_date1)
                                                     ->where('created_at', '<=', $end_date1)
                                                     ->where('gender', config('constKey.GENDER.MEMBER'))
                                                     ->lockForUpdate()
                                                     ->first();
                if (!empty($daily_count)) {
                    $daily_count->today_auth_cnt += 1;
                    $daily_count->updated_at = $now;
                    $daily_count->save();
                } else {
                    RealtimeDailyAuthCount::lockForUpdate()->create(['today_auth_cnt' => 1,
                                                                     'gender' => config('constKey.GENDER.MEMBER'),
                                                                     'created_at' => $now,
                                                                     'updated_at' => $now]);
                }
                //月別リアルタイムカウント
                $monthly_count = RealtimeMonthlyAuthCount::where('created_at', '>=', $start_date2)
                                                         ->where('created_at', '<=', $end_date2)
                                                         ->where('gender', config('constKey.GENDER.MEMBER'))
                                                         ->lockForUpdate()
                                                         ->first();
                if (!empty($monthly_count)) {
                    $monthly_count->this_month_auth_cnt += 1;
                    $monthly_count->updated_at = $now;
                    $monthly_count->save();
                } else {
                    RealtimeMonthlyAuthCount::lockForUpdate()->create(['this_month_auth_cnt' => 1,
                                                                       'gender' => config('constKey.GENDER.MEMBER'),
                                                                       'created_at' => $now,
                                                                       'updated_at' => $now]);
                }

                //コード別稼動集計（日別）
                $code_daily = AdvertisementCodeMemberDailyWork::where('code_id', $code_id)
                                                              ->where('record_day', $now_date)
                                                              ->lockForUpdate()
                                                              ->first();
                if (empty($code_daily)) {
                    AdvertisementCodeMemberDailyWork::lockForUpdate()->create(['code_id'     => $code_id,
                                                                               'record_day'  => $now_date,
                                                                               'auth_cnt'    => 1,
                                                                               'normal_sale' => $price,
                                                                               'total_sale'  => $price,
                                                                               'created_at'  => $now,
                                                                               'updated_at'  => $now]);
                } else {
                    $code_daily->auth_cnt += 1;
                    $code_daily->normal_sale += $price;
                    $code_daily->total_sale += $price;
                    $code_daily->updated_at = $now;
                    $code_daily->save();
                }
                //コード別稼動集計（月別）
                $code_monthly = AdvertisementCodeMemberMonthlyWork::where('code_id', $code_id)
                                                                  ->where('record_month', $now_month)
                                                                  ->lockForUpdate()
                                                                  ->first();
                if (empty($code_monthly)) {
                    AdvertisementCodeMemberMonthlyWork::lockForUpdate()->create(['code_id'      => $code_id,
                                                                                 'record_month' => $now_month,
                                                                                 'auth_cnt'     => 1,
                                                                                 'normal_sale'  => $price,
                                                                                 'total_sale'   => $price,
                                                                                 'created_at'   => $now,
                                                                                 'updated_at'   => $now]);
                } else {
                    $code_monthly->auth_cnt += 1;
                    $code_monthly->normal_sale += $price;
                    $code_monthly->total_sale += $price;
                    $code_monthly->updated_at = $now;
                    $code_monthly->save();
                }
                //グループ別稼動集計（日別）
                if ($group_id != 0) {
                    $group_daily = AdvertisementGroupMemberDailyWork::where('group_id', $group_id)
                                                                    ->where('record_day', $now_date)
                                                                    ->lockForUpdate()
                                                                    ->first();
                    if (empty($group_daily)) {
                        AdvertisementGroupMemberDailyWork::lockForUpdate()->create(['group_id'    => $group_id,
                                                                                    'record_day'  => $now_date,
                                                                                    'auth_cnt'    => 1,
                                                                                    'normal_sale' => $price,
                                                                                    'total_sale'  => $price,
                                                                                    'created_at'  => $now,
                                                                                    'updated_at'  => $now]);
                    } else {
                        $group_daily->auth_cnt += 1;
                        $group_daily->normal_sale += $price;
                        $group_daily->total_sale += $price;
                        $group_daily->updated_at = $now;
                        $group_daily->save();
                    }
                }
                //グループ別稼動集計（月別）
                if ($group_id != 0) {
                    $group_monthly = AdvertisementGroupMemberMonthlyWork::where('group_id', $group_id)
                                                                        ->where('record_month', $now_month)
                                                                        ->lockForUpdate()
                                                                        ->first();
                    if (empty($group_monthly)) {
                        AdvertisementGroupMemberMonthlyWork::lockForUpdate()->create(['group_id'     => $group_id,
                                                                                      'record_month' => $now_month,
                                                                                      'auth_cnt'     => 1,
                                                                                      'normal_sale'  => $price,
                                                                                      'total_sale'   => $price,
                                                                                      'created_at'   => $now,
                                                                                      'updated_at'   => $now]);
                    } else {
                        $group_monthly->auth_cnt += 1;
                        $group_monthly->normal_sale += $price;
                        $group_monthly->total_sale += $price;
                        $group_monthly->updated_at = $now;
                        $group_monthly->save();
                    }
                }
            }

            // 広告用売上合計のみ
            else {
                //コード別稼動集計（日別）
                $code_daily = AdvertisementCodeMemberDailyWork::where('code_id', $code_id)
                                                              ->where('record_day', $now_date)
                                                              ->lockForUpdate()
                                                              ->first();
                if ($pay_method == config('constKey.PAY_METHOD.AFFILIATE')) {
                    if (empty($code_daily)) {
                        AdvertisementCodeMemberDailyWork::lockForUpdate()->create(['code_id'        => $code_id,
                                                                                   'record_day'     => $now_date,
                                                                                   'affiliate_sale' => $price,
                                                                                   'total_sale'     => $price,
                                                                                   'created_at'     => $now,
                                                                                   'updated_at'     => $now]);
                    } else {
                        $code_daily->affiliate_sale += $price;
                        $code_daily->total_sale += $price;
                        $code_daily->updated_at = $now;
                        $code_daily->save();
                    }
                } else {
                    if (empty($code_daily)) {
                        AdvertisementCodeMemberDailyWork::lockForUpdate()->create(['code_id'     => $code_id,
                                                                                   'record_day'  => $now_date,
                                                                                   'normal_sale' => $price,
                                                                                   'total_sale'  => $price,
                                                                                   'created_at'  => $now,
                                                                                   'updated_at'  => $now]);
                    } else {
                        $code_daily->normal_sale += $price;
                        $code_daily->total_sale += $price;
                        $code_daily->updated_at = $now;
                        $code_daily->save();
                    }
                }
                //コード別稼動集計（月別）
                $code_monthly = AdvertisementCodeMemberMonthlyWork::where('code_id', $code_id)
                                                                  ->where('record_month', $now_month)
                                                                  ->lockForUpdate()
                                                                  ->first();
                if ($pay_method == config('constKey.PAY_METHOD.AFFILIATE')) {
                    if (empty($code_monthly)) {
                        AdvertisementCodeMemberMonthlyWork::lockForUpdate()->create(['code_id'        => $code_id,
                                                                                     'record_month'   => $now_month,
                                                                                     'affiliate_sale' => $price,
                                                                                     'total_sale'     => $price,
                                                                                     'created_at'     => $now,
                                                                                     'updated_at'     => $now]);
                    } else {
                        $code_monthly->affiliate_sale += $price;
                        $code_monthly->total_sale += $price;
                        $code_monthly->updated_at = $now;
                        $code_monthly->save();
                    }
                } else {
                    if (empty($code_monthly)) {
                        AdvertisementCodeMemberMonthlyWork::lockForUpdate()->create(['code_id'      => $code_id,
                                                                                     'record_month' => $now_month,
                                                                                     'normal_sale'  => $price,
                                                                                     'total_sale'   => $price,
                                                                                     'created_at'   => $now,
                                                                                     'updated_at'   => $now]);
                    } else {
                        $code_monthly->normal_sale += $price;
                        $code_monthly->total_sale += $price;
                        $code_monthly->updated_at = $now;
                        $code_monthly->save();
                    }
                }
                //グループ別稼動集計（日別）
                if ($group_id != 0) {
                    $group_daily = AdvertisementGroupMemberDailyWork::where('group_id', $group_id)
                                                                    ->where('record_day', $now_date)
                                                                    ->lockForUpdate()
                                                                    ->first();
                    if ($pay_method == config('constKey.PAY_METHOD.AFFILIATE')) {
                        if (empty($group_daily)) {
                            AdvertisementGroupMemberDailyWork::lockForUpdate()->create(['group_id'       => $group_id,
                                                                                        'record_day'     => $now_date,
                                                                                        'affiliate_sale' => $price,
                                                                                        'total_sale'     => $price,
                                                                                        'created_at'     => $now,
                                                                                        'updated_at'     => $now]);
                        } else {
                            $group_daily->affiliate_sale += $price;
                            $group_daily->total_sale += $price;
                            $group_daily->updated_at = $now;
                            $group_daily->save();
                        }
                    } else {
                        if (empty($group_daily)) {
                            AdvertisementGroupMemberDailyWork::lockForUpdate()->create(['group_id'    => $group_id,
                                                                                        'record_day'  => $now_date,
                                                                                        'normal_sale' => $price,
                                                                                        'total_sale'  => $price,
                                                                                        'created_at'  => $now,
                                                                                        'updated_at'  => $now]);
                        } else {
                            $group_daily->normal_sale += $price;
                            $group_daily->total_sale += $price;
                            $group_daily->updated_at = $now;
                            $group_daily->save();
                        }
                    }
                }
                //グループ別稼動集計（月別）
                if ($group_id != 0) {
                    $group_monthly = AdvertisementGroupMemberMonthlyWork::where('group_id', $group_id)
                                                                        ->where('record_month', $now_month)
                                                                        ->lockForUpdate()
                                                                        ->first();
                    if ($pay_method == config('constKey.PAY_METHOD.AFFILIATE')) {
                        if (empty($group_monthly)) {
                            AdvertisementGroupMemberMonthlyWork::lockForUpdate()->create(['group_id'       => $group_id,
                                                                                          'record_month'   => $now_month,
                                                                                          'affiliate_sale' => $price,
                                                                                          'total_sale'     => $price,
                                                                                          'created_at'     => $now,
                                                                                          'updated_at'     => $now]);
                        } else {
                            $group_monthly->affiliate_sale += $price;
                            $group_monthly->total_sale += $price;
                            $group_monthly->updated_at = $now;
                            $group_monthly->save();
                        }
                    } else {
                        if (empty($group_monthly)) {
                            AdvertisementGroupMemberMonthlyWork::lockForUpdate()->create(['group_id'     => $group_id,
                                                                                          'record_month' => $now_month,
                                                                                          'normal_sale'  => $price,
                                                                                          'total_sale'   => $price,
                                                                                          'created_at'   => $now,
                                                                                          'updated_at'   => $now]);
                        } else {
                            $group_monthly->normal_sale += $price;
                            $group_monthly->total_sale += $price;
                            $group_monthly->updated_at = $now;
                            $group_monthly->save();
                        }
                    }
                }
            }

            //広告売上（日別のみ）
            $sale_daily = AdvertisementSale::where('code_id', $code_id)
                                           ->where('record_day', $now_date)
                                           ->lockForUpdate()
                                           ->first();
            if (empty($sale_daily)) {
                $data = ['code_id'     => $code_id,
                         'record_day'  => $now_date,
                         'total_cnt'   => 1,
                         'total_price' => $price,
                         'created_at'  => $now,
                         'updated_at'  => $now];
                switch ($pay_method) {
                    case config('constKey.PAY_METHOD.CREDIT'):
                        $data['credit_cnt'] = 1;
                        $data['credit_price'] = $price;
                        break;
                    case config('constKey.PAY_METHOD.CCHECK'):
                        $data['c_check_cnt'] = 1;
                        $data['c_check_price'] = $price;
                        break;
                    case config('constKey.PAY_METHOD.BITCASH'):
                        $data['bitcash_cnt'] = 1;
                        $data['bitcash_price'] = $price;
                        break;
                    case config('constKey.PAY_METHOD.SMONEY'):
                        $data['s_money_cnt'] = 1;
                        $data['s_money_price'] = $price;
                        break;
                    case config('constKey.PAY_METHOD.CONVENIENCE'):
                        $data['convenience_cnt'] = 1;
                        $data['convenience_price'] = $price;
                        break;
                    case config('constKey.PAY_METHOD.EDY'):
                        $data['edy_cnt'] = 1;
                        $data['edy_price'] = $price;
                        break;
                    case config('constKey.PAY_METHOD.GMONEY'):
                        $data['g_money_cnt'] = 1;
                        $data['g_money_price'] = $price;
                        break;
                    case config('constKey.PAY_METHOD.AFFILIATE'):
                        $data['affiliate_cnt'] = 1;
                        $data['affiliate_price'] = $price;
                        break;
                }
                AdvertisementSale::lockForUpdate()->create($data);
            } else {
                switch ($pay_method) {
                    case config('constKey.PAY_METHOD.CREDIT'):
                        $sale_daily->credit_cnt += 1;
                        $sale_daily->credit_price += $price;
                        break;
                    case config('constKey.PAY_METHOD.CCHECK'):
                        $sale_daily->c_check_cnt += 1;
                        $sale_daily->c_check_price += $price;
                        break;
                    case config('constKey.PAY_METHOD.BITCASH'):
                        $sale_daily->bitcash_cnt += 1;
                        $sale_daily->bitcash_price += $price;
                        break;
                    case config('constKey.PAY_METHOD.SMONEY'):
                        $sale_daily->s_money_cnt += 1;
                        $sale_daily->s_money_price += $price;
                        break;
                    case config('constKey.PAY_METHOD.CONVENIENCE'):
                        $sale_daily->convenience_cnt += 1;
                        $sale_daily->convenience_price += $price;
                        break;
                    case config('constKey.PAY_METHOD.EDY'):
                        $sale_daily->edy_cnt += 1;
                        $sale_daily->edy_price += $price;
                        break;
                    case config('constKey.PAY_METHOD.GMONEY'):
                        $sale_daily->g_money_cnt += 1;
                        $sale_daily->g_money_price += $price;
                        break;
                    case config('constKey.PAY_METHOD.AFFILIATE'):
                        $sale_daily->affiliate_cnt += 1;
                        $sale_daily->affiliate_price += $price;
                        break;
                }
                $sale_daily->total_cnt += 1;
                $sale_daily->total_price += $price;
                $sale_daily->updated_at = $now;
                $sale_daily->save();
            }
        }

        $result = 'OK';
        return $result;
    }
}