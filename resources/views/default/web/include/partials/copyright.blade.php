<div class="copyright-box">
    <div class="links">
        @foreach(getPositionNav('bottom') as $item)
            <a href="{{$item['url']}}" rel="nofollow" @if($item['opennew'])target="_blank" @else target="_self"@endif>{{$item['name']}}</a>@if (!$loop->last)|@endif
        @endforeach
    </div>
    <div class="copyright"> @if(!empty(getConfig('copyright'))){{getConfig('copyright')}}@endif @if(!empty(getConfig('icp_number')))&nbsp;ICP备案证书号:{{getConfig('icp_number')}}@endif @if(!empty(getConfig('powered_by')))&nbsp;POWERED by:{{getConfig('powered_by')}} @endif</div>
</div>
