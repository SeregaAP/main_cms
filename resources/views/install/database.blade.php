@extends('install.layout')

@section('content')
<div class="install_database">
    <h3>Настройка базы данных</h3>
    <form id="databaseForm">
        @csrf
        <div class="install_form">
            <x-input 
                placeholder="хост" 
                type="text" 
                name="db_host" 
                label="Хост БД" 
                :required="true"
                autocomplete="db_host"
                autofocus
                maxlength="255"
            />
            <x-input 
                placeholder="имя базы данных" 
                type="text" 
                name="db_name" 
                label="Имя базы данных" 
                :required="true"
                autocomplete="db_name"
                autofocus
                maxlength="255"
            />
            <x-input 
                placeholder="пользователь бд" 
                type="text" 
                name="db_user" 
                label="Пользователь БД" 
                :required="true"
                autocomplete="db_user"
                autofocus
                maxlength="255"
            />
            <x-input 
                placeholder="пароль бд" 
                type="password" 
                name="db_pass" 
                label="Пароль БД" 
                :required="true"
                autocomplete="db_pass"
                autofocus
                maxlength="255"
            />
        </div>
    
        <div id="testResult" class="result_check"></div>
    
        <div class="install_btn_group">
            <x-btn_link class="reg" href="{{ route('install.requirements') }}" text="Назад" icon="fa-solid fa-arrow-right fa-rotate-180" directions="left" />
            <x-btn type="button" id="testConnection" text="Проверить подключение" icon="fa-solid fa-plug" />
            <x-btn :disabled="true" type="button" id="continueBtn" text="Продолжить" icon="fa-solid fa-arrow-right" />
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('testConnection').addEventListener('click', function() {
    const form = document.getElementById('databaseForm');
    const resultDiv = document.getElementById('testResult');
    const continueBtn = document.getElementById('continueBtn');
    const testBtn = this;

    // Показываем загрузку
    testBtn.disabled = true;

    fetch('{{ route("install.database.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            db_host: form.db_host.value,
            db_name: form.db_name.value,
            db_user: form.db_user.value,
            db_pass: form.db_pass.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.className = 'result_required';
            resultDiv.innerHTML = `
                <div class="result-txt">
                    <i class="fas fa-check-circle"></i>
                    <span>${data.message}</span>
                </div>
            `;
            continueBtn.disabled = false;
            continueBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            continueBtn.classList.add('hover:bg-green-700');
            continueBtn.classList.remove('btn-disabled');
        } else {
            resultDiv.className = 'result_required_error';
            resultDiv.innerHTML = `
                <div class="result-txt">
                    <i class="fas fa-times-circle"></i>
                    <span>${data.message}</span>
                </div>
            `;
        }
    })
    .catch(error => {
        resultDiv.className = 'result_required_error';
        resultDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-times-circle text-red-600 mr-2"></i>
                <span class="text-red-800 font-semibold">Ошибка сети: ${error}</span>
            </div>
        `;
    })
    .finally(() => {
        testBtn.disabled = false;
    });
});

// Разрешаем продолжить после успешной проверки
document.getElementById('continueBtn').addEventListener('click', function() {
    window.location.href = '{{ route("install.admin") }}';
});
</script>
@endpush