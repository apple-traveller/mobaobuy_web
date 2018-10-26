$(function(){
  Ajax.call('/cart/num','',function(res){
    $('#shopping-amount').text(res.data.cart_num);
  });

  $('.ass_menu li').hover(function(){
      $(this).find('.ass_fn').toggle();
  })

    //轮播图
    $('.banner-imgs-div .banner-item').soChange({
        thumbObj:'null',
        thumbNowClass:'on',
        changeTime:2000,
    });
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