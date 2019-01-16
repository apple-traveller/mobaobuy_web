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
            // async: true,//是否一步加载节点
            asyncUrl: selectorurl, //异步加载节点的路径
            asyncParam: ["id"], //异步加载时自动传的参数
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
                    groupzTreeOnClick(event, treeId, treeNode,selectorurl);
                    // hideZtreeSelect(treeId);
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
function groupzTreeOnClick(event, treeId, treeNode,selectorurl) {
    var shopId = treeNode.id; //判断该节点下是否有节点，没有就加载节点

    var treeObj = $.fn.zTree.getZTreeObj(treeId);
    var node = treeObj.getNodeByTId(treeNode.tId);
    if(node.children == null || node.children == "undefined"){0
        $.ajax({
            url: selectorurl,
            type: 'get',//请求方式：get
            data: {id:shopId},
            dataType : 'json',//数据传输格式：json
            error : function() { //请求失败处理函数
                console.log("警告",'亲，请求失败！');
            },
            success : function(data) {
                if(data!=null && data!=""){
                    //添加新节点
                    treeObj.addNodes(node, data);
                    // hideZtreeSelect(treeId);
                }else{
                    hideZtreeSelect(treeId);
                }
            }
        })
    }
}
