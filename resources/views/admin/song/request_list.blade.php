@extends('layout.admin.admin_common')

@section('title', 'お問い合わせ・要望')
@section('content_header', 'お問い合わせ・要望')

@section('content')
<div id="song_request">
    <div class="search_aria" v-cloak>
        {{ csrf_field() }}
        <table id="serch_form1" border="1">
            <tr>
                <th style="width: 100px; text-align: center;">ステータス</th>
                <td style="width: 150px;">
                    <select v-model="status" style="width: 130px;">
                        <option v-for="(label, id) in statusOptions" :value="id">
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
            <table id="serch_form2" style="width: 100%;">
                <tr style="height: 30px;">
                    <th style="text-align: center; width: 20%;">
                        質問者
                    </th>
                    <th style="text-align: center; width: 40%;">
                        内容
                    </th>
                    <th style="text-align: center; width: 20%;">
                        投稿日時
                    </th>
                    <th v-if="response.status == 2" style="text-align: center; width: 20%;">
                        対応終了
                    </th>
                    <th v-if="response.status == 0" style="text-align: center; width: 10%;">
                        対応中
                    </th>
                    <th v-if="response.status == 0" style="text-align: center; width: 10%;">
                        却下
                    </th>
                    <th v-if="response.status == 1" style="text-align: center; width: 10%;">
                        対応完了
                    </th>
                    <th v-if="response.status == 1" style="text-align: center; width: 10%;">
                        棄却
                    </th>
                    <th v-if="response.status == 3" style="text-align: center; width: 10%;">
                        復帰
                    </th>
                    <th v-if="response.status == 3" style="text-align: center; width: 10%;">
                        削除
                    </th>
                </tr>
                <tr v-for="row in response.data" v-if="row.id > 0" style="text-align: center; height: 50px;">
                    <td>
                        @{{ row.nickname }}
                    </td>
                    <td>
                        <span v-html="row.question"></span>
                    </td>
                    <td>
                        @{{ row.created_at }}
                    </td>
                    <td v-if="row.status == 2">
                        @{{ row.updated_at }}
                    </td>
                    <td v-if="row.status == 0">
                        <button @click="acceptRequest(row.id)" class="accept">対応中</button>
                    </td>
                    <td v-if="row.status == 0">
                        <button @click="rejectRequest(row.id)" class="reject">却下</button>
                    </td>
                    <td v-if="row.status == 1">
                        <button @click="completeRequest(row.id)" class="complete">対応完了</button>
                    </td>
                    <td v-if="row.status == 1">
                        <button @click="backRequest(row.id)" class="back">棄却</button>
                    </td>
                    <td v-if="row.status == 3">
                        <button @click="backRequest(row.id)" class="back">復帰</button>
                    </td>
                    <td v-if="row.status == 3">
                        <button @click="deleteRequest(row.id)" class="delete">削除</button>
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
    .accept, .reject, .back, .delete, .complete {
        padding: 0 5px;
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
    $('#6').addClass('active');

    // Vue.js
    Vue.prototype.$http = axios;
    new Vue({
        el: '#song_request',
        data: {
            success: false,
            status: 0,
            statusOptions: {
                 0: '未対応',
                 1: '対応中',
                 2: '対応完了',
                 3: '却下'
            },
            response: {},
            errors: {},
            currentPage: 1,
        },
        methods: {
            onClick: function(page) {
                const params = {status: this.status};
                let self = this;
                axios.post("/admin/orenouta/request_list?page="+page, params)
                    .then( function(res) {
                        self.success = true;
                        self.response = res.data;
                        self.response.status = res.data.data.status;
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
            acceptRequest: function(id) {
                if (confirm("「対応中」に移動しますか？")) {
                    const params = {data_id: id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/orenouta/request/accept', params)
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
            rejectRequest: function(id) {
                if (confirm("「却下」に移動しますか？")) {
                    const params = {data_id: id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/orenouta/request/reject', params)
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
            completeRequest: function(id) {
                if (confirm("「対応完了」に移動しますか？")) {
                    const params = {data_id: id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/orenouta/request/complete', params)
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
            backRequest: function(id) {
                if (confirm("「未対応」に戻しますか？")) {
                    const params = {data_id: id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/orenouta/request/back', params)
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
            deleteRequest: function(id) {
                if (confirm("削除してよろしいですか？")) {
                    const params = {data_id: id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/orenouta/request/delete', params)
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