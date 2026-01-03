<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'alias',
        'description',
        'content',
        'is_active',
        'sort_order'
    ];

    /**
     * Отношение к документам
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function tvForms()
{
    return $this->belongsToMany(
        TvForm::class,
        'template_tv_form'
    )->withPivot('position')->orderBy('pivot_position');
}
}