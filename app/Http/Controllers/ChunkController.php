<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chunk;


class ChunkController extends Controller
{
    public function index(){
        $pageTitle = __('bar_menu_chunk');
        $buttons = [
            [
                'href'  => route('chunks.create'),
                'label' => __('button_add'), // ключ label соответствует Blade
                'class' => 'btn  btn-secondary'
            ]
        ];
        $chunks = Chunk::all();
        return view('chunks.index',compact('chunks','pageTitle','buttons'));
    }

    public function create()
    {

        $pageTitle = __('add_template');
        $buttons = [
            ['href' => route('chunks.index'), 'label' => 'Все чанки', 'class' => 'btn btn-secondary'],
        ];
    
        return view('chunks.create', compact('pageTitle', 'buttons'));

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $data['content'] = $data['content'] ?? '';

        Chunk::create($data);

        return redirect()->route('chunks.index')->with('success', 'Чанк создан!');
    }

    public function edit($id)
    {
        $chunk = Chunk::findOrFail($id);

        $buttons = [
            ['href' => route('chunks.index'), 'label' => 'Все чанки', 'class' => 'btn btn-secondary'],
        ];

        $pageTitle = 'редактировать чанк';
        return view('chunks.edit', compact('chunk', 'buttons','pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $chunk = Chunk::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);
       
        $chunk->update($data);

        return redirect()->route('chunks.index')->with('success', $chunk->name .' обновлен!');
    }

    public function destroy($id)
    {
        $chunk = Chunk::findOrFail($id);
        $chunk->delete();

        return redirect()->route('chunks.index')->with('success', 'Чанк удален!');
    }
}
