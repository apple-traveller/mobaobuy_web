@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '收藏列表')

@section('css')
	<style>
	
       .member_top_right{width: 968px;box-sizing: border-box; height: auto;}
       .member_down_right{height: 703px;}
       .whitebg{background: #FFFFFF;}
       .fl{float:left;}
       .ml15{margin-left:15px;}
       .br1{border: 1px solid #DEDEDE;}
       .pr {position:relative; }.pa{position: absolute;}
       .mt10{margin-top:10px;}
       .product_table,.Real_time{width: 905px;margin: 0 auto;margin-top: 20px;}
        .product_table li:first-child{font-size:14px;height:40px;line-height:40px;border: 1px solid #DEDEDEA;background-color: #eeeeee;}
        .product_table li:nth-child(odd){background-color: #f4f4f4;}
        .product_table li{height: 45px;line-height: 45px;}
        .product_table li span{text-align: center;display: inline-block;float: left;}
        .product_table_btn{width: 60px;height: 25px;line-height: 25px;text-align: center;color: #fff;border-radius: 3px;}
        .cz_line{height: 14px;width: 1px;}
        .product_table .wh181{width: 181px;}
        .product_table .wh135{width: 135px;}
        .product_table .wh85{width: 85px;}
        .product_table .wh90{width: 90px;}
        .product_table .wh100{width: 100px;}
        .product_table .wh130{width: 130px;}
        .product_table .wh155{width: 155px;}
        .product_table .wh219{width: 219px;}
        .product_table .wh115{width: 115px;}
        .product_table .wh209{width: 209px;}
        .product_table .wh226{width: 226px;}
        .ovh{overflow: hidden;}
        .mt20{margin-top:20px;}
        .code_greenbg{background-color: #75b335;} 
        .br0{border: 0px;}
        .no_infor{width:125px;margin:0 auto; text-align: center;margin-top: 200px; display: none;}
        .tac{text-align:center !important;}
        .reward_table_bottom{position:absolute;bottom: 5px;right: 27px;}
        .reward_table_bottom ul.pagination {display: inline-block;padding: 0;margin: 0;}
        .reward_table_bottom ul.pagination li {height: 20px;line-height: 20px;display: inline;}
        .reward_table_bottom ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
            border: 1px solid #ddd;margin: 0 4px;}
        .reward_table_bottom ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .reward_table_bottom ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}
        .news_pages ul.pagination {text-align: center;}
        .news_pages ul.pagination li {display: inline-block;}
        .news_pages ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
            border: 1px solid #ddd;margin: 0 4px;}
        .news_pages ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .news_pages ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}
        .fr{float:right;}
        .add_stock{width: 104px; height: 35px;line-height: 35px;background-color: #fe853b;border-radius: 3px;cursor: pointer;}
        .white,a.white,a.white:hover{color:#fff; text-decoration:none;}

        /*黑色*/
        .block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
        .power_edit{display:none;z-index: 2;width:520px;  left:50%; top:50%;margin-top:-275px;position:fixed;margin-left:-250px;}
        .whitebg{background: #FFFFFF;}
        .pay_title{height: 50px;line-height: 50px;}
        .f4bg{background-color: #f4f4f4;}
        .pl30{padding-left:30px;}
        .gray,a.gray,a.gray:hover{color:#aaa;}
        .fs16{font-size:16px;}
        .fr{float:right;}
        .frame_close{width: 15px;height: 15px;line-height:0;
     display: block;outline: medium none;
     transition: All 0.6s ease-in-out;
     -webkit-transition: All 0.6s ease-in-out;
     -moz-transition: All 0.6s ease-in-out;
     -o-transition: All 0.6s ease-in-out;}
     .mr15{margin-right:15px;}
     .mt15{margin-top:15px;}
     .power_list{width: 415px;margin: 0 auto;overflow: hidden;margin-bottom: 35px;}
    .power_list li{margin-top: 15px;}
    .power_list li span{width: 60px;text-align: right; float: left;line-height: 40px;overflow: hidden;}
    .ml30{margin-left:30px;}
    .mt25{margin-top:25px;}
    .pay_text{width: 330px;height:40px;line-height: 40px;margin-left: 20px;border: 1px solid #e6e6e6;padding: 8px;box-sizing: border-box;}
    .addr_list li .pay_text{width: 343px;}
    .power_cate{width: 330px;margin-left: 80px;} 
    .br1{border: 1px solid #DEDEDE;}
    .power_cate_check_box{width: 235px;margin: 0 auto;margin-top: 25px;margin-bottom: 40px;}
    .power_cate_check_box li{float:left;overflow: hidden;margin-left: 65px;margin-top: 15px;}
    .power_cate_check_box li:nth-child(odd){margin-left: 0px;}
    .power_cate_check_box li span{line-height: 20px;color: #666;}
    input[type='checkbox']{width: 20px;height: 20px;background-color: #fff;-webkit-appearance:none;border: 1px solid #c9c9c9;border-radius: 2px;outline: none;}
    .check_box input[type=checkbox]:checked{background: url(../img/interface-tickdone.png)no-repeat center;}
    .mr5{margin-right:5px;}
    .til_btn{width: 120px;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border-radius:3px;margin-left: 139px;cursor: pointer;}
    .code_greenbg{background-color: #75b335;} 
    .blackgraybg{background-color: #a0a0a0;}
    .xcConfirm .popBox .sgBtn.cancel{background-color: #546a79; color: #FFFFFF;}
	</style>
@endsection

@section('js')
	<script type="text/javascript">
		  var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                language: {
                    "sProcessing": "{{trans('home.sProcessing')}}",
                    "sZeroRecords": "{{trans('home.sZeroRecords')}}",
                    "sEmptyTable": "{{trans('home.sEmptyTable')}}",
                    "sLoadingRecords": "{{trans('home.sLoadingRecords')}}",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "{{trans('home.sFirst')}}",
                        "sPrevious": "{{trans('home.sPrevious')}}",
                        "sNext": "{{trans('home.sNext')}}",
                        "sLast": "{{trans('home.sLast')}}"
                    },
                },
                "ajax": {
                    url: "{{url('collectGoodsList')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        d.goods_name = $('#goods_name').val();
                        d.begin_time = $('#begin_time').val();
                        d.end_time = $('#end_time').val();
                    },
                    dataSrc:
                        function (json) {
                            json.draw = json.data.draw;
                            if (json.data.recordsTotal == null) {
                                json.recordsTotal = 0;
                            }else{
                                json.recordsTotal = json.data.recordsTotal;
                            }
                            json.recordsFiltered = json.data.recordsFiltered;

                            return json.data.data;
                        },
                },
                "columns": [
                    {"data": "add_time", "bSortable": false},
                    {"data": "id", "bSortable": false,
                        "render":function (data,type,row,meta) {
                                return  '<a href="/goodsAttributeDetails/'+row.goods_id+'">'+row.goods_name+'</a>';
                            {{--return '<a href="/goodsAttributeDetails/{{encrypt('+row.goods_id+')}}">'+row.goods_name+'</a>';--}}
                        }
                    },
                    {"data": "id", "bSortable": false,
                        "render": function (data, type, row, meta) {
                            return '<button class="opt-btn add_stock" id="'+row.id+'" onclick="del(this)" style="margin-left:50px;width:47%;">{{trans('home.cancel_collection')}}</button>';
                        }
                    }
               
                ]
            });

            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
        });

	    function del(obj) {
            var id = $(obj).attr('id');
	        $.msg.confirm("{{trans('home.is_cancel_collection')}}?",
                function(){//点击确认
                    $.ajax({
                        'type':'post',
                        'data':{'id':id},
                        'url':'{{url('/delCollectGoods')}}',
                        success:function(res){
                            if(res.code){
                                window.location.reload();
                            }else{
                                $.msg.alert('{{trans('home.error_cancel_collection')}}');
                            }
                        }
                    })
                },
                function(){//点击取消

                }
            );
	    }
	</script>

@endsection

@section('content')
  <div class="data-table-box">
	 <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="50%">{{trans('home.collection_time')}}</th>
                    <th width="20%">{{trans('home.goods_name')}}</th>
                    <th width="">{{trans('home.operation')}}</th>
                </tr>
                </thead>
            </table>
        </div>
     </div>  
@endsection
