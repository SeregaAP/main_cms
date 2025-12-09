@extends('admin.layout')

@section('content')


@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form class="create_form_doc" action="{{ route('documents.store') }}" method="POST">
    @csrf
    <div class="form_scroll_all">
        <div class="form_row">
            <div class="form-group">
                <label >
                    {{__('title')}}
                    <input placeholder="{{__('title')}}" type="text" name="title" class="form-control" required>
                </label>
                
            </div>
            <div class="form-group">
                <label>
                    Alias ({{__('not_optional')}})
                    <input type="text" name="alias" class="form-control">
                </label>
                <small>{{__('is_no_alias')}}</small>
            </div>
            <div class="form-group">
                <label>
                    {{__('parent_doc')}}
                    <input hidden name="parent_id" class="doc_parent" type="text" value="" placeholder="-- нет родителя --">
                </label>
                <div class="form-select_group">
                    <div class="select_group_control">
                        <span class="doc_name">-- {{__('not_doc')}} --</span>
                        <button class="select_btn_open" type="button">
                            <i class="fa-solid fa-list"></i>
                        </button>
                    </div>
                    <div class="select_option_list">
                        @foreach($documents as $doc)
                            <div class="select_option_itm" data-value="{{ $doc->id }}">{{ $doc->title }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>
                    {{__('type_content')}}
                    <input hidden  name="type" value="html" class="doc_parent" type="text" value="" placeholder="-- {{__('not_type')}} --">
                </label>
                <div class="form-select_group">
                    <div class="select_group_control">
                        <span class="doc_name">html</span>
                        <button class="select_btn_open" type="button">
                            <i class="fa-solid fa-list"></i>
                        </button>
                    </div>
                    <div class="select_option_list">
                        <div class="select_option_itm" data-value="html">html</div>
                        <div class="select_option_itm" data-value="txt">txt</div>
                        <div class="select_option_itm" data-value="xml">xml</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                    <label>
                        {{__('template')}}
                        <input hidden  name="template_id" value="" class="doc_parent" type="text" placeholder="-- {{__('not_template')}} --">
                    </label>
                    <div class="form-select_group">
                        <div class="select_group_control">
                            <span class="doc_name">--{{__('not_template')}}--</span>
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
                {{__('content')}}
                <textarea id="content" name="content" class="form-control" rows="5"></textarea>
            </label>
        </div>
    
        <div class="form-check">
            <div class="check_cnt active">
                <div class="check_cheked"></div>
            </div>
            <label for="published" class="form-check-label">
                <input hidden id="published" type="checkbox" name="published" value="1" class="form-check-input" checked>
                {{__('public')}}
            </label>
        </div>
    
        <button type="submit" class="btn btn_all">{{__('create')}}</button>
    </div>
</form>
@endsection