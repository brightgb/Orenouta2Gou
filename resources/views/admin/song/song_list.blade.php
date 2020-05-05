@extends('layout.admin.admin_common')

@section('title', '歌唱曲一覧')
@section('content_header', '歌唱曲一覧')

@section('content')
<div id="song_list">
    <div class="search_aria" v-cloak>
        {{ csrf_field() }}
        <table id="serch_form1" border="1">
            <tr>
                <th style="width: 100px; text-align: center;">ユーザーID</th>
                <td style="width: 200px;">
                    <input type="text" v-model="userid" style="width: 200px;">
                </td>
                <th style="width: 100px; text-align: center;">ニックネーム</th>
                <td style="width: 200px;">
                    <input type="text" v-model="nickname" style="width: 200px;">
                </td>
            </tr>
            <tr>
                <th style="text-align: center;">曲名</th>
                <td>
                    <input type="text" v-model="song_title" style="width: 200px;">
                </td>
                <th style="text-align: center;">曲の並び替え</th>
                <td>
                    <select v-model="sort" style="width: 200px;">
                        <option v-for="(label, id) in sortOptions" :value="id">
                            @{{ label }}
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <th style="text-align: center;">投稿日</th>
                <td colspan="3">
                    <input type="text" id="create_from" v-model="create_from" size="15">
                    &ensp;～&ensp;
                    <input type="text" id="create_to" v-model="create_to" size="15">
                    <span v-if="errors.create_from">
                        <br><code>@{{ errors.create_from }}</code>
                    </span>
                    <span v-else-if="errors.create_to">
                        <br><code>@{{ errors.create_to }}</code>
                    </span>
                    <span v-else-if="errors.validate_from_to">
                        <br><code>@{{ errors.validate_from_to }}</code>
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
                <tr style="height: 30px;">
                    <th style="text-align: center;">ユーザーID</th>
                    <th style="text-align: center;">ニックネーム</th>
                    <th style="text-align: center;">タイトル</th>
                    <th style="text-align: center;">紹介文</th>
                    <th style="text-align: center;">アドバイス数</th>
                    <th style="text-align: center;">投稿日時</th>
                </tr>
                <tr v-for="row in response.data" style="text-align: center; height: 50px;">
                    <td>
                        @{{ row.userid }}
                    </td>
                    <td>
                        @{{ row.nickname }}
                    </td>
                    <td>
                        <a :href="'/admin/orenouta/comment_list?song_id='+row.id" class="link">
                            @{{ row.title }}
                        </a>
                    </td>
                    <td>
                        <span v-html="row.comment"></span>
                    </td>
                    <td>
                        @{{ row.advice_cnt }}
                    </td>
                    <td>
                        @{{ row.created_at }}
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
        width: 90%;
        background-color: white;
        margin: 0 auto 10px auto;
        padding: 10px;
    }
    .result_aria {
        width: 90%;
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
    $('#4').addClass('active');

    Vue.prototype.$http = axios;
    new Vue({
        el: '#song_list',
        data: {
            success: false,
            userid: '',
            nickname: '',
            song_title: '',
            sort: 1,
            sortOptions: {
                1: '投稿日時の最新順',
                2: '投稿日時の古い順',
                3: 'アドバイスの多い順',
                4: 'アドバイスの少ない順'
            },
            create_from: moment().subtract(7, 'days').format('YYYY/MM/DD'),
            create_to: moment().format('YYYY/MM/DD'),
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
                    create_from: "",
                    create_to: "",
                    validate_from_to: ""
                };
            },
            onClick: function(page) {
                // 日付バリデート
                var param_date = [{
                    'from': this.create_from,
                    'to': this.create_to,
                    'from_hour': this.from_hour,
                    'from_min': this.from_min,
                    'from_seconds': this.from_seconds,
                    'to_hour': this.to_hour,
                    'to_min': this.to_min,
                    'to_seconds': this.to_seconds,
                }];
                var error_date = [{
                    'from': this.errors.create_from,
                    'to': this.errors.create_to,
                    'validate_from_to': this.errors.validate_from_to
                }];
                var map_error = [{
                    'create_from': "",
                    'create_to': "",
                    'validate_from_to': ""
                }];
                checkFormDatetime(param_date, error_date, map_error, this.errors);
                if (isEmty(this.errors)) {
                    return;
                }
                // パラメータセット
                const params = {userid: this.userid,
                              nickname: this.nickname,
                            song_title: this.song_title,
                                  sort: this.sort,
                           create_from: this.create_from,
                             create_to: this.create_to};
                this.success = false;
                let self = this;
                this.initErrors();
                axios.post("/admin/orenouta/song_list?page="+page, params)
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
            setDatePicker: function() {
                let self = this;
                $('#create_from').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
                $("#create_from").change(function(){ self.create_from = $(this).val(); });
                $('#create_to').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
                $("#create_to").change(function(){ self.create_to = $(this).val(); });
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