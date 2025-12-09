<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DocumentTv extends Model
{
    protected $table = 'document_tvs';

    protected $fillable = ['document_id','form_tv_id','value','name'];

    protected $casts = [
        'value' => 'array',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function formTv()
    {
        return $this->belongsTo(FormTv::class, 'form_tv_id');
    }

    // очистка кеша документов при изменении tv
    protected static function booted()
    {
        static::saved(function ($tv) {
            \App\Models\Document::clearAllDocumentCache(); // если у тебя есть метод как раньше
        });
        static::deleted(function ($tv) {
            \App\Models\Document::clearAllDocumentCache();
        });
    }

    
}