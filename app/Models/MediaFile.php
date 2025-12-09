<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    protected $fillable = [
        'name', 'original_name', 'path', 'extension', 
        'mime_type', 'size', 'disk', 'meta', 'user_id', 'folder_id'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(MediaFolder::class);
    }

    // URL файла
    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    // Путь к файлу
    public function getFullPathAttribute()
    {
        return Storage::disk($this->disk)->path($this->path);
    }

    // Проверка является ли изображением
    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    // Размеры для изображений
    public function getDimensionsAttribute()
    {
        if (!$this->is_image) return null;
        
        return [
            'width' => $this->meta['width'] ?? null,
            'height' => $this->meta['height'] ?? null,
        ];
    }
}