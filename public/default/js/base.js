$(function(){
    $('.site-nav-menu').hover(
        function(){
            var list_div = $(this).children('.site-nav-menu-list');
            if(!Utils.isEmpty(list_div)){
                list_div.show();
                $(this).children('div:first-child').addClass('whitebg');
            }
        },
        function(){
            var list_div = $(this).children('.site-nav-menu-list');
            if(!Utils.isEmpty(list_div)){
                list_div.hide();
                $(this).children('div:first-child').removeClass('whitebg');
            }
        }
    );
});

changeDeputy(obj){
    var selectCompanyId = $(obj).data('value');
    Ajax.call("/changeDeputy", {user_id:selectCompanyId},function(result){
        window.location.reload();
    },"POST", "JSON");
}