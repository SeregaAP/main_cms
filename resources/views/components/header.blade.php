
<header class="cms-header">
    <div class="cms-logo">
        <div class="logo-icon">
            <i class="fas fa-cube"></i>
        </div>
        {{ $titleHeader }}
    </div>
    <div class="header-actions">
        @if(!empty($buttons) && is_array($buttons))
            @foreach($buttons as $button)
                <a href="{{ $button['href'] ?? '#' }}" class="{{ $button['class'] ?? 'btn' }}">
                    {{ $button['label'] }}
                </a>
            @endforeach
        @endif
    </div>
</header>