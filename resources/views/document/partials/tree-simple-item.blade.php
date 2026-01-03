<!-- resources/views/document/partials/tree-simple-item.blade.php -->
 <!--{{ $document->show_in_menu ? '' : 'hidden' }}-->
<li class="tree-item " data-id="{{ $document->id }}">
    <div class="tree-item-content">
        <div class="tree-item-info_group">
            <div class="tree-item-info">
                <div class="tree-item-title">
                    <span class="drag-handle">
                        <i class="fa-solid fa-arrows-alt"></i>
                    </span>
                    {{ $document->title }}
                    <span class="type-badge type-{{ $document->type }}">
                        @if($document->type == 'document')
                            Документ
                        @elseif($document->type == 'category')
                            Категория
                        @else
                            Товар
                        @endif
                    </span>
                    @if($document->alias)
                        <small style="color: #666;">({{ $document->alias }})</small>
                    @endif
                </div>
                <div class="tree-item-meta">
                    <span class="status-badge status-{{ $document->published ? 'published' : 'draft' }}">
                        {{ $document->published ? 'Опубликован' : 'Черновик' }}
                    </span>
                    @if($document->show_in_menu)
                        <span class="menu-badge">В меню</span>
                    @endif
                    <span>Формат: {{ $document->format }}</span>
                    @if($document->created_at)
                        <span>Создан: {{ $document->created_at->format('d.m.Y H:i') }}</span>
                    @endif
                </div>
            </div>
            <div class="three_btn_group">
                <a class="doc_itm_btn three_btn-view" target="_blank" href="/{{ $document->full_path }}">
                    <i class="fa-solid fa-eye"></i>
                </a>
                <a class="doc_itm_btn three_btn-edit" href="{{ route('documents.edit', $document->id) }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form method="post" action="{{ route('documents.destroy', $document->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="doc_itm_btn three_btn-del">
                        <i class="fa-sharp fa-solid fa-trash"></i>
                    </button>
                </form>
                <button class="doc_itm_btn three_btn-open" type="button">
                    <i class="fa-solid fa-angle-right"></i>
                </button>
            </div>
        </div>
    </div>
    @if($document->children->count() > 0)
        <ul class="tree-children">
            @foreach($document->children as $child)
                @include('document.partials.tree-simple-item', ['document' => $child])
            @endforeach
        </ul>
    @else
    <ul class="tree-children empty-dropzone" data-parent-id="{{ $document->id }}"></ul>
@endif
</li>