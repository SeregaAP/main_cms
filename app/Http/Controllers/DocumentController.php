<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Template;
use App\Helpers\SitemapHelper;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    // -----------------------
    // Админка: список документов
    // -----------------------
    public function index()
    {
        $documents = Document::with('children')->whereNull('parent_id')->get();

        $pageTitle = __('bar_menu_doc');
        $buttons = [
            [
                'href'  => route('documents.create'),
                'label' => __('button_add'), // ключ label соответствует Blade
                'class' => 'btn  btn-secondary'
            ]
        ];
    
        return view('documents.index', compact('documents', 'pageTitle', 'buttons'));
    }

    // -----------------------
    // Админка: страница создания документа
    // -----------------------
    public function create()
    {
        $documents = Document::all();
        $templates = Template::all();
        $pageTitle = __('add_doc');
        $buttons = [
            ['href' => route('documents.index'), 'label' => __('all_doc'), 'class' => 'btn btn-secondary'],
        ];
    
        return view('documents.create', compact(
            'documents', 
            'pageTitle', 
            'buttons',
            'templates'
        ));

    }

    // -----------------------
    // Админка: сохранение нового документа
    // -----------------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255|unique:documents,alias',
            'content' => 'nullable|string',
            'parent_id' => 'nullable|exists:documents,id',
            'template_id' => 'nullable|exists:templates,id',
            'published' => 'nullable|boolean',
        ]);
    
        if (!isset($data['published'])) {
            $data['published'] = false;
        }
    
        // ✅ Генерация alias если он пустой
        if (empty($data['alias'])) {
            $alias = Str::slug($data['title']);
    
            // Проверка уникальности
            $originalAlias = $alias;
            $counter = 1;
    
            while (Document::where('alias', $alias)->exists()) {
                $alias = $originalAlias . '-' . $counter;
                $counter++;
            }
    
            $data['alias'] = $alias;
        }
    
        Document::create($data);
    
        return redirect()->route('documents.index')->with('success', 'Документ создан!');
    }

    // -----------------------
    // Админка: страница редактирования документа
    // -----------------------
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        //$document->load(['template.formTvs', 'tvs']); // подгружаем связанные модели
        $templates = Template::all();

        if($document->template_id){
            $tem = Template::findOrFail($document->template_id);
            $template_name = $tem->name;
        }else{
            $template_name = '--шаблон не присвоен--';
        }
        
        // Получаем всех потомков текущего документа (включая все уровни)
        $descendantsIds = $document->allDescendants()->pluck('id');
        
        // Исключаем текущий документ и всех его потомков
        $excludedIds = $descendantsIds->push($document->id);
        
        // Список документов, которых можно выбрать в качестве родителя
        $documents = Document::whereNotIn('id', $excludedIds)->get();
        
        $documents = Document::where('id', '!=', $id)->get(); // исключаем текущий документ из родителя
        $doc_parent = Document::find($document->parent_id);
        $buttons = [
            ['href' => route('documents.index'), 'label' => __('all_doc'), 'class' => 'btn btn-secondary'],
        ];

        $pageTitle = __('update_doc');
        return view('documents.edit', compact(
            'document', 
            'documents', 
            'buttons',
            'pageTitle',
            'doc_parent',
            'templates',
            'template_name'
        ));
    }

    // -----------------------
    // Админка: обновление документа
    // -----------------------
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $templates = Template::all();

        // Получаем всех потомков текущего документа (включая все уровни)
        $descendantsIds = $document->allDescendants()->pluck('id');
        
        // Исключаем текущий документ и всех его потомков
        $excludedIds = $descendantsIds->push($document->id);
        
        // Список документов, которых можно выбрать в качестве родителя
        $documents = Document::whereNotIn('id', $excludedIds)->get();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255|unique:documents,alias,' . $id,
            'content' => 'nullable|string',
            'parent_id' => 'nullable|exists:documents,id',
            'template_id' => 'nullable|exists:templates,id',
            'published' => 'nullable|boolean',
            'type' => 'required|string|max:255'
        ]);
        
        // Если пусто, пишем null, чтобы прошло exists
        $data['parent_id'] = $data['parent_id'] ?: null;
        
        if (!isset($data['published'])) {
            $data['published'] = false;
        }

        if ($data['parent_id']) {
            $parent = Document::find($data['parent_id']);
            if ($parent->id === $document->id || $parent->isDescendantOf($document)) {
                return redirect()->back()->withErrors(['parent_id' => 'Нельзя выбрать себя или потомка в качестве родителя']);
            }
        }
        
        //$document->update($data);
        $document->fill($data);
        $document->save();

        $document->updateUriRecursively();

        return redirect()->route('documents.index')->with('success', 'Документ обновлен!');
    }

    // -----------------------
    // Админка: удаление документа
    // -----------------------
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Документ удален!');
    }

    public function show($path)
    {
        $path = '/' . trim($path, '/'); 
        $document = Document::where('uri', $path)->firstOrFail();
    
        switch ($document->type) {
            case 'txt':
                return response($document->content)
                    ->header('Content-Type', 'text/plain; charset=utf-8');
    
            case 'xml':
                 return response(SitemapHelper::generate())
                 ->header('Content-Type', 'application/xml; charset=utf-8');
            case 'html':
                $cacheKey = 'document_html_' . $document->id;
                $store = Cache::store(config('cache.default'));
    
                return $store->remember($cacheKey, now()->addHours(2), function () use ($document) {
                    $template = $document->template;
    
                    $variables = [
                        'document' => $document,
                        // Добавляем полезные переменные по умолчанию
                        'documents' => Document::all(),
                        'currentUrl' => request()->url(),
                    ];
    
                    if ($template) {
                        return Blade::render($template->content, $variables);
                    }
                    
                    // Если шаблона нет, используем контент документа как HTML
                    return $document->content;
                });
    
            default:
                abort(404);
        }
    }

    public function reorder(Request $request)
    {
        $tree = $request->input('tree', []);
    
        $updateTree = function($nodes) use (&$updateTree) {
            foreach($nodes as $node) {
                $document = Document::find($node['id']);
                if($document) {
                    $document->parent_id = $node['parent_id']; // обновляем parent_id
                    //$document->save(); // uri пересчитается через booted -> saving
                    $document->updateUriRecursively();
                    if(!empty($node['children'])) {
                        $updateTree($node['children']);
                    }
                }
            }
        };
    
        $updateTree($tree);
    
        return response()->json(['success' => true]);
    }
    
    public function home()
    {
        try {
            DB::connection()->getPdo(); // Попытка получить подключение к базе
        } catch (\Exception $e) {
            // Если база не доступна (не создана), возвращаем ошибку или редирект
            if (env('IS_INSTALL') !== 'true') {
                return redirect('/install'); // Переадресовываем на установку, если база не создана
            }
            abort(500, 'Database connection error: '.$e->getMessage());
        }
        $homeId = Setting::where('key', 'site_start')->value('value');
    
        if (!$homeId) {
            return "Главная страница не настроена!";
        }
    
        $document = Document::find($homeId);
    
        if (!$document) {
            abort(404);
        }
    
        // ✅ вызываем show() по URI
        return $this->show(ltrim($document->uri, '/'));
    }
}