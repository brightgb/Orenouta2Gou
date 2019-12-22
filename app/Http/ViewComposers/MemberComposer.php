<?php
namespace App\Http\ViewComposers;

use App\Library\Util;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class MemberComposer
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
            $query = DB::table('member_points');
            $query->leftJoin('member_profiles', 'member_points.member_id', '=', 'member_profiles.member_id');
            $query->leftJoin('members', 'member_points.member_id', '=', 'members.id');
            $query->where( 'member_points.member_id', $this->id);
            $member = $query->first(
                [
                    'member_points.point',
                    'member_profiles.nickname',
                    'member_profiles.birthday',
                    'member_profiles.area',
                    'member_profiles.waiting_message',
                    'comment',
                    'members.blog_ng_flg',
                    'members.bulletin_board_ng_flg',
                    'members.rank_1'
                ]
            );
            $age = Carbon::parse($member->birthday)->age;
            //クレアからのお知らせメール
            $query = DB::table('info_messageboxs');
            $query->where('user_id', $this->id);
            $query->where('gender', 1);
            $query->where('read_flg', 0);
            $info_cnt = $query->count();

            //サイトからのお知らせ
            $query = DB::table('member_infos');
            $member_info = $query->where('member_id', $this->id)->first(['notice_chk_last_date', 'regist_date', 'blog_main_title']);
            $last_notice_checked = $member_info->regist_date;
            if(!is_null($member_info->notice_chk_last_date)) {
                $last_notice_checked = $member_info->notice_chk_last_date;
            }

            $query = DB::table('admin_notifies');
            $query->whereIn('gender', [config('constKey.GENDER.MEMBER'), config('constKey.GENDER.COMMON')]);
            $query->whereBetween('notify_date', [$last_notice_checked, Carbon::now()]);
            $notice_cnt = $query->count();

            //未読メール
            $query = DB::table('member_messageboxs');
            $query->where('member_id', $this->id);
            $query->leftjoin('performers', 'member_messageboxs.performer_id', 'performers.id');
            $query->where('read_flg', 0);
            $query->where('receiver_del_flg', 0);
            $query->where('performer_stat', config('constKey.PERFORMER_STAT.NORMAL'));
            $message_cnt = $query->count();
            //足あと
            $query = DB::table('member_footstamps');
            $query->where('member_id', $this->id);
            $query->leftjoin('performers', 'member_footstamps.performer_id', 'performers.id');
            $query->where('read_flg', 0);
            $query->where('performer_stat', config('constKey.PERFORMER_STAT.NORMAL'));
            $footstamp_cnt = $query->count();

            //待機中確認
            $query = DB::table('call_waitings');
            $query->where('user_id', $this->id);
            $query->where('gender', config('constKey.GENDER.MEMBER'));
            $query->where('waiting_start_date', '<=', Carbon::now());
            $query->where('waiting_end_date', '>=', Carbon::now());
            $waiting_count = $query->count();

            $my = (object) [
                'id'                => $this->id,
                'login_id'          => \Auth::user()->userid,
                'address'           => \Auth::user()->email,
                'email_stat'        => \Auth::user()->email_stat,
                'tel'               => \Auth::user()->tel,
                'tel_stat'          => \Auth::user()->tel_stat,
                'device'            => Util::getUserDevice(),
                'point'             => $member->point,
                'area'              => ($member->area >= 1 && $member->area <= 47) ? $member->area : 0,
                'unread_info'       => $info_cnt,
                'unread_notice'     => $notice_cnt,
                'unread_messages'   => $message_cnt,
                'unread_footstamps' => $footstamp_cnt,
                'nickname'          => $member->nickname,
                'age'               => $age,
                'app_register_flag' => \Auth::user()->app_regist_flg,
                'app_use_flag'      => \Auth::user()->app_use_flg,
                'free_dial_flag'    => \Auth::user()->free_dial_flg,
                'comment'           => $member->comment,
                'waiting_comment'   => $member->waiting_message,
                'waiting_stat'      => $waiting_count ? true : false,
                'blog_title'        => $member_info->blog_main_title,
                'ban_bbs_flag'      => $member->bulletin_board_ng_flg,
                'rank'              => $member->rank_1
            ];
        }
        $view->with([
            'my' => $my,
        ]);
    }
}