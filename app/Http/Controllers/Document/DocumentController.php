<?php

namespace App\Http\Controllers\Document;

use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Str;
use App\Models\Template;
use App\Models\TvForm;
use App\Models\DocumentTvValue;
use App\Services\TvService;

use App\Services\DocumentContentRenderer;

class DocumentController extends Controller
{
    protected $contentRenderer;

    // Внедряем сервис через конструктор
    public function __construct(DocumentContentRenderer $contentRenderer)
    {
        $this->contentRenderer = $contentRenderer;
    }

    public function index(){
        $documents = Document::with('children')
        ->whereNull('parent_id')
        ->orderBy('position')
        ->get();
        $doc_info = [
            'doc_counter' => Document::all()->count(),
            'doc_publiched' => Document::all()->where('published', true)->count(),
            'doc_in_menu' => Document::all()->where('show_in_menu', true)->count()
        ];
        return view('document.index', compact('documents','doc_info'));
    }

    public function create(Request $request){
        // Оставляем как есть
        $templates = Template::all();
        $type = $request->get('type', 'document');
        $documents = Document::select('id', 'title')->get();
        $formats = collect([
            ['id' => 'html', 'title' => 'HTML'],
            ['id' => 'txt', 'title' => 'Текстовый (TXT)'],
            ['id' => 'xml', 'title' => 'XML'],
        ]);
        return view('document.create',compact('documents','type','formats','templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:document,category,product',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'alias' => 'nullable|string|max:255|unique:documents,alias',
            'parent_id' => 'nullable|exists:documents,id',
            'format' => 'required|in:html,txt,xml,pdf,docx',
            'template_id' => 'nullable|exists:templates,id',

        ]);
    
        // Обработка чекбоксов
        $validated['published'] = $request->has('published') && $request->input('published') === 'on';
        $validated['show_in_menu'] = $request->has('show_in_menu') && $request->input('show_in_menu') === 'on';
        $validated['is_cache'] = $request->has('is_cache') && $request->input('is_cache') === 'on';
        
        // Преобразуем parent_id
        if (empty($validated['parent_id']) || $validated['parent_id'] == '0') {
            $validated['parent_id'] = null;
        }
        
        // Добавляем ID пользователя
        $validated['user_id'] = auth()->id();
        
        // Автоматически определяем позицию
        if ($validated['parent_id']) {
            $maxPosition = Document::where('parent_id', $validated['parent_id'])->max('position');
            $validated['position'] = ($maxPosition !== null) ? $maxPosition + 1 : 0;
        } else {
            $maxPosition = Document::whereNull('parent_id')->max('position');
            $validated['position'] = ($maxPosition !== null) ? $maxPosition + 1 : 0;
        }
        
        // Генерируем алиас
        if (!empty($validated['alias'])) {
            // Проверяем уникальность полного пути
            $fullPath = Document::buildFullPath($validated['alias'], $validated['parent_id']);
            
            if (!Document::isFullPathUnique($fullPath)) {
                // Генерируем уникальный алиас
                $baseAlias = $validated['alias'];
                $counter = 1;
                
                do {
                    $validated['alias'] = $baseAlias . '-' . $counter;
                    $fullPath = Document::buildFullPath($validated['alias'], $validated['parent_id']);
                    $counter++;
                } while (!Document::isFullPathUnique($fullPath) && $counter < 100);
            }
        } else {
            $validated['alias'] = $this->generateAlias($validated['title']);
            
            // Проверяем уникальность полного пути для сгенерированного алиаса
            $fullPath = Document::buildFullPath($validated['alias'], $validated['parent_id']);
            $counter = 1;
            $baseAlias = $validated['alias'];
            
            while (!Document::isFullPathUnique($fullPath) && $counter < 100) {
                $validated['alias'] = $baseAlias . '-' . $counter;
                $fullPath = Document::buildFullPath($validated['alias'], $validated['parent_id']);
                $counter++;
            }
        }
        
        // Создаем полный путь
        $validated['full_path'] = Document::buildFullPath($validated['alias'], $validated['parent_id']);
        
        // Создаем документ
        try {
            $document = Document::create($validated);
            $document->refreshFullPathRecursively();
            
            \Log::info('Документ создан', [
                'id' => $document->id,
                'title' => $document->title,
                'user_id' => auth()->id(),
                'type' => $document->type,
                'full_path' => $document->full_path,
                'url' => $document->full_url,
            ]);
            
            return redirect()->route('documents.index')
                ->with('success', 'Документ "' . $document->title . '" успешно создан! URL: ' . $document->full_url);
                
        } catch (\Exception $e) {
            \Log::error('Ошибка создания документа', [
                'error' => $e->getMessage(),
                'data' => $validated,
                'user_id' => auth()->id(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Произошла ошибка при создании документа: ' . $e->getMessage());
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            $orderData = $request->input('order');
            
            // ВРЕМЕННО: логируем всё что пришло
            \Log::info('📥 ПРИШЛИ ДАННЫЕ:', $orderData);
            file_put_contents(storage_path('logs/order_debug.log'), 
                json_encode($orderData, JSON_PRETTY_PRINT) . "\n\n", 
                FILE_APPEND
            );
            
            if (empty($orderData) || !is_array($orderData)) {
                \Log::warning('❌ Пустые данные');
                return response()->json([
                    'success' => false,
                    'message' => 'Нет данных для сортировки'
                ]);
            }
            
            \DB::beginTransaction();
            
            // ВРЕМЕННО: логируем текущее состояние БД
            $before = Document::select('id', 'title', 'parent_id', 'position')
                ->orderBy('parent_id')
                ->orderBy('position')
                ->get()
                ->toArray();
            \Log::info('📋 БД ДО сохранения:', $before);
            
            // Обрабатываем рекурсивно
            $this->processOrderRecursive($orderData, null);
            
            // ВРЕМЕННО: логируем состояние БД после
            $after = Document::select('id', 'title', 'parent_id', 'position')
                ->orderBy('parent_id')
                ->orderBy('position')
                ->get()
                ->toArray();
            \Log::info('📋 БД ПОСЛЕ сохранения:', $after);
            
            \DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Порядок успешно сохранен'
            ]);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('❌ Ошибка:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function processOrderRecursive($items, $parentId = null)
    {
        foreach ($items as $position => $item) {
            if (!isset($item['id'])) {
                \Log::warning('Элемент без ID', ['item' => $item]);
                continue;
            }
            
            $document = Document::find($item['id']);
            if (!$document) {
                \Log::warning('Документ не найден', ['id' => $item['id']]);
                continue;
            }
            
            \Log::info('📝 Сохраняем:', [
                'id' => $document->id,
                'title' => $document->title,
                'parent_id' => $parentId . ' (было: ' . $document->parent_id . ')',
                'position' => $position . ' (было: ' . $document->position . ')'
            ]);
            $parentChanged = $document->parent_id != $parentId;
            $document->parent_id = $parentId;
            $document->position = $position;
            $document->save();

            if ($parentChanged) {
                $document->refreshFullPathRecursively();
            }
            
            // Проверяем что сохранилось
            $saved = Document::find($document->id);
            \Log::info('✅ Проверка:', [
                'id' => $saved->id,
                'parent_id' => $saved->parent_id,
                'position' => $saved->position
            ]);
            
            if (!empty($item['children'])) {
                $this->processOrderRecursive($item['children'], $document->id);
            }
        }
    }
    /**
     * Генерация алиаса из заголовка
     */
    private function generateAlias(string $title): string
    {
        // Используем Str::slug для лучшей транслитерации
        $alias = Str::slug($title, '-', 'ru');
        
        // Если slug вернул пустую строку
        if (empty($alias)) {
            $alias = 'document-' . time();
        }
        
        return $alias;
    }
    
    public function show($path = null, \App\Services\DocumentContentRenderer $contentRenderer)
    {
        if (!$path) {
            // Главная страница - просто список корневых документов
            $documents = Document::whereNull('parent_id')
                ->where('published', true)
                ->orderBy('position')
                ->get();
            $content = view('document.list', compact('documents'))->render();
            return response($content);
        }
        
        // Ищем документ по полному пути
        $document = Document::where('full_path', $path)
            ->orWhere('alias', $path) // Для обратной совместимости
            ->first();

        if (!$document) {
            abort(404, 'Документ не найден');
        }

        if (!$document->published) {
            abort(403, 'Документ не опубликован');
        }

        $content;
        if ($document->template) {
            $content = $document->template()->first()->content;
        } else {
            $content = $document->content;
        }
        
        //$processedContent = $this->contentRenderer->render($content, $document);
        
        //return response($processedContent);
        [$processedContent, $contentType] = $contentRenderer->render($content, $document);

        return response($processedContent, 200)
            ->header('Content-Type', $contentType);
    }

    public function edit($id)
    {
        // Получаем редактируемый документ
        $doc = Document::findOrFail($id);
        
        // Оставляем как в функции create
        $templates = Template::all();
        $documents = Document::select('id', 'title')->get();

        $old =[
            'documen_parent_old' => $doc->parent_id
        ? Document::find($doc->parent_id)?->title
        : null,
        'document_template_name' => $doc->template_id 
        ? Template::find($doc->template_id)?->title
        : null,
   
        ];
        /////////////////////////////////////
        $templateId = $doc->template_id;
 
            $tvForms = TvForm::whereHas('templates', function ($q) use ($templateId) {
            $q->where('templates.id', $templateId);
        })
        ->with(['templates' => function ($q) use ($templateId) {
            $q->where('templates.id', $templateId);
        }])
        ->get()
        ->sortBy(fn ($tv) => $tv->templates->first()->pivot->position);
    
        $tvValues = DocumentTvValue::where('document_id', $doc->id)
        ->get()
        ->keyBy('tv_form_id') ?? collect();
        ///////////////////////////////////
        
        $formats = collect([
            ['id' => 'html', 'title' => 'HTML'],
            ['id' => 'txt', 'title' => 'Текстовый (TXT)'],
            ['id' => 'xml', 'title' => 'XML'],
        ]);
        
        return view('document.edit', compact('doc', 'documents', 'formats', 'templates','old','tvForms','tvValues'));
    }
    
    public function update(Request $request, $id,TvService $tvService)
    {

        // Получаем редактируемый документ
        $document = Document::findOrFail($id);
        
        // Правила валидации с исключением текущего документа
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:document,category,product',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'alias' => 'nullable|string|max:255|unique:documents,alias,' . $id,
            'parent_id' => 'nullable|exists:documents,id',
            'format' => 'required|in:html,txt,xml,pdf,docx',
            'template_id' => 'nullable|exists:templates,id',
        ];
        
        // Проверяем, чтобы документ не был родителем самому себе
        if ($request->input('parent_id') == $id) {
            return back()
                ->withInput()
                ->with('error', 'Документ не может быть родителем самому себе.');
        }
        
        // Валидация
        $validated = $request->validate($rules);

        $tvService->saveTvValues($document, $request);
        
        // Обработка чекбоксов
        $validated['published'] = $request->has('published') && $request->input('published') === 'on';
        $validated['show_in_menu'] = $request->has('show_in_menu') && $request->input('show_in_menu') === 'on';
        $validated['is_cache'] = $request->has('is_cache') && $request->input('is_cache') === 'on';
        
        // Преобразуем parent_id
        if (empty($validated['parent_id']) || $validated['parent_id'] == '0') {
            $validated['parent_id'] = null;
        }
        
        // Проверяем изменение родителя
        $parentChanged = $document->parent_id != $validated['parent_id'];
        
        // Генерируем алиас, если не указан
        if (empty($validated['alias'])) {
            $validated['alias'] = $this->generateAlias($validated['title']);
        }
        
        // Проверяем уникальность полного пути, если изменился алиас или родитель
        if ($parentChanged || $document->alias != $validated['alias']) {
            $fullPath = Document::buildFullPath($validated['alias'], $validated['parent_id']);
            
            // Проверяем, что новый полный путь уникален (кроме текущего документа)
            $existing = Document::where('full_path', $fullPath)
                ->where('id', '!=', $id)
                ->exists();
                
            if ($existing) {
                // Генерируем уникальный алиас
                $baseAlias = $validated['alias'];
                $counter = 1;
                
                do {
                    $validated['alias'] = $baseAlias . '-' . $counter;
                    $fullPath = Document::buildFullPath($validated['alias'], $validated['parent_id']);
                    $existing = Document::where('full_path', $fullPath)
                        ->where('id', '!=', $id)
                        ->exists();
                    $counter++;
                } while ($existing && $counter < 100);
            }
            
            $validated['full_path'] = $fullPath;
        } else {
            // Если путь не изменился, оставляем старый
            $validated['full_path'] = $document->full_path;
        }
        
        // Обновляем позицию, если изменился родитель
        if ($parentChanged) {
            if ($validated['parent_id']) {
                $maxPosition = Document::where('parent_id', $validated['parent_id'])
                    ->where('id', '!=', $id)
                    ->max('position');
                $validated['position'] = ($maxPosition !== null) ? $maxPosition + 1 : 0;
            } else {
                $maxPosition = Document::whereNull('parent_id')
                    ->where('id', '!=', $id)
                    ->max('position');
                $validated['position'] = ($maxPosition !== null) ? $maxPosition + 1 : 0;
            }
        }
        
        try {
            // Сохраняем старые данные для логов
            $oldData = $document->toArray();
            
            // Обновляем документ
            $aliasChanged = $document->alias !== $validated['alias'];
            $document->update($validated);
            if ($parentChanged || $aliasChanged) {
                $document->refresh(); // 🔥 ОБЯЗАТЕЛЬНО
                $document->refreshFullPathRecursively();
            }
           
            \Log::info('Документ обновлен', [
                'id' => $document->id,
                'title' => $document->title,
                'old_data' => $oldData,
                'new_data' => $validated,
                'user_id' => auth()->id(),
            ]);
            
            return redirect()->route('documents.index')
                ->with('success', 'Документ "' . $document->title . '" успешно обновлен!');
                
        } catch (\Exception $e) {
            \Log::error('Ошибка обновления документа', [
                'id' => $id,
                'error' => $e->getMessage(),
                'data' => $validated,
                'user_id' => auth()->id(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Произошла ошибка при обновлении документа: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Документ удален!');
    }
    
}