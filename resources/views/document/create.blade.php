@extends('admin.layout')

@section('title', 'Ресурсы')

@section('content_menu')

@endsection

@section('content')
<div class="pages_create">
    <form action="{{ route('documents.store') }}" method="post">
        @csrf
        <input hidden value="{{ $type }}" name="type" type="text">
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
                        label="Название" 
                        name="title" 
                        :required="true"
                        autocomplete="title"
                        autofocus
                        maxlength="255"
                    />
                    <x-input 
                        type="text" 
                        label="Заголовок"
                        name="meta_title"
                        placeholder="заголовок"   
                        :required="true"
                        autocomplete="meta_title"
                        autofocus
                        maxlength="255"
                    />
                    <x-input 
                        type="text" 
                        label="Описание"
                        name="meta_description" 
                        placeholder="описание"  
                        :required="true"
                        autocomplete="meta_description"
                        autofocus
                        maxlength="255"
                    />
                    <x-input 
                        type="text" 
                        label="Алиас"
                        name="alias"  
                        placeholder="алиас" 
                        :required="false"
                        autocomplete="alias"
                        autofocus
                        maxlength="255"
                    />
                    <x-select-inp 
                        name="parent_id"
                        type="text"
                        label="Родительский ресурс"
                        :elements="$documents"
                        placeholder="--Не чего не выбранно--"
                        default=""
                    />
                    <x-select-inp 
                        name="format"
                        type="text"
                        label="Формат документа"
                        :elements="$formats"
                        placeholder="HTML"
                        default="html"
                    />
                    <x-select-inp 
                        name="template_id"
                        type="text"
                        label="Шаблоны"
                        :elements="$templates"
                        placeholder="Шаблоны"
                        default=""
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
                        <textarea name="content" id="content">Начальный текст</textarea>
                    </div>
                </div>
            </div>
            @if($type == 'category')
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
            @if($type == 'product')
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
                        :checked="true"
                     />
                     
                     <x-check-box
                        label="Показать в меню"
                        name="show_in_menu"
                        :checked="true"
                     />
                     <x-check-box
                        label="Кешировать"
                        name="is_cache"
                        :checked="true"
                     />
                </div>
            </div>
        </div>
        <x-btn  type="submit"  text="Сохронить" />
    </form>
</div>
@endsection