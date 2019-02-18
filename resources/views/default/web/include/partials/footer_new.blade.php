<div class="footer-new-box">
    <div class="w1200">
        <ul class="new-list">
            @foreach(getFooterArticle() as $cat)
                @if($loop->index < 3)
                <li>
                    <h4>{{getLangData($cat, 'cat_name')}}</h4>
                    @foreach($cat['articles'] as $item)
{{--                        <a href="{{env('APP_URL').$item['file_url']}}" class="ovhwp" rel="nofollow">{{$item['title']}}</a>--}}
                        <a href="/{{$item['id']}}/helpCenter.html" class="ovhwp" rel="nofollow">{{ getLangData($item,'title') }}</a>
                    @endforeach
                </li>
            @endif
            @endforeach

            <li style="width:340px">

                <style>
                    .footer-new-box .new-list li .qr-code{float:left;}
                    .footer-new-box .new-list li .qr-code li{float:left;text-align:center;margin:0 10px;width:120px;}
                    .footer-new-box .new-list li .qr-code li span{line-height:30px;height:30px;font-size:14px;display:block;float:left;width:100%;}
                </style>

                <div class="qr-code">
                    <ul>
                        <li><img src="{{asset(themePath('/','web').'img/699035190855330866.jpg')}}" width="100" alt="{{trans('home.footer_subscription')}}"><span>{{trans('home.footer_subscription')}}</span></li>
                        <li><img src="{{asset(themePath('/','web').'img/二维码小程序.jpg')}}" width="100" alt="{{trans('home.footer_applet')}}"><span>{{trans('home.footer_applet')}}</span></li>
                    </ul>
                </div>

            </li>
            <li  style="width:290px">

                <div class="tel">
                    <p class="fs24 tac" style="color: #75b335;">{{getConfig('service_phone')}}</p>
                    <p class="tac" style="width: 190px; margin: 5px auto; color: #666;">{{trans('home.header_working_day')}} : 9:00-17:00</p>
                    <p class="tac"><a rel="nofollow" href="javascript:" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{getConfig('service_qq')}}&site=qq&menu=yes');"><img alt="{{trans('home.footer_custom_service')}}" border="0" class="mr5p" style="margin-top:3px;" src="{{asset(themePath('/','web').'img/custom.png')}}"></a></p>
                </div>
            </li>
        </ul>
    </div>
</div>
