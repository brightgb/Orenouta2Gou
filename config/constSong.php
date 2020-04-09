<?php

return [
    /* 歌い手ランクのキーとラベル */
    'singer_rank_key' => [
        'default' => 0,
        'silver'  => 1,
        'gold'    => 2
    ],

    'singer_rank_label' => [
        0 => '通常',  // ユーザー側では表示しない
        1 => '注目歌手',
        2 => '人気歌手'
    ],

    /* アドバイザーランクのキーとラベル */
    'advicer_rank_key' => [
        'default' => 0,
        'silver'  => 1,
        'gold'    => 2
    ],

    'advicer_rank_label' => [
        0 => '通常',  // ユーザー側では表示しない
        1 => '的確な助言師',
        2 => '人気講師'
    ],
];