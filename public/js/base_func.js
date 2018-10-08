/*************************弹出框显示设置验证 start**********************/
/* 弹窗验证 */
function validation(required){
	var val = "";
	var msg = "";
	var flog = true;
	required.each(function(){
		val = $(this).val();
		msg = $(this).data("msg");
		if(val == ""){
            $.msg.tips(msg);
			flog = false;
			return false;
		}else{
			flog = true;
		}
	});
	return flog;
}

$.msg = new msg();
function msg() {
    if (typeof layer != 'object')
    {
    	alert('Layer object doesn\'t exists.');
    	return false;
    }
    var self = this;
    this.shade = [0.02, '#000'];
    // 关闭消息框
    this.close = function () {
        return layer.close(this.index);
    };
    // 弹出警告消息框
    this.alert = function (msg, callback) {
        return this.index = layer.alert(msg, {end: callback, scrollbar: false});
    };
    // 确认对话框
    this.confirm = function (msg, ok, no) {
        var self = this;
        return this.index = layer.confirm(msg, {btn: ['确认', '取消']}, function () {
            typeof ok === 'function' && ok.call(this);
            self.close();
        }, function () {
            typeof no === 'function' && no.call(this);
            self.close();
        });
    };
    // 显示成功类型的消息
    this.success = function (msg, time, callback) {
        return this.index = layer.msg(msg, {icon: 1, shade: this.shade, scrollbar: false, end: callback, time: (time || 2) * 1000, shadeClose: true});
    };
    // 显示失败类型的消息
    this.error = function (msg, time, callback) {
        return this.index = layer.msg(msg, {icon: 2, shade: this.shade, scrollbar: false, time: (time || 3) * 1000, end: callback, shadeClose: true});
    };
    // 状态消息提示
    this.tips = function (msg, time, callback) {
        return this.index = layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: callback, shadeClose: true});
    };
    // 显示正在加载中的提示
    this.loading = function (msg, callback) {
        return this.index = msg ? layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: callback}) : layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: callback});
    };
    this.successNeedCloseLayerIndex = [];
    // 自动处理显示Think返回的Json数据
    this.auto = function (data, time) {
        if (parseInt(data.code) === 1) {
            return self.success(data.msg, time, function () {
                !!data.url ? (window.location.href = data.url) : $.form.reload();
                self.close();
                for (var i in self.successNeedCloseLayerIndex) {
                    layer.close(self.successNeedCloseLayerIndex[i]);
                }
                self.successNeedCloseLayerIndex = [];
            });
        }
        return self.error(data.msg, 3, function () {
            !!data.url && (window.location.href = data.url);
        });
    };
}

/*************************弹出框显示设置验证 end**********************/


/*************************文件上传 end**********************/
/* file上传文件类型 封装函数 satrt*/
$(document).on("change",".type-upload-file",function(){
    var file_obj = $(this);

    var type = $(this).data('type');
    var path = $(this).data('path');

    /*var extStart=filepath.lastIndexOf(".");
    var ext=filepath.substring(extStart,filepath.length).toUpperCase();*/

    var formData = new FormData();
    formData.append("upload_type", type);
    formData.append("file", this.files[0]);
    formData.append("upload_path", path);

    Ajax.file("/uploadImg", formData, function (result){
        if(1 == result.code){
            console.log(file_obj);
            file_obj.siblings('.type-file-text').val(result.data.path);
            file_obj.siblings('span').children(".img-tooltip").show().attr('data-img', result.data.url);
        }else{
            layer.msg(res.msg, {time:2000});
        }
    });
});

$(document).tooltip({
    items: ".img-tooltip",
    content: function() {
        var element = $( this );
        var url = element.data('img');
        return "<img class='map' src='"+url+"'>";
    }
});