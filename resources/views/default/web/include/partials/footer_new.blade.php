<div class="footer-new-box">
    <div class="w1200">
        <ul class="new-list">
            @foreach(getFooterArticle() as $cat)
                <li>
                    <h4>{{$cat['cat_name']}}</h4>
                    @foreach($cat['articles'] as $item)
                        <a href="#.html" rel="nofollow">{{$item['title']}}</a>
                    @endforeach
                </li>
            @endforeach
            <li>
                <div class="tel">
                    <p class="fs24 tac" style="color: #75b335;">{{getConfig('service_phone')}}</p>
                    <p class="tac" style="width: 190px; margin: 5px auto; color: #666;">周一至周日8:00-18:00（仅收市话费--{{getConfig('service_qq')}}）</p>
                    <p class="tac"><a rel="nofollow" href="javascript:" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{getConfig('service_qq')}}&site=qq&menu=yes');"><img border="0" class="mr5p" style="margin-top:3px;" src="{{asset(themePath('/','web').'img/custom.png')}}"></a></p>
                </div>
            </li>
        </ul>
    </div>
</div>