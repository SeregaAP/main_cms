<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTv;
use App\Models\FormTv;

class DocumentTvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Дополнительные поля';
        $buttons = [
            [
                'href'  => route('tvs.create'),
                'label' => __('button_add'), // ключ label соответствует Blade
                'class' => 'btn btn-secondary'
            ]
        ];
        return view('tvs.index', compact('pageTitle', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Добавить tv параметр';
        $buttons = [
            ['href' => route('tvs.index'), 'label' => 'Все tvs', 'class' => 'btn btn-secondary'],
        ];
    
        return view('tvs.create', compact('pageTitle', 'buttons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_id' => 'required|integer|exists:documents,id',
            'form_tv_id'  => 'required|integer',
        ]);

        $formTv = FormTv::find($validated['form_tv_id']);
       $validated['name'] = $formTv->name;

        // Собираем все остальные поля формы, кроме служебных
        $data = collect($request->except(['_token', 'document_id', 'form_tv_id']))->toArray();

        DocumentTv::create([
            'document_id' => $validated['document_id'],
            'form_tv_id'  => $validated['form_tv_id'],
            'value'       => $data,
            'name' =>  $validated['name']
        ]);

        return back()->with('success', 'TV сохранён!');
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
    public function editTv($tvId)
    {
        $tv = DocumentTv::findOrFail($tvId);
        $form = FormTv::findOrFail($tv->form_tv_id);
    
        // Декодируем JSON, если пустой, возвращаем пустой массив
        $jsonForm = json_decode($form->form, true);
        if (!is_array($jsonForm)) {
            $jsonForm = [];
        }
    
        return response()->json([
            'form' => $jsonForm,   // теперь точно массив
            'values' => $tv->value ?? [],
            'tv_id' => $tv->id,
            'form_tv_id' => $form->id,
        ]);
    }
    /*    public function editTv($tvId)
    {
        try {
            $tv = DocumentTv::findOrFail($tvId);
            $form = FormTv::findOrFail($tv->form_tv_id);
           
            $formJson = $form->json ? json_decode($form->json, true) : [];
            return response()->json([
                'form' => $form,
                'values' => $tv->value ?? [],
                'tv_id' => $tv->id,
                'form_tv_id' => $form->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }*/

public function update(Request $request, $tvId)
{
    $tv = DocumentTv::findOrFail($tvId);

    $data = $request->except(['_token', 'form_tv_id', 'document_id', '_method']);

    $tv->update([
        'value' => $data,
    ]);

    return back()->with('success', 'TV обновлён!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $doc_tv = DocumentTv::findOrFail($id);
        $doc_tv ->delete();

        return back()->with('success', 'Запись удалена!');
    }

    
}
