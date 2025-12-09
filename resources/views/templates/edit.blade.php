@extends('admin.layout')

@section('content')
    <form class="create_form_doc" action="{{ route('templates.update', $template->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form_scroll_all">
            <div class="form_row">
                <div class="form-group">
                    <label >
                        {{__('name')}}
                        <input value="{{ old('name', $template->name) }}" placeholder="Заголовок" type="text" name="name" class="form-control" required>
                    </label>
                </div>
            </div>
            <div class="form-group form_group_all">
                <label>
                    {{__('content')}}
                    <input type="hidden" name="content" id="content_hidden">
                </label>
                <div id="editor" style="height: 300px; width: 100%;">
                    {{ old('content', $template->content) }}
                </div>
            </div>
            <button class="btn_all" type="submit">{{__('save')}}</button>
        </div>
    </form>
@endsection