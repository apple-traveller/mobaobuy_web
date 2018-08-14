@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="{{url('/user/list')}}" class="s-back">返回</a>会员 - 操作记录</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示了会员所有信息操作记录。</li>
                </ul>
            </div>
            <div class="flexilist">
                <!--商品分类列表-->
                <div class="common-head">
                    <div class="refresh ml0">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$logs['total']}}条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" action="users.php" name="listForm" onsubmit="return confirm(remove_log_confirm);">
                        <div class="list-div" id="listDiv">
                            、
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="3%" class="sign"><div class="tDiv"><input type="checkbox" name="all_list" class="checkbox" id="all_list"><label for="all_list" class="checkbox_stars"></label></div></th>
                                    <th width="5%"><div class="tDiv">编号</div></th>
                                    <th width="30%"><div class="tDiv">操作时间</div></th>
                                    <th width="30%"><div class="tDiv">操作类型</div></th>
                                    <th width="12%"><div class="tDiv">IP地址</div></th>

                                </tr>
                                </thead>
                                <tbody>
                                @if(empty($logs))
                                <tr class=""><td class="no-records" colspan="12">没有找到任何记录</td></tr>
                                @else
                                    @foreach($logs as $log)
                                    <tr class="">
                                        <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="16" class="checkbox" id="checkbox_16"><label for="checkbox_16" class="checkbox_stars"></label></div></td>
                                        <td><div class="tDiv">{{$log->id}}</div></td>
                                        <td><div class="tDiv">{{$log->log_time}}</div></td>
                                        <td><div class="tDiv">{{$log->log_info}}</div></td>
                                        <td><div class="tDiv">{{$log->ip_address}}</div></td>

                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div class="tDiv">
                                            <div class="tfoot_btninfo">
                                                <input name="act" type="hidden" value="batch_log">
                                                <input name="user_id" type="hidden" value="15">

                                                <input name="remove" type="submit" ectype="btnSubmit" value="删除" class="btn btn_disabled" disabled="disabled">
                                            </div>
                                            <div class="list-page">
                                                <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->


                                                    {{$logs->appends(['id' => $id])->links()}}

                                                <style>
                                                    .pagination li{
                                                        float: left;
                                                        width: 30px;
                                                        line-height: 30px;}
                                                </style>


                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
