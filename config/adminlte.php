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

    'logo' => '俺の歌を育てろ',

    'logo_mini' => '俺歌',

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

    /*'menu' => [
        'MAIN NAVIGATION',
        [
            'text' => 'Blog',
            'url' => 'admin/blog',
        ],
        [
            'text' => 'Pages',
            'url' => 'admin/pages',
            'icon' => 'file'
        ],
        'ACCOUNT SETTINGS',
        [
            'text' => 'Profile',
            'url' => 'admin/settings',
            'icon' => 'user'
        ],
        [
            'text' => 'Change Password',
            'url' => 'admin/settings',
            'icon' => 'lock'
        ],
    ],*/
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
            'text'     => '歌唱曲管理',
            'url'      => '',
            'icon'     => 'genderless',
            'guard'    => 'all_allow',
            'sub_menu' => 
            [
                [
                    'menu_id' => 2,
                    'text'    => '歌唱曲一覧',
                    'url'     => '/admin/song_list',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 3,
                    'text'    => 'コメント一覧',
                    'url'     => '/admin/comment_list',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 4,
                    'text'    => '歌唱曲の投稿',
                    'url'     => '/admin/song_post',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
            ],
        ],
        [
            'menu_id'  => 'B',
            'text'     => 'おまけ管理',
            'url'      => '',
            'icon'     => 'genderless',
            'guard'    => 'all_allow',
            'sub_menu' => 
            [
                [
                    'menu_id' => 5,
                    'text'    => 'キャスターボード',
                    'url'     => '/admin',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 6,
                    'text'    => '輪ゴム飛ばし',
                    'url'     => '/admin',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 7,
                    'text'    => 'DJプレイ',
                    'url'     => '/admin',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
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
                    'text'    => 'お問い合わせ・要望',
                    'url'     => '/admin/request_list',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 9,
                    'text'    => '新着情報の登録',
                    'url'     => '/admin/infomation',
                    'icon'    => 'genderless',
                    'guard'   => 'all_allow',
                ],
                [
                    'menu_id' => 10,
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