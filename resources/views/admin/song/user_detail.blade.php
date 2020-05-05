@extends('layout.admin.admin_common')

@section('title', '会員詳細')
@section('content_header', '会員詳細')

@section('content')
    <div class="search_aria">
        <form method="get">
            <table id="serch_form1" border="1" style="table-layout: fixed; max-width: 100%;">
                <tr>
                    <th style="width: 100px; text-align: center;">ユーザーID</th>
                    <td style="width: 200px;">
                        <input type="text" name="userid" value="{{ $userid }}">
                    </td>
                    <th style="width: 100px; text-align: center;">ニックネーム</th>
                    <td style="width: 200px;">
                        <input type="text" name="nickname" value="{{ $nickname }}">
                    </td>
                </tr>
            </table>
            <div>
                <button class="btn">検索</button>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div style="margin-bottom: 10px;">
            <strong><center>{{ session('success') }}</center></strong>
        </div>
    @endif
    @if (!empty($error))
        <font color="red"><strong><center>{{ $error }}</center></strong></font>
    @endif

    @if (!empty($member_data))
        <div class="result_aria">
            <table id="serch_form2" style="width: 100%; table-layout: fixed;">
                <tr style="height: 50px;">
                    <th style="text-align: center;">ユーザーID</th>
                    <th style="text-align: center;">ニックネーム</th>
                    <th style="text-align: center;">歌い手<br>ランク</th>
                    <th style="text-align: center;">アドバイザー<br>ランク</th>
                    <th style="text-align: center;">登録日</th>
                    <th style="text-align: center;">状態</th>
                    <th style="text-align: center;">獲得<br>アドバイス</th>
                    <th style="text-align: center;">投稿曲数</th>
                    <th style="text-align: center;">獲得<br>いいね</th>
                    <th style="text-align: center;">アドバイス<br>送信</th>
                    <th style="text-align: center;">獲得<br>お気に入り</th>
                </tr>
                <tr v-for="row in response.data" style="text-align: center; height: 50px;">
                    <td>
                        {{ $member_data->userid }}
                    </td>
                    <td>
                        {{ $member_data->nickname }}
                    </td>
                    <td>
                        {{ $member_data->singer_rank }}
                    </td>
                    <td>
                        {{ $member_data->advicer_rank }}
                    </td>
                    <td>
                        {{ $member_data->create_date }}
                    </td>
                    <td>
                        @if ($member_data->resign_flg == 1)
                            退会
                        @else
                            活動中
                        @endif
                    </td>
                    <td>
                        {{ $member_data->get_advice_cnt }}
                    </td>
                    <td>
                        {{ $member_data->sing_song_cnt }}
                    </td>
                    <td>
                        {{ $member_data->get_nice_cnt }}
                    </td>
                    <td>
                        {{ $member_data->all_advice_cnt }}
                    </td>
                    <td>
                        {{ $member_data->get_favorite_cnt }}
                    </td>
                </tr>
            </table>
        </div>

        <form onSubmit="return check()" method="post" action="/admin/orenouta/user_update">
            {{ csrf_field() }}
            <label style="margin-top: 50px;">管理メモ編集</label>
            <input type="hidden" name="member_userid" value="{{ $member_data->userid }}">
            <textarea name="admin_memo">{{ $member_data->admin_memo }}</textarea>
            <button class="btn" style="float: right;">更新</button>
        </form>
    @endif

    <div id="song_user_detail">
        @if (!empty($member_data))
            <input type="hidden" v-model="userid">
        @endif
        {{ csrf_field() }}
        <div class="result_aria" v-if="success" v-cloak>
            <label style="margin-top: 50px;">お気に入り登録リスト</label>
            <div>
                @include('layout.admin.vue_pagenation')
            </div>
            <div>
                <table id="serch_form2" style="width: 100%; table-layout: fixed;">
                    <tr style="height: 30px;">
                        <th style="text-align: center;">ニックネーム</th>
                        <th style="text-align: center;">お気に入り</th>
                        <th style="text-align: center;">被お気に入り</th>
                    </tr>
                    <tr v-for="row in response.data" style="text-align: center; height: 30px;">
                        <td>@{{ row.nickname }}</td>
                        <td>
                            <span v-if="row.fav_send" style="font-size: large;"><strong>〇</strong></span>
                        </td>
                        <td>
                            <span v-if="row.fav_receive" style="font-size: large;"><strong>〇</strong></span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/default.form.css') }}">
<style>
    .search_aria {
        width: 100%;
        background-color: white;
        margin: 0 auto 10px auto;
        padding: 10px;
    }
    .result_aria {
        width: 100%;
        margin: 0 auto;
    }
    .btn {
        margin-top: 10px;
        width: 70px;
        height: 40px;
        border-radius: 10px;
        background-color: #3c8dbc;
        color: #ffffff;
        font-size: large;
    }
    textarea {
        width: 100%;
        height: 100px;
    }
    [v-cloak] {
        display: none;
    }
</style>
@stop

@section('js')
<script>
    $('.sidebar-menu li').removeClass('active');
    $('#A').addClass('active');
    $('#3').addClass('active');

    function check() {
        if (window.confirm('この内容で更新しますか？')) {
            return true;
        }
        else {
            return false;
        }
    }

    const flg = "<?php echo $flg; ?>";
    const userid = "<?php echo $userid; ?>";
    Vue.prototype.$http = axios;
    new Vue({
        el: '#song_user_detail',
        data: {
            success: false,
            userid: userid,
            response: {},
            errors: {},
            currentPage: 1
        },
        methods: {
            onClick: function(page) {
                this.success = false;
                if (!flg) { return; }
                // パラメータセット
                const params = {userid: this.userid,
                                  page: page};
                let self = this;
                axios.post("/admin/api/orenouta/user_fav_list?page="+page, params)
                    .then( function(res) {
                        self.success = true;
                        self.response = res.data;
                    })
                    .catch( function(error) {
                        console.log(error);
                    });
            },
            goPage: function(page) {
                if (page >= 1 && page <= this.response.last_page) {
                    this.currentPage = page;
                    this.onClick(page);
                }
            },
        },
        mounted: function() {
            this.onClick(1);
        },
        computed: {
            pages() {
                let pagenation = this.response;
                let start = _.max([pagenation.current_page - 3, 1])
                let end = _.min([start + 7, pagenation.last_page + 1])
                start = _.max([end - 7, 1])
                return _.range(start, end)
            },
        }
    });
</script>
@stop