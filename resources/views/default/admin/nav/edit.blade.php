@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/nav/list" class="s-back">返回</a>系统设置 - 自定义导航栏</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                    <li>请先选择系统已有的内容进行添加。</li>
                    <li>请注意填写根目录下的相对链接地址。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form action="/admin/nav/add" method="post" name="form" id="navigator_form" novalidate="novalidate">
                            <div class="switch_info">

                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                                <input name="id" type="hidden" value="{{$nav['id']}}">
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>名称：</div>
                                    <div class="label_value">
                                        <input type="text" name="name" value="{{$nav['name']}}" id="name" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>名称：</div>
                                    <div class="label_value">
                                        <input type="text" name="name_en" value="{{$nav['name_en']}}" id="name_en" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>链接地址：</div>
                                    <div class="label_value">
                                        <input type="text" name="url" value="{{$nav['url']}}" id="url" size="40"  class="text">
                                        <div class="notic">如果是本站的网址，可缩写为与商城根目录相对地址，如index.php；其他情况都应该输入完整的网址，如http://www.xxxx.com/</div>
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">排序：</div>
                                    <div class="label_value">
                                        <input type="text" name="sort_order" value="{{$nav['sort_order']}}" size="40" class="text text_3">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">是否显示：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_show" >
                                            <option @if($nav['is_show']==1) selected @endif value="1">是</option>
                                            <option @if($nav['is_show']==0) selected @endif value="0">否</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">是否新窗口：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="opennew" >
                                            <option @if($nav['opennew']==1) selected @endif value="1">是</option>
                                            <option @if($nav['opennew']==0) selected @endif value="0">否</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">位置：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="type" >
                                            <option @if($nav['type']=='top') selected @endif value="top">顶部</option>
                                            <option @if($nav['type']=='middle') selected @endif value="middle">中间</option>
                                            <option @if($nav['type']=='bottom') selected @endif value="bottom">底部</option>
                                        </select>
                                        <div class="form_prompt fl"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">是否nofollow：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_nofollow" >
                                            <option @if($nav['is_nofollow']) selected @endif value="1">是</option>
                                            <option @if($nav['is_nofollow'] == 0) selected @endif value="0">否</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="currpage" value="{{$currpage}}">
                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <input type="submit" class="button"  value=" 确定 " id="submitBtn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">


        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#navigator_form").valid()){
                    $("#navigator_form").submit();
                }
            });



            $('#navigator_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    name :{
                        required : true,
                    },
                    name_en :{
                        required : true,
                    },
                    url :{
                        required : true
                    },
                    sort_order:{
                        required:true,
                        number : true,
                    }

                },
                messages:{
                    name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'导航名称不能为空'
                    },
                    name_en:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'导航英文名称不能为空'
                    },
                    url :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'导航地址不能为空'
                    },
                    sort_order :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'排序不能为空',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    }
                }
            });
        });
    </script>

@stop
