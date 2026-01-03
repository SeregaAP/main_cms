<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Document;

class TemplateController extends Controller
{
    public function index(){
        $templates = Template::all();
        return view('template.index',compact('templates'));
    }

    public function create(){
        $documents = Document::all();
        return view('template.create',compact('documents'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        $template = Template::create($validated);
        
        return redirect()->route('templates.index')
                ->with('success', 'Шаблон ' . $template->name . ' успешно создан!');
    }

    public function edit($id){
        $template = Template::findOrFail($id);
        return view('template.edit',compact('template'));
    }

    public function update(Request $request,$id){
        $template = Template::findOrFail($id);
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ];
        $validated = $request->validate($rules);

        $template->update($validated);
        return redirect()->route('templates.index')
                ->with('success', 'Шаблон "' . $template->title . '" успешно обновлен!');
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Шаблон удален!');
    }
}
