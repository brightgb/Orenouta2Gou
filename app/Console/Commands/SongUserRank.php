<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Model\SongUser;
use App\Model\SongUserAction;

class SongUserRank extends Command
{
    protected $signature = 'SongUserRank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '歌い手ランクとアドバイザーランクを更新';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::setDefaultDriver('batch_song_user_rank_log');
        Log::info($this->description. ':開始');

        // 会員のランクをリセット
        SongUser::lockForUpdate()->update([
            'singer_rank'  => config('constSong.singer_rank_key.default'),
            'advicer_rank' => config('constSong.advicer_rank_key.default')
        ]);

        #################### 人気歌手＆人気講師 ####################

        // 歌い手ランク（平均獲得アドバイス）
        $averages = SongUserAction::selectRaw('
                                truncate(get_advice_cnt / sing_song_cnt + 0.005, 2) AS average,
                                member_id
                            ')->orderBy('average', 'desc')  // ↑ 小数点第３位を四捨五入
                              ->pluck('average', 'member_id')->toArray();
        // 上位５人を記録
        $best_advice_getter = [];
        $high_v = 0;
        foreach ($averages as $key => $value) {
            if (!empty($value)) {
                // 最初のキーなら最高値に設定
                if ($high_v == 0) {
                    $high_v = $value;
                    // 上位の会員に追加
                    array_push($best_advice_getter, $key);
                } else {
                    // value が最高値と同じなら上位の人数に加算
                    if ($high_v == $value) {
                        array_push($best_advice_getter, $key);
                    } else {
                        // value が最高値より低い場合、上位の人数を確認
                        $count = count($best_advice_getter);
                        if ($count >= 5) {
                            // ５人に達してたらカウントを止める
                            break;
                        } else {
                            // value を次の最高値に設定
                            $high_v = $value;
                            array_push($best_advice_getter, $key);
                        }
                    }
                }
            }
        }

        // 歌い手ランク（獲得お気に入り数）
        $favorites = SongUserAction::whereNotIn('member_id', $best_advice_getter)
                                   ->where('get_favorite_cnt', '>', 0)
                                   ->orderBy('get_favorite_cnt', 'desc')
                                   ->pluck('get_favorite_cnt', 'member_id')->toArray();
        // 上位５人を記録
        $best_favorite_getter = [];
        $high_v = 0;
        foreach ($favorites as $key => $value) {
            // 最初のキーなら最高値に設定
            if ($high_v == 0) {
                $high_v = $value;
                // 上位の会員に追加
                array_push($best_favorite_getter, $key);
            } else {
                // value が最高値と同じなら上位の人数に加算
                if ($high_v == $value) {
                    array_push($best_favorite_getter, $key);
                } else {
                    // value が最高値より低い場合、上位の人数を確認
                    $count = count($best_favorite_getter);
                    if ($count >= 5) {
                        // ５人に達してたらカウントを止める
                        break;
                    } else {
                        // value を次の最高値に設定
                        $high_v = $value;
                        array_push($best_favorite_getter, $key);
                    }
                }
            }
        }

        // アドバイザーランク
        $advicers = SongUserAction::selectRaw('
                                    truncate(get_nice_cnt / all_advice_cnt + 0.005, 2) AS average,
                                    member_id
                                ')->orderBy('average', 'desc')
                                  ->pluck('average', 'member_id')->toArray();
        // 上位５人を記録
        $best_nice_getter = [];
        $high_v = 0;
        foreach ($advicers as $key => $value) {
            if (!empty($value)) {
                // 最初のキーなら最高値に設定
                if ($high_v == 0) {
                    $high_v = $value;
                    // 上位の会員に追加
                    array_push($best_nice_getter, $key);
                } else {
                    // value が最高値と同じなら上位の人数に加算
                    if ($high_v == $value) {
                        array_push($best_nice_getter, $key);
                    } else {
                        // value が最高値より低い場合、上位の人数を確認
                        $count = count($best_nice_getter);
                        if ($count >= 5) {
                            // ５人に達してたらカウントを止める
                            break;
                        } else {
                            // value を次の最高値に設定
                            $high_v = $value;
                            array_push($best_nice_getter, $key);
                        }
                    }
                }
            }
        }

        // 歌い手ランク更新
        SongUser::whereIn('id', array_merge($best_advice_getter, $best_favorite_getter))
                ->lockForUpdate()
                ->update(['singer_rank' => config('constSong.singer_rank_key.gold')]);
        // アドバイザーランク更新
        SongUser::whereIn('id', $best_nice_getter)
                ->lockForUpdate()
                ->update(['advicer_rank' => config('constSong.advicer_rank_key.gold')]);

        // 更新済みの会員を外しておく
        $except_singers = array_merge($best_advice_getter, $best_favorite_getter);
        $except_advicers = $best_nice_getter;


        #################### 注目歌手＆的確な助言師 ####################


        // 歌い手ランク（平均獲得アドバイス）
        $averages = SongUserAction::selectRaw('
                                truncate(get_advice_cnt / sing_song_cnt + 0.005, 2) AS average,
                                member_id
                            ')->whereNotIn('member_id', $except_singers)
                              ->orderBy('average', 'desc')
                              ->pluck('average', 'member_id')->toArray();
        // 上位５人を記録
        $best_advice_getter = [];
        $high_v = 0;
        foreach ($averages as $key => $value) {
            if (!empty($value)) {
                // 最初のキーなら最高値に設定
                if ($high_v == 0) {
                    $high_v = $value;
                    // 上位の会員に追加
                    array_push($best_advice_getter, $key);
                } else {
                    // value が最高値と同じなら上位の人数に加算
                    if ($high_v == $value) {
                        array_push($best_advice_getter, $key);
                    } else {
                        // value が最高値より低い場合、上位の人数を確認
                        $count = count($best_advice_getter);
                        if ($count >= 5) {
                            // ５人に達してたらカウントを止める
                            break;
                        } else {
                            // value を次の最高値に設定
                            $high_v = $value;
                            array_push($best_advice_getter, $key);
                        }
                    }
                }
            }
        }

        // 歌い手ランク（獲得お気に入り数）
        $favorites = SongUserAction::whereNotIn('member_id', $best_advice_getter)
                                   ->whereNotIn('member_id', $except_singers)
                                   ->where('get_favorite_cnt', '>', 0)
                                   ->orderBy('get_favorite_cnt', 'desc')
                                   ->pluck('get_favorite_cnt', 'member_id')->toArray();
        // 上位５人を記録
        $best_favorite_getter = [];
        $high_v = 0;
        foreach ($favorites as $key => $value) {
            // 最初のキーなら最高値に設定
            if ($high_v == 0) {
                $high_v = $value;
                // 上位の会員に追加
                array_push($best_favorite_getter, $key);
            } else {
                // value が最高値と同じなら上位の人数に加算
                if ($high_v == $value) {
                    array_push($best_favorite_getter, $key);
                } else {
                    // value が最高値より低い場合、上位の人数を確認
                    $count = count($best_favorite_getter);
                    if ($count >= 5) {
                        // ５人に達してたらカウントを止める
                        break;
                    } else {
                        // value を次の最高値に設定
                        $high_v = $value;
                        array_push($best_favorite_getter, $key);
                    }
                }
            }
        }

        // アドバイザーランク
        $advicers = SongUserAction::selectRaw('
                                    truncate(get_nice_cnt / all_advice_cnt + 0.005, 2) AS average,
                                    member_id
                                ')->whereNotIn('member_id', $except_advicers)
                                  ->orderBy('average', 'desc')
                                  ->pluck('average', 'member_id')->toArray();
        // 上位５人を記録
        $best_nice_getter = [];
        $high_v = 0;
        foreach ($advicers as $key => $value) {
            if (!empty($value)) {
                // 最初のキーなら最高値に設定
                if ($high_v == 0) {
                    $high_v = $value;
                    // 上位の会員に追加
                    array_push($best_nice_getter, $key);
                } else {
                    // value が最高値と同じなら上位の人数に加算
                    if ($high_v == $value) {
                        array_push($best_nice_getter, $key);
                    } else {
                        // value が最高値より低い場合、上位の人数を確認
                        $count = count($best_nice_getter);
                        if ($count >= 5) {
                            // ５人に達してたらカウントを止める
                            break;
                        } else {
                            // value を次の最高値に設定
                            $high_v = $value;
                            array_push($best_nice_getter, $key);
                        }
                    }
                }
            }
        }

        // 歌い手ランク更新
        SongUser::whereIn('id', array_merge($best_advice_getter, $best_favorite_getter))
                ->lockForUpdate()
                ->update(['singer_rank' => config('constSong.singer_rank_key.silver')]);
        // アドバイザーランク更新
        SongUser::whereIn('id', $best_nice_getter)
                ->lockForUpdate()
                ->update(['advicer_rank' => config('constSong.advicer_rank_key.silver')]);

        Log::info($this->description. ':終了');
    }
}