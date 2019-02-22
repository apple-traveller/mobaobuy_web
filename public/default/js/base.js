$.extend($.fn.dataTable.defaults, {
    bLengthChange : false,
    bPaginate : true,
    bFilter: false,
    bProcessing: true,
    bSort: false,
    sPaginationType: 'full_numbers',
    serverSide: true,
    oLanguage: {
        "sProcessing": "处理中...",
        "sLengthMenu": "显示 _MENU_ 项结果",
        "sZeroRecords": "没有匹配结果",
        "sInfo": "",
        "sInfoEmpty": "",
        "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
        "sInfoPostFix": "",
        "sSearch": "搜索：",
        "sUrl": "",
        "sEmptyTable": "表中数据为空",
        "sLoadingRecords": "载入中...",
        "sInfoThousands": ",",
        "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "上一页",
            "sNext": "下一页",
            "sLast": "尾页"
        },
        "oAria": {
            "sSortAscending": ": 以升序排列此列",
            "sSortDescending": ": 以降序排列此列"
        }
    }
});

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

function changeDeputy(obj){
    var selectCompanyId = $(obj).data('value');
    Ajax.call("/changeDeputy", {user_id:selectCompanyId},function(result){
        window.location.reload();
    },"POST", "JSON");
}

function jqGetLangData(locale,arr,field) {
    if (locale == 'zh-CN') {
        return arr[field];
    }
    return (arr[field + '_' + locale] != 'undefined' && arr[field + '_' + locale] != '') ? arr[field + '_' + locale] : arr[field];
}