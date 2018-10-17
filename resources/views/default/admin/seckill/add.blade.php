@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('vendor.ueditor.assets')
    <div class="warpper">
        <div class="title"><a href="/admin/seckill/list" class="s-back">返回</a>秒杀 - 添加秒杀活动</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>第一次新增秒杀时间段可对开始时间进行修改，以后默认为上一时段结束时间的后一秒。</li>
                    <li>秒杀时段名称将会显示在秒杀列表页的时间段内。</li>
                    <li>编辑秒杀结束时段时不会影响到下一秒杀时段开始时间，结束时间不得小于当前时段开始时间&不得大于下一时段结束时间。</li>
                </ul>
            </div>

            <div class="flexilist">

                <div class="common-content">
                    <form action="/admin/seckill/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="common-head">
                                <div class="fl">
                                    <input type="hidden" name="seckill_goods" id="seckill_goods" >
                                    <div style="float: left;margin-right: 20px;" class="layui-btn addGoods">
                                        <i class="layui-icon">&#xe608;</i> 选择添加商品
                                    </div>
                                    <select style="margin-top:5px;float: left;height:30px;background-color: #99cfe2;border:1px solid #dbdbdb;line-height:30px;width:100px;" name="shop_id" id="shop_id">
                                        <option value="">请选择店铺</option>
                                        @foreach($shop as $vo)
                                            <option value="{{$vo['id']}}">{{$vo['shop_name']}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="shop_name" id="shop_name">

                                    <input type="text" style="float: left;margin-top:5px;margin-left:20px;"  name="begin_time" class="text" placeholder="选择开始时间"  id="begin_time">
                                    <input type="text" style="float: left;margin-top:5px;margin-left:20px;"  name="end_time" class="text" placeholder="选择结束时间"  id="end_time">
                                    <select style="margin-top:5px;float: left;height:30px;background-color: #99cfe2;border:1px solid #dbdbdb;line-height:30px;width:150px;" name="tb_id">
                                        <option value="">请选择秒杀时间段</option>
                                        @foreach($seckilltimes as $vo)
                                            <option value="{{$vo['id']}}">{{$vo['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="list-div" id="listDiv">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">商品名称</div></th>
                                    <th width="10%"><div class="tDiv">市场价</div></th>
                                    <th width="10%"><div class="tDiv">秒杀价格</div></th>
                                    <th width="10%"><div class="tDiv">秒杀总数量</div></th>
                                    <th width="10%"><div class="tDiv">限制数量</div></th>
                                    <th width="10%"><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody class="mytbody">

                                </tbody>

                            </table>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="submit" value="确定" class="button" id="submitBtn">
                                    <input type="reset" value="重置" class="button button_reset">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $("#shop_name").val($("$shop_id").find("option:selected").text());
        });
        $("#shop_id").change(function(){
            var shop_name = $(this).find("option:selected").text();
            $("#shop_name").val(shop_name);
        });

        layui.use(['table','laydate','layer'], function(){
            var table = layui.table;
            var laydate = layui.laydate;
            var layer = layui.layer;
            var index;

            laydate.render({
                elem: '#begin_time' //指定元素
                ,type: 'date'
            });

            laydate.render({
                elem: '#end_time' //指定元素
                ,type: 'date'
            });


            $(".addGoods").click(function(){
                index = layer.open({
                    type: 1,
                    title: '添加商品',
                    area: ['500px', '300px'],
                    content: '<div style="position: relative;"> <input  type="text"  attr-id="" style="margin-left:20px;width:130px;" placeholder="商品分类" class="text goods_catagory" />' +
                    '<ul class="query" style="position: absolute;top: 30px;left:20px;background: #fff;width: 152px; box-shadow: 1px 1px 1px 1px #dedede;">' +
                    '</ul>' +
                    '<input type="text" attr-content="" attr-value-id=""  style="width:130px;" placeholder="商品值" class="text goods" >' +
                    '<ul class="query1" style="position: absolute;top: 30px;left: 188px;background: #fff;width: 144px; box-shadow: 1px 1px 1px 1px #dedede;">' +
                    '</ul></div>' +
                    '<div><button  class="layui-btn layui-btn-sm layui-btn-danger">确定</button></div>'
                });
            });

            //商品分类名输入框获取焦点事件
            $(document).delegate(".goods_catagory","focus",function(){
                $(".goods").val("");
                $(".query").children().filter("li").remove();
                $.post('/admin/seckill/getGoodsCat',{'cat_name':""},function(res){
                    if(res.code==200){
                        var data = res.data;
                        for(var i=0;i<data.length;i++){
                            $(".query").append('<li class="searchAttr" attr-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].cat_name+'</li>');
                        }
                    }
                },"json");
            });

            //商品分类输入框模糊查询
            $(document).delegate(".goods_catagory","input oninput",function(){
                $(".goods").val("");
                var cat_name = $(this).val();
                $(".query").children().filter("li").remove();
                $.post('/admin/seckill/getGoodsCat',{'cat_name':cat_name},function(res){
                    if(res.code==200){
                        var data = res.data;
                        for(var i=0;i<data.length;i++){
                            $(".query").append('<li class="searchAttr" attr-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].cat_name+'</li>');
                        }
                    }
                },"json");
            });

            //确认商品分类
            $(document).delegate(".searchAttr","click",function(){
                var cat_name = $(this).text();
                var attr_id = $(this).attr('attr-id');
                $(".goods_catagory").val(cat_name);
                $(".goods_catagory").attr('attr-id',attr_id);
                $(".query").children().filter("li").remove();
            });

            //商品名称输入框获取焦点事件
            $(document).delegate(".goods","focus",function(){
                $(".query1").children().filter("li").remove();
                var cat_id =  $(".goods_catagory").attr('attr-id');
                $.post('/admin/seckill/getGood',{'cat_id':cat_id},function(res){
                    if(res.code==200){
                        var data = res.data;
                        if(data==""){
                            $(".goods").val("该分类下没有商品");
                        }else{
                            for(var i=0;i<data.length;i++){
                                $(".query1").append('<li class="searchAttrValue" attr-content="'+data[i].market_price+'" attr-value-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].goods_name+'</li>');
                            }
                        }
                    }
                },"json");
            });

            //商品名输入框模糊查询
            $(document).delegate(".goods","input oninput",function(){
                var cat_id =  $(".goods_catagory").attr('attr-id');
                var goods_name = $(this).val();
                $(".query1").children().filter("li").remove();
                $.post('/admin/seckill/getGood',{'goods_name':goods_name,'cat_id':cat_id},function(res){
                    if(res.code==200){
                        var data = res.data;
                        for(var i=0;i<data.length;i++){
                            $(".query1").append('<li class="searchAttrValue" attr-content="'+data[i].market_price+'" attr-value-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].goods_name+'</li>');
                        }
                    }
                },"json");
            });

            //确认商品
            $(document).delegate(".searchAttrValue","click",function(){
                var goods_name = $(this).text();
                var goods_id = $(this).attr('attr-value-id');
                var market_price = $(this).attr("attr-content");
                $(".goods").val(goods_name);
                $(".goods").attr('attr-value-id',goods_id);
                $(".goods").attr('attr-content',market_price);
                $(".query1").children().filter("li").remove();
            });

            //点击确定返回数据
            $(document).delegate(".layui-btn-danger","click",function(){
                var goods_id=$(".goods").attr("attr-value-id");
                var goods_name=$(".goods").val();
                var market_price=$(".goods").attr("attr-content");
                if(goods_name==""){
                    layer.close(index);//关闭弹窗
                    return ;
                }
                if(goods_id==""){
                    layer.close(index);//关闭弹窗
                    return ;
                }
                $(".mytbody").append('<tr class="mytr">' +
                    '<td class="goods_id" data-id="'+goods_id+'"><div class="tDiv">'+goods_name+'</div></td>' +
                    '<td><div class="tDiv">'+market_price+'</div></td>' +
                    '<td class="sec_price"><div class="tDiv"><input type="text" class="text"></div></td>' +
                    '<td class="sec_num"><div class="tDiv"><input type="text" class="text"></div></td>' +
                    '<td class="sec_limit"><div class="tDiv"><input type="text" class="text"></div></td>' +
                    '<td class="deletetr">' +
                    '    <div class="tDiv">' +
                    '        <a href="javascript:void(0)" ><i class="sc_icon icon-trash"></i>删除</a>' +
                    '    </div>' +
                    '</td>' +
                    '</tr>');
                layer.close(index);//关闭弹窗
            });

            //删除tr
            $(document).delegate(".deletetr","click",function(){
                $(this).parent('tr').remove();
            });

            $("#article_form").submit(function(){
                var tr_element = $(".mytbody").children("tr");
                var seckill_goods = [];
                for(var i=0;i<tr_element.length;i++){
                    var tdArr = tr_element.eq(i).find("td");
                    seckill_goods[i]={
                        "goods_id":tdArr.filter(".goods_id").attr("data-id"),
                        //"goods_name":tdArr.filter(".goods_id").children("div").text(),
                        "sec_price":tdArr.filter(".sec_price").children("div").children("input").val(),
                        "sec_num":tdArr.filter(".sec_num").children("div").children("input").val(),
                        "sec_limit":tdArr.filter(".sec_limit").children("div").children("input").val(),
                    }
                }
                console.log(JSON.stringify(seckill_goods));
                $("#seckill_goods").val(JSON.stringify(seckill_goods));
            })

        });


        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
            });

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    begin_time :{
                        required : true,
                    },
                    end_time :{
                        required : true,
                    }
                },
                messages:{
                    begin_time:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    end_time:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });
        });
    </script>

@stop
