<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section
    | like so: @section('title', 'Dashboard | My Great Admin Panel')
    |
    */

    'title' => '管理画面',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '管理画面',

    'logo_mini' => '管理',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | The dashboard_url is used for the link behind the logo in the upper
    | left corner. The logout_url is used for the logout button in the
    | upper right corner. They are passed through the url() helper.
    |
    */

    'dashboard_url' => 'admin/dashboard',

    'logout_url' => 'auth/logout',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header.
    |
    */

    'menu' => [
        [
            'menu_id' => 1,
            'text'    => 'HOME',
            'url'     => '/admin',
            'icon'    => 'genderless',
            'guard'   => 'all_allow',
        ],
        [
            'menu_id'  => 'A',
            'text'     => '俺の歌を育てろ',
            'url'      => '',
            'icon'     => 'genderless',
            'guard'    => 'all_allow',
            'sub_menu' => 
            [
                [
                    'menu_id' => 2,
                    'text'    => '会員検索',
                    'url'     => '/admin/orenouta/user_search',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 3,
                    'text'    => '会員詳細',
                    'url'     => '/admin/orenouta/user_detail',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 4,
                    'text'    => '歌唱曲一覧',
                    'url'     => '/admin/orenouta/song_list',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 5,
                    'text'    => 'コメント一覧',
                    'url'     => '/admin/orenouta/comment_list',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 6,
                    'text'    => 'お問い合わせ・要望',
                    'url'     => '/admin/orenouta/request_list',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 7,
                    'text'    => '新着情報の登録',
                    'url'     => '/admin/orenouta/infomation',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
            ],
        ],
        [
            'menu_id'  => 'B',
            'text'     => '俺の漫才を育てろ',
            'url'      => '',
            'icon'     => 'genderless',
            'guard'    => 'all_allow',
            'sub_menu' => 
            [
                // サブメニュー
            ],
        ],
        [
            'menu_id'  => 'C',
            'text'     => '管理者権限',
            'url'      => '',
            'icon'     => 'genderless',
            'guard'    => 'all_allow',
            'sub_menu' => 
            [
                [
                    'menu_id' => 8,
                    'text'    => 'アカウント管理',
                    'url'     => '/admin/account',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
            ],
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