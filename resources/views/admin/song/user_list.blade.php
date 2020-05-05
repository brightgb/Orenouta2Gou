@extends('layout.admin.admin_common')

@section('title', '会員検索')
@section('content_header', '会員検索')

@section('content')
<div id="song_user_list">
    <div class="search_aria" v-cloak>
        {{ csrf_field() }}
        <table id="serch_form1" border="1" style="table-layout: fixed; max-width: 100%;">
            <tr>
                <th style="width: 100px; text-align: center;">ユーザーID</th>
                <td style="width: 200px;">
                    <input type="text" v-model="userid">
                </td>
                <th style="width: 100px; text-align: center;">ニックネーム</th>
                <td style="width: 200px;">
                    <input type="text" v-model="nickname">
                </td>
                <th style="width: 100px; text-align: center;">歌い手ランク</th>
                <td style="width: 250px;">
                    <span v-for="val in singer_rank_vals">
                        <input type="checkbox" v-model="singer_rank" v-bind:value="val.id">
                         @{{ val.name }}&ensp;
                    </span>
                    <span v-if="errors.singer_rank_error_msg">
                        <br><code>@{{ errors.singer_rank_error_msg }}</code>
                    </span>
                </td>
            </tr>
            <tr>
                <th style="text-align: center;">登録日</th>
                <td colspan="3">
                    <input type="text" id="regist_from" v-model="regist_from" size="15">
                    &ensp;～&ensp;
                    <input type="text" id="regist_to" v-model="regist_to" size="15">
                    <span v-if="errors.regist_from">
                        <br><code>@{{ errors.regist_from }}</code>
                    </span>
                    <span v-else-if="errors.regist_to">
                        <br><code>@{{ errors.regist_to }}</code>
                    </span>
                    <span v-else-if="errors.validate_from_to">
                        <br><code>@{{ errors.validate_from_to }}</code>
                    </span>
                </td>
                <th style="text-align: center;">アドバイザーランク</th>
                <td>
                    <span v-for="val in advicer_rank_vals">
                        <input type="checkbox" v-model="advicer_rank" v-bind:value="val.id">
                         @{{ val.name }}&ensp;
                    </span>
                    <span v-if="errors.advicer_rank_error_msg">
                        <br><code>@{{ errors.advicer_rank_error_msg }}</code>
                    </span>
                </td>
            </tr>
            <tr>
                <th style="text-align: center;">獲得アドバイス数</th>
                <td>
                    <input type="text" v-model="get_advice_from" size="5">
                    &ensp;～&ensp;
                    <input type="text" v-model="get_advice_to" size="5">
                </td>
                <th style="text-align: center;">投稿曲数</th>
                <td>
                    <input type="text" v-model="song_cnt_from" size="5">
                    &ensp;～&ensp;
                    <input type="text" v-model="song_cnt_to" size="5">
                </td>
                <th style="text-align: center;">獲得いいね数</th>
                <td>
                    <input type="text" v-model="get_nice_from" size="5">
                    &ensp;～&ensp;
                    <input type="text" v-model="get_nice_to" size="5">
                </td>
            </tr>
            <tr>
                <th style="text-align: center;">アドバイス送信数</th>
                <td>
                    <input type="text" v-model="send_advice_from" size="5">
                    &ensp;～&ensp;
                    <input type="text" v-model="send_advice_to" size="5">
                </td>
                <th style="text-align: center;">獲得お気に入り数</th>
                <td>
                    <input type="text" v-model="get_favorite_from" size="5">
                    &ensp;～&ensp;
                    <input type="text" v-model="get_favorite_to" size="5">
                </td>
                <th style="text-align: center;">管理メモ</th>
                <td>
                    <input type="text" v-model="admin_memo" placeholder="キーワード" size="30">
                </td>
            </tr>
            <tr>
                <th style="text-align: center;">会員種別</th>
                <td colspan="3">
                    <span v-for="val in member_type_vals">
                        <input type="radio" v-model="member_type" v-bind:value="val.id">
                         @{{ val.name }}&ensp;
                    </span>
                </td>
            </tr>
        </table>
        <div>
            <button class="btn" @click="onClick(1)">検索</button>
        </div>
    </div>

    <div class="result_aria" v-if="success" v-cloak>
        <div>
            @include('layout.admin.vue_pagenation')
        </div>
        <div>
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
                        <a :href="'/admin/orenouta/user_detail?userid='+row.userid" class="link">
                            @{{ row.userid }}
                        </a>
                    </td>
                    <td>
                        @{{ row.nickname }}
                    </td>
                    <td>
                        @{{ row.singer_rank }}
                    </td>
                    <td>
                        @{{ row.advicer_rank }}
                    </td>
                    <td>
                        @{{ row.created_at }}
                    </td>
                    <td>
                        <span v-if="row.resign_flg == 1">退会</span>
                        <span v-else>活動中</span>
                    </td>
                    <td>
                        @{{ row.get_advice_cnt }}
                    </td>
                    <td>
                        @{{ row.sing_song_cnt }}
                    </td>
                    <td>
                        @{{ row.get_nice_cnt }}
                    </td>
                    <td>
                        @{{ row.all_advice_cnt }}
                    </td>
                    <td>
                        @{{ row.get_favorite_cnt }}
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
    .link {
        text-decoration: none;
        font-weight: bold;
        color: blue;
    }
    [v-cloak] {
        display: none;
    }
</style>
@stop

@section('js')
<script src="{{ asset('js/admin/check_form_datetime.js') }}"></script>
<script>
    $('.sidebar-menu li').removeClass('active');
    $('#A').addClass('active');
    $('#2').addClass('active');

    var singer_rank_vals = [
        @foreach(Config('constSong.singer_rank_label') as $key => $value)
            { id: {{$key}}, name: "{{$value}}" },
        @endforeach
    ];
    var advicer_rank_vals = [
        @foreach(Config('constSong.advicer_rank_label') as $key => $value)
            { id: {{$key}}, name: "{{$value}}" },
        @endforeach
    ];
    var member_type_vals = [
        {id: 0, name: '退会した会員を含まない'},
        {id: 1, name: '退会した会員のみ'},
        {id: 2, name: '退会した会員を含む'}
    ];

    Vue.prototype.$http = axios;
    new Vue({
        el: '#song_user_list',
        data: {
            success: false,
            userid: '',
            nickname: '',
            singer_rank_vals,
            singer_rank: [0, 1, 2],
            regist_from: '',
            regist_to: '',
            advicer_rank_vals,
            advicer_rank: [0, 1, 2],
            get_advice_from: '',
            get_advice_to: '',
            song_cnt_from: '',
            song_cnt_to: '',
            get_nice_from: '',
            get_nice_to: '',
            send_advice_from: '',
            send_advice_to: '',
            get_favorite_from: '',
            get_favorite_to: '',
            admin_memo: '',
            member_type_vals,
            member_type: 0,
            response: {},
            errors: {},
            currentPage: 1,
            from_hour: '00',
            from_min: '00',
            from_seconds: '00',
            to_hour: '23',
            to_min: '59',
            to_seconds: '59'
        },
        methods: {
            initErrors: function() {
                this.errors = {
                    singer_rank_error_msg: '',
                    advicer_rank_error_msg: '',
                    regist_from: "",
                    regist_to: "",
                    validate_from_to: ""
                };
            },
            onClick: function(page) {
                // 日付バリデート
                var param_date = [{
                    'from': this.regist_from,
                    'to': this.regist_to,
                    'from_hour': this.from_hour,
                    'from_min': this.from_min,
                    'from_seconds': this.from_seconds,
                    'to_hour': this.to_hour,
                    'to_min': this.to_min,
                    'to_seconds': this.to_seconds,
                }];
                var error_date = [{
                    'from': this.errors.regist_from,
                    'to': this.errors.regist_to,
                    'validate_from_to': this.errors.validate_from_to
                }];
                var map_error = [{
                    'regist_from': "",
                    'regist_to': "",
                    'validate_from_to': ""
                }];
                checkFormDatetime(param_date, error_date, map_error, this.errors);
                if (isEmty(this.errors)) {
                    return;
                }
                // パラメータセット
                const params = {
                    userid: this.userid,
                    nickname: this.nickname,
                    singer_rank: this.singer_rank,
                    regist_from: this.regist_from,
                    regist_to: this.regist_to,
                    advicer_rank: this.advicer_rank,
                    get_advice_from: this.get_advice_from,
                    get_advice_to: this.get_advice_to,
                    song_cnt_from: this.song_cnt_from,
                    song_cnt_to: this.song_cnt_to,
                    get_nice_from: this.get_nice_from,
                    get_nice_to: this.get_nice_to,
                    send_advice_from: this.send_advice_from,
                    send_advice_to: this.send_advice_to,
                    get_favorite_from: this.get_favorite_from,
                    get_favorite_to: this.get_favorite_to,
                    admin_memo: this.admin_memo,
                    member_type: this.member_type
                };
                this.success = false;
                let self = this;
                this.initErrors();
                axios.post("/admin/orenouta/user_search?page="+page, params)
                    .then( function(res) {
                        self.success = true;
                        self.response = res.data;
                    })
                    .catch( function(error) {
                        console.log(error);
                        if (error.response.data.errors.singer_rank) {
                            self.errors.singer_rank_error_msg = error.response.data.errors.singer_rank[0];
                        }
                        if (error.response.data.errors.advicer_rank) {
                            self.errors.advicer_rank_error_msg = error.response.data.errors.advicer_rank[0];
                        }
                    });
            },
            goPage: function(page) {
                if (page >= 1 && page <= this.response.last_page) {
                    this.currentPage = page;
                    this.onClick(page);
                }
            },
            setDatePicker: function() {
                let self = this;
                $('#regist_from').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
                $("#regist_from").change(function(){ self.regist_from = $(this).val(); });
                $('#regist_to').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
                $("#regist_to").change(function(){ self.regist_to = $(this).val(); });
            }
        },
        mounted: function() {
            this.initErrors();
            this.setDatePicker();
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