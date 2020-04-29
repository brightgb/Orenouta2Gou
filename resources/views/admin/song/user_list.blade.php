@extends('layout.admin.admin_common')

@section('title', '会員検索')
@section('content_header', '会員検索')

@section('content')
<div id="song">
    <div class="search_aria" v-cloak>
            {{ csrf_field() }}
            <table id="serch_form1" border="1">
                <tr>
                    <th style="width: 75px; text-align: center;">曲名</th>
                    <td>
                        <input type="text" v-model="title" size="30">
                    </td>
                    <th style="width: 100px; text-align: center;">並び替え</th>
                    <td>
                        <select v-model="sort">
                            <option v-for="(label, id) in sortOptions" :value="id">
                                @{{ label }}
                            </option>
                        </select>
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
                    <th style="text-align: center;">タイトル</th>
                    <th style="text-align: center;">紹介文</th>
                    <th style="text-align: center;">コメント数</th>
                    <th style="text-align: center;">投稿日時</th>
                    <th style="text-align: center;">更新日時</th>
                </tr>
                <tr v-for="row in response.data" style="text-align: center; height: 50px;">
                    <td>
                        <a :href="'/admin/comment_list?id='+row.id" class="link">
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
                    <td>
                        @{{ row.updated_at }}
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
<script>
    $('.sidebar-menu li').removeClass('active');
    $('#A').addClass('active');
    $('#2').addClass('active');

    Vue.prototype.$http = axios;
    new Vue({
        el: '#song',
        data: {
            success: false,
            title: '',
            sort: 1,
            sortOptions: {
                1: '更新日の最新順',
                2: '更新日の古い順',
                3: 'コメントの多い順',
                4: 'コメントの少ない順'
            },
            response: {},
            error: {},
            currentPage: 1
        },
        methods: {
            onClick: function(page) {
                const params = {title: this.title,
                                 sort: this.sort};
                let self = this;
                axios.post("/admin/user_search?page="+page, params)
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