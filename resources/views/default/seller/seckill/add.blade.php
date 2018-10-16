@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title"><a href="/seller/seckill/list" class="s-back">返回</a>店铺 - 添加秒杀申请</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/seckill/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">秒杀日期</label>
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" id="date_choose" placeholder="申请日期"  maxlength="40px">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <div class="label"><span class="require-field">*</span>&nbsp;秒杀时间段：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="cat_id"  id="Seckill_time">
                                            <option value="0">请选择时间段</option>
                                            @foreach($seckill_time as $v)
                                                <option value="{{$v['id']}}">{{ $v['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="item fbutton add"><p id="addTable" style="width: 150px"><i class="icon icon-plus"></i>选择加入秒杀的商品</p></div>
                            <br>
                            <table class="layui-hide" id="form_ui"></table>
                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="hidden" id="resource_goods"></input>
                                    <input type="button" value="提交" class="button" id="submitBtn">
                                    <input type="reset" value="取消" class="button button_reset">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var goods_data = [];
        re();
        function re() {
           layui.use(['table', 'laydate'], function () {
               var table = layui.table;
               var laydate = layui.laydate;
               reloda();
               function reloda() {
                   table.render({
                       elem: '#form_ui'
                       , cols: [[
                           {type: 'checkbox'}
                           , {field: 'id', title: 'ID', sort: true}
                           , {field: 'goods_sn', title: '商品编号'}
                           , {field: 'goods_name', title: '商品名称'}
                           , {field: 'sec_price', title: '秒杀价格',edit:'number'}
                           , {field: 'sec_num', title: '秒杀总数量',edit:'number'}
                           , {field: 'sec_limit', title: '限制数量',edit:'number'}
                       ]],
                       data: goods_data
                   });
               }
               var date_chose = laydate.render({
                   elem: '#date_choose'
                   , min: '2016-10-14'
                   , max: '2080-10-14'
                   , theme: '#393D49'
                   , ready: function () {
                       date_chose.hint('日期可选值设定在 <br> 2016-10-14 到 2080-10-14');
                   }
               });
               $("#addTable").click(function () {
                   layer.open({
                       type: 2,
                       title: "添加商品",
                       id: "link",
                       shade: 0,
                       area: ['75%', '80%'],
                       fixed: false, //不固定
                       maxmin: true,
                       content: '/seller/seckill/goods_list'
                   });

               });
           });
       }

        $('#submitBtn').click(function () {
            layui.use(['table'],function () {
                let table = layui.table;
                let choose_date= $('#date_choose').val();
                let seckill_time = $('#Seckill_time').val();
                let goods_info = table.checkStatus('form_ui');
                if (choose_date == 0) {
                    layer.msg('请选择日期');
                    return false;
                }
                if (seckill_time == 0) {
                    layer.msg('请选择时间段');
                    return false;
                }
                if (goods_info.length <= 0) {
                    layer.msg('请选择加入秒杀的商品');
                    return false;
                }
                let sec_data = {};
                goods_info.data.map(function (item, index, input) {
                    var Reg = /^\+?[1-9][0-9]*$/;
                    if (!Reg.test(item['sec_price'])) {
                        layer.msg('请选择填写产品的秒杀价格,请填写数字');
                        return false;
                    }
                    if (!Reg.test(item['sec_num'])) {
                        layer.msg('请选择填写产品的秒杀总数量,请填写数字');
                        return false;
                    }
                    if (!Reg.test(item['sec_limit'])) {
                        layer.msg('请选择填写产品的限制数量,请填写数字');
                        return false;
                    }
                    sec_data[index] = {
                        date_time: choose_date,
                        tb_id: seckill_time,
                        goods_id: item['id'],
                        sec_price: item['sec_price'],
                        sec_num: item['sec_num'],
                        sec_limit: item['sec_limit'],
                    };
                })
                console.log(sec_data);
                $.ajax({
                    'url': '/seller/seckill/save',
                    'data': {
                        'sec_data': sec_data
                    },
                    'type': 'post',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 1) {
                            window.location.href = "{{url('/seller/seckill/list')}}";
                        } else {
                            layer.msg(res.msg);
                        }
                    }
                })
            });

        });
        function GetValue(obj){
            obj.map(function (item,index) {
                goods_data.push(item);
            });
            re();
        }
    </script>
@stop

