@extends(themePath('.','web').'web.include.layouts.wall_helpCenter')
@section('title', '帮助中心')
@section('css')

<style>
    </style>
@endsection
@section('content')

    <div class="today_news whitebg fl">
        <div class="w800p">
            <h1 class="info-detail-title" align="center" style="width: 900px;">
                {{ $detail['title'] }}
            </h1>
            <div class="info-detail-bq gray">
                <div class="bshare-custom" style="line-height:38px !important;display: inline-block;margin-left: 40px;"><div class="bsPromo bsPromo2"></div>
                    <div class="bsPromo bsPromo2"></div>
                </div>

            </div>
            <div class="info-detail-content">
                {!! $detail['content'] !!}
            </div>
        </div>
    </div>

@endsection
@section('js')
@endsection
