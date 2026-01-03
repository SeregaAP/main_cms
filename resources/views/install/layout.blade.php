<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Установка CMS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="install_body">
    <div class="install_block">
        <div class="container">
            <div class="install_block_cnt">
                <div class="progress_step">
                    <div class="progress_step_cnt">
                        @php
                            $steps = [
                                'welcome' => ['icon' => 'home', 'label' => 'Приветствие'],
                                'requirements' => ['icon' => 'cog', 'label' => 'Требования'],
                                'database' => ['icon' => 'database', 'label' => 'База данных'],
                                'admin' => ['icon' => 'user-shield', 'label' => 'Администратор'],
                                'complete' => ['icon' => 'check', 'label' => 'Готово'],
                            ];
                            $currentStep = request()->route()->getName();
                        @endphp
                        @foreach($steps as $step => $data)
                            <div class="flex items-center progress_itm">
                                <div class="progress_itm_icon 
                                    {{ $currentStep == "install.{$step}" ? 'bg-required text-white' : 
                                       (array_search($currentStep, array_keys($steps)) >= array_search($step, array_keys($steps)) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                                    <i class="fas fa-{{ $data['icon'] }}"></i>
                                </div>
                                <span class="progress_txt">{{ $data['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Content -->
                <div class="install_block_txt">
                    @yield('content')
                </div>
                <!-- Footer -->
                <div class="install_footer">
                    <p>&copy; {{ date('Y') }} Ваша CMS. Все права защищены.</p>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
    <script src="{{ asset('libs/jquery/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('libs/slick/slick.min.js') }}"></script>
    <script src="{{ asset('js/cms.js') }}"></script>
</body>
</html>