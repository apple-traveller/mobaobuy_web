<div class="framework-sidebar hide">
    <div class="sidebar-content">
        <div class="sidebar-inner">
            <div class="sidebar-fold">
                <span class="glyphicon glyphicon-option-vertical transition"></span>
            </div>
            @foreach($menus as $pmenu)
                @if(!empty($pmenu['sub']))
                    <div data-menu-box="m-{{$pmenu['id']}}">
                        @foreach($pmenu['sub'] as $menu)
                            <div class="sidebar-nav main-nav">
                            @if(empty($menu['sub']))
                                <ul class="sidebar-trans">
                                    <li class="nav-item">
                                        <a data-menu-node='m-{{$pmenu['id']}}-{{$menu['id']}}' data-open="{{$menu['url']}}"
                                           class="sidebar-trans">
                                            <div class="nav-icon sidebar-trans">
                                                <span class="{{$menu['icon'] or 'fa fa-link'}} transition"></span>
                                            </div>
                                            <span class="nav-title">{{$menu['title']}}</span>
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <div class="sidebar-title">
                                    <div class="sidebar-title-inner">
                                        <span class="sidebar-title-icon fa fa-caret-right transition"></span>
                                        <span class="sidebar-title-text">{{$menu['title']}}</span>
                                    </div>
                                </div>
                                <ul class="sidebar-trans" style="display:none" data-menu-node='m-{{$pmenu['id']}}-{{$menu['id']}}'>
                                    @foreach($menu['sub'] as $submenu)
                                    <li class="nav-item">
                                        <a data-menu-node='m-{{$pmenu['id']}}-{{$submenu['id']}}' data-open="{{$submenu['url']}}"
                                           class="sidebar-trans">
                                            <div class="nav-icon sidebar-trans">
                                                <span class="{{$submenu['icon'] or 'fa fa-link'}} transition"></span>
                                            </div>
                                            <span class="nav-title">{{$submenu['title']}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>