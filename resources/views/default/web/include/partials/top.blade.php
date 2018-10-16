<div class="top-box">
    <div class="w1200">
        <div class="fl account">
            <ul>
                @if(session('_web_user_id'))
                <li class="site-nav-menu"><div><a href="{{route('login')}}" class="link-login"><i class="iconfont icon-user"></i>{{session('_web_user')['nick_name']}}</a></div></li>
                <li class="site-nav-menu"><div><a href="{{url('logout')}}">退出</a></div></li>
                    @if(!empty(session('_web_user')['firms']))
                    <li class="site-nav-menu"><div>当前操作对象：</div></li>
                    <li class="site-nav-menu">
                        <div><a href="jacascript::void(0)">{{session('_curr_deputy_user')['name']}}<i class="iconfont iconfont-down"></i></a></div>
                        <div class="site-nav-menu-list">
                            <ul class="menu-bd-panel">
                                <li>个人</li>
                                @foreach(session('_web_user')['firms'] as $v)
                                    <li data-value="{{$v['firm_id']}}" onclick="changeDeputy()">{{$v['firm_name']}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endif

                @else
                    <li class="site-nav-menu"><div><a href="{{url('logout')}}" class="link-login">请登录</a></div></li>
                    <li class="site-nav-menu"><div><a href="{{url('register')}}">免费注册</a></div></li>
                @endif
            </ul>
        </div>
        <div class="fr quick-menu">

            @foreach(getPositionNav('top') as $item)
                <a href="{{$item['url']}}" @if($item['opennew'])target="_blank"@else target="_self"@endif>{{$item['name']}}</a>
            @endforeach
            <span><i class="iconfont icon-3"></i>{{getConfig('service_phone')}}</span>
        </div>
    </div>
</div>