@extends('admin.layout')

@section('content')

<form class="create_form_doc" action="{{ route('chunks.store') }}" method="POST">
    @csrf
    <div class="form_scroll_all">
        <div class="form_row">
            <div class="form-group">
                <label >
                    {{__('name')}}
                    <input placeholder="{{__('name')}}" type="text" name="name" class="form-control" required>
                </label>
                
            </div>
        </div>
        <div class="form-group form_group_all">
            <label>
                    {{__('content')}}
                    <input type="hidden" name="content" id="content_hidden">
                </label>
                <div id="editor" style="height: 300px; width: 100%;"></div>
        </div>
    
        <button type="submit" class="btn btn_all">{{__('create')}}</button>
    </div>
</form>

@endsection