<div class="top-box">
    <div class="w1200">
        <div class="fl account">
            <a href="{{route('login')}}" class="link-login">请登录</a>
            <a href="{{route('register')}}">免费注册</a>
        </div>
        <div class="fr quick-menu">

            @foreach(getPositionNav('top') as $item)
                <a href="{{$item['url']}}" @if($item['opennew'])target="_blank"@else target="_self"@endif>{{$item['name']}}</a>
            @endforeach
            <span><i class="iconfont icon-3"></i>{{getConfig('service_phone')}}</span>
        </div>
    </div>
</div>