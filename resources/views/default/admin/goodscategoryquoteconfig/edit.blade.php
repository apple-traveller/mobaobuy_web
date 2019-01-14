@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('vendor.ueditor.assets')
    <style>
        .mian-info .item .label {width: 15%;}
    </style>
    <div class="warpper">
        <div class="title"><a href="/admin/goodscategoryquoteconfig/list" class="s-back">返回</a>商品分类 - 编辑配置</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>编辑配置。</li>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/goodscategoryquoteconfig/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <input type="hidden" name="id" value="{{$id}}"/>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>所属分类：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="cat_id" id="cat_id">
                                        <option value="">请选择分类</option>
                                        @if(!empty($cateTrees))
                                            @foreach($cateTrees as $v)
                                                <option  value="{{$v['id']}}" @if($v['id'] == $info['cat_id']) selected="selected" @endif>|<?php echo str_repeat('-->',$v['level']).$v['cat_name'];?></option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div style="margin-left:10px;" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>最大值：</div>
                                <div class="label_value">
                                    <input type="number" name="max" class="text" value="{{$info['max'] or ''}}" maxlength="40" autocomplete="off" id="max">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>最小值：</div>
                                <div class="label_value">
                                    <input type="number" name="min" class="text" value="{{$info['min'] or ''}}" maxlength="40" autocomplete="off" id="min">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
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
                    cat_id :{
                        required : true,
                    },
                    max:{
                        required : true
                    },
                    min:{
                        required : true
                    },
                },
                messages:{
                    cat_id:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    max:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    min :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
