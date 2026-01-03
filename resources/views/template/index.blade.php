@extends('admin.layout')

@section('title', 'Шаблоны')

@section('content_menu')
    <div class="content_menu-item">
        <x-btn_link 
        class="btn_all_mini" 
        href="{{ route('templates.create') }}" 
        text="Создать шаблон" 
        directions="left" />
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if($templates->count() > 0)
    <ul>
        @foreach($templates as $template)
            @include('template.partials.template_item', ['template' => $template])
        @endforeach
    </ul>
    @else
        <div class="empty-state">
            <i class="fa-solid fa-folder-open"></i>
            <p>Нет созданных шаблонов</p>
            
            <x-btn_link class="reg" href="{{ route('templates.create') }}" text="Создать первый шаблон"  />
        </div>
    @endif
@endsection