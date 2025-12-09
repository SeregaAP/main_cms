<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function formTvs()
    {
        return $this->hasMany(FormTv::class, 'template_id');
    }
}