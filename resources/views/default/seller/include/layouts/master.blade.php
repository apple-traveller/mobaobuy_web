<!DOCTYPE html>
<html>
<head>
    @include(themePath('.').'seller.include.partials.css_js')
    @yield('styles')
</head>
<body class="">
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

