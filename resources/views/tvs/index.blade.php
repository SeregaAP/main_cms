@extends('admin.layout')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">❌ {{ session('error') }}</div>
@endif

@foreach ($tvforms as $tvform)
    <ul>
        @include('tvs.partials.tvs_item', ['tvf' => $tvform])
    </ul>
@endforeach

@endsection