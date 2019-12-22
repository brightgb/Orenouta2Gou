<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | of your page. You can override it per page with the title section.
    |
    */

    'title' => env('APP_NAME', ''). '管理画面',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | You can use basic HTML here if you want. The logo has also a mini
    |
    */

    'logo_mini' => env('APP_MINI_NAME', '<b>A</b>P'),

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | blue, black, purple, yellow, red, and green. Each skin also has a
    |
    */

    'skin' => env('APP_ADMIN_SKIN', 'blue'),

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menulist' => [

        //稼働状況
        [
            'title'      => '稼働状況管理',
            'icon'       => 'fa-list',
            'guard'      => 'all_allow|menu_operation_status',
            'route'      => '',
            'is_active'  => [
                             'admin::operationStatus.omikujiHistory.member','admin::operationStatus.omikujiHistory.performer',
                             'admin::operationStatus.omikujiHistory.dailyAggregation.member','admin::operationStatus.omikujiHistory.dailyAggregation.performer',
                             'admin::operationStatus.post.tweet.index', 'admin::operationStatus.post.tweet.nice.index','admin::operationStatus.StatisticsOfMailTypes.performer','admin::operationStatus.CallDetails',
                             'admin::operationStatus.points.used.member','admin::operationStatus.friendpointadditional.member','admin::operationStatus.history.like.blog.performer',
                             'admin::operationStatus.history.like.blog.member'

                            ],
            'submenu'    => [
                [
                    'title'      => 'アクセスログ',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                    'submenu'    => [
                        [
                            'title'      => '会員アクセスログ(日別)',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                        [
                            'title'      => '会員アクセスログ(月別)',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                        [
                            'title'      => '出演者アクセスログ(日別)',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.access.log.performer.date',
                            'is_active'  => ['admin::operationStatus.access.log.performer.date'],
                        ],
                        [
                            'title'      => '出演者アクセスログ(月別)',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                    ],
                ],
                [
                    'title'      => '出演者別稼動集計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '会員ポイント履歴',
                    'icon'       => 'fa-map-o',
                    'guard'      => 'all_allow|pointHistory.member.index',
                    'route'      => 'admin::operationStatus.point.history.member',
                    'is_active'  => ['admin::operationStatus.point.history.member'],
                ],
                [
                    'title'      => '出演者ポイント履歴',
                    'icon'       => 'fa-map',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::operationStatus.point.history.performer',
                    'is_active'  => ['admin::operationStatus.point.history.performer'],
                ],
                [
                    'title'      => '投稿状況',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                    'submenu'    => [
                        [
                            'title'      => '会員掲示板',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.bbs.member',
                            'is_active'  => ['admin::operationStatus.bbs.member'],
                        ],
                        [
                            'title'      => '出演者掲示板',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.bbs.performers',
                            'is_active'  => ['admin::operationStatus.bbs.performers'],
                        ],
                        [
                            'title'      => '会員ブログ',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.blog.member',
                            'is_active'  => ['admin::operationStatus.blog.member'],
                        ],
                        [
                            'title'      => '出演者ブログ',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.blog.performers',
                            'is_active'  => ['admin::operationStatus.blog.performers'],
                        ],
                        [
                            'title'      => 'つぶやき記録',
                            'icon'       => 'fa-commenting-o',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.post.tweet.index',
                            'is_active'  => ['admin::operationStatus.post.tweet.index', 'admin::operationStatus.post.tweet.nice.index'],
                        ],
                    ],
                ],
                [
                    'title'      => 'おみくじ履歴',
                    'icon'       => 'fa-history',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => ['admin::operationStatus.omikujiHistory.member','admin::operationStatus.omikujiHistory.performer',
                                        'admin::operationStatus.omikujiHistory.dailyAggregation.member','admin::operationStatus.omikujiHistory.dailyAggregation.performer'],
                    'submenu'    => [
                        [
                            'title'      => '会員おみくじ履歴',
                            'icon'       => 'fa-folder-o',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.omikujiHistory.member',
                            'is_active'  => ['admin::operationStatus.omikujiHistory.member'],
                        ],
                        [
                            'title'      => '会員利用集計',
                            'icon'       => 'fa-folder-open-o',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.omikujiHistory.dailyAggregation.member',
                            'is_active'  => ['admin::operationStatus.omikujiHistory.dailyAggregation.member'],
                        ],
                        [
                            'title'      => '出演者おみくじ履歴',
                            'icon'       => 'fa-folder',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.omikujiHistory.performer',
                            'is_active'  => ['admin::operationStatus.omikujiHistory.performer'],
                        ],
                        [
                            'title'      => '出演者利用集計',
                            'icon'       => 'fa-folder-open',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::operationStatus.omikujiHistory.dailyAggregation.performer',
                            'is_active'  => ['admin::operationStatus.omikujiHistory.dailyAggregation.performer'],
                        ],
                    ],
                ],
                [
                    'title'      => '友達紹介ポイント追加記録',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::operationStatus.friendpointadditional.member',
                    'is_active'  => ['admin::operationStatus.friendpointadditional.member'],
                ],
                [
                    'title'      => '通話明細',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::operationStatus.CallDetails',
                    'is_active'  => ['admin::operationStatus.CallDetails'],
                ],
                [
                    'title'      => '日別会員保有ポイント集計',
                    'icon'       => 'fa-file-powerpoint-o',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::operationStatus.holdpoint.member',
                    'is_active'  => ['admin::operationStatus.holdpoint.member'],
                ],
                [
                    'title'      => '会員別使用ポイント集計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::operationStatus.points.used.member',
                    'is_active'  => ['admin::operationStatus.points.used.member'],
                ],
                [
                    'title'      => '出演者メール送信数種別',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::operationStatus.StatisticsOfMailTypes.performer',
                    'is_active'  => ['admin::operationStatus.StatisticsOfMailTypes.performer'],
                ],
            ],
        ],
        //売上管理
        [
            'title'      => '売上管理',
            'icon'       => 'fa-line-chart',
            'guard'      => 'all_allow|menu_sales_management',
            'route'      => '',
            'is_active'  => ['admin::sales.dailyAggregation','admin::sales.settlementRecord'],
            'submenu'    => [
                [
                    'title'      => '日別売上状況',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::sales.dailyAggregation',
                    'is_active'  => ['admin::sales.dailyAggregation'],
                ],
                [
                    'title'      => '決済記録',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::sales.settlementRecord',
                    'is_active'  => ['admin::sales.settlementRecord'],
                ],
                [
                    'title'      => '決済処理',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [''],
                ],
                [
                    'title'      => '入金記録',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::sales.payment_record',
                    'is_active'  => ['admin::sales.payment_record'],
                ],
            ],
        ],

        // 出演者管理: Performer management
        [
            'title'      => '出演者管理',
            'icon'       => 'fa-users',
            'guard'      => 'all_allow|menu_cast_control',
            'route'      => '',
            'is_active'  => ['admin::performers.index','admin::performers.detail','admin::performers.create',
                             'admin::performers.pickup.index', 'admin::performers.pickup.create','admin::performers.pickup.edit',
                             'admin::performers.profileImgs.index','admin::performers.profileImgs.edit',
                             'admin::performers.registProhibited.index','admin::performers.registProhibited.create','admin::performers.registProhibited.edit',
                             'admin::performers.premiumImgs.index','admin::performers.premiumImgs.edit','admin::performers.planningImage.index','admin::performers.planningImage.edit'
                            ],
            'submenu'    => [
                [
                    'title'      => '出演者検索',
                    'icon'       => 'fa-search',
                    'guard'      => 'all_allow|performers.index',
                    'route'      => 'admin::performers.index',
                    'is_active'  => ['admin::performers.index'],
                ],
                [
                    'title'      => '出演者詳細',
                    'icon'       => 'fa-file-text-o',
                    'guard'      => 'all_allow|performers.show',
                    'route'      => 'admin::performers.detail',
                    'is_active'  => ['admin::performers.detail'],
                ],
                [
                    'title'      => '出演者新規登録',
                    'icon'       => 'fa-user-plus',
                    'guard'      => 'all_allow|performers.create',
                    'route'      => 'admin::performers.performers_register',
                    'is_active'  => ['admin::performers.performers_register'],
                ],
                [
                    'title'      => '新規登録出演者認証',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => 'ピックアップ',
                    'icon'       => 'fa-star-o',
                    'guard'      => 'all_allow|pickup_categories.index',
                    'route'      => 'admin::performers.pickup.index',
                    'is_active'  => ['admin::performers.pickup.index','admin::performers.pickup.create','admin::performers.pickup.edit'],
                ],
                [
                    'title'      => '画像・動画管理',//Image and video management
                    'icon'       => 'fa-file-archive-o',
                    'guard'      => 'all_allow|performers.files',
                    'route'      => '',
                    'is_active'  => ['admin::performers.profileImgs.index','admin::performers.profileImgs.edit',
                                     'admin::performers.premiumImgs.index','admin::performers.premiumImgs.edit',
                                     'admin::performers.planningImage.index','admin::performers.planningImage.edit'
                                    ],
                    'submenu'    => [
                        [
                            'title'      => '画像管理',//Image management
                            'icon'       => 'fa-camera-retro',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => ['admin::performers.profileImgs.index','admin::performers.profileImgs.edit',
                                             'admin::performers.premiumImgs.index','admin::performers.premiumImgs.edit',
                                             'admin::performers.planningImage.index','admin::performers.planningImage.edit'
                                            ],
                            'submenu'    => [
                                [
                                    'title'      => 'プロフィール画像',
                                    'icon'       => 'fa-file-image-o',
                                    'guard'      => 'all_allow',
                                    'route'      => 'admin::performers.profileImgs.index',
                                    'is_active'  => ['admin::performers.profileImgs.index','admin::performers.profileImgs.edit'],
                                ],
                                [
                                    'title'      => 'プレミアム画像',
                                    'icon'       => 'fa-picture-o',
                                    'guard'      => 'all_allow',
                                    'route'      => 'admin::performers.premiumImgs.index',
                                    'is_active'  => ['admin::performers.premiumImgs.index','admin::performers.premiumImgs.edit'],
                                ],
                                [
                                    'title'      => '企画画像',
                                    'icon'       => 'fa-picture-o',
                                    'guard'      => 'all_allow',
                                    'route'      => 'admin::performers.planningImage.index',
                                    'is_active'  => ['admin::performers.planningImage.index','admin::performers.planningImage.edit'],
                                ],
                            ],
                        ],
                        [
                            'title'      => '動画管理',//Video management
                            'icon'       => 'fa-video-camera',
                            'guard'      => 'all_allow',
                            'route'      => 'admin::members.create',
                            'is_active'  => ['performers'],
                            'submenu'    => [
                                [
                                    'title'      => 'プロフィール動画',//Profile video
                                    'icon'       => 'fa-film',
                                    'guard'      => 'all_allow',
                                    'route'      => 'admin::performers.profileVideos.index',//#17772
                                    'is_active'  => ['admin::performers.profileVideos.index'],
                                ],
                                [
                                    'title'      => 'プレミアム動画',//Premium video 
                                    'icon'       => 'fa-file-video-o',
                                    'guard'      => 'all_allow',
                                    'route'      => 'admin::performers.premiumVideos.index',//#17773
                                    'is_active'  => ['admin::performers.premiumVideos.index'],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'title'      => 'マーケット管理',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                    'submenu'    => [
                        [
                            'title'      => '出品中の商品一覧',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                        [
                            'title'      => '審査中の商品一覧',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                        [
                            'title'      => '購入済み商品一覧',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                        [
                            'title'      => '発送済み商品一覧',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                        [
                            'title'      => 'キャンセル商品一覧',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                        [
                            'title'      => '非公開商品一覧',
                            'icon'       => 'fa-genderless',
                            'guard'      => 'all_allow',
                            'route'      => '',
                            'is_active'  => [],
                        ],
                    ],
                ],
                [
                    'title'      => '出演者別精算集計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '精算履歴一覧',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '登録禁止出演者',
                    'icon'       => 'fa-user-times',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::performers.registProhibited.index',
                    'is_active'  => ['admin::performers.registProhibited.index','admin::performers.registProhibited.create','admin::performers.registProhibited.edit'],
                ],
                [
                    'title'      => '出演者退会申請履歴',
                    'icon'       => 'fa-minus-square',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::performers.resign',
                    'is_active'  => ['admin::performers.resign','admin::performers.resign.edit','admin::performers.resign.edit.update','admin::performers.resign.edit.reverse','admin::performers.resign.edit.reseive'],
                ],
            ],
        ],
        // 会員管理
        [
            'title'      => '会員管理',
            'icon'       => 'fa-users',
            'guard'      => 'all_allow|menu_member_management',
            'route'      => '',
            'is_active'  => ['admin::members.index','admin::members.detail','admin:members.create',
                             'admin::members.profileImgs.index','admin::members.profileImgs.edit','admin::members.callWaitingList.index',
                             'admin::members.callWaitingList.detail'
                            ],
            'submenu'    => [
                [
                    'title'      => '会員検索',
                    'icon'       => 'fa-search',
                    'guard'      => 'all_allow|members.index',
                    'route'      => 'admin::members.index',
                    'is_active'  => ['admin::members.index'],
                ],
                [
                    'title'      => '会員詳細',
                    'icon'       => 'fa-file-text-o',
                    'guard'      => 'all_allow|members.show',
                    'route'      => 'admin::members.detail',
                    'is_active'  => ['admin::members.detail'],
                ],
                [
                    'title'     => '会員新規登録',
                    'icon'      => 'fa-user-plus',
                    'guard'     => 'all_allow|members.create',
                    'route'     => 'admin::members.create',
                    'is_active' => ['admin::members.create'],
                ],
                [
                    'title'      => 'プロフィール画像',
                    'icon'       => 'fa-file-image-o',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::members.profileImgs.index',
                    'is_active'  => ['admin::members.profileImgs.index','admin::members.profileImgs.edit'],
                ],
                [
                    'title'      => '電話待機一覧',
                    'icon'       => 'fa-whatsapp',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::members.callWaitingList.index',
                    'is_active'  => ['admin::members.callWaitingList.index','admin::members.callWaitingList.detail'],
                ],
                [ //#17677
                    'title'      => '会員退会申請履歴',
                    'icon'       => 'fa-minus-square',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::members.resign_list', 
                    'is_active'  => ['admin::members.resign_list'],
                ],
            ]

        ],
        // サイト管理
        [
            'title'     => 'サイト管理',
            'icon'      => 'fa-cogs',
            'guard'     => 'all_allow|menu_site_setting',
            'route'     => '',
            'is_active' => [
                'admin::settings.purchase_settings.index','admin::settings.purchase_settings.show','admin::settings.purchase_settings.create','admin::settings.purchase_settings.edit'
                ,'admin::settings.members_rank.index','admin::settings.members_rank.edit'
                ,'admin::settings.performers_rank.index','admin::settings.performers_rank.edit'
                ,'admin::settings.omikuji.index','admin::settings.omikuji.edit'
                ,'admin::settings.mobile_money_transfer.index','admin::settings.mobile_money_transfer.create','admin::settings.mobile_money_transfer.edit'
                ,'admin::settings.member_notifies.index','admin::settings.replace_url.index'

            ],
            'submenu'    => [
                [
                    'title'      => '会員用管理者連絡',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.member_notifies.index',
                    'is_active'  => ['admin::settings.member_notifies.index'],
                ],
                [
                    'title'      => '出演者用管理者連絡',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.performer_notifies.index', //#18106
                    'is_active'  => ['admin::settings.performer_notifies.index']
                ],
                [
                    'title'      => '会員ランク設定',
                    'icon'       => 'fa-male',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.members_rank.index',
                    'is_active'  => ['admin::settings.members_rank.index','admin::settings.members_rank.edit']
                ],
                [
                    'title'      => '出演者ランク設定',
                    'icon'       => 'fa-female',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.performers_rank.index',
                    'is_active'  => ['admin::settings.performers_rank.index','admin::settings.performers_rank.edit']
                ],
                [
                    'title'      => '購入設定',
                    'icon'       => 'fa-usd',
                    'guard'      => 'all_allow|purchaseSettings.index',
                    'route'      => 'admin::settings.purchase_settings.index',
                    'is_active'  => ['admin::settings.purchase_settings.index','admin::settings.purchase_settings.show','admin::settings.purchase_settings.create','admin::settings.purchase_settings.edit']
                ],
                [
                    'title'      => 'ドコモケータイ送金設定',
                    'icon'       => 'fa-mobile',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.mobile_money_transfer.index',
                    'is_active'  => ['admin::settings.mobile_money_transfer.index','admin::settings.mobile_money_transfer.create','admin::settings.mobile_money_transfer.edit'],
                ],
                [
                    'title'      => '決済設定',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.show.setting_payment',
                    'is_active'  => ['admin::settings.show.setting_payment'],
                ],
                [
                    'title'      => 'ポイント還元設定',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.show.setting_point',
                    'is_active'  => ['admin::settings.show.setting_point'],
                ],
                [
                    'title'      => 'キャンペーン設定',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.show.setting_campain',
                    'is_active'  => ['admin::settings.show.setting_campain'],
                ],
                //#18328: date payment 報酬支払日
                [
                    'title'      => '報酬支払予定日',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.performer_payment_plan.index', 
                    'is_active'  => ['admin::settings.performer_payment_plan.index']
                ],
                [
                    'title'      => 'おみくじ設定',
                    'icon'       => 'fa-sticky-note',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::settings.omikuji.index',
                    'is_active'  => ['admin::settings.omikuji.index','admin::settings.omikuji.edit'],
                ],
            ],
        ],
        //メール管理
        [
            'title'      => 'メール管理',
            'icon'       => 'fa-envelope',
            'guard'      => 'all_allow|menu_mails',
            'route'      => '',
            'is_active'  => ['admin::ng_words.index', 'admin::ng_words.create', 'admin::ng_words.edit','admin::open.mail.performer','admin::bulk.mail.record','admin::mail.domain.setting',
                             'admin::mail_template.index','admin::smsrecord.sms_list'],
            'submenu'    => [
                [
                    'title'      => 'メールテンプレート',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::mail_template.index',
                    'is_active'  => ['admin::mail_template.index'],
                ],
                [
                    'title'      => 'メール記録',//#18053
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::mail_record.index',
                    'is_active'  => ['admin::mail_record.index'],
                ],
                [
                    'title'      => '一括メール記録',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::bulk.mail.record',
                    'is_active'  => ['admin::bulk.mail.record'],
                ],
                [
                    'title'      => 'NGワード',
                    'icon'       => 'fa-ban',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::ng_words.index',
                    'is_active'  => ['admin::ng_words.index', 'admin::ng_words.create', 'admin::ng_words.edit']
                ],
                [
                    'title'      => 'メール文章ドメイン設定',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::mail.domain.setting',
                    'is_active'  => ['admin::mail.domain.setting'],
                ],
                [
                    'title'      => 'SMS送信',
                    'icon'       => 'fa-comment',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::sms_send',
                    'is_active'  => ['admin::sms_send'],
                ],
                [
                    'title'      => 'SMS記録',
                    'icon'       => 'fa-comment-o',
                    'guard'      => 'all_allow',
                    'route'      => 'admin::smsrecord.sms_list',
                    'is_active'  => ['admin::smsrecord.sms_list'],
                ],
            ],
        ],
        //広告管理
        [
            'title'      => '広告管理',
            'icon'       => 'fa-envelope',
            'guard'      => 'all_allow|menu_mails',
            'route'      => '',
            'is_active'  => [''],
            'submenu'    => [
                [
                    'title'      => '広告コード',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '広告グループ',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '広告グループ割当',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => 'アフィリエータ－広告コード割当',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '会員広告コード別稼働集計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '出演者広告コード別稼働集計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => []
                ],
                [
                    'title'      => '会員広告コード日別月計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '出演者広告コード日別月計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '出演者広告コード日別月計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '広告別売上状況',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '会員広告グループ別詳細稼働集計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '出演者広告グループ別詳細稼働集計',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
                [
                    'title'      => '代理店向けID・PASS発行',
                    'icon'       => 'fa-genderless',
                    'guard'      => 'all_allow',
                    'route'      => '',
                    'is_active'  => [],
                ],
            ],
        ],
        // 管理者設定 : Administrator settings
        [
            'title'      => '管理者設定',
            'icon'       => 'fa-users',
            'guard'      => 'all_allow|menu_admin_setting',
            'route'      => '',
            'is_active'  => [
                'admin::permissions.index', 'admin::permissions.edit', 'admin::permissions.create',
                'admin::roles.index', 'admin::roles.edit', 'admin::roles.create',
                'admin::admins.index', 'admin::admins.edit', 'admin::admins.create',
            ],
            'submenu'    => [
                [
                    'title'      => 'パーミッション',
                    'icon'       => 'fa-lock',
                    'guard'      => '',
                    'route'      => 'admin::permissions.index',
                    'is_active'  => ['admin::permissions.index', 'admin::permissions.edit', 'admin::permissions.create']
                ],
                [
                    'title'      => '権限設定',
                    'icon'       => 'fa-unlock-alt',
                    'guard'      => 'all_allow|roles.index',
                    'route'      => 'admin::roles.index',
                    'is_active'  => ['admin::roles.index', 'admin::roles.edit', 'admin::roles.create']
                ],
                [
                    'title'      => '管理者一覧',
                    'icon'       => 'fa-user',
                    'guard'      => 'all_allow|admins.index',
                    'route'      => 'admin::admins.index',
                    'is_active'  => ['admin::admins.index', 'admin::admins.edit', 'admin::admins.create']
                ],
            ],
        ],
        [
            'title'     => 'パスワード変更',
            'icon'      => 'fa-key',
            'guard'     => 'all_allow',
            'route'     => 'admin::admins.password',
            'is_active' => ['admin::admins.password'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

];
