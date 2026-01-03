<li class="tv_form_item">
    <div class="tv_form_txt">
        <span class="tv_form_name">{{ $tv->name }} {{ $tv->id }}</span> 
        <span class="tv_form_type">тип: {{ $tv->type }}</span>
    </div>
    <div class="three_btn_group">
        <a class="doc_itm_btn three_btn-edit" href="{{ route('tv_forms.edit', $tv->id) }}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form method="post" action="{{ route('tv_forms.destroy', $tv) }}">
            @csrf
            @method('DELETE')
            <button class="doc_itm_btn three_btn-del">
                <i class="fa-sharp fa-solid fa-trash"></i>
            </button>
        </form>
    </div>
</li>