@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/shopuser/list?currpage={{$currpage}}" class="s-back">返回</a>店铺 - 编辑职员</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shopuser/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择店铺：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;" name="shop_id" id="shop_id">
                                        @foreach($shops as $vo)
                                            <option @if($shopUser['shop_id']==$vo['id']) selected @endif  value="{{$vo['id']}}">{{$vo['shop_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                <input type="hidden" name="id" value="{{$shopUser['id']}}" >
                                <input type="hidden" name="currpage" value="{{$currpage}}" >
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;登录用户名：</div>
                                <div class="label_value">
                                    <input type="text" name="user_name" class="text" value="{{$shopUser['user_name']}}" maxlength="40" autocomplete="off" id="user_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;登录密码：</div>
                                <div class="label_value">
                                    <input type="text" name="password" class="text" value="" maxlength="40" autocomplete="off" id="password">
                                    <div class="form_prompt"></div>
                                    <div class="notic">留空代表不修改</div>
                                </div>
                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否是店铺管理员：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;" name="is_super" id="is_super">
                                        <option @if($shopUser['is_super']==0) selected @endif value="0">否</option>
                                        <option @if($shopUser['is_super']==1) selected @endif value="1">是</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="submit" value="确定" class="button" id="submitBtn">
                                    <input type="reset" value="重置" class="button button_reset">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
            });

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    user_name :{
                        required : true,
                    },

                },
                messages:{
                    user_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },

                }
            });
        });
    </script>


@stop
