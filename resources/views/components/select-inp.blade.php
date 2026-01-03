<div class="select_inp">
    <label for="{{ $name }}">{{ $label }}</label>
    <div class="select_inp_type">
        <div class="select_inp-result">
            <span class="select-result-txt">{{ $placeholder }}</span>
            <button class="select_btn_open" type="button">
                <i class="fa-regular fa-angle-right"></i>
            </button>
        </div>
        <input class="select-input" type="hidden" placeholder="grdtrfdtf" value="{{ $default }}" id="{{ $name }}" name="{{ $name }}" type="text">
    </div>
    <div class="select_inp_list-block">
        <div class="select_inp_itm-group">
            <div class="select_inp_itm_padding">
                <div data-id="" class="select_inp_itm">Оставить поле пустым</div>
                @if(!empty($elements) && $elements->count() > 0)
                    @foreach($elements as $element)
                        <div 
                            data-id="{{ $element->id ?? $element['id'] }}" 
                            class="select_inp_itm"
                        >
                            {{ $element->title ?? $element['title'] }}
                        </div>
                    @endforeach
                @else
                    <div class="select_inp_itm">Нет доступных страниц</div>
                @endif
            </div>
        </div>
    </div>
</div>