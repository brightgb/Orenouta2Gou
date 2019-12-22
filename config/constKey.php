<?php

return [

    /** 端末情報 */
    'DEVICE_TYPE' => [
        'ANDROID'      => 1,
        'IOS'          => 2,
        'FEATUREPHONE' => 3,
        'ETC'          => 9,
    ],

    /** 最新のアプリバージョン */
    'LATEST_APP_VERSION' => '1.6.1',    //登録時にSIPから呼ばれるAPIのパラメーターの値を参考

    /** 携帯キャリア */
    'CAREAR' => [
        'AU'       => 1,
        'DOCOMO'   => 2,
        'SOFTBANK' => 3,
    ],

    /** サイト種別 */
    'SITE' => [
        'CREA'  => 1,
        'CANDY' => 2,
        'GRAN'  => 3
    ],

    /** サイト名 */
    'SITE_NAME' => [
        'crea'  => 'クレア',
        'gran'  => 'グラン',
        'candy' => 'キャンディトーク'
    ],

    /** サポートメールアドレス */
    'SUPPORT_MAIL' => [
        'crea'  => 'support@mka-dev-mail-01.itsherpa.net',
        'gran'  => 'support@gran-tv.jp',
        'candy' => 'support@candy-tv.jp'
    ],

    /** 銀行情報 */
    'BANK' => [
        'crea' => [
            'bank_name'      => 'クレア銀行',
            'branch'         => 'クレア店',
            'account_type'   => '普通口座',
            'account_number' => '1234567',
            'account_name'   => 'dummy'
        ],
        'gran' => [
            'bank_name'      => 'グラン銀行',
            'branch'         => 'グラン店',
            'account_type'   => '普通口座',
            'account_number' => '1234567',
            'account_name'   => 'dummy'
        ],
        'candy' => [
            'bank_name'      => 'キャンディ銀行',
            'branch'         => 'キャンディ店',
            'account_type'   => '普通口座',
            'account_number' => '1234567',
            'account_name'   => 'dummy'
        ]
    ],

    /** 認証用電話番号 サイトごとに固定 */
    'AUTH_NUMBER' => [
        'crea'  => '18605036282551',
        'gran'  => '18605036282167',
        'candy' => '18605036282567',
    ],

    /** 電話番号認証でゲットするポイント */
    'TEL_AUTH_POINT' => [
        'crea'  => 50,
        'gran'  => 60,
        'candy' => 60,
    ],

    /** 登録時の特典で付与されるポイント */
    'REGIST_BENEFIT' => [
        'NORMAL_REGIST' => 280,
        'TEL_AUTH'      => 330,
    ],

    /** クレジット認証でゲットするポイント */
    'CREDIT_AUTH_POINT' => [
        'crea'  => 200,
        'gran'  => 200,
        'candy' => 200,
    ],

    /** 会員の種別 */
    'GENDER' => [
        'MEMBER'    => 1,
        'PERFORMER' => 2,
        'COMMON'    => 3
    ],

    /* type of member in table admin_notifies */
    'GENDER_NOTIFY' => [
        'MEMBER_NOTI'    => 1,
        'PERFORMER_NOTI' => 2,
        'ALL_NOTI'       => 3,
    ],
    /* 
    config('constKey.GENDER_NOTIFY.MEMBER_NOTI')    => '会員',
        config('constKey.GENDER_NOTIFY.PERFORMER_NOTI') => '出演者',
        config('constKey.GENDER_NOTIFY.ALL_NOTI') => '共通',
    */

    /** 会員・出演者のパスワード暗号化用 */
    'PASSWORD_CRYPT_KEY' => '2018crea',
    'INITIAL_VECTOR'     => '15981378',

    /** 新規登録タイプ */
    'REGISTRATION_TYPE' => [
        'NORMAL' => 0,
        'EMAIL'  => 1,
        'SMS'    => 2
    ],

    /** 会員ステータス */
    'MEMBER_STAT' => [
        'UNCERTIFIED' => 0,
        'NORMAL'      => 1,
        'ON_HOLD'     => 2,
        'WITHDRAWAL'  => 3,
        'BAN'         => 4,
        'STOP'        => 5,
        'FROM_MEETS'  => 6,
    ],

    /** 出演者ステータス */
    'PERFORMER_STAT' => [
        'UNCERTIFIED' => 0,
        'NORMAL'      => 1,
        'ON_HOLD'     => 2,
        'WITHDRAWAL'  => 3,
        'BAN'         => 4,
        'STOP'        => 5,
        'FROM_CANDY'  => 6,
    ],

    /** メールステータス */
    'EMAIL_STAT' => [
        'NG' => '0',
        'OK' => '1',
    ],

    /** 通話デバイス */
    'CALL_DEVICE' => [
        'OUTSIDE_LINE' => 0,
        'APPLICATION'  => 1,
    ],

    /** 通話種別 */
    'CALL_TYPE' => [
        'VOICE_CALL'      => 1,
        'TV_CALL'         => 2,
        'VOICE_CALL_WAIT' => 3,
        'TV_CALL_WAIT'    => 4,
    ],

    /** 通話アクション */
    'CALL_ACTION' => [
        'FROM_MEMBER'    => 1,
        'FROM_PERFORMER' => 2,
    ],

    /** 通話待ち受けタイプ */
    'CALL_WAIT_TYPE' => [
        'VOICE_WAIT'    => 1,
        'TV_WAIT'       => 2,
        'VOICE_TV_WAIT' => 3,
    ],

    /** 通話終了理由 */
    'CUTTING_REASON' => [
        'CALLER_CUT'         => 1,
        'RECEIVER_CUT'       => 2,
        'NO_POINT'           => 3,
        'NO_ANSWER'          => 4,
        'IN_CALL'            => 5,
        'CALL_REJECT'        => 6,
        'NO_APP_REGISTERED'  => 7,
        'SYSTEM_ERROR'       => 8,
        'OTHER_REASON'       => 9,
    ],

    /** 購入タイプ */
    'PAY_METHOD' => [
        'BANK'              => 101,
        'CREDIT'            => 102,
        'CCHECK'            => 103,
        'BITCASH'           => 104,
        'SMONEY'            => 105,
        'CONVENIENCE'       => 106,
        'EDY'               => 107,
        'GMONEY'            => 108,
        'MOBILE_REMITTANCE' => 109,
        'AFFILIATE'         => 110,
    ],

    /** 決済会社（DBと一致）**/
    'PAY_COMPANY' => [
        'TELECOM'   => 1,
        'E-DREAM'   => 2,
        'METAPPUSU' => 3,
        'BITCASH'   => 4,
        'GREAT'     => 5,
        'INTERNET'  => 6,
        'INSIGHT'   => 7,
    ],

    /** 決済ステータス */
    'PAY_STATUS' => [
        'UNRESEIVE' => 0,
        'COMPLETE'  => 1,
        'FAIL'      => 2,
        'FAIL_NUM'  => 3,
    ],

    /** クレジット認証状態 */
    'CREDIT_AUTH_STATUS' => [
        'UNRESEIVE' => 0,
        'COMPLETE'  => 1,
        'FAIL'      => 2,
    ],

    /** 処理状態 */
    'TRANSACTION_STATUS' => [
        'UNTREATED' => 0,
        'COMPLETE'  => 1,
    ],

    /** ポイント更新モード */
    'POINT_UPD_MODE' => [
        'NEW_REGIST'              => 1,
        'CHANGE_ADMIN'            => 2,
        'PAYMENT'                 => 3,
        'WITHDRAWAL'              => 4,
        'VOICE_CALL'              => 11,
        'TV_CALL'                 => 12,
        'WAIT_VOICE_CALL'         => 13,
        'WAIT_TV_CALL'            => 14,
        'MAIL_SEND'               => 21,
        'MAIL_IMG_SEND'           => 22,
        'MAIL_VIDEO_SEND'         => 23,
        'MAIL_RECEIVE'            => 24,
        'MAIL_IMG_RECEIVE'        => 25,
        'MAIL_VIDEO_RECEIVE'      => 26,
        'MAIL_IMG_BROWSING'       => 27,
        'MAIL_VIDEO_BROWSING'     => 28,
        'PREMIUM_IMAGE'           => 31,
        'PREMIUM_VIDEO'           => 32,
        'MARKET'                  => 40,
        'PRESENT'                 => 50,
        'PAY_BANK'                => 101,
        'PAY_CREDIT'              => 102,
        'PAY_CCHECK'              => 103,
        'PAY_BITCASH'             => 104,
        'PAY_SMONEY'              => 105,
        'PAY_CONVENIENCE'         => 106,
        'PAY_EDY'                 => 107,
        'PAY_GMONEY'              => 108,
        'PAY_MOBILE_REMITTANCE'   => 109,
        'PAY_AFFILIATE'           => 110,
        'CREDIT_AUTH'             => 111,
        'TEL_AUTH'                => 112,
        'OMIKUJI'                 => 200,
        'INTRODUCER'              => 201,
        'INTRODUCED'              => 202,
        'KICK_BACK'               => 203,
    ],

    /** ログイン中として表示する時間 */
    'LOGGING_IN_PERIOD_MINUIT' => 120,

    /** 新人として表示する時間 */
    'NEW_REGIST_PERIOD_MONTH' => 1,

    /** 最低精算金額 */
    'MINIMUM_SETTLE_POINT' => 5000,

    /**  精算事務手数料 */
    'SETTLEMENT_FEE' => 500,

    /** 1日に可能なマナー返信数 */
    'MANNER_LIMIT' => 30,

    /** (アプリ利用しない)直接電話する時に利用 */
    'DIRECT_PHONE_NUM' => '5037342767',

    /** メッセージタイプ */
    'MESSAGE_TYPE' => [
        'APPROACH_MEMBER'       => '1',
        'REPLY_MEMBER'          => '2',
        'APPROACH_PERFORMER'    => '3',
        'REPLY_PERFORMER'       => '4',
        'INFO_MEMBER'           => '5',
        'INFO_PERFORMER'        => '6',
        'REPLY_MANNER'          => '7',
        'APPOINTMENT_VOICE'     => '8',
        'APPOINTMENT_TV'        => '9',
        'INVITATION'            => '10',
        'LOGIN'                 => '11',
        'LOGOUT'                => '12',
        'REMINDER'              => '13',
        'PERFORMER_SOLICIT'     => '14',
        'MAIL_MAGAZINE'         => '15',
        'PERFORMER_WAIT_END'    => '16',
        'INFO_ALL'              => '17',
        'MAIL_ADDRESS'          => '18',
        'MARKET'                => '19',
        'SETTLE'                => '20',
        'POINT'                 => '21',
        'PURCHASE'              => '22',
        'ATTACH_MAIL'           => '23',
        'REGIST'                => '24',
        'OTHERS'                => '25',
    ],

    /** メッセージ添付のフラグ */
    'MESSAGE_TMP_FLG' => [
        'PLAIN' => '0',
        'IMAGE' => '1',
        'MOVIE' => '2',
    ],

    /** メッセージ表示期限(日指定) */
    'MESSAGE_DISPLAY_DEADLINE' => 90,

    /** ノーイメージの画像 */
    'NO_IMAGE_PATH' => 'nopicSp.gif',
    'NO_IMAGE_S_PATH' => 'nopicSpS.gif',

    /** 出演者画像パス */
    'PERFORMER_IMG_FREE_DIR'  => 'performer/profile',
    'PERFORMER_IMG_PAID_DIR'  => 'performer/premium',
    'PERFORMER_IMG_PLAN_DIR' => 'performer/event',
    'PERFORMER_IMG_IDENTIFICATION_DIR' => 'performer/identification',    //身分証明書

    /** 会員プロフィール画像 */
    'MEMBER_PROFILE_IMG_DIR' => 'member/profile',

    /** 画像ステータス */
    'IMG_STAT' => [
        'UNAPPROVED'  => 0,
        'PRIVATE'     => 1,
        'RELEASE'     => 2,
        'USER_DELETE' => 3,
        'MANAGE_NG'   => 9,
        'DRAFT'       => 99,  //temp用の画像だから、管理画面では表示しない（キーのみ設定）
    ],

    /** 動画ステータス */
    'MOVIE_STAT' => [
        'UNAPPROVED'  => 0,
        'PRIVATE'     => 1,
        'RELEASE'     => 2,
        'USER_DELETE' => 3,
        'MANAGE_NG'   => 9,
        'DRAFT'       => 99,    //temp用の画像だから、管理画面では表示しない（キーのみ設定）
    ],

    'IMG_SIZE' => [
        's'  => '140x140',
        'm'  => '220x220',
        'l'  => '480x480',
        'xl' => '640x640',
    ],

    'IMG_CATEGORY' => [
        'SOFT' => '1',
        'SEXY' => '2',
        'PLAN' => '3',
    ],

    'IMG_PROPERTY_SOFT' => [
        'PRINT_CLUB' => '1',
        'FACE'       => '2',
        'FULL_BODY'  => '3',
        'CLOTHING'   => '4',
        'COSPLAY'    => '5',
        'OTHER'      => '99',
    ],

    'IMG_PROPERTY_SEXY' => [
        'FACE'       => '1',
        'FELLATIO'   => '2',
        'CLOTHING'   => '3',
        'UNDARWEAR'  => '4',
        'COSPLAY'    => '5',
        'BATHING'    => '6',
        'FULL_BODY'  => '7',
        'HAND_BRA'   => '8',
        'UPPER_BODY' => '9',
        'UNDER_BODY' => '10',
        'OTHER'      => '99',
    ],

    'IMG_PROPERTY_PLAN' => [
        'TAKING_DOWN'   => '1',
        'XMAS'          => '2',
        'BATHING_SUITS' => '3',
        'HALLOWEEN'     => '4',
    ],

    'MOVIE_CATEGORY' => [
        'SOFT' => '1',
        'SEXY' => '2',
    ],

    'MOVIE_PROPERTY_SOFT' => [
        'FACE'      => '1',
        'FULL_BODY' => '2',
        'CLOTHING'  => '3',
        'COSPLAY'   => '4',
        'OTHER'     => '99',
    ],

    'MOVIE_PROPERTY_SEXY' => [
        'FACE'       => '1',
        'FELLATIO'   => '2',
        'CLOTHING'   => '3',
        'CHANGING'   => '4',
        'UNDERWEAR'  => '5',
        'COSPLAY'    => '6',
        'BATHING'    => '7',
        'FULL_BODY'  => '8',
        'UPPER_BODY' => '9',
        'UNDER_BODY' => '10',
        'MASTURBATE' => '11',
        'OTHER'      => '99',
    ],

    /** 銀行口座種別 */
    'BANK_ACCOUNT_TYPE' => [
        'NORMAL'  => 1,
        'CURRENT' => 2,
        'SAVING'  => 3,
    ],

    /** ピックアップ区分 */
    'PICKUP_CLASS' => [
        'PERFORMER'     => 1,
        'PROF_IMAGE'    => 2,
        'PROF_MOVIE'    => 3,
        'PREMIUM_IMAGE' => 4,
        'PREMIUM_VIDEO' => 5,
        'TAKING_DOWN'   => 6,
        'XMAS'          => 7,
        'BATHING_SUITS' => 8,
        'HALLOWEEN'     => 9,
    ],

    /** ピックアップ作成と編集 */
    'PICKUP_CLASS_EDIT' => [
        'PERFORMER'          => 1,
        'PROF_IMAGE_DATE'    => 2,
        'PROF_MOVIE_DATE'    => 3,
        'PREMIUM_IMAGE_DATE' => 4,
        'PREMIUM_IMAGE_NUM'  => 5,
        'PREMIUM_VIDEO_DATE' => 6,
        'PREMIUM_VIDEO_NUM'  => 7,
        'TAKING_DOWN_DATE'   => 8,
        'TAKING_DOWN_NUM'    => 9,
        'XMAS_DATE'          => 10,
        'XMAS_NUM'           => 11,
        'BATHING_SUITS_DATE' => 12,
        'BATHING_SUITS_NUM'  => 13,
        'HALLOWEEN_DATE'     => 14,
        'HALLOWEEN_NUM'      => 15,
    ],

    /** ピックアップ関連の公開と非公開 */
    'PICKUP_STAT' => [
        'PRIVATE' => 0,
        'OPEN'    => 1,
    ],

    /** ピックアップの表示順 */
    'PICKUP_SORT' => [
        'CREATE' => 1,
        'VIEW'   => 2,
    ],

    /** 会員ランク */
    'MEMBER_RANK' => [
        'FREE'    => 0,
        'MILLAGE' => 1,
        'PAID'    => 2,
    ],

    /** 出演者ランク */
    'PERFORMER_RANK' => [
        'RANK_A' => 0,
        'RANK_B' => 1,
        'RANK_C' => 2,
    ],

    /** おみくじユーザータイプ */
    'OMIKUJI_USER_TYPE' => [
        'M_FREE'    => 1,
        'M_PAID'    => 2,
        'PERFORMER' => 10,
    ],

    /** おみくじ種別の設定数 */
    'OMIKUJI_LOTTERY_NUM' => 5,

    /** 登録できるグループ最大数 */
    'GROUP_LIMIT' => 3,

    /** 退会申請状況 */
    'WITHDRAWAL_STAT' => [
        'UNRESEIVE'  => 1,
        'RESEIVE'    => 2,
    ],

    /** 精算申請状態（performer_infos.monetize_request_stat）*/
    'SETTLEMENT_STAT' => [
        'NO_APPLICATION'        => 0,
        'APPLIED'               => 1,
        'SETTLEMENT_PROCESSING' => 2
    ],

    /** 精算締め状態（monetize_histories.closing_stat）*/
    'CLOSING_STAT' => [
        'UNTREATED' => 0,
        'APPLIED'   => 1,
    ],

    /** 投稿NGフラグ（ブログ、掲示板とつぶやきの共通）*/
    'TOUKOU_NG_FLG' => [
        'OK' => 0,
        'NG' => 1,
    ],

    /** 投稿状態（ブログ、掲示板とつぶやきの共通）*/
    'TOUKOU_STAT' => [
        'UNAPPROVED'   => 0,
        'APPROVED'     => 1,
        'ON_HOLD'      => 2,
        'USER_DELETE'  => 3,
        'ADMIN_DELETE' => 9,
        'DRAFT'        => 99,  //temp用の画像だから、管理画面では表示しない（キーのみ設定）
    ],

    'BLOG_PHOTO_STAT' => [
        'DEFAULT' => 0,
        'DELETE_USER' => 1,
        'DELETE_ADMIN' => 2
    ],

    'BOARD_STAT' => [
        'UNAPPROVED'   => 0,
        'APPROVED'     => 1,
        'ON_HOLD'      => 2,
        'USER_DELETE'  => 3,
        'ADMIN_DELETE' => 9
    ],

    'BLOG_STAT' => [
        'PRIVATE' => 0,
        'OPEN' => 1,
        'ON_HOLD' => 2,
        'USER_DELETE' => 3,
        'ADMIN_DELETE' => 9
    ],

    'BLOG' => [
        'DAILY_LIMIT' => 3,
        'INTERVAL'    => 180
    ],

    'MEMBER_MESSAGE' => [
        'MEMBER_APPROACH' => 1,
        'MEMBER_REPLY' => 2,
        'PERFORMER_APPROACH' => 3,
        'PERFORMER_REPLY' => 4,
        'MEMBER_NOTICE' => 5,
        'PERFORMER_NOTICE' => 6,
        'MANA_REPLY' => 7
    ],

    /** キャンペーン種別 */
    'CAMPAIGN_TYPE' => [
        'UNDEFINE'   => 0,
        'PURCHASE'   => 1,
        'DISCOUNT'   => 2,
        'INVITATION' => 3
    ],

    /** 友達紹介ポイント */
    'INVITATION_POINT' => [
        'INVITOR_MEMBER'    => 100,
        'INVITOR_PERFORMER' => 3000,
        'INVITED_PERFORMER' => 2000,
        'JUDGE_LINE'        => 3000
    ],

    /** 紹介方法 */
    'INVITE_METHOD' => [
        'TWITTER' => 1,
        'LINE'    => 2,
        'MAIL'    => 3,
        'BLOG'    => 4
    ],

    /** SMS種別 */
    'SMS_TYPE' => [
        'PROVISIONAL_REGIST' => 1,
        'REMINDER'           => 2,
        'TO_MEMBER'          => 3,
        'TO_PERFORMER'       => 4
    ],

    /** SMS送信結果 */
    'SMS_RESULT' => [
        'COMPLETE' => 1,
        'ERROR'    => 2,
    ],

    /** マーケット出品状況 */
    'MARKET_GOODS_STATUS' => [
        'UNCERTIFIED' => 0, // 出品中の商品に問題があった場合管理画面から手動で遷移
        'RELEASE'     => 1, // 出品時の初期値
        'PRIVATE'     => 2, // 出品中の商品に対して、ユーザーが任意に遷移可能
        'SOLD'        => 3, // 男性が商品を購入したときに自動的に遷移
        'COMPLETE'    => 4, // 未発送の商品に対して、郵便物の画像を承認した場合、管理画面から手動で遷移
        'CANCEL'      => 5, // 未発送の商品に対して、女性の発送が確認できなかった場合、管理画面から手動で遷移
        'END'         => 6, // 商品出品後、購入されずに30日経過した場合自動的に遷移
        'ADMIN_NG'    => 7, // 出品中の商品に著しい問題があった場合に、管理画面から手動で遷移
        'USER_DELETE' => 8, // 審査中 非表示 出品期間終了 の商品に対して、ユーザーが任意に遷移可能
    ],

    /** 商品カテゴリ */
    'MARKET_GOODS_CATEGORY' => [
        'PANTY'     => 1,
        'BRASSIERE' => 2,
        'UNDERWEAR' => 3,
        'LEG'       => 4,
        'CLOTHES'   => 5,
        'OTHERS'    => 6,
    ],

    /** 商品発送先（自宅 or 郵便局留め）*/
    'MARKET_GOODS_DESTINATION' => [
        'HOME'        => 1,
        'POST_OFFICE' => 2,
    ],

    /** マーケット男性消費ポイントのレート（女性設定価格　×　比率）*/
    'MARKET_PRICE_RATE' => 0.13,

    /** TMP_FLG member_messageboxs */
    'TMP_FLG'=>[
        'ATTACHED_FLG' => 1,
        'ATTACH_IMAGE' => 2,
        'ATTACH_VIDEO' => 3
    ],

    /** ドメイン利用FLG domain_use_flg */
    'DOMAIN_USE_FLG'=>[
        'NONE' => 0,
        'SETTING' => 1
    ],

    /**購入履歴*/
    'CANCELLED' => [
        'NONE' => 0,
        'CANCEL' => 1
    ],

    /** 広告管理（成果認証タイミング）*/
    'AUTH_TIMING' => [
        'REGIST'           => 1,
        'FIRST_LOGIN'      => 2,
        'FIRST_PURCHASE'   => 3,
        'PROFILE_COMPLETE' => 4,
        'TEL_COMPLETE'     => 5,
        'STAT_NORMAL'      => 6,
    ],

    /** 広告管理（売上閲覧許可フラグ）*/
    'SALE_VIEW_FLG' => [
        'NG' => 0,
        'OK' => 1,
    ],
];