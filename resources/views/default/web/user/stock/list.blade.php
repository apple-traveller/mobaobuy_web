@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '实时库存')
<style type="text/css">
    .filter_item{
        line-height: 40px;
    }
    .fl{
        float: left !important;
    }

    input[type='checkbox'] {
    width: 20px;
    height: 20px;
    background-color: #fff;
    -webkit-appearance: none;
    border: 1px solid #c9c9c9;
    border-top-color: rgb(201, 201, 201);
    border-top-style: solid;
    border-top-width: 1px;
    border-right-color: rgb(201, 201, 201);
    border-right-style: solid;
    border-right-width: 1px;
    border-bottom-color: rgb(201, 201, 201);
    border-bottom-style: solid;
    border-bottom-width: 1px;
    border-left-color: rgb(201, 201, 201);
    border-left-style: solid;
    border-left-width: 1px;
    border-image-source: initial;
    border-image-slice: initial;
    border-image-width: initial;
    border-image-outset: initial;
    border-image-repeat: initial;
    border-radius: 2px;
    outline: none;
    }

    .check_box input[type=checkbox]:checked {
        background: url(/images/interface-tickdone.png)no-repeat center;
    }


</style>
@section('js')

    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                
                "ajax": {
                    url: "{{url('stock/list')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        var checkedArr = Array();
                        $('input[type=checkbox]:checked').each(function(){
                            checkedArr.push($(this).val());
                         });
                        d.goods_name = $('#goods_name').val();
                        d.cat_id = checkedArr
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
                    {"data": "cat_name", "bSortable": false},
                    {"data": "goods_name", "bSortable": false},
                    {"data": "number", "bSortable": false},
                    {"data": "id", "bSortable": false,
                        "render": function (data, type, full, meta) {
                            return '<a href="/stock/flow?id='+ data +'" class="opt-btn">查看</a>';
                        }
                    }
                ]

            });

            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();

            });

            // $('#on-query').click(function(){
            //     var oSettings = tbl.fnSettings();
            //     tbl.fnClearTable(0);
            //     tbl.fnDraw();
            // });
        });
    </script>

@endsection

@section('content')
    <!--标题-->
    <div class="data-table-box">
        <div class="pro_brand" style="border-bottom: none;">
                <dl class="fl filter_item"><dt class="fl">分类:</dt>
                    <dd class="pro_brand_list" style="width: 770px;">
                        @if($catInfo)
                            @foreach($catInfo['catInfo'] as $k=>$v)
                                <label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value="{{$v}}"><span class="fl">{{$catInfo['catName'][$k]}}</span></label>
                            @endforeach
                        @endif
                    </dd>
                    {{--<div class="fl pro_brand_btn region_btn ml20" id="on-query">确定</div><div class="fl pro_brand_btn region_btn ml20">取消</div>--}}
                </dl>
         </div>

        <div class="table-condition" style="clear:both;">
            <div class="item"><input type="text" class="text" id="goods_name" placeholder="商品名称"></div>
            <button id="on-search" class="search-btn">查询</button>
        </div>

        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="20%">分类名称</th>
                    <th width="40%">名称</th>
                    <th width="25%">库存剩余数量(kg)</th>
                    <th width="15%">操作</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection

