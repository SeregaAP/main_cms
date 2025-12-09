@extends('admin.layout')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<ul id="document-tree">
    @foreach ($documents->where('parent_id', null) as $document)
        @include('documents.partials.nestable_item', ['doc' => $document])
    @endforeach
</ul>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const treeEl = document.getElementById('document-tree');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function makeSortable(el) {
        new Sortable(el, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            handle: 'span',
            onEnd(evt) {
                const data = getTreeData(treeEl);
                fetch("{{ route('documents.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({tree: data})
                })
                .then(res => res.json())
                .then(res => console.log(res))
                .catch(err => console.error(err));
            }
        });

        el.querySelectorAll('ul').forEach(child => makeSortable(child));
    }

    makeSortable(treeEl);

    function getTreeData(el, parentId = null) {
    return Array.from(el.children).map(li => {
        const id = parseInt(li.id.replace('document-', ''));
        const childrenUl = li.querySelector('ul');
        const children = childrenUl ? getTreeData(childrenUl, id) : [];
        return {id, parent_id: parentId, children};
    });
}
});
</script>



@endsection