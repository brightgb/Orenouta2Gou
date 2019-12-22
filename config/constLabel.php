<?php

return [

    //サイト種別
    'site' => [
        config('constKey.SITE.CREA')  => 'クレア',
        config('constKey.SITE.CANDY') => 'キャンディー',
        config('constKey.SITE.GRAN')  => 'グラン',
    ],

    //会員の種別
    'gender' => [
        config('constKey.GENDER.MEMBER')    => '会員',
        config('constKey.GENDER.PERFORMER') => '出演者',
        config('constKey.GENDER.COMMON')    => '共通',
    ],

    // type of member in table admin_notifies
    'gender_notify' => [
        config('constKey.GENDER_NOTIFY.MEMBER_NOTI')    => '会員',
        config('constKey.GENDER_NOTIFY.PERFORMER_NOTI') => '出演者',
        config('constKey.GENDER_NOTIFY.ALL_NOTI')       => '共通',
    ],

    //管理画面入金タイプ
    'deposit_type' => [
        config('constKey.PAY_METHOD.BANK')              => '銀行振込',
        config('constKey.PAY_METHOD.MOBILE_REMITTANCE') => 'ケータイ送金',
    ],

    //決済種別
    'pay_method' => [
        config('constKey.PAY_METHOD.BANK')              => '銀行振込',
        config('constKey.PAY_METHOD.CREDIT')            => 'クレジット',
        config('constKey.PAY_METHOD.CCHECK')            => 'C-Check',
        config('constKey.PAY_METHOD.BITCASH')           => 'BitCash',
        config('constKey.PAY_METHOD.SMONEY')            => 'S-Money',
        config('constKey.PAY_METHOD.CONVENIENCE')       => 'コンビニダイレクト',
        config('constKey.PAY_METHOD.EDY')               => 'EDY',
        config('constKey.PAY_METHOD.GMONEY')            => 'G-Money',
        config('constKey.PAY_METHOD.MOBILE_REMITTANCE') => 'ケータイ送金',
        config('constKey.PAY_METHOD.AFFILIATE')         => 'ポイントアフリ',
    ],

    //決済会社（DBと一致）
    'pay_company' => [
        config('constKey.PAY_COMPANY.TELECOM')   => '(株)テレコムクレジット',
        config('constKey.PAY_COMPANY.E-DREAM')   => '(株)E-DREAM',
        config('constKey.PAY_COMPANY.METAPPUSU') => '(株)メタップスペイメント',
        config('constKey.PAY_COMPANY.BITCASH')   => '(株)ビットキャッシュ',
        config('constKey.PAY_COMPANY.GREAT')     => '(株)グレートインフォメーション',
        config('constKey.PAY_COMPANY.INTERNET')  => '(株)インターネットペイメントサービス(gw)',
        config('constKey.PAY_COMPANY.INSIGHT')   => '(株)インサイト(A.I.AD Offer Wall)',
    ],

    //決済ステータス（クレジット認証でも使用）
    'pay_status' => [
        config('constKey.PAY_STATUS.UNRESEIVE') => '申請中',
        config('constKey.PAY_STATUS.COMPLETE')  => '決済ＯＫ',
        config('constKey.PAY_STATUS.FAIL')      => '決済失敗',
        config('constKey.PAY_STATUS.FAIL_NUM')  => '番号不正',  // BITCASH , E-DREAM
    ],

    //クレジット認証状態
    'credit_auth_status' => [
        config('constKey.CREDIT_AUTH_STATUS.UNRESEIVE') => '申請中',
        config('constKey.CREDIT_AUTH_STATUS.COMPLETE')  => '決済ＯＫ',
        config('constKey.CREDIT_AUTH_STATUS.FAIL')      => '決済失敗',
    ],

    //処理状態
    'transaction_status' => [
        config('constKey.TRANSACTION_STATUS.UNTREATED') => '未処理',
        config('constKey.TRANSACTION_STATUS.COMPLETE')  => '処理済み',
    ],

    //電話番号認証
    'tel_stat' => [
        '0' => '未承認',
        '1' => '承認済み',
    ],

    //端末種別
    'device_type' => [
        config('constKey.DEVICE_TYPE.ANDROID')      => 'Android',
        config('constKey.DEVICE_TYPE.IOS')          => 'iPhone',
        config('constKey.DEVICE_TYPE.FEATUREPHONE') => 'ガラケー',
        config('constKey.DEVICE_TYPE.ETC')          => 'その他',
    ],

    //通話デバイス
    'call_device' => [
        config('constKey.CALL_DEVICE.OUTSIDE_LINE') => '公衆回線',
        config('constKey.CALL_DEVICE.APPLICATION')  => 'アプリ',
    ],

    //通話タイプ
    'call_type' => [
        config('constKey.CALL_TYPE.VOICE_CALL')      => '音声電話',
        config('constKey.CALL_TYPE.TV_CALL')         => 'TV電話',
        config('constKey.CALL_TYPE.VOICE_CALL_WAIT') => '音声電話待機',
        config('constKey.CALL_TYPE.TV_CALL_WAIT')    => 'TV電話待機',
    ],

    //通話アクション
    'call_action' => [
        config('constKey.CALL_ACTION.FROM_MEMBER')      => '会員からコール',
        config('constKey.CALL_ACTION.FROM_PERFORMER')   => '出演者からコール',
    ],

    //電話待機
    'call_wait_type' => [
        config('constKey.CALL_WAIT_TYPE.VOICE_WAIT')    => '音声通のみ希望',
        config('constKey.CALL_WAIT_TYPE.TV_WAIT')       => 'TV電話のみ希望',
        config('constKey.CALL_WAIT_TYPE.VOICE_TV_WAIT') => '音声/TV電話両方',
    ],

    //通話終了理由
    'cutting_reason' => [
        config('constKey.CUTTING_REASON.CALLER_CUT')        => '発信者が切断',
        config('constKey.CUTTING_REASON.RECEIVER_CUT')      => '着信者が切断',
        config('constKey.CUTTING_REASON.NO_POINT')          => 'ポイント不足で終了',
        config('constKey.CUTTING_REASON.NO_ANSWER')         => '着信者が応答しない',
        config('constKey.CUTTING_REASON.IN_CALL')           => '着信者が通話中',
        config('constKey.CUTTING_REASON.CALL_REJECT')       => '発信者または着信者がコールを終了',
        config('constKey.CUTTING_REASON.NO_APP_REGISTERED') => '着信者がアプリ未登録',
        config('constKey.CUTTING_REASON.SYSTEM_ERROR')      => 'システムエラー',
        config('constKey.CUTTING_REASON.OTHER_REASON')      => 'その他の理由により切断',
    ],

    //SMS種別
    'sms_type' => [
        config('constKey.SMS_TYPE.PROVISIONAL_REGIST') => '仮登録SMS',
        config('constKey.SMS_TYPE.REMINDER')           => 'リマインダーSMS',
        config('constKey.SMS_TYPE.TO_MEMBER')          => '管理 → 会員SMS',
        config('constKey.SMS_TYPE.TO_PERFORMER')       => '管理 → 出演者SMS',
    ],

    //SMS送信結果
    'sms_result' => [
        config('constKey.SMS_RESULT.COMPLETE') => '送信完了',
        config('constKey.SMS_RESULT.ERROR')    => '送信エラー',
    ],

    //メールステータス
    'email_stat' => [
        config('constKey.EMAIL_STAT.NG') => 'NG',
        config('constKey.EMAIL_STAT.OK') => 'OK',
    ],

    //メッセージタイプ
    'message_type' => [
        config('constKey.MESSAGE_TYPE.APPROACH_MEMBER')       => 'アプローチ（会員 -> 出演者）',
        config('constKey.MESSAGE_TYPE.REPLY_MEMBER')          => '返信（会員 -> 出演者）',
        config('constKey.MESSAGE_TYPE.APPROACH_PERFORMER')    => 'アプローチ（出演者 -> 会員）',
        config('constKey.MESSAGE_TYPE.REPLY_PERFORMER')       => '返信（出演者 -> 会員）',
        config('constKey.MESSAGE_TYPE.INFO_MEMBER')           => 'お知らせメール（管理 -> 会員）',
        config('constKey.MESSAGE_TYPE.INFO_PERFORMER')        => 'お知らせメール（管理 -> 出演者）',
        config('constKey.MESSAGE_TYPE.REPLY_MANNER')          => 'マナー返信メール',
        config('constKey.MESSAGE_TYPE.APPOINTMENT_VOICE')     => '待ち合わせメール（音声）',
        config('constKey.MESSAGE_TYPE.APPOINTMENT_TV')        => '待ち合わせメール（TV）',
        config('constKey.MESSAGE_TYPE.INVITATION')            => '招待メール',
        config('constKey.MESSAGE_TYPE.LOGIN')                 => 'ログイン通知',
        config('constKey.MESSAGE_TYPE.LOGOUT')                => 'ログアウト通知',
        config('constKey.MESSAGE_TYPE.REMINDER')              => '催促メール',
        config('constKey.MESSAGE_TYPE.PERFORMER_SOLICIT')     => '未認証出演者勧誘メール',
        config('constKey.MESSAGE_TYPE.MAIL_MAGAZINE')         => 'メールマガジン',
        config('constKey.MESSAGE_TYPE.PERFORMER_WAIT_END')    => '出演者待機終了メール',
        config('constKey.MESSAGE_TYPE.INFO_ALL')              => 'お知らせメール（管理 -> 共通）',
        config('constKey.MESSAGE_TYPE.MAIL_ADDRESS')          => 'メールアドレス関連',
        config('constKey.MESSAGE_TYPE.MARKET')                => 'マーケット関連',
        config('constKey.MESSAGE_TYPE.SETTLE')                => '精算関連',
        config('constKey.MESSAGE_TYPE.POINT')                 => 'ポイント関連',
        config('constKey.MESSAGE_TYPE.PURCHASE')              => '入金 ・ 決済 ・ 購入関連',
        config('constKey.MESSAGE_TYPE.ATTACH_MAIL')           => '添付メール受信',
        config('constKey.MESSAGE_TYPE.REGIST')                => '登録関連',
        config('constKey.MESSAGE_TYPE.OTHERS')                => 'その他メール',
    ],

    //フリーダイアル
    'free_dial_flg' => [
        '0' => '利用しない',
        '1' => '利用する',
    ],

    //画像状態
    'img_stat' => [
        config('constKey.IMG_STAT.UNAPPROVED')  => '未認証',
        config('constKey.IMG_STAT.PRIVATE')     => '非公開',
        config('constKey.IMG_STAT.RELEASE')     => '公開中',
        config('constKey.IMG_STAT.USER_DELETE') => '削除',
        config('constKey.IMG_STAT.MANAGE_NG')   => '管理NG',
    ],

    //動画状態
    'movie_stat' => [
        config('constKey.MOVIE_STAT.UNAPPROVED')  => '未認証',
        config('constKey.MOVIE_STAT.PRIVATE')     => '非公開',
        config('constKey.MOVIE_STAT.RELEASE')     => '公開中',
        config('constKey.MOVIE_STAT.USER_DELETE') => '削除',
        config('constKey.MOVIE_STAT.MANAGE_NG')   => '管理NG',
    ],

    //投稿状態(ブログ、掲示板、つぶやきの共通)
    'toukou_ng_flg' => [
        config('constKey.TOUKOU_NG_FLG.OK') => '利用可',
        config('constKey.TOUKOU_NG_FLG.NG') => '利用不可',
    ],

    //投稿状態(ブログ、掲示板、つぶやきの共通)
    'toukou_stat' => [
        config('constKey.TOUKOU_STAT.UNAPPROVED')   => '未承認',
        config('constKey.TOUKOU_STAT.APPROVED')     => '承認済み',
        config('constKey.TOUKOU_STAT.ON_HOLD')      => '保留',
        config('constKey.TOUKOU_STAT.USER_DELETE')  => '削除',
        config('constKey.TOUKOU_STAT.ADMIN_DELETE') => '管理側削除',
    ],

    //ピックアップ区分
    'pickup' => [
        'class' => [
            config('constKey.PICKUP_CLASS.PERFORMER')     => '出演者',
            config('constKey.PICKUP_CLASS.PROF_IMAGE')    => 'プロフィール画像',
            config('constKey.PICKUP_CLASS.PROF_MOVIE')    => 'プロフィール動画',
            config('constKey.PICKUP_CLASS.PREMIUM_IMAGE') => 'プレミアム画像（企画画像を除く）',
            config('constKey.PICKUP_CLASS.PREMIUM_VIDEO') => 'プレミアム動画',
            config('constKey.PICKUP_CLASS.TAKING_DOWN')   => '完全撮り下ろしギャラリー',
            config('constKey.PICKUP_CLASS.XMAS')          => 'クリスマス',
            config('constKey.PICKUP_CLASS.BATHING_SUITS') => '水着',
            config('constKey.PICKUP_CLASS.HALLOWEEN')     => 'ハロウィン',
        ],
        'stat' => [
            config('constKey.PICKUP_STAT.PRIVATE') => '非公開',
            config('constKey.PICKUP_STAT.OPEN')    => '公開',
        ]
    ],

    //ピックアップ作成と編集
    'pickup_edit' => [
        'class' => [
            config('constKey.PICKUP_CLASS_EDIT.PERFORMER')          => '出演者：優先度順',
            config('constKey.PICKUP_CLASS_EDIT.PROF_IMAGE_DATE')    => 'プロフィール画像：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.PROF_MOVIE_DATE')    => 'プロフィール動画：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.PREMIUM_IMAGE_DATE') => 'プレミアム画像（企画画像を除く）：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.PREMIUM_IMAGE_NUM')  => 'プレミアム画像（企画画像を除く）：閲覧数順',
            config('constKey.PICKUP_CLASS_EDIT.PREMIUM_VIDEO_DATE') => 'プレミアム動画：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.PREMIUM_VIDEO_NUM')  => 'プレミアム動画：閲覧数順',
            config('constKey.PICKUP_CLASS_EDIT.TAKING_DOWN_DATE')   => '完全撮り下ろしギャラリー：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.TAKING_DOWN_NUM')    => '完全撮り下ろしギャラリー：閲覧数順',
            config('constKey.PICKUP_CLASS_EDIT.XMAS_DATE')          => 'クリスマス：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.XMAS_NUM')           => 'クリスマス：閲覧数順',
            config('constKey.PICKUP_CLASS_EDIT.BATHING_SUITS_DATE') => '水着：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.BATHING_SUITS_NUM')  => '水着：閲覧数順',
            config('constKey.PICKUP_CLASS_EDIT.HALLOWEEN_DATE')     => 'ハロウィン：投稿日時順',
            config('constKey.PICKUP_CLASS_EDIT.HALLOWEEN_NUM')      => 'ハロウィン：閲覧数順',
        ],
        'stat' => [
            config('constKey.PICKUP_STAT.PRIVATE') => '非公開',
            config('constKey.PICKUP_STAT.OPEN')    => '公開',
        ]
    ],

    //ピックアップ内容の公開と非公開
    'pickup_list' => [
        config('constKey.PICKUP_STAT.PRIVATE') => '非公開',
        config('constKey.PICKUP_STAT.OPEN')    => '公開',
    ],

    //ピックアップの表示順
    'pickup_sort' => [
        config('constKey.PICKUP_SORT.CREATE') => '投稿日時順',
        config('constKey.PICKUP_SORT.VIEW')   => '閲覧数順',
    ],

    //おみくじ設定
    'user_type' => [
        '1'  => '無料会員',
        '2'  => '有料会員',
        '10' => '出演者',
    ],

    //退会申請状況
    'withdrawal_stat' => [
        config('constKey.WITHDRAWAL_STAT.UNRESEIVE')  => '申請中',
        config('constKey.WITHDRAWAL_STAT.RESEIVE')    => '退会処理', //'退会', #17738: require change 退会 to 退会処理
    ],

    //精算申請状態（performer_infos.monetize_request_stat）
    'settlement_stat' => [
        config('constKey.SETTLEMENT_STAT.NO_APPLICATION')        => '申請なし',
        config('constKey.SETTLEMENT_STAT.APPLIED')               => '申請済み',
        config('constKey.SETTLEMENT_STAT.SETTLEMENT_PROCESSING') => '精算処理中',
    ],

    //精算締め状態（monetize_histories.closing_stat）
    'closing_stat' => [
        config('constKey.CLOSING_STAT.UNTREATED') => '未処理',
        config('constKey.CLOSING_STAT.APPLIED')   => '処理済み',
    ],

    //キャンペーン種別
    'campaign_type' => [
        config('constKey.CAMPAIGN_TYPE.UNDEFINE')   => '未定義',
        config('constKey.CAMPAIGN_TYPE.PURCHASE')   => '入金キャンペーン',
        config('constKey.CAMPAIGN_TYPE.DISCOUNT')   => '割引キャンペーン',
        config('constKey.CAMPAIGN_TYPE.INVITATION') => '友達紹介キャンペーン',
    ],

    'member_point_mode' => [
        config('constKey.POINT_UPD_MODE.NEW_REGIST')              => '新規登録',
        config('constKey.POINT_UPD_MODE.CHANGE_ADMIN')            => '管理変更',
        config('constKey.POINT_UPD_MODE.WITHDRAWAL')              => '退会',
        config('constKey.POINT_UPD_MODE.VOICE_CALL')              => '音声電話',
        config('constKey.POINT_UPD_MODE.TV_CALL')                 => 'TV電話',
        config('constKey.POINT_UPD_MODE.WAIT_VOICE_CALL')         => '待機音声電話',
        config('constKey.POINT_UPD_MODE.WAIT_TV_CALL')            => '待機TV電話',
        config('constKey.POINT_UPD_MODE.MAIL_SEND')               => 'メール送信',
        config('constKey.POINT_UPD_MODE.MAIL_IMG_SEND')           => '画像添付メール送信',
        config('constKey.POINT_UPD_MODE.MAIL_VIDEO_SEND')         => '動画添付メール送信',
        config('constKey.POINT_UPD_MODE.MAIL_IMG_BROWSING')       => 'メール添付画像閲覧',
        config('constKey.POINT_UPD_MODE.MAIL_VIDEO_BROWSING')     => 'メール添付動画閲覧',
        config('constKey.POINT_UPD_MODE.PREMIUM_IMAGE')           => 'プレミアム画像閲覧',
        config('constKey.POINT_UPD_MODE.PREMIUM_VIDEO')           => 'プレミアム動画閲覧',
        config('constKey.POINT_UPD_MODE.MARKET')                  => 'Cフリマ',
        config('constKey.POINT_UPD_MODE.PRESENT')                 => 'プレゼント送信',
        config('constKey.POINT_UPD_MODE.PAY_BANK')                => '銀行振込',
        config('constKey.POINT_UPD_MODE.PAY_CREDIT')              => 'クレジット',
        config('constKey.POINT_UPD_MODE.PAY_CCHECK')              => 'C-Check',
        config('constKey.POINT_UPD_MODE.PAY_BITCASH')             => 'BitCash',
        config('constKey.POINT_UPD_MODE.PAY_SMONEY')              => 'S-Money',
        config('constKey.POINT_UPD_MODE.PAY_CONVENIENCE')         => 'コンビニダイレクト',
        config('constKey.POINT_UPD_MODE.PAY_EDY')                 => 'EDY',
        config('constKey.POINT_UPD_MODE.PAY_GMONEY')              => 'G-Money',
        config('constKey.POINT_UPD_MODE.PAY_MOBILE_REMITTANCE')   => 'ケータイ送金',
        config('constKey.POINT_UPD_MODE.PAY_AFFILIATE')           => 'アフィリエイト',
        config('constKey.POINT_UPD_MODE.CREDIT_AUTH')             => 'クレジット認証',
        config('constKey.POINT_UPD_MODE.TEL_AUTH')                => '電話番号認証',
        config('constKey.POINT_UPD_MODE.OMIKUJI')                 => 'おみくじポイント',
        config('constKey.POINT_UPD_MODE.INTRODUCER')              => '紹介者',
    ],

    'performer_point_mode' => [
        config('constKey.POINT_UPD_MODE.NEW_REGIST')              => '新規登録',
        config('constKey.POINT_UPD_MODE.CHANGE_ADMIN')            => '管理変更',
        config('constKey.POINT_UPD_MODE.PAYMENT')                 => '精算処理',
        config('constKey.POINT_UPD_MODE.WITHDRAWAL')              => '退会',
        config('constKey.POINT_UPD_MODE.VOICE_CALL')              => '音声電話',
        config('constKey.POINT_UPD_MODE.TV_CALL')                 => 'TV電話',
        config('constKey.POINT_UPD_MODE.WAIT_VOICE_CALL')         => '待機音声電話',
        config('constKey.POINT_UPD_MODE.WAIT_TV_CALL')            => '待機TV電話',
        config('constKey.POINT_UPD_MODE.MAIL_RECEIVE')            => 'メール受信',
        config('constKey.POINT_UPD_MODE.MAIL_IMG_RECEIVE')        => '画像添付メール受信',
        config('constKey.POINT_UPD_MODE.MAIL_VIDEO_RECEIVE')      => '動画添付メール受信',
        config('constKey.POINT_UPD_MODE.MAIL_IMG_BROWSING')       => 'メール添付画像閲覧',
        config('constKey.POINT_UPD_MODE.MAIL_VIDEO_BROWSING')     => 'メール添付動画閲覧',
        config('constKey.POINT_UPD_MODE.PREMIUM_IMAGE')           => 'プレミアム画像閲覧',
        config('constKey.POINT_UPD_MODE.PREMIUM_VIDEO')           => 'プレミアム動画閲覧',
        config('constKey.POINT_UPD_MODE.MARKET')                  => 'Cフリマ',
        config('constKey.POINT_UPD_MODE.PRESENT')                 => 'プレゼント受信',
        config('constKey.POINT_UPD_MODE.OMIKUJI')                 => 'おみくじポイント',
        config('constKey.POINT_UPD_MODE.INTRODUCER')              => '紹介者',
        config('constKey.POINT_UPD_MODE.INTRODUCED')              => '被紹介者',
        config('constKey.POINT_UPD_MODE.KICK_BACK')               => 'キックバック',
    ],

    //マーケット出品状況
    'market_goods_status' => [
        config('constKey.MARKET_GOODS_STATUS.UNCERTIFIED') => '審査中',      // 出品中の商品に問題があった場合管理画面から手動で遷移
        config('constKey.MARKET_GOODS_STATUS.RELEASE')     => '出品中',      // 出品時の初期値
        config('constKey.MARKET_GOODS_STATUS.PRIVATE')     => '非表示',      // 出品中の商品に対して、ユーザーが任意に遷移可能
        config('constKey.MARKET_GOODS_STATUS.SOLD')        => '未発送',      // 男性が商品を購入したときに自動的に遷移
        config('constKey.MARKET_GOODS_STATUS.COMPLETE')    => '発送済み',     // 未発送の商品に対して、郵便物の画像を承認した場合、管理画面から手動で遷移
        config('constKey.MARKET_GOODS_STATUS.CANCEL')      => 'キャンセル',     // 未発送の商品に対して、女性の発送が確認できなかった場合、管理画面から手動で遷移
        config('constKey.MARKET_GOODS_STATUS.END')         => '出品期間終了', // 商品出品後、購入されずに30日経過した場合自動的に遷移
        config('constKey.MARKET_GOODS_STATUS.ADMIN_NG')    => '非公開',      // 出品中の商品に著しい問題があった場合に、管理画面から手動で遷移
        config('constKey.MARKET_GOODS_STATUS.USER_DELETE') => '削除',        // 審査中 非表示 出品期間終了 の商品に対して、ユーザーが任意に遷移可能
    ],

    //商品カテゴリ
    'market_goods_category' => [
        config('constKey.MARKET_GOODS_CATEGORY.PANTY')     => 'パンティ',
        config('constKey.MARKET_GOODS_CATEGORY.BRASSIERE') => 'ブラジャー',
        config('constKey.MARKET_GOODS_CATEGORY.UNDERWEAR') => '下着上下セット',
        config('constKey.MARKET_GOODS_CATEGORY.LEG')       => '脚モノ',
        config('constKey.MARKET_GOODS_CATEGORY.CLOTHES')   => '洋服',
        config('constKey.MARKET_GOODS_CATEGORY.OTHERS')    => 'その他',
    ],

    //商品発送先（自宅 or 郵便局留め）
    'market_goods_destination' => [
        config('constKey.MARKET_GOODS_DESTINATION.HOME')        => 'ご自宅等',
        config('constKey.MARKET_GOODS_DESTINATION.POST_OFFICE') => '郵便局留め',
    ],

    //マーケット名
    'market_name' => env('MARKET_NAME', 'Cフリマ'),

    //口座種別
    'bank_account_type' => [
        config('constKey.BANK_ACCOUNT_TYPE.NORMAL')  => '普通',
        config('constKey.BANK_ACCOUNT_TYPE.CURRENT') => '当座',
        config('constKey.BANK_ACCOUNT_TYPE.SAVING')  => '貯蓄',
    ],

    //広告管理（会員成果認証タイミング）
    'member_auth_timing' => [
        config('constKey.AUTH_TIMING.REGIST')           => '登録完了時',
        config('constKey.AUTH_TIMING.FIRST_LOGIN')      => '初ログイン時',
        config('constKey.AUTH_TIMING.FIRST_PURCHASE')   => '初ポイント購入時',
        config('constKey.AUTH_TIMING.PROFILE_COMPLETE') => 'プロフィール登録完了時',
        config('constKey.AUTH_TIMING.TEL_COMPLETE')     => '電話番号認証',
    ],

    //広告管理（出演者成果認証タイミング）
    'performer_auth_timing' => [
        config('constKey.AUTH_TIMING.STAT_NORMAL')      => '認証完了時',
        config('constKey.AUTH_TIMING.PROFILE_COMPLETE') => 'プロフィール登録完了時',
    ],

    //広告管理（売上閲覧許可フラグ）
    'sale_view_flg' => [
        config('constKey.SALE_VIEW_FLG.NG') => '許可しない',
        config('constKey.SALE_VIEW_FLG.OK') => '許可する',
    ],

    //日付(月)
    'month' => [
        '1'  => '1',
        '2'  => '2',
        '3'  => '3',
        '4'  => '4',
        '5'  => '5',
        '6'  => '6',
        '7'  => '7',
        '8'  => '8',
        '9'  => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
    ],

    //日付(日)
    'day' => [
        '1'  => '1',
        '2'  => '2',
        '3'  => '3',
        '4'  => '4',
        '5'  => '5',
        '6'  => '6',
        '7'  => '7',
        '8'  => '8',
        '9'  => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30',
        '31' => '31',
    ],

    //時間(時)
    'hour' => [
        '00' => '00',
        '01' => '01',
        '02' => '02',
        '03' => '03',
        '04' => '04',
        '05' => '05',
        '06' => '06',
        '07' => '07',
        '08' => '08',
        '09' => '09',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
    ],

    //時間(分/秒)
    'minute_sec' => [
        '00' => '00',
        '01' => '01',
        '02' => '02',
        '03' => '03',
        '04' => '04',
        '05' => '05',
        '06' => '06',
        '07' => '07',
        '08' => '08',
        '09' => '09',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30',
        '31' => '31',
        '32' => '32',
        '33' => '33',
        '34' => '34',
        '35' => '35',
        '36' => '36',
        '37' => '37',
        '38' => '38',
        '39' => '39',
        '40' => '40',
        '41' => '41',
        '42' => '42',
        '43' => '43',
        '44' => '44',
        '45' => '45',
        '46' => '46',
        '47' => '47',
        '48' => '48',
        '49' => '49',
        '50' => '50',
        '51' => '51',
        '52' => '52',
        '53' => '53',
        '54' => '54',
        '55' => '55',
        '56' => '56',
        '57' => '57',
        '58' => '58',
        '59' => '59',
    ],

    //地域
    'area' => [
        '1'  => '北海道',
        '2'  => '青森県',
        '3'  => '岩手県',
        '4'  => '宮城県',
        '5'  => '秋田県',
        '6'  => '山形県',
        '7'  => '福島県',
        '8'  => '茨城県',
        '9'  => '栃木県',
        '10' => '群馬県',
        '11' => '埼玉県',
        '12' => '千葉県',
        '13' => '東京都',
        '14' => '神奈川県',
        '15' => '新潟県',
        '16' => '富山県',
        '17' => '石川県',
        '18' => '福井県',
        '19' => '山梨県',
        '20' => '長野県',
        '21' => '岐阜県',
        '22' => '静岡県',
        '23' => '愛知県',
        '24' => '三重県',
        '25' => '滋賀県',
        '26' => '京都府',
        '27' => '大阪府',
        '28' => '兵庫県',
        '29' => '奈良県',
        '30' => '和歌山県',
        '31' => '鳥取県',
        '32' => '島根県',
        '33' => '岡山県',
        '34' => '広島県',
        '35' => '山口県',
        '36' => '徳島県',
        '37' => '香川県',
        '38' => '愛媛県',
        '39' => '高知県',
        '40' => '福岡県',
        '41' => '佐賀県',
        '42' => '長崎県',
        '43' => '熊本県',
        '44' => '大分県',
        '45' => '宮崎県',
        '46' => '鹿児島県',
        '47' => '沖縄県',
        '48' => 'ﾋﾐﾂ'
    ],

    'region' => [
        '101' => '北海道・東北',
        '102' => '関東',
        '103' => '甲信越・北陸',
        '104' => '東海',
        '105' => '関西',
        '106' => '中国・四国',
        '107' => '九州・沖縄',
    ],

    'img_category' => [
        config('constKey.IMG_CATEGORY.SOFT') => 'ソフト',
        config('constKey.IMG_CATEGORY.SEXY') => 'セクシー',
        config('constKey.IMG_CATEGORY.PLAN') => '企画',
    ],

    'img_category_remove_plan' => [
        config('constKey.IMG_CATEGORY.SOFT') => 'ソフト',
        config('constKey.IMG_CATEGORY.SEXY') => 'セクシー',
    ],

    'img_property' => [
        config('constKey.IMG_CATEGORY.SOFT') => [
            config('constKey.IMG_PROPERTY_SOFT.PRINT_CLUB') => 'プリクラ',
            config('constKey.IMG_PROPERTY_SOFT.FACE')       => '顔',
            config('constKey.IMG_PROPERTY_SOFT.FULL_BODY')  => '全身',
            config('constKey.IMG_PROPERTY_SOFT.CLOTHING')   => '着衣',
            config('constKey.IMG_PROPERTY_SOFT.COSPLAY')    => 'コスプレ',
            config('constKey.IMG_PROPERTY_SOFT.OTHER')      => 'その他',
        ],
        config('constKey.IMG_CATEGORY.SEXY') => [
            config('constKey.IMG_PROPERTY_SEXY.FACE')       => '顔',
            config('constKey.IMG_PROPERTY_SEXY.FELLATIO')   => 'フェラ顔',
            config('constKey.IMG_PROPERTY_SEXY.CLOTHING')   => '着衣',
            config('constKey.IMG_PROPERTY_SEXY.UNDARWEAR')  => '下着',
            config('constKey.IMG_PROPERTY_SEXY.COSPLAY')    => 'コスプレ',
            config('constKey.IMG_PROPERTY_SEXY.BATHING')    => '入浴',
            config('constKey.IMG_PROPERTY_SEXY.FULL_BODY')  => '全身',
            config('constKey.IMG_PROPERTY_SEXY.HAND_BRA')   => '手ブラ',
            config('constKey.IMG_PROPERTY_SEXY.UPPER_BODY') => '上半身',
            config('constKey.IMG_PROPERTY_SEXY.UNDER_BODY') => '下半身',
            config('constKey.IMG_PROPERTY_SEXY.OTHER')      => 'その他',
        ],
        config('constKey.IMG_CATEGORY.PLAN') => [
            config('constKey.IMG_PROPERTY_PLAN.TAKING_DOWN')   => '完全撮り下ろし',
            config('constKey.IMG_PROPERTY_PLAN.XMAS')          => 'クリスマス',
            config('constKey.IMG_PROPERTY_PLAN.BATHING_SUITS') => '水着',
            config('constKey.IMG_PROPERTY_PLAN.HALLOWEEN')     => 'ハロウィン',
        ],
    ],

    'movie_category' => [
        config('constKey.MOVIE_CATEGORY.SOFT') => 'ソフト',
        config('constKey.MOVIE_CATEGORY.SEXY') => 'セクシー',
    ],

    'movie_property' => [
        config('constKey.MOVIE_CATEGORY.SOFT') => [
            config('constKey.MOVIE_PROPERTY_SOFT.FACE') => '顔',
            config('constKey.MOVIE_PROPERTY_SOFT.FULL_BODY') => '全身',
            config('constKey.MOVIE_PROPERTY_SOFT.CLOTHING') => '着衣',
            config('constKey.MOVIE_PROPERTY_SOFT.COSPLAY') => 'コスプレ',
            config('constKey.MOVIE_PROPERTY_SOFT.OTHER') => 'その他',
        ],
        config('constKey.MOVIE_CATEGORY.SEXY') => [
            config('constKey.MOVIE_PROPERTY_SEXY.FACE')       => '顔',
            config('constKey.MOVIE_PROPERTY_SEXY.FELLATIO')   => 'フェラ顔',
            config('constKey.MOVIE_PROPERTY_SEXY.CLOTHING')   => '着衣',
            config('constKey.MOVIE_PROPERTY_SEXY.CHANGING')   => '着替え',
            config('constKey.MOVIE_PROPERTY_SEXY.UNDERWEAR')  => '下着姿',
            config('constKey.MOVIE_PROPERTY_SEXY.COSPLAY')    => 'コスプレ',
            config('constKey.MOVIE_PROPERTY_SEXY.BATHING')    => '入浴',
            config('constKey.MOVIE_PROPERTY_SEXY.FULL_BODY')  => '全身',
            config('constKey.MOVIE_PROPERTY_SEXY.UPPER_BODY') => '上半身（オッパイなど）',
            config('constKey.MOVIE_PROPERTY_SEXY.UNDER_BODY') => '下半身（お尻・脚など）',
            config('constKey.MOVIE_PROPERTY_SEXY.MASTURBATE') => 'オナニー',
            config('constKey.MOVIE_PROPERTY_SEXY.OTHER')      => 'その他',
        ]
    ],

    //各モデルに依存するもの

    //会員
    'members' => [
        'member_stat' => [
            config('constKey.MEMBER_STAT.UNCERTIFIED') => '仮登録',
            config('constKey.MEMBER_STAT.NORMAL')      => '正常',
            config('constKey.MEMBER_STAT.ON_HOLD')     => '保留',
            config('constKey.MEMBER_STAT.WITHDRAWAL')  => '退会',
            config('constKey.MEMBER_STAT.BAN')         => '禁止',
            config('constKey.MEMBER_STAT.STOP')        => '停止',
            config('constKey.MEMBER_STAT.FROM_MEETS')  => 'ミーツからの登録',
        ],
        'rank_1' => [
            '0' => '無料',
            '1' => 'マイレージ歴あり',
            '2' => '課金歴あり',
        ],
        'app_use_flg' => [
            '0' => '利用しない',
            '1' => '利用する',
        ],
    ],

    'member_profiles' => [
        'job' => [
            '1'  => '自営業',
            '2'  => 'フリーター',
            '3'  => '学生',
            '4'  => 'フリーランス',
            '5'  => '無職',
            '6'  => '美術/音楽/作家',
            '7'  => '銀行/金融/不動産',
            '8'  => 'IT関連/情報技術',
            '9'  => 'エンジニア/建築/土木',
            '10' => '教育/研究',
            '11' => '娯楽/ﾒﾃﾞｨｱ/出版',
            '12' => '旅行/接客業',
            '13' => '法律',
            '14' => '製造/エネルギー',
            '15' => '流通/運輸',
            '16' => '医薬/健康',
            '17' => '介護/福祉',
            '18' => '農林/水産',
            '19' => '食品/外食',
            '20' => '政府/自治体',
            '21' => 'マーケティング',
            '22' => '小売/卸売',
            '23' => 'サービス',
            '24' => '非営利団体',
            '25' => 'その他会社員',
            '26' => 'その他',
        ],
        'body_style' => [
            '1' => 'スリム',
            '2' => 'やせマッチョ',
            '3' => '普通',
            '4' => 'ガッチリ',
            '5' => 'まっちょ',
            '6' => 'ポッチャリ',
            '7' => '秘密',
            '8' => '不明/その他',
        ],
        'hobby' => [
            '1'  => '車/ﾊﾞｲｸ',
            '2'  => 'スポーツ観戦',
            '3'  => '野球',
            '4'  => 'サッカー',
            '5'  => 'サーフィン',
            '6'  => 'スキー/スノボ',
            '7'  => '格闘技',
            '8'  => 'ゴルフ',
            '9'  => '登山',
            '10' => '釣り',
            '11' => 'その他スポーツ',
            '12' => 'パチンコ/スロット',
            '13' => '競馬',
            '14' => '麻雀',
            '15' => 'マンガ/アニメ',
            '16' => 'ゲーム',
            '17' => '映画',
            '18' => 'テレビ',
            '19' => 'ネット/PC',
            '20' => '鉄道',
            '21' => 'ガン/ミリタリー',
            '22' => '読書',
            '23' => '音楽',
            '24' => 'アート',
            '25' => 'ファッション',
            '26' => 'ペット',
            '27' => 'ガーデニング',
            '28' => '料理/お菓子',
            '29' => 'ﾀﾞｰﾂ/ﾋﾞﾘﾔｰﾄﾞ',
            '30' => 'ｸﾞﾙﾒ/お酒',
            '31' => '夜遊び全般',
            '32' => '特になし',
            '33' => '不明/その他',
        ],
        'type_me' => [
            '1'  => 'さわやか系',
            '2'  => 'おっとり系',
            '3'  => '癒し系',
            '4'  => 'マジメ系',
            '5'  => 'お笑い系',
            '6'  => '天然系',
            '7'  => 'おバカ系',
            '8'  => 'インテリ系',
            '9'  => 'スポーツマン',
            '10' => 'イケメン系',
            '11' => 'ジャニーズ系',
            '12' => 'サーファー系',
            '13' => 'ガテン系',
            '14' => 'ワイルド系',
            '15' => 'ヤンキー系',
            '16' => 'B系',
            '17' => 'お兄系',
            '18' => 'オヤジ系',
            '19' => '秘密',
            '20' => '不明/その他',
        ],
        'liked_age' => [
            '1'  => '18歳～20歳',
            '2'  => '21歳～25歳',
            '3'  => '26歳～30歳',
            '4'  => '31歳～35歳',
            '5'  => '36歳～40歳',
            '6'  => '41歳～45歳',
            '7'  => '46歳～50歳',
            '8'  => '51歳以上',
            '9'  => '何歳でもOK',
            '10' => '不明/その他',
        ],
        'liked_style' => [
            '1'  => 'スレンダー',
            '2'  => 'スリム',
            '3'  => 'ややスリム',
            '4'  => '普通',
            '5'  => 'グラマー',
            '6'  => 'ややポッチャリ',
            '7'  => 'ポッチャリ',
            '8'  => 'ﾅｲｽﾊﾞﾃﾞｨ',
            '9'  => '小柄っ娘',
            '10' => 'どんな子でもOK',
            '11' => '不明/その他',
        ],
        'liked_type' => [
            '1'  => '可愛い系',
            '2'  => '綺麗系',
            '3'  => '萌え系',
            '4'  => 'ギャル系',
            '5'  => 'メガネッ娘系',
            '6'  => 'お姉系',
            '7'  => 'セレブ系',
            '8'  => 'お笑い系',
            '9'  => '奉仕系',
            '10' => '人妻系',
            '11' => '熟女系',
            '12' => '巨乳系',
            '13' => '癒し系',
            '14' => 'エロ系',
            '15' => 'ツンデレ系',
            '16' => 'S系',
            '17' => 'M系',
            '18' => '変態系',
            '19' => '天然系',
            '20' => '不思議系',
            '21' => 'おっとり系',
            '22' => 'おバカ系',
            '23' => 'お水系',
            '24' => '何系でもOK',
            '25' => '不明/その他',
        ],
        'desired_content' => [
            '1'  => 'ただ眺めてるだけでｲｲ',
            '2'  => 'まったり話したい',
            '3'  => 'エッチな話がしたい',
            '4'  => 'メル友がほしい',
            '5'  => '癒して欲しい',
            '6'  => '癒してあげるよ',
            '7'  => '甘えさせて欲しい',
            '8'  => '甘えさせてあげる',
            '9'  => 'TELエッチしたいな',
            '10' => 'メールエッチしたいな',
            '11' => 'TV電で見せ合いたいな',
            '12' => 'イジメてあげる',
            '13' => 'イジメて欲しい',
            '14' => '変態プレイ',
            '15' => 'イメージプレイ',
            '16' => '不明/その他',
        ],
        'fetishism' => [
            '1'  => '下着',
            '2'  => '唇',
            '3'  => '声',
            '4'  => 'うなじ',
            '5'  => '美脚',
            '6'  => 'パンスト',
            '7'  => 'ミニスカ',
            '8'  => '二の腕',
            '9'  => '爪先',
            '10' => 'おっぱい',
            '11' => '谷間',
            '12' => 'ブラチラ',
            '13' => 'お尻',
            '14' => 'パンチラ',
            '15' => 'くびれ',
            '16' => '制服',
            '17' => '白衣',
            '18' => 'エプロン',
            '19' => '和服',
            '20' => 'コスプレ',
            '21' => '熟女',
            '22' => '匂い',
            '23' => 'アナル',
            '24' => '聖水',
            '25' => 'スカトロ',
            '26' => '不明/その他',
        ],
        's_or_m' => [
            '1' => 'ドS',
            '2' => 'チョイS',
            '3' => '普通',
            '4' => 'チョイM',
            '5' => 'ドM',
            '6' => '相手次第で両方OK',
            '7' => 'わからない',
            '8' => '不明/その他',
        ],
        'appearance_time' => [
            '1' => '朝/午前中',
            '2' => '昼休み頃',
            '3' => '夕方頃',
            '4' => '夜～深夜',
            '5' => '深夜～早朝',
            '6' => 'バラバラ',
            '7' => 'メールで声かけてね',
            '8' => '不明/その他',
        ]
    ],


    //出演者
    'performers' => [
        'performer_stat' => [
            config('constKey.PERFORMER_STAT.UNCERTIFIED') => '未認証',
            config('constKey.PERFORMER_STAT.NORMAL')      => '正常',
            config('constKey.PERFORMER_STAT.ON_HOLD')     => '保留',
            config('constKey.PERFORMER_STAT.WITHDRAWAL')  => '退会',
            config('constKey.PERFORMER_STAT.BAN')         => '禁止',
            config('constKey.PERFORMER_STAT.STOP')        => '停止',
            config('constKey.PERFORMER_STAT.FROM_CANDY')  => 'キャンディからの登録',
        ],
        'rank_1' => [
            '0' => 'A',
            '1' => 'B',
            '2' => 'C',
        ],
        'app_use_flg' => [
            '0' => '利用しない',
            '1' => '利用する',
        ],
    ],

    'performer_profiles' => [
        'job' => [
            '1'  => '学生',
            '2'  => 'フリーター',
            '3'  => '家事手伝い',
            '4'  => '自営業',
            '5'  => '主婦',
            '6'  => 'OL',
            '7'  => 'ショップ店員',
            '8'  => 'ウェイトレス',
            '9'  => '飲食関係',
            '10' => '服飾関係',
            '11' => '美容関係',
            '12' => '看護師',
            '13' => '保母さん',
            '14' => '医療関係',
            '15' => 'キャビンアテンダント',
            '16' => '秘書',
            '17' => '教師',
            '18' => 'モデル',
            '19' => 'キャバ嬢',
            '20' => '風俗嬢',
            '21' => '無職',
            '22' => 'ヒミツ',
            '23' => '不明/その他',
        ],
        'hobby' => [
            '1'  => '買い物/ファッション',
            '2'  => '手芸/ガーデニング',
            '3'  => '華道/茶道',
            '4'  => 'ペット',
            '5'  => '料理',
            '6'  => '読書ﾞ',
            '7'  => '音楽',
            '8'  => 'アート',
            '9'  => 'ネット/PC',
            '10' => '映画',
            '11' => 'テレビ',
            '12' => 'マンガ/アニメ',
            '13' => 'ゲーム',
            '14' => '車/ バイク',
            '15' => 'スポーツ観戦',
            '16' => 'ゴルフ',
            '17' => '登山',
            '18' => '釣り',
            '19' => '格闘技',
            '20' => 'その他スポーツ',
            '21' => 'パチンコ/スロット',
            '22' => '競馬/麻雀',
            '23' => 'グルメ/お酒',
            '24' => '一人エッチ',
            '25' => 'セックス',
            '26' => '特になし',
            '27' => '不明/その他',
        ],
        'type_me' => [
            '1'  => 'カワイ系',
            '2'  => 'キレイ系',
            '3'  => '萌え系',
            '4'  => 'ギャル系',
            '5'  => 'メガネッ系',
            '6'  => 'お姉系',
            '7'  => '妹系',
            '8'  => 'セレブ系',
            '9'  => 'お笑い系',
            '10' => 'ご奉仕系',
            '11' => '人妻系',
            '12' => '熟女系',
            '13' => '巨乳系',
            '14' => '癒し系',
            '15' => 'エロ系',
            '16' => 'ツンデレ系',
            '17' => '変態系',
            '18' => '天然系',
            '19' => '不思議系',
            '20' => 'おっとり系',
            '21' => 'おバカ系',
            '22' => 'お水系',
            '23' => '不明/その他',
        ],
        'body_style' => [
            '1'  => 'スリム',
            '2'  => 'ややスリム',
            '3'  => '普通',
            '4'  => 'ややポチャ',
            '5'  => 'ポッチャリ',
            '6'  => 'スレンダー',
            '7'  => 'グラマー',
            '8'  => '小柄',
            '9'  => '自信あり',
            '10' => 'ヒミツ',
            '11' => '不明/その他',
        ],
        'bust_size' => [
            '1'  => 'Aカップ',
            '2'  => 'Bカップ',
            '3'  => 'Cカップ',
            '4'  => 'Dカップ',
            '5'  => 'Eカップ',
            '6'  => 'Fカップ',
            '7'  => '爆乳チャン',
            '8'  => 'ヒミツ',
            '9'  => '不明/その他',
        ],
        'appearance_time' => [
            '1' => '朝/午前中',
            '2' => '昼休み頃',
            '3' => '夕方頃',
            '4' => '夜～深夜',
            '5' => '深夜～早朝',
            '6' => 'バラバラ',
            '7' => 'メールで呼んでね',
            '8' => '不明/その他',
        ],
        'liked_type' => [
            '1'  => '優しい人',
            '2'  => 'たくましい人',
            '3'  => 'ワイルドな人',
            '4'  => '知的な人',
            '5'  => '面白い人',
            '6'  => '不良っぽい人',
            '7'  => 'カッコイイ人',
            '8'  => 'まじめな人',
            '9'  => 'どんな人でもOK',
            '10' => '不明/その他',
        ],
        's_or_m' => [
            '1' => 'ドS',
            '2' => 'チョイS',
            '3' => '普通',
            '4' => 'チョイM',
            '5' => 'ドM',
            '6' => '相手次第で両方OK',
            '7' => 'わからない',
            '8' => '不明/その他',
        ],
        'talk_type' => [
            '1' => '話しかけるタイプ',
            '2' => '話しかけてほしい',
            '3' => 'どちらでもOK',
            '4' => '不明/その他',
        ],
        'erotic_degree' => [
            '1' => 'アダルトNG',
            '2' => '★☆☆☆☆',
            '3' => '★★☆☆☆',
            '4' => '★★★☆☆',
            '5' => '★★★★☆',
            '6' => '★★★★★',
        ],
        'tv_callable' => [
            '0' => '―',
            '1' => 'お誘い待ち',
        ],
    ],
];