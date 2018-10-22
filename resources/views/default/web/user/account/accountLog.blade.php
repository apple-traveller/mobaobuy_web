@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '积分详情')
@section('css')
    <style>
        /*会员中心-查看积分*/

        .member_list_mode h1{font-size: 16px;padding-left: 24px;margin-left: 30px;}

        .member_left_list li{display:block;margin-top: 10px;padding-left: 52px;cursor: pointer;}
        .member_left_list li:hover{color: #75b335;}
        .member_left_list li.member_left_curr{border-left:4px solid #75b335;padding-left: 46px;color: #75b335; box-sizing: border-box;}
        .member_left_list li:last-child{position:relative;margin-top: 40px;}

        .reward_table_list{width: 905px;margin: 0 auto;margin-top: 20px;margin-bottom: 70px;}
        .reward_table_list li{height: 46px;line-height: 46px;}
        .reward_table_title{width: 70%;padding: 0 10px;box-sizing: border-box;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .reward_table_num{width: 30%;}
        .reward_table_list li:nth-child(odd){background-color: #f4f4f4;}
        .reward_table_list li:first-child{font-size:14px;height:40px;line-height:40px;border: 1px solid #DEDEDEA;background-color: #eeeeee;}
        .reward_table_list li:last-child{font-size:14px;height:81px;line-height:81px;background-color: #f8f8f8;}
        .reward_table_list .reward_totle_num{float: right;margin-right: 100px;}

        .lcolor{color:#75b335;}

        .reward_table_bottom{position:absolute;bottom: 5px;right: 27px;}
        .reward_table_bottom ul.pagination {display: inline-block;padding: 0;margin: 0;}
        .reward_table_bottom ul.pagination li {height: 20px;line-height: 20px;display: inline;}
        .reward_table_bottom ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
            border: 1px solid #ddd;margin: 0 4px;}
        .reward_table_bottom ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .reward_table_bottom ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}

    </style>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
@endsection
@section('js')


@endsection

@section('content')
    <div class="clearfix mt25">

            <ul class="reward_table_list">
                <li><div class="reward_table_title fl tac">名称</div><div class="reward_table_num fl tac">积分</div></li>
                @foreach($user_account_logs as $vo)
                <li><div class="reward_table_title fl tac">{{$vo['change_desc']}}</div><div class="reward_table_num fl tac lcolor">{{$vo['points']}}</div></li>
                @endforeach
                <li><div class="reward_totle_num">总积分：<span class="orange fwb">{{$totalPoints}}</span></div></li>
            </ul>
            <div class="reward_table_bottom">
                <ul id="page" class="pagination">

                </ul>
            </div>
    </div>
    <script src="{{asset(themePath('/').'plugs/layui/layui.js')}}" ></script>
    <script type="text/javascript">
        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , prev: "上一页"
                    , next: "下一页"
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/account/viewPoints?currpage="+obj.curr;
                        }
                    }
                });
            });
        }
    </script>
@endsection
