<button 
class="btn_all {{ $class }} @if($disabled) btn-disabled @endif" 
id="{{ $id }}" 
type="{{ $type }}"
@if($disabled) disabled @endif
> 
    <span class="btn_all_txt">{{ $text}}</span>
    <span class="btn_all_hover"></span>
    @if($icon)
    <i class="{{ $icon }}"></i>
    @endif
</button>
