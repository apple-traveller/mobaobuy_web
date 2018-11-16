@extends(themePath('.')."seller.include.layouts.master")
@section('title','沫宝商户')
@section('styles')
    <style>
        #main{
            height: 400px;
            overflow: hidden;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #e3e3e3;
            -moz-border-radius: 4px;
            border-radius: 4px;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection
@section('content')
<div class="layui-layout layui-layout-admin">

    <!-- 内容主体区域 -->
    <div class="layui-header" style="background:#3b8cd8;" >
        <a href="">
            <div class="layui-logo" style="background:#fff;">
            <img style="max-height: 40px;" src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}">
            </div>
        </a>
        <!-- 头部区域（可配合layui已有的水平导航） -->

        @include(themePath('.')."seller.include.partials._header")
    </div>
    <div class="layui-side" style="background:#383838; ">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="left-menu" style="color: #ffffff">
                @include(themePath('.')."seller.include.partials._sidebar")
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- 内容主体区域 -->
    <div class="layui-body ">
        <div class="layui-tab" lay-allowClose="true" lay-filter="tab-switch" >
            <ul class="layui-tab-title">
                <li class="layui-this" >后台首页</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div id="main">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-footer">
    @include(themePath('.')."seller.include.partials._footer")
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset(themePath('/').'e-chars/echarts-all.js')}}" ></script>
    <script src="{{asset(themePath('/').'e-chars/require.js')}}" ></script>
    <script type="text/javascript">
        require.config({
            paths: {
                echarts: 'theme/macarons'
            }
        });
        let month = [];
        var waitAffirm = [];
        var waitPay = [];
        var waitSend = [];
        var finished = [];
        // 第二个参数可以指定前面引入的主题
        var chart = echarts.init(document.getElementById('main'), 'macarons');
        $.ajax({
            url:'/seller/chars',
            data:'',
            type:'POST',
            async:false,
            success:function (res) {
                if (res.code==1){
                    for (let i1 in res.data.waitAffirm) {
                        waitAffirm.push(res.data.waitAffirm[i1]);
                    }
                    for (let i2 in res.data.waitPay) {
                        waitPay.push(res.data.waitPay[i2]);
                    }
                    for (let i3 in res.data.waitSend) {
                        waitSend.push(res.data.waitSend[i3]);
                    }
                    for (let i3 in res.data.finished) {
                        finished.push(res.data.finished[i3]);
                    }
                }
            }
        });
        chart.setOption({
            title : {
                text: '订单情况',
                subtext: ''
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['待付款','待发货','已成交']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'待付款',
                    type:'line',
                    smooth:true,
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                    data: waitPay
                },
                {
                    name:'待发货',
                    type:'line',
                    smooth:true,
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                    data: waitSend
                },
                {
                    name:'已成交',
                    type:'line',
                    smooth:true,
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                    data:finished
                }
            ]
        });

    </script>
@endsection


