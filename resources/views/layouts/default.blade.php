<div class="container">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        {{--href route里面的home是路由 / 的别名--}}
        <a class="navbar-brand" href="{{ route('home')  }}">首页</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="www.baidu.com">百度</a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                @auth
                <a href="{{ route('logout') }}" class="btn btn-danger my-2 my-sm-0 mr-2">退出</a>
                @else
                    <a href="{{ route('user.create') }}" class="btn btn-danger my-2 my-sm-0 mr-2">注册</a>
                    <a href="{{ route('login') }}" class="btn btn-success my-2 my-sm-0">登陆</a>
                @endauth

            </form>
        </div>
    </nav>
    @include('layouts._error')
    @include('layouts._message')
    @yield('content')

</div>