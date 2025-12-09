<li id="document-{{ $doc->id }}">
    <div class="docs_itm">
        <div class="doc_itm_txt">
            <span class="doc_itm_id">{{ $doc->id }}</span>
            <span class="doc_itm-name">{{ $doc->title }}</span>
        </div>
        <div class=" itm_group_btn_all">
            
            <x-btn-action :doc="$doc" route="documents" type="view" />
            <x-btn-action :doc="$doc" route="documents" type="edit" />
            <x-btn-action :doc="$doc" route="documents" type="delete" />

            @if($doc->children->isNotEmpty())
                <button type="button" class="btn-action btn_doc_open">
                    <i class="fas fa-chevron-down"></i>
                </button>
            @endif
        </div>
    </div>
    
    <ul>
        @foreach($doc->children as $child)
            @include('documents.partials.nestable_item', ['doc' => $child])
        @endforeach
    </ul>
</li>