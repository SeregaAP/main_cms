<a class="btn_all {{ $class }}" href="{{ $href }}">
    @if(isset($icon) && isset($directions) && $directions == 'left')
        <i class="{{ $icon }}"></i>
    @endif
    <span class="btn_all_txt">{{ $text}}</span>
    <span class="btn_all_hover"></span>
    @if(isset($icon) && isset($directions) && $directions == 'right')
        <i class="{{ $icon }}"></i>
    @endif
</a>