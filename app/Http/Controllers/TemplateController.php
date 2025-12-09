<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Document;

class TemplateController extends Controller
{
    public function index(){
        $pageTitle = __('bar_menu_template');
        $buttons = [
            [
                'href'  => route('templates.create'),
                'label' => __('add_template'), // ключ label соответствует Blade
                'class' => 'btn btn-secondary'
            ]
        ];

        $templates = Template::all();
    
        return view('templates.index', compact('pageTitle', 'buttons','templates'));
    }

    public function create()
    {

        $pageTitle = __('add_template');
        $buttons = [
            ['href' => route('templates.index'), 'label' => __('all_template'), 'class' => 'btn btn-secondary'],
        ];
    
        return view('templates.create', compact('pageTitle', 'buttons'));

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $data['content'] = $data['content'] ?? '';

        Template::create($data);

        return redirect()->route('templates.index')->with('success', 'Шаблон создан!');
    }

    public function edit($id)
    {
        $template = Template::findOrFail($id);

        $buttons = [
            ['href' => route('templates.index'), 'label' => __('all_template'), 'class' => 'btn btn-secondary'],
        ];

        $pageTitle = __('update_template');
        return view('templates.edit', compact('template', 'buttons','pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);
       
        $template->update($data);

        $documents = Document::where('template_id', $template->id)->get();
        foreach ($documents as $document) {
            $cacheKey = 'document_html_' . $document->id;
            Cache::forget($cacheKey);
        }

        return redirect()->route('templates.index')->with('success', $template->name .' обновлен!');
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Шаблон удален!');
    }
}
