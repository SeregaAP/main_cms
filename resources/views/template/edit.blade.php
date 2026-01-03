@extends('admin.layout')

@section('title', 'Шаблоны')

@section('content_menu')
    <div class="content_menu-item">
       
    </div>
@endsection

@section('content')

<div class="pages_create">
    <form id="templateForm" action="{{ route('templates.update', $template->id) }}" method="post">
        @csrf
        @method('PUT')
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
                        value="{{ $template->title }}"
                        autofocus
                        maxlength="255"
                    />
                    <x-input 
                        placeholder="описание" 
                        type="text" 
                        name="description" 
                        label="Описание" 
                        :required="true"
                        autocomplete="description"
                        value="{{ $template->description }}"
                        autofocus
                        maxlength="255"
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
                        <label for="editor">
                            <textarea data-content="{{ $template->content }}" name="content" class="editor_ace" id="codeEditor"></textarea>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <x-btn  type="submit"  text="Сохронить" />
    </form>
</div>
@endsection