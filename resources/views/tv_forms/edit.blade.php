@extends('admin.layout')

@section('title', 'Создать TV Form')

@section('content_menu')
    <div class="content_menu-item">
        <x-btn_link 
        class="btn_all_mini" 
        href="#" 
        text="Создать TV" 
        directions="left" />
    </div>
@endsection

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tv_forms.update', $tvForm) }}" method="POST">
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
                        label="Название TV Form" 
                        name="name" 
                        :required="true"
                        autocomplete="name"
                        autofocus
                        value="{{ $tvForm->name }}"
                        maxlength="255"
                    />
                    <x-input 
                        placeholder="Ключ (key)" 
                        type="text" 
                        label="Ключ (key)" 
                        name="key" 
                        :required="true"
                        autocomplete="key"
                        autofocus
                        value="{{ $tvForm->key }}"
                        maxlength="255"
                    />
                    <x-select-inp 
                        name="type"
                        type="text"
                        label="Тип"
                        :elements="$types"
                        placeholder="{{ $tvForm->type }}"
                        default="text"
                    />
                    <x-input 
                        placeholder="Описание" 
                        type="text" 
                        label="Описание" 
                        name="description" 
                        :required="true"
                        autocomplete="description"
                        autofocus
                        value="{{ $tvForm->description }}"
                        maxlength="255"
                    />
                </div>
            </div>
            <div class="acardion-item">
                <div class="acardion_header">
                    <span class="acardion_name">Содержимое json</span>
                    <button class="acardion_btn" type="button">
                        <i class="fa-sharp fa-solid fa-angle-right"></i>
                    </button>
                </div>
                <div class="acardion_grid">
                    <div class="text_editor_block">
                        <label for="editor">
                            <textarea data-content="{{ json_encode($tvForm->config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}" name="config" class="editor_ace" id="codeEditor">
                            </textarea>
                        </label>
                    </div>
                </div>
            </div>
            <div class="acardion-item">
                <div class="acardion_header">
                    <span class="acardion_name">Доступно для шаблонов</span>
                    <button class="acardion_btn" type="button">
                        <i class="fa-sharp fa-solid fa-angle-right"></i>
                    </button>
                </div>
                <div class="acardion_grid acardion_grid-three">
                    @foreach($templates as $template)
                        <label class="check_input_group" for="template_{{ $template->id }}">
                            {{ $template->title }}
                            <input 
                            @checked($tvForm->templates->contains($template->id)) 
                            class="checkbox" type="checkbox" name="templates[]" 
                            value="{{ $template->id }}" 
                            id="template_{{ $template->id }}">
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <x-btn  type="submit"  text="Сохранить" />
    </form>
</div>
@endsection