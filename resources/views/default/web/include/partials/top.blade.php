<div class="top-box">
    <div class="w1200">
        <div class="fl account">
            @if(session('_web_user_id'))
                <a href="{{route('login')}}" class="link-login"><i class="iconfont icon-user"></i>{{session('_web_user')['nick_name']}}</a>
                <a href="{{url('logout')}}">退出</a>

                @if(!empty(session('_web_user')['firms']))
                    <select id="selectCompany" onchange="selectCompany();">
                        @if(!session('_web_user')['is_firm'])
                            <option @if(session('_curr_deputy_user')['is_self']) selected @endif value="0">个人</option>
                            @foreach(session('_web_user')['firms'] as $v)
                                <option @if(session('_curr_deputy_user')['firm_id'] == $v['firm_id']) selected @endif value="{{$v['firm_id']}}">{{$v['firm_name']}}</option>
                            @endforeach
                        @else
                            <option value="0">{{session('_web_user')['nick_name']}}</option>
                        @endif
                    </select>
                @endif
            @else
                <a href="{{route('login')}}" class="link-login">请登录</a>
                <a href="{{route('register')}}">免费注册</a>
            @endif
        </div>
        <div class="fr quick-menu">

            @foreach(getPositionNav('top') as $item)
                <a href="{{$item['url']}}" @if($item['opennew'])target="_blank"@else target="_self"@endif>{{$item['name']}}</a>
            @endforeach
            <span><i class="iconfont icon-3"></i>{{getConfig('service_phone')}}</span>
        </div>
    </div>
</div>