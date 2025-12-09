@extends('admin.layout')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<!--
<form id="uploadForm" enctype="multipart/form-data">
  <input class="btn" type="file" name="file" id="fileInput">
  <button type="submit">Загрузить</button>
</form>

<div id="preview"></div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const uploadForm = document.getElementById('uploadForm');
    uploadForm.addEventListener('submit', async e => {
        e.preventDefault();
        const fileInput = document.getElementById('fileInput');
        if (!fileInput.files[0]) return alert('Файл не выбран');

        const formData = new FormData();
        formData.append('file', fileInput.files[0]);

        const token = document.querySelector('meta[name="csrf-token"]').content;

        const res = await fetch('/admin/upload', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': token }
        });

        const data = await res.json();
        document.getElementById('preview').innerHTML = `<img src="${data.path}" width="150">`;
    });
});
</script>
-->
<div class="media_block">
    <div class="directory_bar">
        <ul class="file-tree">
            <li>
                <span data-patch="" class="directory directory_home">
                    <i class="fa-solid fa-folder"></i>
                    <span class="dir_name">{{__('to_home')}}</span>
                </span>
            </li>
            @foreach ($trees as $item)
                <li>
                    @if ($item->type === 'directory')
                        <span data-patch="{{ $item->path }}" class="directory">
                            <i class="fa-solid fa-folder"></i>
                            <span class="dir_name">{{ $item->name }}</span>
                        </span>
                        @if (!empty($item->children))
                            <ul>
                                @foreach ($item->children as $child)
                                    <li>
                                        @if ($child->type === 'directory')
                                        <span data-patch="{{ $child->path }}" class="directory">
                                            <i class="fa-solid fa-folder"></i>
                                            <span class="dir_name">{{ $child->name }}</span>
                                        </span>
                                        
                                        <ul>
                                           @foreach ($child->children as $chi)
                                                <li>
                                                    @if ($chi->type === 'directory')
                                                    <span data-patch="{{ $chi->path }}" class="directory">
                                                        <i class="fa-solid fa-folder"></i>
                                                        <span class="dir_name">{{ $chi->name }}</span>
                                                    </span>
                                                        
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                            
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <div id="file_block" class="file_block">

    </div>
</div>
<div id="context-menu" class="context-menu">
    <div class="item" data-action="create-folder">Добавить папку</div>
    <div class="item" data-action="delete-folder">Удалить папку</div>
    <div class="item" data-action="upload-file">Загрузить файлы</div>
</div>
@endsection



