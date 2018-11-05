@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="content">

        <div class="flexilist">

            <div class="common-head">

            </div>

            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv" data-id="">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="10%"><div class="tDiv">订单号</div></th>
                                <th width="10%"><div class="tDiv">商品名称</div></th>
                                <th width="10%"><div class="tDiv">价格</div></th>
                                <th width="10%"><div class="tDiv">数量</div></th>
                                <th width="15%"><div class="tDiv">创建时间</div></th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(!empty($invoice_goods))
                            @foreach($invoice_goods as $vo)
                            <tr class="">
                                <td><div class="tDiv">{{$vo['order_sn']}}</div></td>
                                <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                <td><div class="tDiv">{{$vo['goods_price']}}</div></td>
                                <td><div class="tDiv">{{$vo['invoice_num']}}</div></td>
                                <td><div class="tDiv">{{$vo['created_at']}}</div></td>
                            </tr>
                            @endforeach

                            @else
                                <tr class=""> <td style="color:red;">未查询到数据</td></tr>
                            @endif
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@stop
