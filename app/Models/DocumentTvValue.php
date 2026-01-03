<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTvValue extends Model
{
    protected $fillable = [
        'document_id',
        'tv_form_id',
        'value',
    ];

    /** Значение принадлежит документу */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    /** Значение принадлежит TV */
    public function tvForm()
    {
        return $this->belongsTo(TvForm::class);
    }
}