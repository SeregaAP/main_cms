@extends('install.layout')

@section('content')
<h3>Настройка базы данных</h3>
<form id="databaseForm">
    @csrf
    <div class="install_form">
        <div class="install_form_itm">
            <label>
                Хост БД
                <input type="text" name="db_host" value="localhost" required>
            </label>
        </div>

        <div class="install_form_itm">
            <label>
                Имя базы данных
                <input type="text" name="db_name" required>
            </label>
        </div>

        <div class="install_form_itm">
            <label>
                Пользователь БД
                <input type="text" name="db_user" required>
            </label>
        </div>

        <div class="install_form_itm">
            <label>
                Пароль БД
                <input type="password" name="db_pass">
            </label>
        </div>
    </div>

    <div id="testResult" class=""></div>

    <div class="install_btn_group">
        <a href="{{ route('install.requirements') }}" 
           class="btn_all">
            <i class="fas fa-arrow-left mr-2"></i>
            Назад
        </a>

        <button type="button" id="testConnection" 
                class="btn_all">
            <i class="fas fa-plug mr-2"></i>
            Проверить подключение
        </button>

        <button type="button" id="continueBtn" disabled
                class="btn_all">
            Продолжить
            <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('testConnection').addEventListener('click', function() {
    const form = document.getElementById('databaseForm');
    const resultDiv = document.getElementById('testResult');
    const continueBtn = document.getElementById('continueBtn');
    const testBtn = this;

    // Показываем загрузку
    testBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Проверка...';
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
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                    <span class="text-green-800 font-semibold">${data.message}</span>
                </div>
            `;
            continueBtn.disabled = false;
            continueBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            continueBtn.classList.add('hover:bg-green-700');
        } else {
            resultDiv.className = 'result_required_error';
            resultDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-times-circle text-red-600 mr-2"></i>
                    <span class="text-red-800 font-semibold">${data.message}</span>
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
        testBtn.innerHTML = '<i class="fas fa-plug mr-2"></i> Проверить подключение';
        testBtn.disabled = false;
    });
});

// Разрешаем продолжить после успешной проверки
document.getElementById('continueBtn').addEventListener('click', function() {
    window.location.href = '{{ route("install.admin") }}';
});
</script>
@endpush