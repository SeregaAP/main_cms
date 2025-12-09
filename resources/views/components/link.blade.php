<div class="component_link-parent {{ $active ? 'active' : '' }}">
    @if($nameList)
        <span>{{ $nameList }}</span>
    @endif
    <a href="{{ $href ?? '#' }}" class="component_link {{ $class ?? '' }}">
        {{ $slot }}
    </a>
</div>