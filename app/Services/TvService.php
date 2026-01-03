<?php
namespace App\Services;

use App\Models\TvForm;
use App\Models\DocumentTvValue;
use Illuminate\Http\Request;

class TvService
{
    /**
     * Сохраняет значения TV для документа
     */
    public function saveTvValues($document, Request $request)
    {
        $tvData = $request->input('tv', []);
        
        $tvForms = TvForm::whereHas('templates', function ($q) use ($document) {
            $q->where('templates.id', $document->template_id);
        })->get();

        foreach ($tvForms as $tv) {
            $value = $tvData[$tv->id] ?? null;
            if (is_array($value)) {
                $value = $value['old'] ?? '';
            }
            if ($tv->type === 'image' && $request->hasFile("tv.$tv->id")) {
                $file = $request->file("tv.$tv->id");
                $path = $file->store('tv_images', 'public');

                 $path = str_replace('\\', '/', $path);
                 
                $value = $path;
            }
            
          

            DocumentTvValue::updateOrCreate(
                [
                    'document_id' => $document->id,
                    'tv_form_id' => $tv->id,
                ],
                [
                    //'value' => is_array($value) ? json_encode($value) : $value
                    'value' => $value

                ]
            );
        }
    }

    /**
     * Получить TV значения документа в виде ['name' => 'value']
     */
    public function getTvValuesByName($document): array
    {
        // Подгружаем relation, если ещё не загружена
        //$document->loadMissing('documentTvValues.tvForm');
        $document->loadMissing('document_tv_values.tvForm');

        $tvValues = [];
        foreach ($document->document_tv_values as $tvValue) {
            if ($tvValue->tvForm) {
                $tvValues[$tvValue->tvForm->key] = $tvValue->value;
            }
        }
        return $tvValues;
    }
}