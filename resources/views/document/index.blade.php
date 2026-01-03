@extends('admin.layout')

@section('title', 'Ресурсы')

@section('content_menu')
    <div class="content_menu-item">
        <x-btn class="btn_all_mini cnt_menu_btn" type="button" id="continueBtn" text="Создать ресурс"  />
        <div class="content_menu-item_list">
            <a href="{{ route('documents.create', ['type' => 'document']) }}">
                <i class="fa-solid fa-file"></i>
                Создать документ
            </a>
            <a href="{{ route('documents.create', ['type' => 'product']) }}">
                <i class="fa-brands fa-product-hunt"></i>
                Создать товар
            </a>
            <a href="{{ route('documents.create', ['type' => 'category']) }}">
                <i class="fa-solid fa-layer-group"></i>
                Создать категорию
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="pages_content">
    <div class="pages_list">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div id="save-status" class="alert alert-error ">
                <i class="fa-solid fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif
        
        <div id="documents-tree" class="documents-tree">
            @if($documents->count() > 0)
                <ul class="tree-list">
                    @foreach($documents as $document)
                        @include('document.partials.tree-simple-item', ['document' => $document])
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-folder-open"></i>
                    <p>Нет созданных документов</p>
                    
                    <x-btn_link class="reg" href="{{ route('documents.create') }}" text="Создать первый документ"  />
                </div>
            @endif
        </div>
    </div>
    <div class="page_info">
        <x-flip-counter :counter="$doc_info['doc_counter']" icon="fa-light fa-border-all" title="Всего документов" />
        <x-flip-counter :counter="$doc_info['doc_publiched']" icon="fa-light fa-bullhorn" title="Опубликовано" />
        <x-flip-counter :counter="$doc_info['doc_in_menu']" icon="fa-light fa-list" title="В меню" />
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const documentsTree = document.getElementById('documents-tree');
       
        const saveStatus = document.getElementById('save-status');
    
        if (!documentsTree) return;
        const sortableOptions = {
        group: 'nested',
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        fallbackOnBody: true,
        swapThreshold: 0.65,
        onStart: function(evt) {
      
        },
        onEnd: function(evt) {
            
            let newParentId = null;
            if (evt.to.classList.contains('tree-children')) {
                const parentItem = evt.to.closest('.tree-item');
                if (parentItem) {
                    newParentId = parseInt(parentItem.dataset.id);
                }
            }
            
            updateOrder();
            enableSaveButton();
        }
        };
    
        function initSortables() {  
        // 1. Корневой список
        const rootList = documentsTree.querySelector('.tree-list');
        if (rootList) {
            if (rootList.sortable) {
                rootList.sortable.destroy();
            }
            rootList.sortable = new Sortable(rootList, sortableOptions);
        }
        
        // 2. ВСЕ дочерние списки (включая пустые и свернутые)
        const allLists = documentsTree.querySelectorAll('.tree-children');
        allLists.forEach((list, index) => {
            
            if (list.sortable) {
                list.sortable.destroy();
            }
            
            // Для пустых списков тоже инициализируем Sortable
            list.sortable = new Sortable(list, sortableOptions);
        });
        }
    
        function collectTreeData() {
    
        const data = [];
        const rootList = documentsTree.querySelector('.tree-list');
        
        if (!rootList) return data;
        
        const processedIds = new Set();
        
        function collectItems(list, parentId = null) {
            const items = [];
            const listItems = list.querySelectorAll('.tree-item');
            
            listItems.forEach((item, index) => {
                const itemId = parseInt(item.dataset.id);
                
                if (processedIds.has(itemId)) {
                    return;
                }
                
                processedIds.add(itemId);
                
                const itemData = {
                    id: itemId,
                    position: index,
                    parent_id: parentId,
                    children: []
                };
                
                // Рекурсивно собираем детей
                const childList = item.querySelector('.tree-children');
                if (childList) {
                    itemData.children = collectItems(childList, itemId);
                }
                
                items.push(itemData);
            });
            
            return items;
        }
        
        const result = collectItems(rootList, null);
        return result;
        }
    
        function getChildren(parentElement) {
        const children = [];
        const childList = parentElement.querySelector('.tree-children');
        
        if (childList) {
            // Собираем только элементы tree-item которые находятся в этом списке
            const childItems = childList.querySelectorAll('.tree-item');
            childItems.forEach((child, index) => {
                // Проверяем, что элемент действительно прямой ребенок этого parentElement
                if (child.closest('.tree-item') === parentElement) {
                    const childData = {
                        id: parseInt(child.dataset.id),
                        position: index,
                        parent_id: parseInt(parentElement.dataset.id),
                        children: getChildren(child)
                    };
                    children.push(childData);
                }
            });
        }
        
        return children;
        }
    
        function updateOrder() {
        const treeData = collectTreeData();
        
        if (treeData.length === 0) {
            console.warn('⚠️ Нет данных для отправки');
            showStatus('Нет данных для сохранения', 'error');
            return;
        }
        
        fetch("{{ route('documents.sort') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                order: treeData,
                _token: csrfToken 
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showStatus('❌ Ошибка: ' + (data.message || 'Неизвестная ошибка'), 'error');
            }
        })
        .catch(error => {
            console.error('❌ Ошибка сети:', error);
            showStatus('❌ Ошибка сети при сохранении', 'error');
        });
        }
    
        
    
        function showStatus(message, type) {
        if (saveStatus) {
            saveStatus.textContent = message;
            saveStatus.className = `status-message ${type}`;
            setTimeout(() => {
                saveStatus.textContent = '';
                saveStatus.className = 'status-message';
            }, 3000);
        }
        }
    
        function addDragHandles() {
        const items = documentsTree.querySelectorAll('.tree-item');
        
        items.forEach(item => {
            const title = item.querySelector('.tree-item-title');
            if (title && !title.querySelector('.drag-handle')) {
                const handle = document.createElement('span');
                handle.className = 'drag-handle';
                handle.innerHTML = '<i class="fa-solid fa-grip-vertical"></i>';
                handle.style.cssText = 'cursor: move; margin-right: 8px; color: #666; display: inline-flex; align-items: center;';
                handle.setAttribute('title', 'Перетащите для перемещения');
                title.prepend(handle);
            }
        });
        }
        addDragHandles();
        initSortables();
        
        const style = document.createElement('style');
        style.textContent = `
        /* Стили для перетаскивания */
        .sortable-ghost {
            opacity: 0.4;
            background: rgba(74, 144, 226, 0.1) !important;
            border: 2px dashed #4a90e2 !important;
        }
        
        .sortable-chosen {
            background: #e3f2fd !important;
            border-color: #4a90e2 !important;
            box-shadow: 0 0 10px rgba(74, 144, 226, 0.2);
        }
        
        .sortable-drag {
            z-index: 9999 !important;
            opacity: 0.9;
        }
        
        /* Drag handle */
        .drag-handle {
            cursor: move;
            user-select: none;
            padding: 5px 8px;
            border-radius: 4px;
            background: rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        
        .drag-handle:hover {
            background: rgba(0,0,0,0.1);
            cursor: grabbing;
        }
        
        /* Подсветка при перетаскивании */
        body.dragging .tree-item {
            cursor: grabbing !important;
        }
        
        /* Пустые drop-зоны */
        .tree-children.empty-dropzone {
            min-height: 30px;
            border: 2px dashed #ddd !important;
            background: rgba(248, 249, 250, 0.5) !important;
            margin-left: 30px;
            margin-top: 5px;
        }
        
        .tree-children.empty-dropzone:hover {
            border-color: #2ecc71 !important;
            background: rgba(46, 204, 113, 0.05) !important;
        }
        
        /* Статус сообщения */
        .status-message {
            margin-left: 15px;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .status-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection





       