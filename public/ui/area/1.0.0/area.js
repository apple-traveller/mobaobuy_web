/* $Id : region.js 4865 2007-01-31 14:04:10Z paulgao $ */

var region = new Object();

region.view_country = true;

region.init = function(target_div)
{
    var html = '';
    var init_name = $(target_div).data('init-name');console.log(init_name);
    if(Utils.isEmpty(init_name)){
        init_name = '请选择';
    }
    html += '<div class="tit"><span>'+ init_name +'</span><i class="iconfont icon-down"></i></div>';
    html += '<div class="area-warp">';

    html += '<ul class="tab">';
    html += '</ul>';

    html += '</div>';
    $(target_div).append(html);

    if(region.view_country){
        region.loadNext(0, 0, $(target_div).children('.area-warp'));
    }else{
        region.loadNext(1, 1, $(target_div).children('.area-warp'));
    }
}

/* *
 * 载入指定的国家下所有的省份
 *
 * @country integer     国家的编号
 * @selName string      列表框的名称
 */
region.loadNext = function(parent, level, loadDiv, clickObj)
{
    Ajax.call('/region/level', 'level=' + level + "&parent=" + parent , function(result){

        if(loadDiv == null){
            var contentObj = $(clickObj).parent().parent().parent();
            loadDiv = contentObj.parent();
            var liCurr = loadDiv.children('.tab').children('.curr');
            liCurr.data('id', $(clickObj).data('id'));
            liCurr.text($(clickObj).attr('title'));
        }else{
            loadDiv = $(loadDiv);
        }

        if(result.data.length === 0){
            //没有下一级,关闭
            region.close(loadDiv);
            return false;
        }

        loadDiv.children('.tab').children('li').removeClass('curr');


        //添加tab
        var tab_html = '';
        tab_html += '<li onclick="region.changeTab(this, '+ level +')" data-id class="curr">请选择</li>';
        loadDiv.children('.tab').removeClass('curr').append(tab_html);

        //添加content
        var html = '';
        html += '<div class="tab-content level-'+ level +'">';
        for (var i = 0; i < result.data.length; i ++ ) {
            html += '<ul><li><a title="'+ result.data[i].region_name +'" href="javascript:void(0);" onclick="region.loadNext('+ result.data[i].region_id + ',' + (level+1) + ', null,this)" data-id="'+result.data[i].region_id+'">'+ result.data[i].region_name +'</a></li></ul>';
        }
        html += '</div>';
        var content = loadDiv.children('.tab-content');
        if(content.length > 0){
            content.hide();
            content.last().after(html);
        }else{
            loadDiv.children('.tab').after(html);
        }
    }, "POST", "JSON");
};

region.changeTab = function(target_tab, level)
{
    $(target_tab).nextAll().remove();
    $(target_tab).siblings().removeClass('curr');
    $(target_tab).addClass('curr');

    $(target_tab).parent().parent().children('.level-'+level).nextAll().remove();
    $(target_tab).parent().parent().children('.tab-content').hide();
    $(target_tab).parent().parent().children('.level-'+level).show();
};

region.close = function(target_div)
{
    var titles = new Array();
    var ids = new Array();
    $(target_div).children('.tab').children('li').each(function(){
        titles.push($(this).text());
        ids.push($(this).data('id'));
    });
    target_div.prev().children('span').text(titles.join(' / '));

    var area_div = target_div.parent();
    area_div.removeClass('hover');
    var name = area_div.data('value-name');
    $("#"+name).val(titles.join(' / '));
    var id = area_div.data('value-id');
    $("#"+id).val(ids.join('|'));
};

$(function() {
    $('.ui-area').each(function () {
        region.init(this);
    });

    $('.ui-area .tit').mouseover(function(){

    });

    $("body").on("mouseover mouseout", ".ui-area", function() {
        if(event.type == "mouseover"){
            $(this).addClass('hover');
        }else if(event.type == "mouseout"){
            $(this).removeClass('hover');
        }
    });
});