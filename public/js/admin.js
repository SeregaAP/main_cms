import { Editor } from './Editor/Editor.js';

let currentInputId = null;

$(document).ready(function(){
    $('.select_btn_open').on('click',function(){
        $('.select_btn_open').removeClass('active');
        $('.select_inp_list-block').removeClass('active');
        $('.select_inp').removeClass('active');
        $(this).addClass('active');
        var parent = $(this).parent();
        parent = $(parent).parent();
        parent = $(parent).parent();
        $(parent).addClass('active');
        var list = $(parent).children('.select_inp_list-block');
        $(list).addClass('active');
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('.select_inp').length) {
            $('.select_btn_open').removeClass('active');
            $('.select_inp_list-block').removeClass('active'); // закрываем все
        }
        
    });

    $('.select_inp_itm').on('click',function(){
        var parent = $(this).parent();
        parent = $(parent).parent();
        parent = $(parent).parent();
        parent = $(parent).parent();
        var result_txt = parent.find('.select-result-txt');
        var inp = parent.find('.select-input');
        if($(this).data('id') != ''){
            $(inp).val($(this).data('id'));
            $(result_txt).text($(this).text());
        }else{
            $(inp).val('');
            $(result_txt).text('--Не чего не выбранно--');
        }

        $('.select_btn_open').removeClass('active');
        $('.select_inp_list-block').removeClass('active');
    });

    $('.tab-btn').on('click',function(){
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        var tabClass = $(this).data('tab');
        $('.tab').removeClass('active');
        $(tabClass).addClass('active');
    });

    $('.acardion_btn').on('click',function(){
        $('.acardion-item').removeClass('active');
        var parent = $(this).parent();
        parent = $(parent).parent();
        $(parent).addClass('active');
    });

    $('.cnt_menu_btn').on('click',function(){
        var parent = $(this).parent();
        $(parent).children('.content_menu-item_list').toggleClass('active');
    });

    $('.three_btn-open').on('click',function(){
        $(this).toggleClass('active');
        var parent = $(this).parent();
        parent = $(parent).parent();
        parent = $(parent).parent();
        parent = $(parent).parent();
        console.log(parent);
        
        var list = $(parent).children('ul');
        $(list).toggleClass('active');
    });

    $('.btn_close-modal-file').on('click',function(){
        $('.modal-file').removeClass('active');
    })

    Editor.init({
        selector: '#content',
        height: '200px'
    });
    
    if(document.getElementById("codeEditor")){
        var editor = CodeMirror.fromTextArea(document.getElementById("codeEditor"), {
            lineNumbers: true,
            mode: "htmlmixed",
            theme: "base16-dark",
            lineWrapping: true
        });

        const content = $('#codeEditor').attr('data-content'); // ВСЕГДА строка
        editor.setValue(content);
    }

});


document.addEventListener('DOMContentLoaded', () => {
    const settings = {
        duration: 0.9,       // длительность одной половинки переворота
        easeIn: 'power2.in',  // easing для верхней текущей/нижней текущей
        easeOut: 'power2.out',// easing для верхней следующей/нижней следующей
        interval: 1000        // задержка между перелистыванием цифр
    };

    document.querySelectorAll('.flip-digit').forEach(flip => {

        const max = parseInt(flip.dataset.max, 10) || 0;
        let current = 0;

        const upper      = flip.querySelector('.card.upper:not(.next)');
        const lower      = flip.querySelector('.card.lower:not(.next)');
        const upperNext  = flip.querySelector('.card.upper.next');
        const lowerNext  = flip.querySelector('.card.lower.next');

        const upperImg     = upper.querySelector('img');
        const lowerImg     = lower.querySelector('img');
        const upperNextImg = upperNext.querySelector('img');
        const lowerNextImg = lowerNext.querySelector('img');

        // стартовые положения
        gsap.set(upperNext, { rotationX: 90 });
        gsap.set(lowerNext, { rotationX: -90 });

        function flipTo(next) {

            // Меняем картинки у img
            upperNextImg.src = `/images/timer/${next}-0.jpg`;
            lowerNextImg.src = `/images/timer/${next}-1.jpg`;

            const tl = gsap.timeline({
                onComplete: () => {
                    upperImg.src = upperNextImg.src;
                    lowerImg.src = lowerNextImg.src;

                    // Сброс вращения для следующего цикла
                    gsap.set(upper, { rotationX: 0 });
                    gsap.set(lower, { rotationX: 0 });
                    gsap.set(upperNext, { rotationX: 90 });
                    gsap.set(lowerNext, { rotationX: -90 });
                }
            });

            tl.to(upper, {
                rotationX: -90,
                duration: settings.duration,
                ease: settings.easeIn
            })
            .to(upperNext, {
                rotationX: 0,
                duration: settings.duration,
                ease: settings.easeOut
            }, '<')
            .to(lower, {
                rotationX: 90,
                duration: settings.duration,
                ease: settings.easeIn
            }, '<')
            .to(lowerNext, {
                rotationX: 0,
                duration: settings.duration,
                ease: settings.easeOut
            }, '<');
        }

        const timer = setInterval(() => {
            current++;
            if (current > max) {
                clearInterval(timer);
                return;
            }
            flipTo(current);
        }, settings.interval);

    });

    if (document.getElementById('media-tree')) {
        loadFolders('media-tree', 'media-files'); // ✅
        loadFiles('', 'media-files');
    }

    var btn_open_file_modal = document.querySelector('.file-modal-open');
    if(btn_open_file_modal){
        $('.file-modal-open').on('click',function(){
            var modal_file = document.querySelector('.modal-file');
            loadFolders('modal-file_folder','modal-file_file');
            loadFiles('', 'modal-file_file'); 
            currentInputId = this.dataset.id;
            modal_file.classList.add('active');
        });
    }
    
});


//folder 
async function loadFolders(id_wrapper,file_list) {
    const response = await fetch('/media/folders');
    const json = await response.json();

    const container = document.getElementById(id_wrapper);
    container.innerHTML = '';

    container.appendChild(renderTree(json.data,file_list));
}

/*
function renderTree(folders) {
    const ul = document.createElement('ul');

    folders.forEach(folder => {
        const li = document.createElement('li');

        const label = document.createElement('div');
        label.className = 'folder';
        label.textContent = folder.name;
        label.dataset.path = folder.path;

        li.appendChild(label);

        if (folder.children.length) {
            const children = renderTree(folder.children);
            children.classList.add('hidden');

            label.addEventListener('click', () => {
                children.classList.toggle('hidden');
                loadFiles(folder.path, 'media-files');
            });

            li.appendChild(children);
        }

        ul.appendChild(li);
    });

    return ul;
}*/
function renderTree(folders,file_list) {
    const ul = document.createElement('ul');

    folders.forEach(folder => {
        const li = document.createElement('li');

        const label = document.createElement('div');
        label.className = 'folder';
        label.textContent = folder.name;
        label.dataset.path = folder.path;

        li.appendChild(label);

        let children = null;

        if (folder.children.length) {
            children = renderTree(folder.children, file_list);
            children.classList.add('hidden');
            li.appendChild(children);
        }

        label.addEventListener('click', () => {
            // всегда грузим файлы
            console.log('uygyuguy');
            
            loadFiles(folder.path,file_list);

            // раскрываем только если есть подпапки
            if (children) {
                children.classList.toggle('hidden');
            }
        });

        ul.appendChild(li);
    });

    return ul;
}
//files
async function loadFiles(path = '', wrapperId,) {
    const container = document.getElementById(wrapperId);
    if (!container) return; // ✅ защита

    const url = path
        ? `/media/files?path=${encodeURIComponent(path)}`
        : `/media/files`;

    const response = await fetch(url);
    const json = await response.json();

    container.innerHTML = '';

    if (!json.success || !json.data.length) {
        container.textContent = 'Файлы не найдены';
        return;
    }
    
    
    container.appendChild(renderFiles(json.data));
}

function renderFiles(files) {
    const ul = document.createElement('div');
    ul.className = 'file-list';

    files.forEach(file => {
        const item = renderTypeFile(file);

        // 👇 клик по файлу
        item.addEventListener('click', () => {
            const input = document.getElementById(currentInputId);
            if (input){
                input.value = file.path;
            }
            $('.modal-file').removeClass('active');
            
        });
        ul.appendChild(item);
    });

    return ul;
}

function renderTypeFile(file){
    const item = document.createElement('div');
    const img = document.createElement('img');
    const sp = document.createElement('span');
    item.className = 'file';
    sp.textContent = file.name;
    item.dataset.path = file.path;
    item.dataset.url = file.url;
    item.dataset.ext = file.ext;
    switch (file.ext) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
        case 'svg':
            img.src = file.url;
            break;
    
        case 'css':
        case 'scss':
            img.src = BASE_ICONS + 'css.jpg';
            break;
    
        case 'js':
            img.src = BASE_ICONS + 'js.jpg';
            break;
    
        case 'woff2':
            img.src = BASE_ICONS + 'font.jpg';
            break;
    
        case 'json':
            img.src = BASE_ICONS + 'json.jpg';
            break;
    
        case 'html':
            img.src = BASE_ICONS + 'html.jpg';
            break;
    
        case 'md':
            img.src = BASE_ICONS + 'md.jpg';
            break;
    
        default:
            img.src = BASE_ICONS + 'default.jpg';
    }
    item.appendChild(img);
    item.appendChild(sp);
    return item;
}

