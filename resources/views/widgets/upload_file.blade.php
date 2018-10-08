<div class="type-file-box">
    <input type="button" class="type-file-button">
    <input type="file" class="type-upload-file" size="30" data-type="{{$upload_type}}" data-path="{{$upload_path}}" hidefocus="true">
    <span class="show">
        <i class="iconfont icon-image img-tooltip" @if(!isset($value) || empty($value)) style="display: none;" @else data-img="{{getFileUrl($value)}}" @endif ></i>
    </span>
    <input type="text" name="{{$name}}" id="{{$name}}" class="type-file-text" value="{{$value or ''}}" readonly>
</div>