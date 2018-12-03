@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('vendor.ueditor.assets')
    <div class="warpper">
        <div class="title"><a href="/admin/article/list?currpage={{$currpage}}" class="s-back">返回</a>文章 - 查看文章</div>
        <div class="content">

            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>展示文章的详细信息，文章的内容点击按钮弹窗显示出来。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/article/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label">文章标题：</div>
                                <div class="label_value">
                                    <input type="text" name="title" class="text" value="{{$article['title']}}" maxlength="40" autocomplete="off" id="title">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$article['id']}}">
                            <!--  -->
                            <div class="item">
                                <div class="label">&nbsp;文章分类：</div>
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
                                <div class="label">文章作者：</div>
                                <div class="label_value"><input type="text" name="author" class="text" autocomplete="off" value="{{$article['author']}}"><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label">关键字：</div>
                                <div class="label_value"><input type="text" name="keywords" class="text" autocomplete="off" value="{{$article['keywords']}}"><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label">网页描述：</div>
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
                                    @if(empty($article['image']))
                                        未上传
                                    @else
                                        <div  content="{{getFileUrl($article['image'])}}" class="layui-btn viewImg">点击查看</div>
                                    @endif
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">内容：</div>
                                <div class="label_value">
                                    <div content="{{$article['content']}}" class="layui-btn viewContent">点击查看</div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        layui.use(['upload','layer'], function() {
            var layer = layui.layer;


            $(".viewContent").click(function(){
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '500px'],
                    content: content
                });
            });

            $(".viewImg").click(function(){
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '500px'],
                    content: '<img src="'+content+'">'
                });
            });

        });
    </script>

@stop
