@extends('admin.layout')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">❌ {{ session('error') }}</div>
@endif

<form class="create_form_doc" action="{{ route('tvs.update', $formTv->id) }}" method="POST">
    @csrf
     @method('PUT')
    <div class="form_scroll_all">
        <div class="form_row">
            <div class="form-group">
                <label >
                    {{__('name')}}
                    <input value="{{ $formTv->name }}" placeholder="{{__('name')}}" type="text" name="name" class="form-control" required>
                </label>
            </div>
            <div class="form-group">
                <label >
                    {{__('description')}}
                    <input value="{{ $formTv->caption }}" placeholder="{{__('description')}}" type="text" name="caption" class="form-control" required>
                </label>
            </div>

            <div class="form-group">
                <label>
                    {{ __('For_template') }}
                    <input hidden name="template_id" class="doc_parent" type="text" value="{{ $formTv->template_id }}" placeholder="-- {{ __('not_template')}} --" required>
                </label>
                <div class="form-select_group">
                    <div class="select_group_control">
                        <span class="doc_name">{{ $old_template->name }}</span>
                        <button class="select_btn_open" type="button">
                            <i class="fa-solid fa-list"></i>
                        </button>
                    </div>
                    <div class="select_option_list">
                        @foreach($templates as $template)
                            <div class="select_option_itm" data-value="{{ $template->id }}">{{ $template->name }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group form_group_all">
            <label>
                    {{__('form')}}
                    <input value="{{ $formTv->form }}"  type="hidden" name="form" id="content_hidden">
                </label>
                <div id="editor" style="height: 300px; width: 100%;">{{ $formTv->form }}</div>
        </div>
        <button type="submit" class="btn btn_all">{{__('create')}}</button>
    </div>
</form>

@endsection