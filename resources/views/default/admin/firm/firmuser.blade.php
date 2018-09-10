@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/firm/list" class="s-back">返回</a>企业 - 企业用户</div>
        <div class="content">

            <div class="flexilist">
                <div class="common-content">
                    <div class="list-div" id="listDiv">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <thead>
                            <tr>
                                <th width="10%"><div class="tDiv">用户id</div></th>
                                <th width="20%"><div class="tDiv">用户真实姓名</div></th>
                                <th width="10%"><div class="tDiv">能否po</div></th>
                                <th width="10%"><div class="tDiv">能否pay</div></th>
                                <th width="10%"><div class="tDiv">能否confirm</div></th>
                                <th width="10%"><div class="tDiv">能否stock_in</div></th>
                                <th width="10%"><div class="tDiv">能否stock_out</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($firmusers as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['user_id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['real_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['can_po']}}</div></td>
                                    <td><div class="tDiv">{{$vo['can_pay']}}</div></td>
                                    <td><div class="tDiv">{{$vo['can_confirm']}}</div></td>
                                    <td><div class="tDiv">{{$vo['can_stock_in']}}</div></td>
                                    <td><div class="tDiv">{{$vo['can_stock_out']}}</div></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="list-page">
                                        <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->

                                        {{$firmusers->links()}}

                                        <style>
                                            .pagination li{
                                                float: left;
                                                width: 30px;
                                                line-height: 30px;}
                                        </style>


                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
