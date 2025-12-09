@extends('admin.layout')

@section('title_header', 'Панель администратора') 
@section('content')

    <div class="funnel-compact">
    <div class="funnel-header">
        <h3><i class="fas fa-filter"></i> Воронка посещений</h3>
        <select class="period-select">
            <option>Сегодня</option>
            <option selected>Неделя</option>
            <option>Месяц</option>
        </select>
    </div>
    
    <div class="funnel-visual">
        <div class="funnel-level">
            <div class="level-bar" style="width: 100%">
                <span class="level-label">Посетители</span>
                <span class="level-value">12,458</span>
            </div>
        </div>
        <div class="funnel-level">
            <div class="level-bar" style="width: 70%">
                <span class="level-label">Клики</span>
                <span class="level-value">8,742</span>
            </div>
        </div>
        <div class="funnel-level">
            <div class="level-bar" style="width: 26%">
                <span class="level-label">Корзина</span>
                <span class="level-value">3,215</span>
            </div>
        </div>
        <div class="funnel-level">
            <div class="level-bar" style="width: 15%">
                <span class="level-label">Покупки</span>
                <span class="level-value">1,847</span>
            </div>
        </div>
    </div>
    
    <div class="funnel-stats">
        <div class="stat-item">
            <div class="stat-value">14.8%</div>
            <div class="stat-label">Конверсия</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">57.4%</div>
            <div class="stat-label">В корзину</div>
        </div>
    </div>
</div>

<style>
:root {
    --white_color: #fff;
    --blue_color: #0496ba;
    --link_hover: #07637a;
    --blue_dark_color: #2f323c;
}

.funnel-compact {
    background: var(--white_color);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: 1px solid #eaeaea;
}

.funnel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.funnel-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--blue_dark_color);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.funnel-header h3 i {
    color: var(--blue_color);
}

.period-select {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 4px 8px;
    font-size: 12px;
    color: #666;
    background: var(--white_color);
}

.funnel-visual {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 15px;
}

.funnel-level {
    display: flex;
    align-items: center;
    gap: 10px;
}

.level-bar {
    background: var(--blue_color);
    padding: 8px 12px;
    border-radius: 6px;
    color: var(--white_color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.level-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transform: translateX(-100%);
}

.level-bar:hover {
    background: var(--link_hover);
}

.level-bar:hover::before {
    animation: shimmer 1.5s infinite;
}

.level-label {
    font-size: 12px;
    font-weight: 500;
}

.level-value {
    font-size: 12px;
    font-weight: 600;
}

.funnel-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    border-top: 1px solid #f0f0f0;
    padding-top: 15px;
}

.stat-item {
    text-align: center;
    padding: 8px;
    background: #f8f9fa;
    border-radius: 6px;
}

.stat-value {
    font-size: 18px;
    font-weight: 700;
    color: var(--blue_color);
    margin-bottom: 2px;
}

.stat-label {
    font-size: 10px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Анимация появления */
.funnel-level .level-bar {
    animation: slideInRight 0.6s ease-out;
}

.funnel-level:nth-child(1) .level-bar { animation-delay: 0.1s; }
.funnel-level:nth-child(2) .level-bar { animation-delay: 0.2s; }
.funnel-level:nth-child(3) .level-bar { animation-delay: 0.3s; }
.funnel-level:nth-child(4) .level-bar { animation-delay: 0.4s; }

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Анимация чисел
    const counters = document.querySelectorAll('.level-value, .stat-value');
    
    counters.forEach(counter => {
        const originalText = counter.textContent;
        if (originalText.includes('%')) {
            return; // Пропускаем проценты
        }
        
        const target = parseInt(originalText.replace(/,/g, ''));
        const duration = 1500;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });
});
</script>
@endsection