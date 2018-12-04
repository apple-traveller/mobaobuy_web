<div class="footer-new-box">
    <div class="w1200">
        <ul class="new-list">
            @foreach(getFooterArticle() as $cat)
                @if($loop->index < 3)
                <li>
                    <h4>{{$cat['cat_name']}}</h4>
                    @foreach($cat['articles'] as $item)
{{--                        <a href="{{env('APP_URL').$item['file_url']}}" class="ovhwp" rel="nofollow">{{$item['title']}}</a>--}}
                        <a href="/{{$item['id']}}/helpCenter.html" class="ovhwp" rel="nofollow">{{$item['title']}}</a>
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
                        <li><img src="https://www.sumibuy.com/images/web/qr1.jpg" width="100" alt="关注秣宝公众号"><span>关注秣宝公众号</span></li>
                        <li><img src="https://www.sumibuy.com/images/web/qr2.jpg" width="100" alt="进入秣宝小程序"><span>进入秣宝小程序</span></li>
                    </ul>
                </div>

            </li>
            <li  style="width:290px">

                <div class="tel">
                    <p class="fs24 tac" style="color: #75b335;">{{getConfig('service_phone')}}</p>
                    <p class="tac" style="width: 190px; margin: 5px auto; color: #666;">周一至周日8:00-18:00（仅收市话费）</p>
                    <p class="tac"><a rel="nofollow" href="javascript:" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{getConfig('service_qq')}}&site=qq&menu=yes');"><img border="0" class="mr5p" style="margin-top:3px;" src="{{asset(themePath('/','web').'img/custom.png')}}"></a></p>
                </div>
            </li>
        </ul>
    </div>
</div>
