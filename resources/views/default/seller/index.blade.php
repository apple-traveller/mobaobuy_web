@include('layouts.header')
<style>
    .main{
        text-align: center;
        background-color: #fff;
        border-radius: 20px;
        width: 600px;
        height: 350px;
        margin: auto;
        position: absolute;
        top: 20px;
        left: 600px;
    }
    li {float: left;margin-right:20px; list-style: none}
</style>
<body>
<div class="main" >
    <li><a href="/seller">首页</a></li>
    <li><a href="javascript:void(0);">商品</a></li>
    <li><a href="javascript:void(0);">订单</a></li>
    <li><a href="javascript:void(0);">报表</a></li>
    <li><a href="javascript:void(0);">系统</a></li>
    <li><a href="javascript:void(0);">店铺信息</a></li>
    <li><a href="seller/logout">退出</a></li>
    <h1>商户主页</h1>
    <table>
        <tr>
            <td>用户名</td>
            <td> <B>{{ $data['user_name'] }}</B></td>
            <td>店铺名称</td>
            <td>  <b>{{ $data['shop_name'] }}</b></td>
        </tr>
        <tr>
            <td>权限管理</td>
            <td>   <B>@if($data['is_super']==0)职员@else管理员@endif</B></td>
            <td>最后登录</td>
            <td>{{ $data['last_log'] }}</td>
        </tr>
    </table>
</div>

</body>
<script>
</script>
</html>
