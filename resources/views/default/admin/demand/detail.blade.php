@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/demand/detail?currpage={{$currpage}}&action_state={{$action_state}}" class="s-back">返回</a>优惠活动 - 优惠活动详情</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label">&nbsp;用户名：</div>
                                <div class="label_value font14">{{$demand['user_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;用户昵称：</div>
                                <div class="label_value font14">{{$demand['nick_name']}}</div>
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
                                    <textarea class="textarea">{{$demand['desc']}}</textarea>
                                </div>
                            </div>


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
