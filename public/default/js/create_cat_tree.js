/**
 * Created by Administrator on 2018\11\29 0029.
 */
function showZtreeSelect(treeId, x, y){
    $("#"+treeId).parent().css({"top":y+"px", "left":x+"px","z-index":"999","position":"absolute", "visibility":"visible"}).slideDown("fast");
    $("body").bind("mousedown", function(){
        if (!(event.target.id == treeId || $(event.target).parents("#"+treeId).length>0)) {
            hideZtreeSelect(treeId);
        }
    });
}
function hideZtreeSelect(treeId){
    $("#"+treeId).parent().fadeOut("fast");
    $("body").unbind("mousedown");
}
function showWinZtreeSelector(combobj,_treeId){
    var treeId = $(combobj).attr("treeId");
    var selectOffset = $(combobj).offset();
    if($('#'+treeId).length == 0){
        treeId = _treeId;

        var labelName = $(combobj).attr("name");
        var valueName = labelName.substring(0,labelName.lastIndexOf("_LABELS"));
        var needCheckId = $("input[name='"+valueName+"']").val();
        var selectorurl = $(combobj).attr("treeDataUrl");
        var title = $(combobj).attr("title");
        var datarule = $(combobj).attr("datarule");
        var callbackfn = $(combobj).attr("callbackfn");

        //生成添加元素
//                treeId = PlatUtil.getUUID();
        $(combobj).attr("treeId", treeId);

        var treeSetting = {
            check : {
                enable : false
            },
            edit : {
                enable : true,
                showRemoveBtn : false,
                showRenameBtn : false
            },
            view : {
                selectedMulti : false,
//                        fontCss: PlatUtil.getTreeNodeHighLightFont
            },
            async : {
                enable : true,
                url: selectorurl,
                autoParam: ["id"],
                otherParam : {
                    //是否显示树形标题
                    "isShowTreeTitle" : title.length>0?true:false,
                    //根据节点名称
                    "treeTitle": title
                }
            },
            callback: {
                onClick: function(event, treeId, treeNode, clickFlag) {
                    if(event.target.tagName=="SPAN"){
                        $(combobj).val(treeNode.name);
                        $(combobj).attr('old',treeNode.name);
                        $("input[name='"+valueName+"']").val(treeNode.id);
                        if(datarule){
                            $(combobj).trigger("validate");
                        }
                        if(callbackfn){
                            eval(callbackfn).call(this,treeNode.id,treeNode.name);
                        }
                    }
                    hideZtreeSelect(treeId);
                },
                onAsyncSuccess: function(event, treeId, treeNode, clickFlag) {
                    var zTreeObj = $.fn.zTree.getZTreeObj(treeId);
                    zTreeObj.selectNode(zTreeObj.getNodesByParam('id', needCheckId)[0]);
                }
            }
        };

        $.fn.zTree.init($("#"+treeId), treeSetting);
    }
    showZtreeSelect(treeId, selectOffset.left, selectOffset.top+$(combobj).outerHeight());
}
