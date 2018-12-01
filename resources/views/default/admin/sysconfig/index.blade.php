@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper shop_special visible">
        <div class="title">系统设置 - 商店设置</div>
        <div class="content visible">
            <div class="tabs_info">
                <ul>
                    @foreach($topConfigs as $vo)
                    <li @if($parent_id==$vo['id']) class="curr" @endif><a  href="/admin/sysconfig/index?parent_id={{$vo['id']}}">{{$vo['name']}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i>
                    <h4>操作提示</h4>
                    <span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>请根据平台商城信息，谨慎填写信息。</li>
                </ul>
            </div>
            <div class="flexilist visible">
                <div class="mian-info visible">
                    <form enctype="multipart/form-data" name="theForm" action="/admin/sysconfig/modify" method="post" id="shopConfigForm" novalidate="novalidate" class="visible">
                        <div class="switch_info shopConfig_switch visible">
                            @foreach($childConfigs as $vo)
                            <div class="item shop_name" data-val="101">
                                <div class="label">{{$vo['name']}}：</div>
                                <div class="label_value">
                                    @if($vo['type']=='text')
                                        <input name="{{$vo['code']}}" id="{{$vo['code']}}" class="text" value="{{$vo['value']}}" autocomplete="off" type="text">
                                        <div class="form_prompt"></div>
                                        <div class="notic">{{$vo['config_desc']}}</div>
                                    @elseif($vo['type']=='select')
                                        @php
                                        $items = explode(',', $vo['store_range']);
                                        @endphp

                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:320px;float:left;margin-right: 10px;" name="{{$vo['code']}}" id="{{$vo['code']}}">
                                        @foreach($items as $item)
                                            @php
                                                $arr = explode('|', $item);
                                            @endphp
                                            <option @if($vo['value'] == $arr[0]) selected @endif value="{{$arr[0]}}">{{$arr[1]}}</option>
                                        @endforeach
                                        </select>
                                    @elseif($vo['type']=='textarea')
                                        <textarea class="textarea"  name="{{$vo['code']}}" id="{{$vo['code']}}">{{$vo['value']}}</textarea>
                                        <div class="form_prompt"></div>
                                    @elseif($vo['type']=='file')
                                        <button type="button" class="layui-btn upload-file" data-type="{{$vo['code']}}" data-path="{{$vo['store_dir']}}" ><i class="layui-icon">&#xe681;</i>上传图片</button>
                                        <input type="text" value="{{$vo['value']}}" class="text"  name="{{$vo['code']}}" style="display:none;">
                                        <img @if(empty($vo['value'])) style="width:60px;height:60px;display:none;" @else style="width:60px;height:60px;" src="{{getFileUrl($vo['value'])}}"  @endif   class="layui-upload-img"><br/>
                                    @endif
                                    <div class="notic">{{$vo['config_desc']}}</div>
                                </div>
                            </div>
                            @endforeach


                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input value=" 确 定 " ectype="btnSubmit" class="button" type="submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        layui.use(['upload','layer'], function(){
            var upload = layui.upload;
            var layer = layui.layer;

            //文件上传
            upload.render({
                elem: '.upload-file' //绑定元素
                ,url: "/uploadImg" //上传接口
                ,accept:'file'
                ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                    this.data={'upload_type':this.item.attr('data-type'),'upload_path':this.item.attr('data-path')};
                }
                ,done: function(res){
                    //上传完毕回调
                    if(1 == res.code){
                        var item = this.item;
                        item.siblings('input').attr('value', res.data.path);
                        item.siblings('img').show().attr('src', res.data.url);
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }
            });
        });


    </script>
@stop
