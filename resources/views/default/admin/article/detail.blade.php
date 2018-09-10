@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/article/list" class="s-back">返回</a>文章 - 编辑文章</div>
        <div class="content">
            <div class="tabs_info">
                <ul>
                    <li class="curr"><a href="javascript:void(0);">通用信息</a></li>

                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/article/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;文章标题：</div>
                                <div class="label_value">
                                    <input type="text" name="title" class="text" value="{{$article['title']}}" maxlength="40" autocomplete="off" id="title">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$article['id']}}">
                            <!--  -->
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;文章分类：</div>
                                <div class="label_value">

                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;" name="cat_id" id="cat_id">

                                        @foreach($cateTrees as $vo)
                                            <option @if($vo['id']==$article['cat_id']) selected  @endif value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="item">
                                <div class="label">是否显示：</div>
                                <div class="label_value">
                                    <div class="checkbox_items">
                                        <div class="checkbox_item">
                                            <input type="radio" @if($article['is_show']==1) selected  @endif class="ui-radio" name="is_show" id="sex_3" value="1" checked>
                                            <label for="sex_3" class="ui-radio-label">显示</label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input type="radio" @if($article['is_show']==0) selected  @endif class="ui-radio" name="is_show" id="sex_4" value="0">
                                            <label for="sex_4" class="ui-radio-label">不显示</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>文章作者：</div>
                                <div class="label_value"><input type="text" name="author" class="text" autocomplete="off" value="{{$article['author']}}"><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>关键字：</div>
                                <div class="label_value"><input type="text" name="keywords" class="text" autocomplete="off" value="{{$article['keywords']}}"><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>网页描述：</div>
                                <div class="label_value">
                                    <textarea name="description" class="textarea">{{$article['description']}}</textarea>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">排序：</div>
                                <div class="label_value"><input type="text" name="sort_order" class="text text_2 valid" autocomplete="off" id="sort_order" value="{{$article['sort_order']}}" aria-invalid="false"></div>
                            </div>
                            <div class="item">
                                <div class="label">外部链接：</div>
                                <div class="label_value"><input type="text" name="file_url" class="text valid" autocomplete="off" id="link_url" value="{{$article['file_url']}}" aria-invalid="false"></div>
                            </div>
                            <div class="item">
                                <div class="label">上传图片：</div>
                                <div class="label_value">

                                    <img  style="width:60px;height:60px;"    class="layui-upload-img" src="{{$article['image']}}" id="demo1" ><br/>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">内容：</div>
                                <div class="label_value">
                                    <script id="container" name="content" type="text/plain">{{html_entity_decode($article['content'])}}</script>

                                </div>
                            </div>
                        </div>




                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset(themePath('/').'ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{asset(themePath('/').'ueditor/ueditor.all.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
            initialFrameWidth : '100%',//宽度
            initialFrameHeight: 500//高度
        });
    </script>


@stop
