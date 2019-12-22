<?php

namespace App\Jobs;

use App\Library\Mailer;
use App\Model\AdminMessageTemplate;
use App\Model\AdminNotify;
use App\Model\Member;
use App\Model\Performer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AdminInfoNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger()->info("It works! | ".$this->id);
        $admin_notify = AdminNotify::find($this->id);
        $members = array();
        $performers = array();
        $mail_tr_members = array();
        $mail_tr_performers = array();
        //通知対象のユーザーリスト と メール転送対象のユーザーリスト取得
        if($admin_notify->gender == config('constKey.GENDER.MEMBER') || $admin_notify->gender == 3) {
            //通知対象の会員リスト取得
            $members = Member::leftJoin('member_infos', 'members.id', 'member_infos.member_id')
                ->where('members.member_stat', config('constKey.MEMBER_STAT.NORMAL'))
                ->where('member_infos.notification_info', 1)
                ->pluck('members.userid')
                ->toArray();
            //メール転送対象の会員リスト取得
            $mail_tr_members = Member::leftJoin('member_infos', 'members.id', 'member_infos.member_id')
                ->where('members.member_stat', config('constKey.MEMBER_STAT.NORMAL'))
                ->where('member_infos.siteinfo_mail_transfer', 1)
                ->selectRaw('members.id AS member_id, members.email')
                ->get()
                ->toArray();
        }
        if($admin_notify->gender == config('constKey.GENDER.PERFORMER') || $admin_notify->gender == 3) {
            //通知対象の出演者リスト取得
            $performers = Performer::leftJoin('performer_infos', 'performers.id', 'performer_infos.performer_id')
                ->where('performers.performer_stat', config('constKey.PERFORMER_STAT.NORMAL'))
                ->where('performer_infos.notification_info', 1)
                ->pluck('performers.userid')
                ->toArray();
            //通知対象の出演者リスト取得
            $mail_tr_performers = Performer::leftJoin('performer_infos', 'performers.id', 'performer_infos.performer_id')
                ->where('performers.performer_stat', config('constKey.PERFORMER_STAT.NORMAL'))
                ->where('performer_infos.siteinfo_mail_transfer', 1)
                ->selectRaw('performers.id AS performer_id, performers.email')
                ->get()
                ->toArray();
        }
        //通知処理
        foreach($members as $userid) {
            $app_url = config('app.url');

            $cmd = "curl -X POST -F 'sid={$userid}' -F 'url={$app_url}/member/info' -F 'msg=サイトからのお知らせを受信しました。' -F 'site=12345' http://210.148.155.108/api/push_notification";
            shell_exec($cmd);
        }
        foreach($performers as $userid) {
            $app_url = config('app.url');

            $cmd = "curl -X POST -F 'sid={$userid}' -F 'url={$app_url}/performer/info' -F 'msg=サイトからのお知らせを受信しました。' -F 'site=12345' http://210.148.155.108/api/push_notification";
            shell_exec($cmd);
        }

        //メール転送処理
        $message_data = [
            'title' => $admin_notify->title,
            'body'  => $admin_notify->message
        ];
        $subject = '[クレア] サイトからのお知らせ';
        $template = AdminMessageTemplate::where('template_name', 'サイトからのお知らせ')->firstOrFail();
        $template_id = $template->id;   //サイトからのお知らせのテンプレートID
        foreach($mail_tr_members as $value) {
            $forward_time_check = Mailer::forwardTimeCheck($value['member_id'], config('constKey.GENDER.MEMBER'));
            if ($forward_time_check) {
                // TODO:メールテンプレートにtitleとbody用の置換番号
                Mailer::templateMailSend($template_id, $mail_tr_members->member_id, config('constKey.GENDER.MEMBER'));
            }
        }
        foreach($mail_tr_performers as $value) {
            $forward_time_check = Mailer::forwardTimeCheck($value['performer_id'], config('constKey.GENDER.PERFORMER'));
            if ($forward_time_check) {
                // TODO:メールテンプレートにtitleとbody用の置換番号
                Mailer::templateMailSend($template_id, $mail_tr_performers->performer_id, config('constKey.GENDER.PERFORMER'));
            }
        }
    }
}
