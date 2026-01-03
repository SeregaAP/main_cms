<?php

namespace App\Http\Controllers\TvForm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TvForm;
use App\Models\Template;

class TvFormController extends Controller
{
    public function index()
    {
        $tvForms = TvForm::orderBy('name')->get();
        return view('tv_forms.index', compact('tvForms'));
    }

    public function create()
    {
        $types = collect([
            ['id' => 'text', 'title' => 'text'],
            ['id' => 'image', 'title' => 'image'],
            ['id' => 'migx', 'title' => 'migx'],
        ]);
        $templates = Template::all();
        return view('tv_forms.create', compact('templates','types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:tv_forms,key',
            'type' => 'required|in:text,image,migx',
            'description' => 'nullable|string|max:1000',
            'config' => 'nullable|string', // <-- было array, стало string
            'templates' => 'nullable|array',
            //'templates.*' => 'exists:templates,id',
        ]);
    
        // Преобразуем JSON в массив
        if (!empty($validated['config'])) {
            $validated['config'] = json_decode($validated['config'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['config' => 'Неверный JSON']);
            }
        }
    
        // Создаём TV Form
        $tvForm = TvForm::create($validated);
    
        // Привязываем к шаблонам, если выбраны
        if ($request->has('templates')) {
            $tvForm->templates()->sync($request->input('templates'));
        }
    
        return redirect()->route('tv_forms.index')
                         ->with('success', 'TV Form успешно создан!');
    }

    public function edit($id)
    {
        $tvForm = TvForm::findOrFail($id);
        $types = collect([
            ['id' => 'text', 'title' => 'text'],
            ['id' => 'image', 'title' => 'image'],
            ['id' => 'migx', 'title' => 'migx'],
        ]);
        $templates = Template::all();
        return view('tv_forms.edit', compact('tvForm','templates','types'));
    }

    public function update(Request $request, TvForm $tvForm)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:tv_forms,key,' . $tvForm->id,
            'type' => 'required|in:text,image,migx',
            'description' => 'nullable|string|max:500',
            'config' => 'nullable|string',
            'templates' => 'nullable|array',
        ]);
    
        // Преобразуем config в массив
        $newConfig = [];
        if (!empty($validated['config'])) {
            $newConfig = json_decode($validated['config'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['config' => 'Неверный JSON']);
            }
        }
    
        // Проверяем, изменились ли ключи config
        $oldKeys = array_keys($tvForm->config ?? []);
        $newKeys = array_keys($newConfig);
        $keysChanged = $oldKeys !== $newKeys;
    
        // Обновляем TV Form
        $tvForm->update(array_merge($validated, ['config' => $newConfig]));
    
        // Если ключи изменились — удаляем все связанные document_tv_values
        if ($keysChanged) {
            \App\Models\DocumentTvValue::where('tv_form_id', $tvForm->id)->delete();
        }
    
        // Синхронизируем привязку к шаблонам
        $tvForm->templates()->sync($request->input('templates', []));
    
        return redirect()->route('tv_forms.index')
                         ->with('success', 'TV обновлена');
    }

    public function destroy(TvForm $tvForm)
    {
        $tvForm->delete();
        return back()->with('success', 'TV удалена');
    }
}
