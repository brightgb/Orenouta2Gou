@extends('layout.admin.admin_common')

@section('title', '新着情報の登録')
@section('content_header', '新着情報の登録')

@section('content')
    @if (session('success'))
    <div>
        <p><strong><center>{{ session('success') }}</center></strong></p>
    </div>
    @endif
<div id="song_infomation">
    <div class="search_aria" v-cloak>
        {{ csrf_field() }}
        <table id="serch_form1" border="1">
            <tr style="height: 50px;">
                <th style="text-align: center;">お知らせ日時</th>
                <td>
                    <select v-model="year" id="js-changeYear" style="width: 70px; height: 30px;">
                        <option v-for="(label, id) in yearOptions" :value="id">
                            @{{ label }}
                        </option>
                    </select>年
                    <select v-model="month" id="js-changeMonth" @change="formSetDay()" style="width: 50px; height: 30px; margin-left: 10px;">
                        <option v-for="(label, id) in monthOptions" :value="id">
                            @{{ label }}
                        </option>
                    </select>月
                    <select v-model="day" style="width: 50px; height: 30px; margin-left: 10px;">
                        <option v-for="(label, id) in dayOptions" :value="id">
                            @{{ label }}
                        </option>
                    </select>日
                    <select v-model="hour" style="width: 50px; height: 30px; margin-left: 10px;">
                        <option v-for="(label, id) in hourOptions" :value="id">
                            @{{ label }}
                        </option>
                    </select>時
                    <select v-model="min" style="width: 50px; height: 30px; margin-left: 10px;">
                        <option v-for="(label, id) in minOptions" :value="id">
                            @{{ label }}
                        </option>
                    </select>分
                </td>
            </tr>
            <tr>
                <th style="text-align: center;">内容<br>（HTML表記可能）</th>
                <td>
                    <textarea v-model="message" cols="60" rows="5" required></textarea>
                </td>
            </tr>
        </table>
        <div>
            <button class="btn" @click="registInfo()">追加</button>
        </div>
    </div>

    <div class="result_aria" v-cloak>
        <div>
            @include('layout.admin.vue_pagenation')
        </div>
        <table id="serch_form2" style="width: 100%;">
            <tr style="height: 30px;">
                <th style="text-align: center; width: 20%;">お知らせ日時</th>
                <th style="text-align: center; width: 70%;">内容</th>
                <th style="text-align: center; width: 10%;">削除</th>
            </tr>
            <tr v-for="row in response.data" style="text-align: center; height: 50px;">
                <td>
                    @{{ row.notify_date }}
                </td>
                <td>
                    <span v-html="row.message"></span>
                </td>
                <td>
                    <button @click="deleteInfo(row.id)" class="delete">削除</button>
                </td>
            </tr>
        </table>
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
        padding: 10px 0 0 10px;
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
    .result_aria {
        width: 90%;
        margin: 0 auto;
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
    $('#7').addClass('active');

    var yearOptions = {
        @foreach($years as $key => $value)
            {{ $value }} : "{{$value}}",
        @endforeach
    };
    var monthOptions = {
        @foreach($months as $key => $value)
            {{ $key }} : "{{$value}}",
        @endforeach
    };
    var dayOptions = {};  // formSetDay() で定義
    var hourOptions = {
        @foreach($hours as $key => $value)
            {{ $key }} : "{{$value}}",
        @endforeach
    };
    var minOptions = {
        @foreach($mins as $key => $value)
            {{ $key }} : "{{$value}}",
        @endforeach
    };
    Vue.prototype.$http = axios;
    new Vue({
        el: '#song_infomation',
        data: {
            year: moment().format('YYYY'),
            month: moment().format('M'),
            day: moment().format('D'),
            hour: moment().startOf('day').format('H'),
            min: moment().startOf('day').format('m'),
            message: '',
            yearOptions,
            monthOptions,
            dayOptions,
            hourOptions,
            minOptions,
            response: {},
            errors: {},
            currentPage: 1
        },
        methods: {
            onClick: function(page) {
                let self = this;
                axios.post("/admin/orenouta/infomation?page="+page)
                    .then( function(res) {
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
            registInfo: function() {
                if (!this.message) {
                    alert('新着情報の内容を記入してください。');
                } else {
                    if (confirm("追加してよろしいですか？")) {
                        const params = {year: this.year,
                                       month: this.month,
                                         day: this.day,
                                        hour: this.hour,
                                         min: this.min,
                                     message: this.message};
                        let self = this;
                        axios.post("/admin/orenouta/add_info", params)
                            .then( function(res) {
                                location.href = "/admin/orenouta/infomation?result=success";
                            })
                            .catch( function(error) {
                                console.log(error);
                            });
                    } else {
                        return true;
                    }
                }
            },
            deleteInfo: function(id) {
                if (confirm("削除してよろしいですか？")) {
                    const params = {delete_id: id};
                    var page = this.response.current_page;
                    let self = this;
                    axios.post('/admin/orenouta/delete_info', params)
                        .then( function(res) {
                            location.href = "/admin/orenouta/infomation?result=delete";
                        })
                        .catch( function(error) {
                            console.log(error);
                        });
                } else {
                    return true;
                }
            },
            // 自動で月末日を取得
            formSetDay: function() {
                var lastday = this.formSetLastDay($('#js-changeYear').val(), $('#js-changeMonth').val());
                this.dayOptions = {};
                for (var i = 1; i <= lastday; i++) {
                    if (i < 10) {
                        this.dayOptions[i] = '0' + i;
                    } else {
                        this.dayOptions[i] = i;
                    }
                }
            },
            formSetLastDay: function(year, month) {
                var lastday = new Array('', 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
                if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0) {
                    lastday[2] = 29;
                }
                return lastday[month];
            }
        },
        mounted: function() {
            this.formSetDay();
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
        },
    });
</script>
@stop