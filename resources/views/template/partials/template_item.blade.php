<li class="template_item">
    <div class="template_create_update">
        <span class="create_at">создан : {{ $template->created_at }}</span>
        <span class="update_at">обновлен : {{ $template->updated_at }}</span>
    </div>
    <div class="template_info_group">
        <div class="template_item-icon">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div class="template_item-right">
            <span class="template_name">{{ $template->title }}</span>
            <span class="template_description">{{ $template->description }}</span>
        </div>
    </div>
    <div class="three_btn_group">
        <a class="doc_itm_btn three_btn-edit" href="{{ route('templates.edit', $template->id) }}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form method="post" action="{{ route('templates.destroy', $template->id) }}">
            @csrf
            @method('DELETE')
            <button class="doc_itm_btn three_btn-del">
                <i class="fa-sharp fa-solid fa-trash"></i>
            </button>
        </form>
    </div>
</li>