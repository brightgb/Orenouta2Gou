if(typeof textbox_id != "undefined"){
	check_len_arr = [[target_label_id ,textbox_id]];
}

function myLen(s) {
    s = s.replace(/\r\n/,"  ");
    s = s.replace(/\n/g,"  ");

    return s.length;
}

var num=0;
function init_target(o){
	var txt = o.$label.html();
	o.len_limit = txt.match(/\d+文字以内/)[0].match(/\d+/)[0];
	o.$label.html(txt.replace(/\d+文字以内/,
		'残<span id="countdown' + num +'">0</span>文字'));
	o.$countdown = $('#countdown' + num);

	o.len_prev = myLen(o.$textbox.val());
	o.$countdown.text(o.len_limit - o.len_prev);

	if(o.len_prev > o.len_limit){
	 	o.$countdown.css('color','red');
	}

	num++;
}

$(function(){
	var check_len_arr = [["lblDoc","mail_txt"]];

	var target_arr = check_len_arr;
	var target_list = new Array();
	var target_selectors = new Array();
	function target(arg){
		this.len_limit = 0;
		this.len_prev = 0;
		this.label = arg[0];
		this.textbox = arg[1]
		this.$label = $("#" + this.label);
		this.$textbox = $("#" + this.textbox);
		this.$countdown = null;

		if(!this.$textbox[0]){ return; }

		target_selectors.push(this.$textbox[0]);
		init_target(this);
	}

	for(var i=0;i<target_arr.length;i++){
		target_list.push(new target(target_arr[i]));
	}
	$(target_selectors).on("keyup change",function(){
		var target_obj = null;
		for(var i=0;i<target_list.length;i++){
			if(target_list[i].textbox == $(this).attr("id")){
				target_obj = target_list[i];
			}
		}

		var len = myLen($(this).val());
		if(len > target_obj.len_limit && target_obj.len_limit >= target_obj.len_prev){
			alert("文字数がオーバーしました");
			target_obj.$countdown.css('color','red');
		}else if(len <= target_obj.len_limit && target_obj.len_limit < target_obj.len_prev){
			target_obj.$countdown.css('color','');
		}
		target_obj.len_prev = len;
		target_obj.$countdown.text(target_obj.len_limit - len);
	});

});

