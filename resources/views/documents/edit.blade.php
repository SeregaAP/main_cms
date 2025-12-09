@extends('admin.layout')

@section('content')

    <div class="tab_container">
        <div class="tab_control">
            <button data-tab=".tab-1" class="btn tab-btn active" type="button">{{__('basic')}}</button>
            <button data-tab=".tab-2" class="btn tab-btn" type="button">{{__('Additional fields')}}</button>
        </div>
        <div class="tab_list">
            <div class="tab tab-1 active">
                <form class="create_form_doc" action="{{ route('documents.update', $document->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form_scroll_all">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="form_row">
                            <div class="form-group">
                                <label >
                                    {{__('title')}}
                                    <input value="{{ old('title', $document->title) }}" placeholder="Заголовок" type="text" name="title" class="form-control" required>
                                </label>
                                
                            </div>
                            <div class="form-group">
                                <label>
                                    Alias ({{__('not_optional')}})
                                    <input type="text" name="alias" value="{{ old('alias', $document->alias) }}" class="form-control">
                                </label>
                     
                            </div>
                            <div class="form-group">
                                <label>
                                    {{__('parent_doc')}}
                                    <input hidden  name="parent_id" value="{{ $document->parent_id }}" class="doc_parent" type="text" value="" placeholder="-- нет родителя --">
                                </label>
                                <div class="form-select_group">
                                    <div class="select_group_control">
                                        <span class="doc_name">{{ $doc_parent->title ?? '--' . __('not_doc') .'--' }}</span>
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
                                    <input hidden  name="type" value="{{ $document->type }}" class="doc_parent" type="text" value="" placeholder="-- {{__('not_type')}} --">
                                </label>
                                <div class="form-select_group">
                                    <div class="select_group_control">
                                        <span class="doc_name">{{ $document->type ?? '-- нет родителя --' }}</span>
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
                                    <input hidden  name="template_id" value="{{ $document->template_id }}" class="doc_parent" type="text" placeholder="-- {{__('not_template')}} --">
                                </label>
                                <div class="form-select_group">
                                    <div class="select_group_control">
                                        <span class="doc_name">{{ $template_name }}</span>
                                        <button class="select_btn_open" type="button">
                                            <i class="fa-solid fa-list"></i>
                                        </button>
                                    </div>
                                    <div class="select_option_list">
                                        <div class="select_option_itm" data-value="">Без шаблона</div>
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
                                <textarea id="content" name="content" class="form-control" rows="5">{{ old('content', $document->content) }}</textarea>
                            </label>
                        </div>
                        <div class="form-check">
                            @if($document->published)
                                <div class="check_cnt active">
                                    <div class="check_cheked"></div>
                                </div>
                            @else
                                <div class="check_cnt">
                                    <div class="check_cheked"></div>
                                </div>
                            @endif
                            <label for="published" class="form-check-label">
                                <input hidden  id="published" type="checkbox" name="published" value="1" class="form-check-input" {{ $document->published ? 'checked' : '' }}>
                                {{__('public')}}
                            </label>
                        </div>
                        <button class="btn" type="submit">{{__('save')}}</button>
                    </div>
                </form>
            </div>
            <div class="tab tab-2">
                <div class="form_scroll_all">
                    @foreach($document->template?->formTvs ?? [] as $formTv)
                        <div class="form_tv" data-form-tv-id="{{ $formTv->id }}">
                            <div class="form_tv_group">
                                <div class="form_tv_group_txt">
                                    <span class="tv_name">{{ $formTv->name }}</span>
                                    <span class="tv_desc">| {{ $formTv->caption }}</span>
                                </div>
                                <div class="form_tv_group_buttons">
                                    <button type="button" class="btn btn-secondary btn-add-tv" data-form-tv-id="{{ $formTv->id }}">
                                        {{__('button_add')}}
                                    </button>
                                    <button class="btn btn-secondary btn_open_form-list" type="buttons">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <ul class="tv_list" id="tv-list-{{ $formTv->id }}">
                                @php
                                    $docTvs = $document->tvs->where('form_tv_id', $formTv->id);
                                @endphp
                            
                                @if($docTvs )
                                    @foreach($docTvs as $item) 
                                        <li class="tv_itm" data-index="">
                                            {{ $item->name }}  
                                            <div class="tv_itm_btn-group">
                                                <button type="button" class="btn btn-edit-tv" data-tvId="{{ $item->id }}" data-form-tv-id="{{ $item->form_tv_id }}" data-index="">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <form action="{{ route('document-tvs.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-del-tv" onclick="return confirm('Удалить запись?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="text-muted">Нет данных</li>
                                @endif
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div id="tvModal" class="modal_tv">
                    <div class="modal-content">
                        <button type="submit" class="close_modal-form">
                            <i class="fal fa-xmark"></i>
                        </button>
                        <h3 id="modalTitle">Добавить запись</h3>
                        <form id="tvForm" method="POST" action="{{ route('document-tvs.store', ['document_id' => $document->id]) }}">
                            @csrf
                            <input type="hidden" name="form_tv_id" id="form_tv_id">
                            <div class="tv_fields" id="tvFields"> сюда будут подставляться поля из JSON </div>
                            <button type="submit" class="btn">Сохранить</button>
                        </form>
                    </div>
                </div>
                <div id="tvModalEdit" class="modal_tv modal_tv_edit">
                    <div class="modal-content">
                        <button type="button" class="close_modal-form">
                            <i class="fal fa-xmark"></i>
                        </button>
                        <h3 id="modalTitle">Редактировать запись</h3>
                        <form id="tvFormEdit" method="POST">
                            @csrf
                            @method('PUT') <!-- Важно для update -->
                            <input type="hidden" name="form_tv_id" id="form_tv_id_edit">
                            <div class="tv_fields" id="tvFieldsEdit"></div>
                            <button type="submit" class="btn">Сохранить</button>
                        </form>
                    </div>
                </div>
                <x-modal-upload-img-all inputSelector=".input_image_path_edit" />
            </div>
        </div>
    </div>

    

    
@endsection


