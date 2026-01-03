@extends('admin.layout')

@section('title', 'Ресурсы')

@section('content_menu')

@endsection

@section('content')
<div class="pages_create">
    <form action="{{ route('documents.update', $doc->id) }}" method="post">
        @csrf
        @method('PUT')
        <input hidden value="{{ $doc->type }}" name="type" type="text">
        <div class="acardion_container">
            <div class="acardion-item active">
                <div class="acardion_header">
                    <span class="acardion_name">Название и идентификация</span>
                    <button class="acardion_btn" type="button">
                        <i class="fa-sharp fa-solid fa-angle-right"></i>
                    </button>
                </div>
                <div class="acardion_grid">
                    <x-input 
                        placeholder="название" 
                        type="text" 
                        name="title" 
                        label="Название" 
                        :required="true"
                        autocomplete="title"
                        value="{{ $doc->title }}"
                        autofocus
                        maxlength="255"
                    />
                    <x-input 
                        placeholder="заголовок" 
                        type="text" 
                        name="meta_title" 
                        label="Заголовок" 
                        :required="true"
                        autocomplete="meta_title"
                        value="{{ $doc->meta_title }}"
                        autofocus
                        maxlength="255"
                    />
                    <x-input 
                        placeholder="описание" 
                        type="text" 
                        name="meta_description" 
                        label="Описание" 
                        :required="true"
                        autocomplete="meta_description"
                        value="{{ $doc->meta_description }}"
                        autofocus
                        maxlength="255"
                    />
                    <x-input 
                        placeholder="алиас" 
                        type="text" 
                        name="alias" 
                        label="Алиас" 
                        :required="false"
                        autocomplete="alias"
                        value="{{ $doc->alias }}"
                        autofocus
                        maxlength="255"
                    />
                    <x-select-inp 
                        name="parent_id"
                        type="text"
                        label="Родительский ресурс"
                        :elements="$documents"
                        placeholder="{{ $old['documen_parent_old'] ?? '--Ничего не выбрано--' }}"
                        default="{{ $doc->parent_id }}"
                    />
                    <x-select-inp 
                        name="format"
                        type="text"
                        label="Формат документа"
                        :elements="$formats"
                        placeholder="{{ $doc->format }}"
                        default="{{ $doc->format }}"
                    />
                    <x-select-inp 
                        name="template_id"
                        type="text"
                        label="Шаблоны"
                        :elements="$templates"
                        placeholder="{{ $old['document_template_name'] ?? '--Шаблон не подключен--' }}"
                        default="{{ $doc->template_id }}"
                    />
                </div>
            </div>
            <div class="acardion-item">
                <div class="acardion_header">
                    <span class="acardion_name">Содержимое (Content)</span>
                    <button class="acardion_btn" type="button">
                        <i class="fa-sharp fa-solid fa-angle-right"></i>
                    </button>
                </div>
                <div class="acardion_grid">
                    <div class="text_editor_block">
                        <textarea  name="content" id="content">
                            {{ $doc->content }}
                        </textarea>
                    </div>
                </div>
            </div>
            @if($doc->type == 'category')
                <div class="acardion-item">
                    <div class="acardion_header">
                        <span class="acardion_name">Категория</span>
                        <button class="acardion_btn" type="button">
                            <i class="fa-sharp fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                    <div class="acardion_grid">
                        
                    </div>
                </div>
            @endif
            @if($doc->type == 'product')
                <div class="acardion-item">
                    <div class="acardion_header">
                        <span class="acardion_name">Товар</span>
                        <button class="acardion_btn" type="button">
                            <i class="fa-sharp fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                    <div class="acardion_grid">
                        
                    </div>
                </div>
            @endif
            <div class="acardion-item">
                <div class="acardion_header">
                    <span class="acardion_name">Настройки</span>
                    <button class="acardion_btn" type="button">
                        <i class="fa-sharp fa-solid fa-angle-right"></i>
                    </button>
                </div>
                <div class="acardion_grid">
                    <x-check-box
                        label="Опубликован"
                        name="published"
                        checked="{{ $doc->published }}"
                     />
                     
                     <x-check-box
                        label="Показать в меню"
                        name="show_in_menu"
                        checked="{{ $doc->show_in_menu }}"
                     />
                     <x-check-box
                        label="Кешировать"
                        name="is_cache"
                        checked="{{ $doc->is_cache }}"
                     />
                </div>
            </div>
            <!-------------->
            @include('document.partials.tv_forms_edit', ['tvForms' => $tvForms,'tvValues'=> $tvValues])
            <!----------------->
        </div>
    </form>
</div>
<x-modal-file />
@endsection