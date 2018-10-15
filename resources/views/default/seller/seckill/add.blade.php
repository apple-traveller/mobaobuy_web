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
                                <div class="label"><span class="require-field">*</span>&nbsp;秒杀时间段：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="cat_id"  id="Seckill_time">
                                        <option value="0">请选择时间段</option>
                                        @foreach($seckill_time as $v)
                                            <option  value="{{$v['id']}}">{{ $v['title'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="notic">秒杀提示：时间为开始时间后两个小时</div>
                                </div>

                            </div>
                            <div class="item ">选择加入秒杀的商品</div>
                            <br>
                            <table class="layui-hide" id="from_ui" ></table>


                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
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

        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#from_ui'
                ,id:'goods'
                ,skin:'line'
                ,url:'/seller/goods/GoodsForm'
                ,event:'true'
                ,cols: [[
                    {type:'checkbox'}
                    ,{field:'id', width:80, title: 'ID', sort: true}
                    ,{field:'goods_sn',  title: '产品编码'}
                    ,{field:'goods_name',  title: '产品名称'}
                    ,{field:'goods_number',  title: '产品数量'}
                    ,{field:'shop_price', title: '产品价格', minWidth: 100}
                    ,{field:'sec_price', title: '秒杀价格', minWidth: 100,edit: 'number',}
                    ,{field:'sec_num', title: '秒杀总数量', minWidth: 100,edit: 'number'}
                    ,{field:'sec_limit', title: '限制数量', minWidth: 100,edit: 'number'}
                ]]
                ,page: true
            });
           $('#submitBtn').click(function () {
               let seckill_time = $('#Seckill_time').val();
               let goods_info = table.checkStatus('goods');
               console.log(goods_info);
               return false;
               if (seckill_time == 0){
                   layer.msg('请选择时间段');
                   return false;
               }
               if (goods_info.length<=0){
                   console.log(goods_info.data);
                   layer.msg('请选择加入秒杀的商品');
                   return false;
               }
               let sec_data = {};
              goods_info.data.map(function (item,index,input) {
                  var Reg = /^\+?[1-9][0-9]*$/;
                 if (!Reg.test(item['sec_price'])){
                     layer.msg('请选择填写产品的秒杀价格,请填写数字');
                     return false;
                 }
                  if (!Reg.test(item['sec_num'])){
                      layer.msg('请选择填写产品的秒杀总数量,请填写数字');
                      return false;
                  }
                  if (!Reg.test(item['sec_limit'])){
                      layer.msg('请选择填写产品的限制数量,请填写数字');
                      return false;
                  }
                  sec_data[index] = {
                      tb_id: seckill_time,
                      goods_id:item['id'],
                      sec_price:item['sec_price'],
                      sec_num:item['sec_num'],
                      sec_limit:item['sec_limit'],
                  };

                 $.ajax({
                     'url':'/seller/seckill/save',
                     'data':{
                         'sec_data':sec_data
                     },
                     'type':'post',
                     success:function (res) {
                         if (res.code == 1){
                             window.location.href="{{url('/seller/seckill/list')}}";
                         } else {
                             layer.msg(res.msg);
                         }
                     }
                 })
              })
           });
        });
    </script>
@stop
