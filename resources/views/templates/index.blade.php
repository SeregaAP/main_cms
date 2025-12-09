@extends('admin.layout')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@foreach ($templates as $template)
    <ul>
        @include('templates.partials.template_item', ['tem' => $template])
    </ul>
@endforeach

@endsection

