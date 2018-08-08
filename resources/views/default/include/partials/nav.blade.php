<div class="framework-topbar">
    <div class="console-topbar">
        <div class="topbar-wrap topbar-clearfix">
            <div class="topbar-head topbar-left">
                <a href="{{url('group/index')}}" class="topbar-logo topbar-left">
                    <span class="icon-logo">
                        {{config('website.app_name')}} <sup>{{config('website.app_version')}}</sup>
                    </span>
                </a>
            </div>
            @foreach($menus as $menu)
                @if(empty($menu['sub']))
                    <a data-menu-node='m-{{$menu['id']}}' data-open="{{$menu['url']}}"
                       class="topbar-home-link topbar-btn topbar-left">
                        <span>@if(!empty($menu['icon']))<i class="{{$menu['icon']}}"></i>@endif {{$menu['title']}}</span>
                    </a>
                @else
                    <a data-menu-target='m-{{$menu['id']}}' class="topbar-home-link topbar-btn topbar-left">
                        <span>@if(!empty($menu['icon']))<i class="{{$menu['icon']}}"></i>@endif {{$menu['title']}}</span>
                    </a>
                @endif
            @endforeach
            <div class="topbar-info topbar-right">
                <a data-reload data-tips-text='刷新' style='width:50px'
                   class=" topbar-btn topbar-left topbar-info-item text-center">
                    <span class='glyphicon glyphicon-refresh'></span>
                </a>
                <div class="topbar-left topbar-user">
                    @if(empty(session('_account_user_info')))
                        <div class=" topbar-info-item">
                            <a data-href="{{route('account_login')}}" data-toggle="dropdown" class=" topbar-btn text-center">
                                <span class='glyphicon glyphicon-user'></span> 立即登录 </span>
                            </a>
                        </div>
                    @else
                        <div class="dropdown topbar-info-item">
                            <a href="#" class="dropdown-toggle topbar-btn text-center" data-toggle="dropdown">
                                <span class='glyphicon glyphicon-user'></span> {{session('_account_user_info.real_name')??session('_account_user_info.login_name')}} </span>
                                <span class="glyphicon glyphicon-menu-up transition" style="font-size:12px"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="topbar-info-btn">
                                    <a data-modal="{{url('auth/pass')}}">
                                        <span><i class='glyphicon glyphicon-lock'></i> 修改密码</span>
                                    </a>
                                </li>
                                <li class="topbar-info-btn">
                                    <a data-modal="{{url('auth/info')}}">
                                        <span><i class='glyphicon glyphicon-edit'></i> 修改资料</span>
                                    </a>
                                </li>
                                <li class="topbar-info-btn">
                                    <a data-load="{{url('logout')}}" data-confirm='确定要退出登录吗？'>
                                        <span><i class="glyphicon glyphicon-log-out"></i> 退出登录</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>