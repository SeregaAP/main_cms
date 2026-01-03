@extends('admin.layout')

@section('title', 'Фаилы')

@section('content_menu')
@endsection

@section('content')


<div class="media">
    <div class="media_cnt">
        <div class="media_folder">
            <div class="media-tree" id="media-tree"></div>
        </div>
        <div class="media_file" id="media-files">

        </div>
    </div>
</div>



@endsection