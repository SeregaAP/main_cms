<div class="info-card">
    <span class="circle"></span>
    <span class="circle2"></span>
    <div class="info-card_icon">
        <i class="{{ $icon }}"></i>
    </div>
    <div class="info-card_content">
        <span class="info-card-title">{{ $title }}</span>
        <div class="flip-counter-wrapper">
            @foreach($counter as $digit)
                <div class="flip-digit" data-max="{{ $digit }}">
                    <div class="card upper">
                    <img src="/images/timer/0-0.jpg">
                    </div>
                    <div class="card lower">
                    <img src="/images/timer/0-1.jpg">
                    </div>
                    <div class="card upper next">
                    <img>
                    </div>
                    <div class="card lower next">
                    <img>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
