<a href="{{ $route }}" class="nav_item">
    <div class="nav_item_group">
        <i class="{{ $icon }}"></i>
        <span>{{ $name }}</span>
    </div>
    @if(isset($count) && $count != '')
    <span class="badge">{{ $count }}</span>
    @endif
</a>