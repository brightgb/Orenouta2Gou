<?php

namespace App\Library;

use App\Model\AdminMessageTemplate;
use App\Model\Member;
use App\Model\MemberInfo;
use App\Model\Performer;
use App\Model\PerformerInfo;
use Carbon\Carbon;

class Mailer
{
    /**
     * 転送時間チェック
     *
     * @param $user_id
     * @param $gender
     * @return bool
     */
    static function forwardTimeCheck($user_id, $gender) {
        if ($gender == config('constKey.GENDER.PERFORMER')) {
            $info = PerformerInfo::where('performer_id', $user_id)->first();
        } else {
            $info = MemberInfo::where('member_id', $user_id)->first();
        }

        $transfer_time_from = $info->transfer_time_from;
        $transfer_time_to = $info->transfer_time_to;

        if ($transfer_time_from%2 == 0) {
            $time_from = sprintf('%02d:00:00', $transfer_time_from/2);
        } else {
            $time_from = sprintf('%02d:30:00', $transfer_time_from/2);
        }
        if ($transfer_time_to%2 == 0) {
            $time_to = sprintf('%02d:00:00', $transfer_time_to/2);
        } else {
            $time_to = sprintf('%02d:30:00', $transfer_time_to/2);
        }
        if($transfer_time_from > $transfer_time_to) {
            $time_from = str_replace('00:00:00', $time_from, Carbon::today());
            $time_to = str_replace('00:00:00', $time_to, Carbon::tomorrow());
        } else {
            $time_from = str_replace('00:00:00', $time_from, Carbon::today());
            $time_to = str_replace('00:00:00', $time_to, Carbon::today());
        }

        if(Carbon::now() >= $time_from && Carbon::now() <= $time_to) {
            return true;
        } else {
            return false;
        }

    }




    static function templateMailSend($template_no, $receiver_id, $gender, $sender_id = '')
    {
        // テンプレートファイル取得
        $template = AdminMessageTemplate::find($template_no);
        if(is_null($template)) {
            return false;
        }

        $body_template = $template->file_name;
        $template_name = $template->template_name;

        if ($gender == config('constKey.GENDER.MEMBER')) {  //受信者は男性の場合
            // ユーザー(受信者)情報取得
            $users = Member::leftJoin('member_profiles', 'members.id', 'member_profiles.member_id')
                ->selectRaw('
                members.email,
                members.userid,
                members.password_org,
                member_profiles.nickname,
                member_profiles.area,
                member_profiles.body_style
            ')
                ->whereIn('members.id', $receiver_id)
                ->where('members.member_stat', config('constKey.MEMBER_STAT.NORMAL'))
                ->where('member_profiles.profile_stat', 1)
                ->where('members.email_stat', 1)
                ->get();

            if (is_null($users)) {
                return false;
            }

            // 送信者情報取得
            if ($sender_id != '') {
                $sender = Performer::leftJoin('performer_profiles', 'performers.id', 'performer_profiles.performer_id')
                    ->leftJoin('performer_profile_imgs', function ($join) {
                        $join->on('performers.id', 'performer_profile_imgs.performer_id');
                        $join->where('performer_profile_imgs.img_stat', config('constKey.IMG_STAT.RELEASE'));
                        $join->where('performer_profile_imgs.prof_top_flg', 1);
                    })
                    ->selectRaw('
                        performers.id,
                        performer_profiles.nickname,
                        performers.userid,
                        performer_profile_imgs.img_file,
                        performer_profile_imgs.updated_at
                    ')
                    ->where('performers.id', $sender_id)
                    ->where('performers.performer_stat', config('constKey.PERFORMER_STAT.NORMAL'))
                    ->where('performer_profiles.profile_stat', 1)
                    ->first();
                if (!is_null($sender)) {
                    $sender->img_path = ImageProc::imageCacheUrl($sender->img_file, 'm') . '?' . strtotime($sender->updated_at);
                } else {
                    $sender = (object)[
                        'nickname' => '送信者ハンドル名',
                        'userid' => '送信者ログインID',
                        'img_path' => '送信者画像パス'
                    ];
                }
            } else {
                $sender = (object)[
                    'nickname' => '送信者ハンドル名',
                    'userid' => '送信者ログインID',
                    'img_path' => '送信者画像パス'
                ];
            }

            // replacements array作成
            $cryptor = new OpenSslCryptor('bf-cbc');
            $replacements = array();
            foreach ($users as $user) {
                $replacements[$user->email] = array (
                    '%%1%%' => $user->email,
                    '%%2%%' => $user->userid,
                    '%%3%%' => $cryptor->decrypt($user->password_org),
                    '%%4%%' => $user->nickname,
                    '%%5%%' => $sender->nickname,
                    '%%6%%' => $sender->id,
                    '%%7%%' => $sender->img_path,
                    '%%8%%' => config('constLabel.area.'.$user->area),
                    '%%9%%' => config('constLabel.member_profiles.body_style.'.$user->body_style),
                    '%%10%%' => 'NONE',
                    '%%11%%' => 'NONE',
                    '%%12%%' => env('APP_URL')
                );
            }
        } else {    //受信者は女性の場合
            // ユーザー(受信者)情報取得
            $users = Performer::leftJoin('performer_profiles', 'performers.id', 'performer_profiles.performer_id')
                ->selectRaw('
                performers.email,
                performers.userid,
                performers.password_org,
                performer_profiles.nickname,
                performer_profiles.area,
                performer_profiles.body_style
            ')
                ->whereIn('performers.id', $receiver_id)
                ->get();

            if (is_null($users)) {
                return false;
            }

            // 送信者情報取得
            if ($sender_id != '') {
                $sender = Member::leftJoin('member_profiles', 'members.id', 'member_profiles.member_id')
                    ->leftJoin('member_profile_imgs', function ($join) {
                        $join->on('members.id', 'member_profile_imgs.member_id');
                        $join->where('member_profile_imgs.img_stat', config('constKey.IMG_STAT.RELEASE'));
                    })
                    ->selectRaw('
                        member_profiles.nickname,
                        members.userid,
                        member_profile_imgs.img_file,
                        member_profile_imgs.updated_at
                    ')
                    ->where('members.id', $sender_id)
                    ->where('members.performer_stat', config('constKey.PERFORMER_STAT.NORMAL'))
                    ->where('member_profiles.profile_stat', 1)
                    ->first();
                if (!is_null($sender)) {
                    $sender->img_path = ImageProc::imageCacheUrl($sender->img_file, 'm') . '?' . strtotime($sender->updated_at);
                } else {
                    $sender = (object)[
                        'nickname' => '送信者ハンドル名',
                        'userid' => '送信者ログインID',
                        'img_path' => '送信者画像パス'
                    ];
                }
            } else {
                $sender = (object)[
                    'nickname' => '送信者ハンドル名',
                    'userid' => '送信者ログインID',
                    'img_path' => '送信者画像パス'
                ];
            }

            // replacements array作成
            $cryptor = new OpenSslCryptor('bf-cbc');
            $replacements = array();
            foreach ($users as $user) {
                $replacements[$user->email] = array (
                    '%%1%%' => $user->email,
                    '%%2%%' => $user->userid,
                    '%%3%%' => $cryptor->decrypt($user->password_org),
                    '%%4%%' => $user->nickname,
                    '%%5%%' => $sender->nickname,
                    '%%6%%' => $sender->userid,
                    '%%7%%' => env('APP_URL').$sender->img_path,
                    '%%8%%' => config('constLabel.area.'.$user->area),
                    '%%9%%' => config('constLabel.performer_profiles.'.$user->body_style),
                    '%%10%%' => 'NONE',
                    '%%11%%' => 'NONE',
                    '%%12%%' => env('APP_URL')
                );
            }
        }

        // Create mail transport configuration
        $transport = new \Swift_SmtpTransport('lp2019.crea-live.com', 18025);
        $transport->setUsername('username');
        $transport->setPassword('password');

        // Create an instance of the plugin and register it
        $plugin = new \Swift_Plugins_DecoratorPlugin($replacements);
        $mailer = new \Swift_Mailer($transport);
        $mailer->registerPlugin($plugin);

        // Create the message
        $message = new \Swift_Message();
        $message->setSubject($template_name);
        $message->setBody(view($body_template), 'text/html');
        $message->setFrom('supp@mka-dev-mail-01.itsherpa.net');

        // Send the email
        foreach($users as $user) {
            $message->setTo($user->email, $user->nickname);
            $mailer->send($message);
        }
        return 'メール送信完了';
    }

}