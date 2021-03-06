$(function(){


    //轮播图
    $('.banner-imgs-div .banner-item').soChange({
        thumbObj:'null',
        thumbNowClass:'on',
        changeTime:2000,
    });

    //活动倒计时
    $(".count-down").each(function(){
        var obj = $(this);
        var time = obj.data('endtime');
        //setTimeout("updateCountDownText('"+obj+"')", 1000);
        updateCountDownText(obj)
    });

    $("#demand-btn").click(function(){
        var phone = $("#demand-phone").val();
        var text = $("#demand-text").val();
        if(Utils.isEmpty(phone)){
            $.msg.alert('联系方式不能为空！');
            return ;
        }
        if(Utils.isEmpty(text)){
            $.msg.alert('需求内容不能为空！');
            return ;
        }

        Ajax.call('/demand/add', {contact:phone,content:text}, function(res){
            if(res.code){
                $.msg.alert(res.msg);
                $("#demand-text").val('');
            }else{
                $.msg.alert(res.msg)
            }
        },'POST');
    });
});
$(function() {
    var oUl = $('.trans_marquee ul');
    var timer = null;
    $(oUl).hover(function () {
        clearInterval(timer);
    }, function () {
        timer = setInterval(function () {
            var field = oUl.find('li:first');
            field.animate({'marginTop': -50 + 'px'}, 600, function () {
                field.css('marginTop', 0).appendTo(oUl);
            });
        }, 5000);
    }).trigger('mouseleave');
});

$(".shopping_cart").click(function(){
    var userId = "{{session('_web_user_id')}}";
    if(userId==""){
        $.msg.error("未登录",1);
        return false;
    }else{
        window.location.href="/cart";
    }
})