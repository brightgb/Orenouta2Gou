<?php
namespace App\Http\ViewComposers;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PerformerComposer
{
    protected $id;

    public function __construct()
    {
    }

    public function compose(View $view)
    {
        $my = (object) [];
        if (\Auth::user()) {
            $this->id = \Auth::user()->id;
            $query = DB::table('performer_points');
            $query->leftjoin('performers', 'performer_points.performer_id', '=', 'performers.id');
            $query->leftJoin('performer_profiles', 'performer_points.performer_id', '=', 'performer_profiles.performer_id');
            $query->where( 'performer_points.performer_id', $this->id);
            $performer = $query->first(
                [
                    'performer_points.total_point AS point',
                    'performer_profiles.nickname',
                    'performers.tweet_ng_flg',
                    'performers.bulletin_board_ng_flg'
                ]
            );
            //クレアからのお知らせメール
            $query = DB::table('info_messageboxs');
            $query->where('user_id', $this->id);
            $query->where('gender', 2);
            $query->where('read_flg', 0);
            $info_cnt = $query->count();

            //サイトからのお知らせ
            $query = DB::table('performer_infos');
            $performer_info = $query->where('performer_id', $this->id)->first(['notice_chk_last_date', 'regist_date']);
            $last_notice_checked = $performer_info->regist_date;
            if(!is_null($performer_info->notice_chk_last_date)) {
                $last_notice_checked = $performer_info->notice_chk_last_date;
            }

            $query = DB::table('admin_notifies');
            $query->whereIn('gender', [config('constKey.GENDER.PERFORMER'), config('constKey.GENDER.COMMON')]);
            $query->whereBetween('notify_date', [$last_notice_checked, Carbon::now()]);
            $notice_cnt = $query->count();

            //未読メール
            $query = DB::table('performer_messageboxs');
            $query->where('performer_id', $this->id);
            $query->leftjoin('members', 'performer_messageboxs.member_id', 'members.id');
            $query->where('read_flg', 0);
            $query->where('receiver_del_flg', 0);
            $query->where('member_stat', config('constKey.MEMBER_STAT.NORMAL'));
            $message_cnt = $query->count();
            //足あと
            $query = DB::table('performer_footstamps');
            $query->where('performer_id', $this->id);
            $query->leftjoin('members', 'performer_footstamps.member_id', 'members.id');
            $query->where('read_flg', 0);
            $query->where('member_stat', config('constKey.MEMBER_STAT.NORMAL'));
            $footstamp_cnt = $query->count();
            //未確認プレゼント
            $query = DB::table('present_histories');
            $query->where('performer_id', $this->id);
            $query->leftjoin('members', 'present_histories.member_id', 'members.id');
            $query->where('read_flg', 0);
            $query->where('member_stat', config('constKey.MEMBER_STAT.NORMAL'));
            $unchecked_present_cnt = $query->count();

            $my = (object) [
                'id'                      => $this->id,
                'point'                   => $performer->point,
                'unread_notice'           => $notice_cnt,
                'unread_info'             => $info_cnt,
                'unread_messages'         => $message_cnt,
                'unread_footstamps'       => $footstamp_cnt,
                'nickname'                => $performer->nickname,
                'unchecked_present_count' => $unchecked_present_cnt,
                'ban_tweet_flag'          => $performer->tweet_ng_flg? true: false,
                'is_banned_bbs'           => $performer->bulletin_board_ng_flg? true: false
            ];
        }
        $view->with([
            'my' => $my,
        ]);
    }
}