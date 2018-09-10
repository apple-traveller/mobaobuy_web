@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/firm/list" class="s-back">返回</a>企业 - 企业积分</div>
        <div class="content">

            <div class="flexilist">
                <div class="common-content">
                    <div class="list-div" id="listDiv">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <thead>
                            <tr>
                                <th width="20%"><div class="tDiv">id</div></th>
                                <th width="35%"><div class="tDiv">类型</div></th>
                                <th width="20%"><div class="tDiv">改变时间</div></th>
                                <th width="10%"><div class="tDiv">积分数量</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($points as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            @if($vo['change_type']=1)增加
                                            @else 减少
                                            @endif
                                        </div>
                                    </td>
                                    <td><div class="tDiv">{{$vo['change_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['points']}}</div></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="list-page">
                                        <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->

                                        {{$points->links()}}

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
