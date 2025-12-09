<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormTv;
use App\Models\Template;

class FormTvController extends Controller
{
    public function index()
    {
        $tvforms = FormTv::all();
        $pageTitle = __('Additional fields');
        $buttons = [
            [
                'href'  => route('tvs.create'),
                'label' => __('button_add'), // ключ label соответствует Blade
                'class' => 'btn btn-secondary'
            ]
        ];
        return view('tvs.index', compact('tvforms','pageTitle', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = Template::all();
        $pageTitle = __('add_tv');
        $buttons = [
            ['href' => route('tvs.index'), 'label' => __('all_tv'), 'class' => 'btn btn-secondary'],
        ];
    
        return view('tvs.create', compact('templates','pageTitle', 'buttons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'name' => 'required|string|max:255',
            'caption' => 'nullable|string|max:255',
            'form' => 'required|string',
        ]);
    
        // Проверяем, что JSON валиден
        $decodedForm = json_decode($data['form']);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->with('error', 'Некорректный JSON в поле Form.')->withInput();
        }
    
        // Пытаемся сохранить
        if (FormTv::create($data)) {
            return redirect()->route('tvs.index')->with('success', 'Form TV successfully created!');
        } else {
            return redirect()->route('tvs.index')->with('error', 'Некорректный JSON в поле Form.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   $formTv = FormTv::findOrFail($id);
        $templates = Template::all();
        $old_template  = Template::findOrFail($formTv->template_id);
        $pageTitle = __('add_tv');
        $buttons = [
            ['href' => route('tvs.index'), 'label' => __('all_tv'), 'class' => 'btn btn-secondary'],
        ];
    
        return view('tvs.edit', compact('templates','pageTitle', 'buttons','formTv','old_template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tvs = FormTv::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'caption' => 'nullable|string',
            'template_id' => 'string',
            'form' => 'string',
        ]);
       
        $tvs->update($data);

        /*$documents = Document::where('template_id', $template->id)->get();
        foreach ($documents as $document) {
            $cacheKey = 'document_html_' . $document->id;
            Cache::forget($cacheKey);
        }*/

        return redirect()->route('tvs.index')->with('success', $tvs->name .' обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tvs = FormTv::findOrFail($id);
        $tvs->delete();

        return redirect()->route('tvs.index')->with('success', 'tv удален!');
    }
}
