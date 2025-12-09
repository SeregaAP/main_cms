@extends('admin.layout')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<ul id="document-tree">
    @foreach ($chunks as $chunk)
        @include('chunks.partials.chunk_item', ['chunk' => $chunk])
    @endforeach
</ul>
@endsection