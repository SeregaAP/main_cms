export class Editor {
    static init(config) {
        document.querySelectorAll(config.selector).forEach(textarea => {
            // Создаем тулбар
            const toolbar = document.createElement('div');
            toolbar.className = 'editor-toolbar';
            toolbar.innerHTML = `
                <button type="button" data-cmd="bold">B</button>
                <button type="button" data-cmd="italic">I</button>
                <button type="button" data-cmd="underline">U</button>
                <span class="separator">|</span>
                <button type="button" data-cmd="h1">H1</button>
                <button type="button" data-cmd="h2">H2</button>
                <span class="separator">|</span>
                <button type="button" data-cmd="link">🔗</button>
                <button type="button" data-cmd="ul">☰</button>
                <button type="button" data-cmd="ol">1.</button>
                <span class="separator">|</span>
                <!-- КНОПКИ ЦВЕТА -->
                <button type="button" data-cmd="color" data-value="#FF0000" style="color: #FF0000;" title="Красный">■</button>
                <button type="button" data-cmd="color" data-value="#0000FF" style="color: #0000FF;" title="Синий">■</button>
                <button type="button" data-cmd="color" data-value="#008000" style="color: #008000;" title="Зеленый">■</button>
                <button type="button" data-cmd="color" data-value="#FFA500" style="color: #FFA500;" title="Оранжевый">■</button>
                <button type="button" data-cmd="color" data-value="#000000" style="color: #000000; background: #eee;" title="Черный">■</button>
                <button type="button" data-cmd="colorPicker" title="Выбрать цвет">🎨</button>
            `;
            
            // Создаем редактор
            const editor = document.createElement('div');
            editor.className = 'editor-area';
            editor.contentEditable = true;
            editor.innerHTML = textarea.value || '';

            editor.style.outline = 'none';
            editor.style.boxShadow = 'none';

            editor.style.height = config.height || '200px';
            editor.style.minHeight = '150px'
            
            // Прячем textarea и вставляем элементы
            textarea.style.display = 'none';
            textarea.after(toolbar);
            toolbar.after(editor);
            
            // Функция синхронизации (внутренняя)
            const sync = () => {
                textarea.value = editor.innerHTML;
            };
            
            // Вешаем слушатели
            editor.addEventListener('input', sync);
            editor.addEventListener('blur', sync);
            editor.addEventListener('keyup', sync);
            
            // Обработка кнопок
            toolbar.addEventListener('click', (e) => {
                if (e.target.tagName === 'BUTTON') {
                    const cmd = e.target.dataset.cmd;
                    const value = e.target.dataset.value;
                    
                    if (cmd === 'bold') document.execCommand('bold');
                    if (cmd === 'italic') document.execCommand('italic');
                    if (cmd === 'underline') document.execCommand('underline');
                    
                    if (cmd === 'h1') document.execCommand('formatBlock', false, '<h1>');
                    if (cmd === 'h2') document.execCommand('formatBlock', false, '<h2>');
                    
                    if (cmd === 'ul') document.execCommand('insertUnorderedList');
                    if (cmd === 'ol') document.execCommand('insertOrderedList');
                    
                    if (cmd === 'link') {
                        const url = prompt('Введите URL:');
                        if (url) document.execCommand('createLink', false, url);
                    }
                    
                    // ЦВЕТ ТЕКСТА
                    if (cmd === 'color') {
                        document.execCommand('foreColor', false, value);
                    }
                    
                    // ВЫБОР ЦВЕТА ИЗ ПАЛИТРЫ
                    if (cmd === 'colorPicker') {
                        // Создаем input типа color
                        const colorInput = document.createElement('input');
                        colorInput.type = 'color';
                        colorInput.value = '#000000';
                        
                        colorInput.addEventListener('change', function() {
                            document.execCommand('foreColor', false, this.value);
                            sync();
                        });
                        
                        colorInput.click(); // Открываем палитру
                    }
                    
                    editor.focus();
                    sync(); // Синхронизация после команды
                }
            });
            
            // Начальная синхронизация
            sync();
        });
    }
    
    // Опциональные методы для удобства
    static getContent(selector) {
        const textarea = document.querySelector(selector);
        return textarea ? textarea.value : '';
    }
    
    // Метод для установки цвета текста (можно вызывать извне)
    static setTextColor(selector, color) {
        const textarea = document.querySelector(selector);
        if (textarea && textarea._editor) {
            document.execCommand('foreColor', false, color);
            textarea._editor.focus();
            
            // Синхронизируем
            textarea.value = textarea._editor.innerHTML;
        }
    }
}