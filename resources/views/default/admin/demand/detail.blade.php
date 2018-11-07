@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/demand/list?currpage={{$currpage}}&action_state={{$action_state}}" class="s-back">返回</a>优惠活动 - 优惠活动详情</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>该页面展示用户的求购或者咨询信息。</li>
                    <li>客服处理后添加备注信息提交保存。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="/admin/demand/save" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label">&nbsp;昵称：</div>
                                <div class="label_value font14">
                                    {{$demand['nick_name']}}
                                </div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;联系方式：</div>
                                <div class="label_value font14">{{$demand['contact_info']}}</div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;添加时间：</div>
                                <div class="label_value font14">{{$demand['created_at']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;求购信息：</div>
                                <div class="label_value font14">
                                    <textarea disabled="disabled" class="textarea">{{$demand['desc']}}</textarea>
                                </div>
                            </div>

                            @if(empty($demand['action_log']))
                            <div class="item">
                                <div class="label">&nbsp;处理意见 ：</div>
                                <div class="label_value font14">
                                    <textarea name="action_log" class="textarea"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$demand['id']}}">

                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="submit" value="提交" class="button" id="submitBtn">
                                    <input type="reset" value="重置" class="button button_reset">
                                </div>
                            </div>
                            @else
                                <div class="item">
                                    <div class="label">&nbsp;处理意见 ：</div>
                                    <div class="label_value font14">
                                        <?php
                                            $operator = explode(";",$demand['action_log'])[0];
                                            echo "处理人：".$operator.":<br>";
                                            $time = explode(";",$demand['action_log'])[1];
                                            echo "处理时间：".$time.":<br>";
                                            $content = explode(";",$demand['action_log'])[2];
                                            echo "备注：".$content
                                        ?>
                                    </div>
                                </div>

                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        layui.use(['layer'], function() {
            var layer = layui.layer;



        });
    </script>
@stop
