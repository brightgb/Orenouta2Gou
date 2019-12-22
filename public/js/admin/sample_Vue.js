Vue.prototype.$http = axios;
dvue = new Vue({
    el: 'test',
    data: {
        success:false,
        params: {},
        response: {},
        errors: {},
        currentPage: 1
    },
    methods: {
        initParams: function(){
            this.params = {
                email_stat: '99',
                mode: '0',
                regist_date_from: '',
                regist_date_to: '',
                member_stat_vals,
                member_stat: [],
                member_rank_1_vals,
                val1: '1',
                val2: '1',
                text: '',
                cm_code: '',
                rank_1: [],
                app_use_flg: '99',
                hide: '',
                force: ''
            }
            if (adcd) {
                this.params.cm_code = adcd;
            }
            if (start) {
                this.params.regist_date_from = start;
            }
            if (end) {
                this.params.regist_date_to = end;
            }
        },
        initErrors: function(){
            this.errors = {
                userid: '',
                email: '',
                tel: '',
                point_from: '',
                point_to: '',
                total_purchase_from: '',
                total_purchase_to: '',
                regist_date_from: '',
                regist_date_to: '',
                login_last_date_from: '',
                login_last_date_to: '',
                app_version_from: '',
                app_version_to: '',
            };
        },
        onClick: function(page) {
            var self = this;
            this.success = false;
            this.initErrors();
            this.$http.post('{{ route('admin::api.members.search') }}?page='+page, this.params)
                .then(function(response){
                    self.success = true;
                    self.response = response.data;
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
        setDatePicker() {
            const self = this.params;
            $('#regist_date_from').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
            $("#regist_date_from").change(function(){ self.regist_date_from = $(this).val(); });
            $('#regist_date_to').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
            $("#regist_date_to").change(function(){ self.regist_date_to = $(this).val(); });
            $('#login_last_date_from').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
            $("#login_last_date_from").change(function(){ self.login_last_date_from = $(this).val(); });
            $('#login_last_date_to').datepicker({dateFormat: 'yy/mm/dd', showOn: 'button'});
            $("#login_last_date_to").change(function(){ self.login_last_date_to = $(this).val(); });
        }
    },
    mounted: function() {
        this.initParams();
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