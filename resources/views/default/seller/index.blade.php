@extends(themePath('.')."seller.include.layouts.master")
@section('title','en-this')
@section('styles')
    <style>
        .main{
            text-align: center;
            background-color: #fff;
            border-radius: 20px;
            width: 600px;
            height: 350px;
            margin: auto;
            position: absolute;
            top: 200px;
            left: 100px;
        }
        li {float: left;margin-right:20px; list-style: none}
    </style>
@endsection
@section('content')
<div class="layui-layout layui-layout-admin">

    <!-- 内容主体区域 -->
    <div class="layui-header" style="background:#3b8cd8;" >
        <div class="layui-logo" style="background:#fff;">
            <img style="max-height: 40px;" src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}">
        </div>
        <!-- 头部区域（可配合layui已有的水平导航） -->

        @include(themePath('.')."seller.include.partials._header")
    </div>
    <div class="layui-side" style="background:#383838; ">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="left-menu" style="color: #ffffff">
                @include(themePath('.')."seller.include.partials._sidebar")
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- 内容主体区域 -->
    <div class="layui-body">
        <div class="layui-tab" lay-allowClose="true" lay-filter="tab-switch" >
            <ul class="layui-tab-title">
                <li class="layui-this" >后台首页</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">

                    <blockquote class="layui-elem-quote layui-text">
                        <div class="main">
                            <table>
                                <tr>
                                    <td>店铺名</td>
                                    <td>{{ $data['shop_name'] }}</td>
                                </tr>
                                <tr>
                                    <td>用户名</td>
                                    <td>{{ $data['user_name'] }}</td>
                                </tr>
                                <tr>
                                    <td>管理权限</td>
                                    <td>@if($data['is_super']==0)职员 @else 店长 @endif</td>
                                </tr>
                                <tr>
                                    <td>登录时间</td>
                                    <td>{{ $data['last_log'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-footer">
    @include(themePath('.')."seller.include.partials._footer")
    </div>
</div>
@endsection



