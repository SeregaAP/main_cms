@extends('install.layout')

@section('content')
<div class="requirement_block">
    <h3>Проверка требований</h3>
    <div class="requirement_list">
       @foreach($requirements as $requirement => $passed)
        <div class="requirement_itm">
            <span class="text-gray-700">{{ $requirement }}</span>
            <span class="{{ $passed ? 'text-green-600' : 'text-red-600' }}">
                <i class="fas fa-{{ $passed ? 'check' : 'times' }}"></i>
            </span>
        </div>
        @endforeach
    </div>
    <h3>Права на запись</h3>
    <div class="requirement_list">
        <div class="requirement_list">
            @foreach($writablePaths as $path => $writable)
            <div class="requirement_itm">
                <span class="text-gray-700">{{ $path }}</span>
                <span class="{{ $writable ? 'text-green-600' : 'text-red-600' }}">
                    <i class="fas fa-{{ $writable ? 'check' : 'times' }}"></i>
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @if($allPassed && $allWritable)
    <div class="result_required">
        <div class="result-txt">
            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
            <span class="text-green-800 font-semibold">Все требования удовлетворены!</span>
        </div>
        <x-btn_link 
        class="reg"  
        href="{{ route('install.database') }}" 
        text="Далее" 
        icon="fa-solid fa-arrow-right"
        directions="right" />
    </div>
    
    @else
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-6">
        <div class="result-txt">
            <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-3"></i>
            <span class="text-red-800 font-semibold">Не все требования удовлетворены</span>
        </div>
        <p class="text-red-700 mt-2">Пожалуйста, исправьте отмеченные проблемы перед продолжением.</p>
    </div>
    <div class="flex justify-between mt-6">
        <a href="{{ route('install.welcome') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Назад
        </a>
        <button onclick="location.reload()" 
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-sync-alt mr-2"></i>
            Проверить снова
        </button>
    </div>
    @endif
</div>
@endsection