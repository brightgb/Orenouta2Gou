@extends('layout.admin.admin_common')

@section('title', 'コメント一覧')
@section('content_header', 'コメント一覧')

@section('content')
<div id="comment">
    <div class="search_aria" v-cloak>
            {{ csrf_field() }}
            <table id="serch_form1" border="1">
                <tr>
                    <th style="width: 75px; text-align: center;">曲番号</th>
                    <td>
                        <input type="text" v-model="song_id" size="10">
                    </td>
                    <th style="width: 75px; text-align: center;">曲名</th>
                    <td>
                        <input type="text" v-model="title" size="30">
                    </td>
                </tr>
            </table>
            <div>
                <button class="btn" @click="onClick(1)">検索</button>
            </div>
    </div>

    <div class="result_aria" v-if="success" v-cloak>
        <div style="display: flex; width: 100%;">
            <div style="width: 70%">
                @include('layout.admin.vue_pagenation')
            </div>
            <div style="text-align: center; width: 30%; display: inline-block; margin: 20px 0;">
                <button class="audio" @click="win_open(response.data.file)" v-if="response.data.file != undefined">
                    視 聴 す る
                </button>
            </div>
        </div>
        <div>
            <table id="serch_form2" style="width: 100%;">
                <tr style="height: 30px;">
                    <th style="text-align: center; width: 70%;">内容</th>
                    <th style="text-align: center; width: 20%;">投稿日時</th>
                    <th style="text-align: center; width: 10%;">削除</th>
                </tr>
                <tr v-for="row in response.data" v-if="row.advice_id > 0" style="text-align: center; height: 50px;">
                    <td>
                        <span v-html="row.advice"></span>
                    </td>
                    <td>
                        @{{ row.created_at }}
                    </td>
                    <td>
                        <button @click="deleteComment(row.advice_id, row.id)" class="delete">削除</button>
                    </td>
                </tr>
                <tr v-else style="display: none;"></tr>
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
    $('#3').addClass('active');

    // Vue.js
    var song_id = "<?php echo $id ?>";
    var title = "<?php echo $title ?>";
    Vue.prototype.$http = axios;
    new Vue({
        el: '#comment',
        data: {
            success: false,
            song_id: '',
            title: '',
            response: {},
            error: {},
            currentPage: 1,
        },
        methods: {
            initParams: function() {
                if (song_id) {
                    this.song_id = song_id;
                }
                if (title) {
                    this.title = title;
                }
            },
            onClick: function(page) {
                const params = {song_id: this.song_id,
                                  title: this.title};
                let self = this;
                axios.post("/admin/comment_list?page="+page, params)
                    .then( function(res) {
                        self.success = true;
                        self.response = res.data;
                        self.song_id = res.data.data.id;
                        self.title = res.data.data.title;
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
            deleteComment: function(list_id, song_id) {
                if (confirm("削除してよろしいですか？")) {
                    const params = {delete_id: list_id,
                                      song_id: song_id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/comment_delete', params)
                        .then( function(res) {
                            self.onClick(page);
                        })
                        .catch( function(error) {
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