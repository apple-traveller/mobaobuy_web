
<div class="top-box">
    <div class="w1200">
        <div class="fl account">
            <ul>
                @if(session('_web_user_id'))
                <li class="site-nav-menu"><div><a rel="nofollow" href="javascript:void(0);" class="link-login"><i class="iconfont icon-user"></i>{{session('_web_user')['nick_name']}}</a></div></li>
                <li class="site-nav-menu"><div><a rel="nofollow" href="{{url('logout')}}">退出</a></div></li>
                    @if(!empty(session('_web_user')['firms']))
                    <li class="site-nav-menu"><div>当前操作对象：</div></li>
                    <li class="site-nav-menu">
                        <div><a rel="nofollow" href="javascript:void(0);"> @if(session('_curr_deputy_user.is_self'))个人 @else{{session('_curr_deputy_user.name')}}@endif <i class="iconfont iconfont-down"></i></a></div>
                        <div class="site-nav-menu-list">
                            <div class="menu-bd-panel">
                                <a rel="nofollow" href="javascript:void(0);" data-value="0" onclick="changeDeputy(this)">个人</a>
                                @foreach(session('_web_user')['firms'] as $v)
                                    <a rel="nofollow" href="javascript:void(0);" data-value="{{$v['firm_id']}}" onclick="changeDeputy(this)">{{$v['firm_name']}}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    @endif

                @else
                    <li class="site-nav-menu"><div><a rel="nofollow" href="{{url('logout')}}" class="link-login">请登录</a></div></li>
                    <li class="site-nav-menu"><div><a rel="nofollow" href="{{route('register')}}">免费注册</a></div></li>
                @endif
                    交易时间(工作日) : 9:00-17:00
            </ul>
        </div>
        <div class="fr quick-menu">


            @foreach(getPositionNav('top') as $item)
                <a @if($item['is_nofollow']) rel="nofollow" @endif href="{{$item['url']}}" @if($item['opennew'])target="_blank"@else target="_self"@endif>{{$item['name']}}</a>
            @endforeach
            <span><i class="iconfont icon-3"></i>{{getConfig('service_phone')}}</span>
        </div>
    </div>
</div>