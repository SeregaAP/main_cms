<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TvForm extends Model
{
    protected $fillable = [
        'name',
        'key',
        'type',
        'description',
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    /** TV может быть у многих шаблонов */
    public function templates()
    {
        return $this->belongsToMany(
            Template::class,
            'template_tv_form'
        )->withPivot('position');
    }

    /** Значения TV у документов */
    public function values()
    {
        return $this->hasMany(DocumentTvValue::class);
    }
}