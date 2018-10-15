<div class="footer-new-box">
    <div class="w1200">
        <ul class="new-list">
            @foreach(getFooterArticle() as $cat)
                <li>
                    <h4>{{$cat['cat_name']}}</h4>@php print_r($cat); @endphp
                    @foreach($cat['articles'] as $item)
                        <a href="#.html" rel="nofollow">{{$item['title']}}</a>
                    @endforeach
                </li>
            @endforeach
            <li>
                <div class="tel">
                    <p class="fs24 tac" style="color: #75b335;">{{getConfig('service_phone')}}</p>
                    <p class="tac" style="width: 190px; margin: 5px auto; color: #666;">周一至周日8:00-18:00（仅收市话费）</p>
                    <p class="tac"><a rel="nofollow" href="#"><img border="0" class="mr5p" style="margin-top:3px;" src="{{themePath('/','web')}}img/custom.png"></a></p>
                </div>
            </li>
        </ul>
    </div>
</div>