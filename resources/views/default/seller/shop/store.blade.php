@extends(themePath('.')."seller.include.layouts.master")
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/dsc/general.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/dsc/style.css')}}" />
@section('body')
    <div class="warpper">
        <div class="title">店铺列表</div>
        <div class="content">

        </div>
    </div>

    <script>
        layui.use(['upload','layer'], function() {
            var layer = layui.layer;

            $(".viewPic").click(function(){
                var src = $(this).attr('path');
                index = layer.open({
                    type: 1,
                    title: '大图',
                    // area: ['700px', '600px'],
                    content: '<img src="'+src+'">'
                });
            });

        });
        $("#submitBtn").click(function () {
            let settlement_bank_account_name = $("input[name='settlement_bank_account_name']").val();
            let settlement_bank_account_number = $("input[name='settlement_bank_account_number']").val();
            let data = {};
            if (settlement_bank_account_name){
                data.settlement_bank_account_name = settlement_bank_account_name;
            }
            if (settlement_bank_account_number) {
                data.settlement_bank_account_number = settlement_bank_account_number;
            }
            if (data.length==0){
                return false;
            }
            console.log(data);
            $.ajax({
                url:'/seller/updateCash',
                data:data,
                type:'POST',
                success: function (res) {
                    if (res.code==1){
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);
                    }
                    window.location.reload();
                }
            });
        });
    </script>
@stop
