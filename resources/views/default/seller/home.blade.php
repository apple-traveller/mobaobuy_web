@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
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
<body>
<div class="main" >
    <li><a href="/seller">首页</a></li>
    <li><a href="/seller/goods/list">商品</a></li>
    <li><a href="javascript:void(0);">订单</a></li>
    <li><a href="javascript:void(0);">报表</a></li>
    <li><a href="javascript:void(0);">系统</a></li>
    <li><a href="javascript:void(0);">店铺信息</a></li>
    <li><a href="seller/logout">退出</a></li>
    <h1>商户主页</h1>
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
</body>
@stop
