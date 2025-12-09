import FolderAction from './media_js/FolderAction.js';
import FileAction from './media_js/FileAction.js';

const folder = new FolderAction();
const fileManager = new FileAction();

$(document).ready(function() {
    const menu = document.getElementById("context-menu");
    let currentPath = null;

    document.addEventListener("contextmenu", e => {
        const dir = e.target.closest(".directory");
        if (!dir) return;
        e.preventDefault();
        currentPath = dir.dataset.patch;
        if(!menu) return;
        menu.style.top = e.pageY + "px";
        menu.style.left = e.pageX + 30 + "px";
        menu.style.display = "block";
    });

    document.addEventListener("click", e => {
        if (!menu) return;
        if (!menu.contains(e.target)) {
            menu.style.display = "none";
        }
    });
    
    if(menu){
        menu.addEventListener("click", async e => {
            const item = e.target.closest(".item");
            if (!item) return;
            const action = item.dataset.action;
            if (action === "create-folder") {
            let name = prompt("Название новой папки:");
            if (!name) return;
            const response = await folder.create(name, currentPath || "");
            if (response.success) location.reload();
            else alert(response.message);
            }
    
            if (action === "delete-folder") {
            if (!confirm("Удалить папку?")) return;
            const response = await folder.delete(currentPath);
            if (response.success) location.reload();
            else alert("Ошибка удаления");
            }
        
            if (action === "upload-file") {
            const allowedExtensions = ["jpg", "jpeg", "png", "gif", "pdf","css"]; 
            const input = document.createElement("input");
            input.type = "file";
            input.multiple = true;
        
            input.onchange = async () => {
                const files = input.files;
                if (!files.length) return;
                for (let file of files) {
                    const ext = file.name.split('.').pop().toLowerCase();
                    if (!allowedExtensions.includes(ext)) {
                        alert(`Файл "${file.name}" имеет недопустимое расширение`);
                        continue; 
                    }
        
                    const response = await fileManager.create(file, currentPath);
                    if (!response.success) {
                        alert(`Ошибка загрузки файла: ${file.name}`);
                    }
                }
        
                location.reload();
            };
        
            input.click();
            }
        
            menu.style.display = "none";
        });
    }

    if (document.getElementById("editor")) {
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/html");
        editor.session.setUseWorker(false); // 👈 отключает валидацию и ошибки
        editor.session.setUseSoftTabs(true);
        editor.session.setTabSize(4);
        editor.session.setUseWrapMode(true);
        editor.setShowInvisibles(true);
        editor.setOptions({
            fontSize: "12pt",
            showPrintMargin: false,
            wrap: true
        });
        editor.session.setOption("trimTrailingWhitespace", true);
        editor.session.setOption("trimTrailingWhitespace", true);
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('content_hidden').value = editor.getValue();
        });
    }
   
    $('#content').summernote({
        placeholder: 'Введите текст...',
        tabsize: 2,
        height: 200,
        lang: 'ru-RU',
        callbacks: {
            onImageUpload: function(files) {
                uploadImage(files[0]);
            }
        }
    });

});




document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.btn_menu_sidebar').forEach(button => {
        button.addEventListener('click', () => {
            const parent = button.parentElement;
            parent.classList.toggle('active');
    
            const ul = parent.querySelector('ul');
            if (ul) {
                ul.classList.toggle('active');
            }
        });
    });

    document.querySelectorAll('.select_option_itm').forEach(item => {
        item.addEventListener('click', () => {
            const list = item.parentElement;
            let parent = list.parentElement;
    
            const doc_name_el = parent.querySelector(".select_group_control .doc_name");
            parent = parent.parentElement;
    
            const inp_el = parent.querySelector("label .doc_parent");
    
            // Устанавливаем значение input и текст doc_name
            if (inp_el) inp_el.value = item.dataset.value;
            if (doc_name_el) doc_name_el.textContent = item.textContent;
    
            // Закрываем список
            if (list.classList.contains('active')) {
                list.classList.remove('active');
            }
        });
    });

    document.querySelectorAll('.select_btn_open').forEach(btn => {
        btn.addEventListener('click', () => {
            let parent = btn.parentElement;
            parent = parent.parentElement;

            const list = parent.querySelector('.select_option_list');
            if (list) {
                list.classList.add('active');
            }
        });
    });

    document.querySelectorAll('.check_cheked').forEach(checkElem => {
        checkElem.addEventListener('click', () => {
            const check = checkElem.parentElement;
            const inpLabel = check.parentElement.querySelector('label');
            const inp = inpLabel ? inpLabel.querySelector('.form-check-input') : null;
    
            if (!inp) return;
    
            check.classList.toggle('active');
    
            const isActive = check.classList.contains('active');
            inp.checked = isActive;
            inp.value = isActive ? 1 : 0;
        });
    });

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            const tabSelector = btn.getAttribute('data-tab');
            const tab = document.querySelector(tabSelector);
            if (tab) {
                tab.classList.add('active');
            }
    
            btn.classList.add('active'); 
        });
    });

    document.querySelectorAll('.btn_open_form-list').forEach(btn => {
        btn.addEventListener('click', function() {
            // поднимаемся на три уровня вверх
            let parent = btn.parentElement;
            if (parent) parent = parent.parentElement;
            if (parent) parent = parent.parentElement;
    
            if (parent) {
                const listFormTv = parent.querySelector('.tv_list');
                if (listFormTv) {
                    listFormTv.classList.toggle('active');
                }
            }
        });
    });

    document.querySelectorAll('.close_modal-form').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.modal_tv').forEach(modal => {
                modal.classList.remove('active');
            });
        });
    });

    document.querySelectorAll('.btn_doc_open').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
    
            let list_doc = this.parentElement;
            list_doc = list_doc.parentElement;
            list_doc = list_doc.parentElement;
    
            if (list_doc) {
                const ul = list_doc.querySelector('ul');
                if (ul) ul.classList.toggle('active');
            }
        });
    });

    document.querySelectorAll('.directory').forEach(dirElem => {
        dirElem.addEventListener('click', function(e) {
            e.preventDefault();
    
            const path = this.dataset.patch;
            const parent = this.parentElement;
            const ul = Array.from(parent.children).find(el => el.tagName === 'UL');
    
            if (ul) {
                ul.classList.toggle('active');
            }
            loadFileTree('file_block',path);
        });
    });
    
    let tvFields = document.getElementById('tvFields');
    if(tvFields){
        document.getElementById('tvFields').addEventListener('click', function(e) {
            if (e.target.classList.contains('upload_img_btn')) {
                const folderAction = new FolderAction();
                folderAction.getTree('').then(tree => {
                    var container = document.querySelector('.tv_modal_upload_folder');
                    if(container){
                        renderFolders(tree, container);
                        loadFileTreeModal('tv_modal_upload_file','');
                    }
                });
                document.querySelector('.tv_modal_upload_img').classList.add('active');
            }
        });
    }
    let tvFieldsEdit = document.getElementById('tvFieldsEdit');
    if(tvFieldsEdit){
        document.getElementById('tvFieldsEdit').addEventListener('click', function(e) {
            if (e.target.classList.contains('upload_img_btn')) {
                const folderAction = new FolderAction();
                folderAction.getTree('').then(tree => {
                    var container = document.querySelector('.tv_modal_upload_folder');
                    if(container){
                        renderFolders(tree, container);
                        loadFileTreeModal('tv_modal_upload_file','');
                    }
                });
                document.querySelector('.tv_modal_upload_img').classList.toggle('active');
            }
        });
    }
    
    let tv_modal_upload_file = document.querySelector('.tv_modal_upload_img');
    if(tv_modal_upload_file){
        document.querySelector('.tv_modal_upload_img').addEventListener('click', function(e) {
            const item = e.target.closest('.image-item_modal');
            if (!item) return;
            const preview = item.querySelector('.image-preview'); // находим контейнер
            const img = preview.querySelector('img');
            if (!img) return;
            const url = img.src;
            console.log(tv_modal_upload_file.dataset.input);
            const inputSelector = tv_modal_upload_file.dataset.input;
            let input = document.querySelector(inputSelector);
            if (input) {
                console.log(tv_modal_upload_file.dataset.input);
                input.value = url;
                document.querySelector('.tv_modal_upload_img').classList.remove('active');
            }
        });
    }
    let close_btn_variant_img = document.querySelector('.close_btn_variant_img');
    if(close_btn_variant_img){
        close_btn_variant_img.addEventListener('click',function(){
            document.querySelector('.tv_modal_upload_img').classList.remove('active');
        });
    }

    document.querySelectorAll('.btn-add-tv').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const formTvId = btn.dataset.formTvId;

            const modal = document.getElementById('tvModal');
            const fieldsContainer = document.getElementById('tvFields');
            const formIdInput = document.getElementById('form_tv_id');
            // Очистим прошлые поля
            fieldsContainer.innerHTML = '';
            formIdInput.value = formTvId;
            const response = await fetch(`/admin/form-tvs/${formTvId}`);
            const data = await response.json();
            if (data.form) {
                    try {
                        const jsonForm = JSON.parse(data.form);
                
                        jsonForm.forEach(field => {
                            const formGroup = document.createElement('div');
                            formGroup.classList.add('form_tv_group');
                
                            // метка
                            const label = document.createElement('label');
                            label.textContent = field.labels?.ru?.label || field.name;
                
                            let input;
                            let img_group;
                            let btn_image;
                            let inp_txt;
                
                            // ✅ Проверка типа поля
                            switch (field.type) {
                                case 'textarea':
                                    input = document.createElement('textarea');
                                    break;
                
                                case 'select':
                                    input = document.createElement('select');
                                    if (field.options && Array.isArray(field.options)) {
                                        field.options.forEach(opt => {
                                            const option = document.createElement('option');
                                            option.value = opt;
                                            option.textContent = opt;
                                            input.appendChild(option);
                                        });
                                    }
                                    break;
                
                                case 'checkbox':
                                    input = document.createElement('input');
                                    input.type = 'checkbox';
                                    input.checked = true;
                                    break;
                
                                case 'images':
                                    img_group = document.createElement('div');
                                    img_group.classList.add('group_image_input');
                                    btn_image = document.createElement('button');
                                    btn_image.classList.add('btn');
                                    btn_image.classList.add('btn_upload_img');
                                    btn_image.textContent = 'Загрузить';
                                    btn_image.type = 'button';
                                    btn_image.classList.add('upload_img_btn');
                                    inp_txt = document.createElement('input');
                                    inp_txt.classList.add('input_image_path');
                                    inp_txt.type = 'text';
                                    img_group.appendChild(btn_image);
                                    img_group.appendChild(inp_txt);
                                    break;
                
                                default:
                                    input = document.createElement('input');
                                    input.type = field.type || 'text';
                            }
                            if(img_group){
                                inp_txt.name = field.name;
                                formGroup.appendChild(img_group);
                                fieldsContainer.appendChild(formGroup);
                            }else{
                                input.name = field.name;
                                label.appendChild(input);
                                formGroup.appendChild(label);
                                fieldsContainer.appendChild(formGroup);
                            }
                        });
                
                    } catch (err) {
                        console.error('Ошибка парсинга формы:', err);
                    }
            }
            $(modal).addClass('active');
        });
    });

    document.querySelectorAll('.btn-edit-tv').forEach(btn => {
        btn.addEventListener('click', async () => {
            const tvId = btn.dataset.tvid; // data-tv-id на кнопке
            
            const modal = document.getElementById('tvModalEdit');
            const fieldsContainer = document.getElementById('tvFieldsEdit');
            const formIdInput = document.getElementById('form_tv_id_edit');
            const form = document.getElementById('tvFormEdit');
    
            // Очистка прошлых полей
            fieldsContainer.innerHTML = '';
            formIdInput.value = '';
    
            try {
                // Получаем данные TV + форму
                const response = await fetch(`/admin/document-tvs/${tvId}/edit`);
                const data = await response.json();
    
                formIdInput.value = data.form_tv_id;
                
                // Динамически строим поля формы
                data.form.forEach(field => {
                    const formGroup = document.createElement('div');
                    formGroup.classList.add('form_tv_group');
    
                    const label = document.createElement('label');
                    label.textContent = field.labels?.ru?.label || field.name;
    
                    let input;
                    let img_group;
                    let btn_image;
                    let inp_txt;
                    switch (field.type) {
                        case 'textarea':
                            input = document.createElement('textarea');
                            input.value = data.values[field.name] || '';
                            break;
                        case 'select':
                            input = document.createElement('select');
                            field.options?.forEach(opt => {
                                const option = document.createElement('option');
                                option.value = opt;
                                option.textContent = opt;
                                if (data.values[field.name] == opt) option.selected = true;
                                input.appendChild(option);
                            });
                            break;
                        case 'checkbox':
                            input = document.createElement('input');
                            input.type = 'checkbox';
                            input.checked = !!data.values[field.name];
                            break;
                        case 'images':
                                    img_group = document.createElement('div');
                                    img_group.classList.add('group_image_input');
                                    btn_image = document.createElement('button');
                                    btn_image.classList.add('btn');
                                    btn_image.classList.add('btn_upload_img');
                                    btn_image.textContent = 'Загрузить';
                                    btn_image.type = 'button';
                                    btn_image.classList.add('upload_img_btn');
                                    inp_txt = document.createElement('input');
                                    inp_txt.classList.add('input_image_path_edit');
                                    inp_txt.type = 'text';
                                    inp_txt.value = data.values[field.name] || '';
                                    img_group.appendChild(btn_image);
                                    img_group.appendChild(inp_txt);
                                    break;
                        default:
                            input = document.createElement('input');
                            input.type = field.type || 'text';
                            input.value = data.values[field.name] || '';
                    }
                    if(img_group){
                                inp_txt.name = field.name;
                                formGroup.appendChild(img_group);
                                fieldsContainer.appendChild(formGroup);
                            }else{
                                input.name = field.name;
                                label.appendChild(input);
                                formGroup.appendChild(label);
                                fieldsContainer.appendChild(formGroup);
                            }
                });
    
                // Устанавливаем action формы на update
                form.action = `/admin/document-tvs/${tvId}`;
    
                // Открываем модалку
                modal.classList.add('active');
    
            } catch (err) {
                console.error('Ошибка при загрузке TV:', err);
            }
        });
    });

    document.querySelectorAll('.close_modal-form').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.closest('.modal_tv').classList.remove('active');
        });
    });

    document.addEventListener('click', function(e) {
        const target = e.target;
        // Проверяем, не кликнули ли на .select_btn_open или на .select_option_itm
        const isBtnOpen = target.closest('.select_btn_open');
        const isOptionItem = target.closest('.select_option_itm');
        if (!isBtnOpen && !isOptionItem) {
            // Снимаем класс active со всех списков
            document.querySelectorAll('.select_option_list.active').forEach(list => {
                list.classList.remove('active');
            });
        }
    });

    let user_btn_avatar_upload = document.querySelector('.user_btn_avatar_upload');
    if(user_btn_avatar_upload){
        user_btn_avatar_upload.addEventListener('click',function(e){
            let modal_upload_img_all = document.querySelector('.tv_modal_upload_img');
            if(modal_upload_img_all){
               const folderAction = new FolderAction();
                folderAction.getTree('').then(tree => {
                    var container = document.querySelector('.tv_modal_upload_folder');
                    if(container){
                        renderFolders(tree, container);
                        loadFileTreeModal('tv_modal_upload_file','');
                    }
                });
                modal_upload_img_all.classList.add('active');
            }
        });
    }
    let close_btn_variant = document.querySelector('.close_btn_variant');
    if(close_btn_variant){
        close_btn_variant.addEventListener('click',function(e){
            let modal_upload_img_all = document.querySelector('.modal_upload_img_all');
            if(modal_upload_img_all){
                modal_upload_img_all.classList.remove('active');
            }
        });
    }
    
});





function renderFolders(tree, container) {
    container.innerHTML = ''; // очищаем контейнер
    tree.forEach(item => {
        if (item.type !== 'directory') return; // пропускаем файлы
        const folderLi = document.createElement('li');
        folderLi.className = 'folder_item';
        folderLi.dataset.path = item.path;
        folderLi.innerHTML = `<span class="itm_folder"><i class="fa-solid fa-folder"></i> ${item.name}</span>`;

        const ulChild = document.createElement('ul');
        ulChild.style.display = 'none';
        ulChild.style.marginLeft = '20px';
        folderLi.appendChild(ulChild);

        folderLi.querySelector('span').addEventListener('click', (e) => {
            e.stopPropagation();
            ulChild.style.display = ulChild.style.display === 'none' ? 'block' : 'none';
            ///////////////////////////////////////////////
            const parent = e.currentTarget.parentElement; 
            const path = parent.dataset.path;             
            const ul = Array.from(parent.children).find(el => el.tagName === 'UL');
        
            if (ul) {
                ul.classList.toggle('active');
            }
        
            loadFileTreeModal('tv_modal_upload_file', path);
            //////////////////////////////////////////////////
            console.log('Выбрана папка:', item.path);
        });

        container.appendChild(folderLi);

        if (item.children && item.children.length > 0) {
            renderFolders(item.children, ulChild);
        }
    });
}


function loadFolderImages(element) {
    const folderPath = element.getAttribute('data-path');
    
    // Убираем выделение с предыдущей активной папки
    document.querySelectorAll('.directory.active').forEach(item => {
        item.classList.remove('active');
    });
    
    // Добавляем выделение текущей папке
    element.classList.add('active');
    
    // Загружаем файлы из этой папки
    loadFileTree('file_block',folderPath);
}


function loadFileTree(el,path = '') {
    fetch(`/admin/media/tree?path=${encodeURIComponent(path)}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById(el);
            if (!container) return; // если элемента нет, выходим
            container.innerHTML = renderTree(data);
        })
        .catch(error => {
            console.error('Error loading file tree:', error);
            const container = document.getElementById(el);
            if (container) {
                container.innerHTML = 'Ошибка загрузки файлов';
            }
        });
}

function loadFileTreeModal(el,path = '') {
    fetch(`/admin/media/tree?path=${encodeURIComponent(path)}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById(el);
            if (!container) return; // если элемента нет, выходим
            container.innerHTML = renderTreeModalImg(data);
        })
        .catch(error => {
            console.error('Error loading file tree:', error);
            const container = document.getElementById(el);
            if (container) {
                container.innerHTML = 'Ошибка загрузки файлов';
            }
        });
}


function renderTree(items) {
    if (!items || !items.length) {
        return '<div class="no-files">Файлы не найдены</div>';
    }

    // Фильтруем только файлы (изображения)
    const files = items.filter(item => item.type === 'file');
    
    if (files.length === 0) {
        return '<div class="no-files">В этой папке нет файлов</div>';
    }

    let html = '<div class="images-grid">';
    files.forEach(file => {
        // Проверяем, является ли файл изображением
        const isImage = /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(file.name);
        const isFileFront = /\.(css|json|xml|txt|js)$/i.test(file.name);
        if (isImage) {
            html += `
            <div class="image-item">
                <div class="image-preview">
                    <img src="${file.url}" alt="${file.name}" 
                         onerror="this.style.display='none'">
                </div>
                <div class="image-info">
                    <button title="Копировать URL" onclick="copyUrl('${file.url}')" class="copy-btn">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
                <div class="image-name">${file.name}</div>
            </div>`;
        }
        if (isFileFront) {
            html += `
            <div class="image-item">
                <div class="image-preview">
                    <i class="fa-notdog fa-solid fa-file"></i>
                </div>
                <div class="image-info">
                    <button title="Копировать URL" onclick="copyUrl('${file.url}')" class="copy-btn">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
                <div class="image-name">${file.name}</div>
            </div>`;
        }
    });
    html += '</div>';
    return html;
}

function renderTreeModalImg(items) {
    if (!items || !items.length) {
        return '<div class="no-files">Файлы не найдены</div>';
    }

    // Фильтруем только файлы (изображения)
    const files = items.filter(item => item.type === 'file');
    
    if (files.length === 0) {
        return '<div class="no-files">В этой папке нет файлов</div>';
    }

    let html = '<div class="images-grid">';
    files.forEach(file => {
        // Проверяем, является ли файл изображением
        const isImage = /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(file.name);
        
        if (isImage) {
            html += `
            <div class="image-item_modal">
                <div class="image-preview">
                    <img src="${file.url}" alt="${file.name}" 
                         onerror="this.style.display='none'">
                </div>
                <div class="image-info">
                    <button title="Копировать URL" onclick="copyUrl('${file.url}')" class="copy-btn">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
                <div class="image-name">${file.name}</div>
            </div>`;
        }
    });
    html += '</div>';
    return html;
}


function copyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('URL скопирован: ' + url);
    });
}
document.addEventListener('DOMContentLoaded', function() {
    loadFileTree('file_block',''); // загружаем файлы из корневой директории
    loadFileTree('.tv_modal_upload_file','');
});


