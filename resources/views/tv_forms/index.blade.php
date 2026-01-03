@extends('admin.layout')

@section('title', 'Шаблоны')

@section('content_menu')
    <div class="content_menu-item">
        <x-btn_link 
        class="btn_all_mini" 
        href="{{ route('tv_forms.create') }}" 
        text="Создать TV" 
        directions="left" />
    </div>
@endsection

@section('content')
<ul>
    @foreach($tvForms as $tv)
        @include('tv_forms.partials.form_tv_item', ['tv' => $tv])
        
    @endforeach
</ul>
@endsection