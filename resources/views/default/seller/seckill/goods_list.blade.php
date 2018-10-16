@extends(themePath('.')."seller.include.layouts.master")
@section('styles')
    <style>
        body{padding:10px; font-size:14px; background:#fff; width:95%; margin:0 auto; font-size:14px; line-height:20px; overflow:auto;}
        p{margin-bottom:10px;}
        input{border:1px solid #999; padding:5px 10px; margin:0 10px 10px 0;}

        .layui-form-item {
            margin-top: 15px;
        }
        .layui-input-block{
            float: left;
            margin-left: 0;
            margin-right: 2%;
        }
        td.on{
            border-bottom: 1px solid #D60711;
            color: #D60711;
        }
        td.active{
            background: #D60711;
            color: #fff;
        }
        .search_div{
            width: 95%;
            position: fixed;
            z-index: 2;
            background-color: #fff;
            border: 1px solid #e6e6e6;
        }
        .layui-table {
            width: 100%;
            background-color: #fff;
            color: #666;
        }
    </style>
@endsection
@section('body')
    <div class="warpper">
        <div class="title">商品</div>
        <div class="search_div">

            <div class="layui-form-item">
                <label class="layui-form-label">输入关键字</label>
                <div class="layui-input-block">
                    <input type="text" name="title" required  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input" id="searchInput" >
                </div>
                <div class="layui-input-block">
                    <button class="layui-btn" id="form" lay-submit lay-filter="formDemo">搜索</button>
                </div>
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" id="add"><i class="layui-icon"></i>添加列表</button>
                </div>
            </div>

        </div>
        <p style="height: 70px;"></p>
        <table class="layui-hide" id="test_goods"></table>
    </div>
@endsection

@section('script')
<script type="text/javascript">//注意：parent 是 JS 自带的全局对象，可用于操作父页面
    layui.use(['table','layer', 'form'], function(){
        var table = layui.table;
        var layer = layui.layer
            ,form = layui.form;
        $ = layui.jquery;
        var link = parent.layer.getFrameIndex(window.name); //获取窗口索引
        var shop_name = $("#searchInput").val();
        reloda(shop_name);
        function reloda(shop_name) {
            table.render({
                elem: '#test_goods'
                ,url:'/seller/goods/GoodsForm',
                where:{'goods_name':shop_name}
                ,cols: [[
                    {type:'checkbox'}
                    ,{field:'id',  title: 'ID', sort: true}
                    ,{field:'goods_sn',  title: '商品编号'}
                    ,{field:'goods_name',  title: '商品名称'}
                ]]
            });
        }
        $(".layui-input").bind("keydown",function(e){
            // 兼容FF和IE和Opera
            var theEvent = e || window.event;
            var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
            if (code == 13) {
                //回车执行查询
                $("#form").click(function () {
                    console.log(shop_name);
                    return false;
                });
            }
        });

        form.on("submit(formDemo)",function(data){
            var kwds = $("#searchInput").val();
            reloda(kwds);
        })
        $('#add').on('click', function(){
         let goods_data = table.checkStatus('test_goods');
            parent.GetValue(goods_data.data);
            parent.layer.close(link);
        });

    });
</script>
    @endsection
