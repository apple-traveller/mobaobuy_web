<!DOCTYPE html>
<html>
<head>
    @include(themePath('.').'seller.include.partials.css_js')
    @yield('styles')
</head>
<body class="layui-layout-body">
    @yield('body')
    @yield('script')
    @yield('content')
    <script>
        layui.use('element', function(){
            var element = layui.element;
        });
    </script>
</body>

</html>

