@extends(themePath('.').'account.include.layouts.base')

@section('body')
    @include(themePath('.').'account.include.partials.nav')
    <div class="framework-body framework-sidebar-mini">
        @include(themePath('.').'account.include.partials.menu')
        <div class="framework-container" style="left:0">
            @yield('content')
        </div>
    </div>
@endsection