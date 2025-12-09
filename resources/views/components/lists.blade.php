<div class="list_menu_sidebar {{ $class ?? '' }}" >
    @if($name)
        <button class="btn_menu_sidebar" type="button">
            {{ $name }}
            <span>
                <i class="fa-sharp fa-regular fa-angle-right"></i>
            </span>
        </button>
    @endif
    <ul class="{{ $class }}">
        {{ $slot }}
    </ul>
</div>