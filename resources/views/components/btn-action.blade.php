@php
    switch ($type) {
        case 'edit':
            $icon = 'fa-solid fa-pen-to-square';
            break;
        case 'view':
            $icon = 'fa-solid fa-eye';
            break;
        case 'delete':
            $icon = 'fa-solid fa-trash';
            break;
    }
@endphp

@if ($type === 'edit')
<a class="btn-action btn_edit" href="{{ route($route . '.edit', $doc->id) }}">
    <i class="{{ $icon }}"></i>
</a>
@elseif($type === 'view')
<a class="btn-action btn_view"
   target="_blank"
   href="{{ route($route . '.show', ['path' => ltrim($doc->uri, '/')]) }}">
    <i class="{{ $icon }}"></i>
</a>
@elseif($type === 'delete')
<form action="{{ route($route . '.destroy', $doc->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button class="btn-action btn_del" onclick="return confirm('Удалить документ?')">
        <i class="{{ $icon }}"></i>
    </button>
</form>
@else
@endif