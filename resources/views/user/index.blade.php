@extends('admin.layout')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@foreach ($users as $user)
    <ul>
        @include('user.partials.user_item', ['user' => $user])
    </ul>
@endforeach


@endsection