@extends(themePath('.')."seller.include.layouts.master")
@section('styles')
    <style>
        body{padding:10px; font-size:14px; background:#fff; width:95%; margin:0 auto; font-size:14px; line-height:20px; overflow:auto;}
        p{margin-bottom:10px;}
        input{border:1px solid #999; padding:5px 10px; margin:0 10px 10px 0;}
        .search_div{
            width: 95%;
            position: fixed;
            z-index: 2;
            background-color: #fff;
            border: 1px solid #e6e6e6;
        }
    </style>
@endsection
@section('body')
    <div class="warpper">
        <div class="title"><a href="/seller/seckill/list" class="s-back">返回</a>秒杀申请列表</div>
        <div class="title">商品</div>
        <div class="search_div">
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
            var list = eval(<?php echo json_encode($list) ?>); // very lihai d xiaoming
            table.render({
                elem: '#test_goods'
                ,cols: [[
                    {field:'id',  title: 'ID', sort: true}
                    ,{field:'goods_name',  title: '商品名称'}
                    ,{field:'sec_num',  title: '秒杀数量'}
                    ,{field:'sec_price',  title: '秒杀价格'}
                    ,{field:'sec_limit',  title: '限制数量'}
                ]],
                data:list
            });
        });
    </script>
@endsection
