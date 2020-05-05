@extends('layout.admin.admin_common')

@section('title', 'アドバイス一覧')
@section('content_header', 'アドバイス一覧')

@section('content')
<div id="song_comment">
    <div class="search_aria" v-cloak>
        {{ csrf_field() }}
        <table id="serch_form1" border="1">
            <tr>
                <th style="width: 100px; text-align: center;">曲番号</th>
                <td style="width: 100px;">
                    <input type="text" v-model="song_id" size="10">
                </td>
                <th style="width: 100px; text-align: center;">曲名</th>
                <td style="width: 200px;">
                    <input type="text" v-model="song_title" style="width: 200px;">
                </td>
            </tr>
        </table>
        <div>
            <button class="btn" @click="onClick(1)">検索</button>
        </div>
    </div>

    <div style="margin-top: 10px;" v-if="errors.msg" v-cloak>
        <font color="red"><strong><center>@{{ errors.msg }}</center></strong></font>
    </div>

    <div class="result_aria" v-if="success" v-cloak>
        <div style="display: flex; width: 100%;">
            <div style="width: 70%">
                @include('layout.admin.vue_pagenation')
            </div>
            <div style="text-align: center; width: 30%; display: inline-block; margin: 20px 0;">
                <button class="audio" @click="win_open(response.data.file)" v-if="response.data.file">
                    視 聴 す る
                </button>
            </div>
        </div>
        <div>
            <table id="serch_form2" style="width: 100%;">
                <tr style="height: 30px;">
                    <th style="text-align: center; width: 20%;">アドバイザー</th>
                    <th style="text-align: center; width: 30%;">内容</th>
                    <th style="text-align: center; width: 20%;">送信日時</th>
                    <th style="text-align: center; width: 20%;">いいね認定</th>
                    <th style="text-align: center; width: 10%;">削除</th>
                </tr>
                <tr v-for="row in response.data" v-if="row.song_id" style="text-align: center; height: 50px;">
                    <td>
                        @{{ row.nickname }}
                    </td>
                    <td>
                        <span v-html="row.advice"></span>
                    </td>
                    <td>
                        @{{ row.created_at }}
                    </td>
                    <td>
                        <span v-if="row.nice_flg"><strong>〇</strong></span>
                    </td>
                    <td>
                        <button @click="deleteComment(row.song_id, row.member_id, row.advice_id)" class="delete">削除</button>
                    </td>
                </tr>
                <tr v-else></tr>
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
        height: 100px;
        background-color: white;
        margin: 0 auto 10px auto;
        padding: 10px 0 0 10px;
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
    .audio {
        width: 100px;
        height: 40px;
        border-radius: 5px;
        background-color: teal;
        color: #ffffff;
        font-size: large;
    }
    .delete {
        width: 50px;
        height: 30px;
        border-radius: 10px;
        background-color: orange;
        color: black;
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
    $('#5').addClass('active');

    // Vue.js
    const song_id = "<?php echo $song_id; ?>";
    const song_title = "<?php echo $song_title; ?>";
    Vue.prototype.$http = axios;
    new Vue({
        el: '#song_comment',
        data: {
            success: false,
            song_id: '',
            song_title: '',
            response: {},
            errors: {msg: ''},
            currentPage: 1,
        },
        methods: {
            initParams: function() {
                if (song_id) {
                    this.song_id = song_id;
                }
                if (song_title) {
                    this.song_title = song_title;
                }
            },
            onClick: function(page) {
                this.errors.msg = '';
                if (!this.song_id && !this.song_title) {
                    this.errors.msg = '曲番号 または 曲名を指定してください。';
                    return;
                }
                const params = {song_id: this.song_id,
                             song_title: this.song_title};
                this.success = false;
                let self = this;
                axios.post("/admin/orenouta/comment_list?page="+page, params)
                    .then( function(res) {
                        self.success = true;
                        self.response = res.data;
                        self.song_id = res.data.data.song_id;
                        self.song_title = res.data.data.song_title;
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
            deleteComment: function(song_id, member_id, advice_id) {
                if (confirm("削除してよろしいですか？")) {
                    const params = {song_id: song_id,
                                  member_id: member_id,
                                  advice_id: advice_id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/orenouta/comment_delete', params)
                        .then( function(res) {
                            self.onClick(page);
                        })
                        .catch( function(error) {
                            alert('パラメータが不正です。')
                            console.log(error);
                        });
                } else {
                    return true;
                }
            },
            win_open: function(file) {
                win_url = 'https://www.youtube.com/watch?v='+file;
                var w = ( screen.width - 400 ) / 2;
                var h = ( screen.height - 300 ) / 2;
                w_para="width=400,height=300" + ",left=" + w + ",top=" + h;
                window.open(win_url, null, w_para);
            },
        },
        mounted: function() {
            this.initParams();
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