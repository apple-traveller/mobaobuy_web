<!DOCTYPE html>
<html>
<head>
    @include(themePath('.').'seller.include.partials.css_js')
    @yield('styles')
</head>
<body style="min-width: 0px">
    @yield('body')

    @yield('content')
    <script>
        layui.use('element', function(){
            var element = layui.element;
        });
    </script>
</body>
@yield('script')
</html>

