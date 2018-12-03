@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '我要卖货')
@section('css')
    <style>
        .account_infor_list{margin-top: 30px;margin-left: 40px;}
        .account_infor_list li{overflow: hidden;}
        .account_infor_list li .infor_title{width: 150px;float: left; text-align: right;}
        .account_infor_list li .infor_title_input{width: 85px;float: left; text-align: right;height: 40px;line-height: 40px;}
        .infor_input{width: 260px;height: 40px;line-height: 40px;border: 1px solid #DEDEDE;margin-left: 10px;padding: 10px;box-sizing: border-box;}
        .account_infor_btn{width: 140px;height: 40px;line-height: 40px;border: none; border-radius:3px;margin-left: 42px;margin-top: 30px;background-color: #75b335;}
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).tooltip({
            items: ".img-tooltip",
            content: function() {
                var element = $( this );
                var url = element.data('img');
                return "<img class='map' src='"+url+"'>";
            }
        });

        $(".attorney_letter_fileImg").click(function(){
            var img = $(this).attr('data-img');
            index = layer.open({
                type: 1,
                title: '添加商品',
                area: ['500px', '300px'],
                content: '<img src="'+img+'">'
            });
        });


        function formToJson(data){
            data= decodeURIComponent(data,true);//防止中文乱码
            data = data.replace(/&/g, "','" );
            data = data.replace(/=/g, "':'" );
            data = "({'" +data + "'})" ;
            obj = eval(data);
            return obj;
        }

        $('.account_infor_btn').click(function (){

            var data = $("#user_real_form").serialize();
            var jsonData = formToJson(data);
            Ajax.call('/sale',jsonData,function(res){
                // console.log(res.data);
                console.log(res);
                if (res.code == 1) {
                    $.msg.alert('提交成功,请等待客服与您联系！');
                    $('textarea[name=content]').val('');
                    $('input[name=bill_file]').val('');
                } else {
                    $.msg.alert(res.msg);

                }
            },'POST','JSON');
        });
    </script>
@endsection

@section('content')
    <div class="clearfix mt25">
        <form method="post" action="javascript:void(0);" id="user_real_form">
        <div class="w1200">
                <ul class="account_infor_list">
                    <li>
                        用户可以把自己的商品信息提供给客服人员，由客服人员发布信息来帮助用户完成卖货。<br/>
                        提供信息的方式有三种,选择一种即可：
                    </li>
                    <li class="mt25">
                        1.直接拨打电话联系客服：<span class="ml10">{{getConfig('service_phone')}}</span>
                    </li>
                    <li class="mt25">
                        2.填写货物详细信息：
                        <p>
                            <textarea name="content" style="max-width:800px;width:400px;min-height:200px;margin: 10px 0 0 12px;"></textarea>
                        </p>
                    </li>
                    <li class="mt25">
                        3.上传货物内容文档：
                        <div style="margin: 10px 0 0 12px;">
                            <span class="ml10">@component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/userSale/','name'=>'bill_file'])@endcomponent</span>
                        </div>
                    </li>

                </ul>
            <button class="account_infor_btn code_greenbg fs18 white">提 交</button>
        </div>
        </form>
    </div>
@endsection
