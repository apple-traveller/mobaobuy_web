
<div class="top-box">
    <div class="w1200">
        <div class="fl account">
            <ul>
                @if(session('_web_user_id'))
                <li class="site-nav-menu"><div><a rel="nofollow" href="javascript:void(0);" class="link-login"><i class="iconfont icon-user"></i>{{session('_web_user')['nick_name']}}</a></div></li>
                <li class="site-nav-menu"><div><a rel="nofollow" href="{{url('logout')}}">{{trans('home.header_quit')}}</a></div></li>
                    @if(!empty(session('_web_user')['firms']))
                    <li class="site-nav-menu"><div>{{trans('home.header_curr')}}：</div></li>
                    <li class="site-nav-menu">
                        <div><a rel="nofollow" href="javascript:void(0);"> @if(session('_curr_deputy_user.is_self')){{trans('home.header_personal')}} @else{{session('_curr_deputy_user.name')}}@endif <i class="iconfont iconfont-down"></i></a></div>
                        <div class="site-nav-menu-list">
                            <div class="menu-bd-panel">
                                <a rel="nofollow" href="javascript:void(0);" data-value="0" onclick="changeDeputy(this)">{{trans('home.header_personal')}}</a>
                                @foreach(session('_web_user')['firms'] as $v)
                                    <a rel="nofollow" href="javascript:void(0);" data-value="{{$v['firm_id']}}" onclick="changeDeputy(this)">{{$v['firm_name']}}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    @endif

                @else
                    <li class="site-nav-menu"><div><a rel="nofollow" href="{{url('logout')}}" class="link-login">{{trans('home.header_login')}}</a></div></li>
                    <li class="site-nav-menu"><div><a rel="nofollow" href="{{route('register')}}">{{trans('home.header_register')}}</a></div></li>
                @endif
                    {{trans('home.header_working_day')}} : 9:00-17:00
                <select onchange="changelang(this.value)">
                    <option value='zh-cn'@if(App::getLocale() == 'zh-cn') selected @endif>简体中文</option>
                    <option value="en" @if(App::getLocale() =='en')selected @endif> English </option>
                </select>
            </ul>
        </div>
        <div class="fr quick-menu">


            @foreach(getPositionNav('top') as $item)
                <a rel="nofollow" href="{{$item['url']}}" @if($item['opennew'])target="_blank"@else target="_self"@endif>{{$item['name']}}</a>
            @endforeach
            <span><i class="iconfont icon-3"></i>{{getConfig('service_phone')}}</span>
        </div>
    </div>
</div>
<script>
    function changelang(val){
        $.ajax({
            type :'get',
            url :'{{url("edit_language")}}',
            data:{
                lang :val
            },
            dataType :'json',
            success:function(res){
                if(res){
                    window.location.reload();
                }
            }
        })

    }

</script>