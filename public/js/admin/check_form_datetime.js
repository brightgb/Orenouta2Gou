function checkFormDatetime(params, errors, map_error, all_errors) {

    params.forEach(function (item, index) {

        var parent_error = Object.keys(map_error[index]);
        var date_from = item.from + " " + item.from_hour + ":" + item.from_min + ":" + item.from_seconds;
        var date_to = item.to + " " + item.to_hour + ":" + item.to_min + ":" + item.to_seconds;
        var res_from =  moment(item.from, "YYYY-MM-DD");
        var res_to =  moment(item.to, "YYYY-MM-DD");
        var isdate_from = moment(res_from).isValid();
        var isdate_to = moment(res_to).isValid();
        if (item.from && !validDate(date_from)) {
            errors[index].from = 'YYYY/MM/DD の形式で入力してください。';
        } else if(item.from && !isdate_from){
            errors[index].from = 'YYYY/MM/DD の形式で入力してください。';
        }else {
            errors[index].from = '';
        }
        if (item.to && !validDate(date_to)) {
            errors[index].to = 'YYYY/MM/DD の形式で入力してください。';
        } else if(item.to && !isdate_to ) {
            errors[index].to = 'YYYY/MM/DD の形式で入力してください。';
        } else {
            errors[index].to = '';
        }
        if (item.from && item.to) {
            if (date_from >= date_to) {
                errors[index].validate_from_to = '開始日は終了日より過去を指定してください';
            } else {
                errors[index].validate_from_to = '';
            }
        }

        var child_error = Object.values(errors[index]);
        parent_error.forEach(function (item, index) {
            all_errors[item] = child_error[index];
        })
    });
}


function validDate(date_check) {
    var dates = date_check.split('/').join('-');
    // var re = /^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (0?[0-9]|[0-2][0-3]):([0-9]|[0-5][0-9])$/;
    var re = /20\d{2}(-|\/)((0[1-9])|(1[0-2]))(-|\/)((0[1-9])|([1-2][0-9])|(3[0-1]))(T|\s)(([0-1][0-9])|(2[0-3])):([0-5][0-9]):([0-5][0-9])/;
    return re.test(dates);
}

function isEmty(obj) {
    for (var key in obj) {
        if (obj[key] !== null && obj[key] != "" && obj[key] != undefined)
            return true;
    }
    return false;
}


function valInputTimeInAddEdit(params, errors, map_error, all_errors) {
    params.forEach(function (item, index) {
        var parent_error = Object.keys(map_error[index]);
        var notify_date = item.notify_date;
        var full_notify_date = notify_date + " " + item.hour_notify + ":" + item.min_notify;
        var notify_date_compare = new Date(full_notify_date);
        var now_date = new Date();
        //validate date time
        if (notify_date) {
            if (!validDate(full_notify_date)) {
                errors[index].notify_date = '連絡日はY/m/d形式で指定してください。';
            } else if (Date.parse(notify_date_compare) < Date.parse(now_date)) {
                errors[index].notify_date = '現在の日付以降の日付を入力してください。';
            } else {
                errors[index].notify_date = '';
            }
        } else if (!(notify_date)) {
            errors[index].notify_date = ' 連絡日は必ず指定してください。';
        } else {
            errors[index].notify_date = '';
        }
        //validate title
        if (!(item.title)) {
            errors[index].title = 'タイトルを入力してください。';
        } else {
            errors[index].title = '';
        }
        //validate message
        if (!(item.message)) {
            errors[index].message = '本文を入力してください。';
        } else {
            errors[index].message = '';
        }

        var child_error = Object.values(errors[index]);
        parent_error.forEach(function (item, index) {
            all_errors[item] = child_error[index];
        })
    });
}