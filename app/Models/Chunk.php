<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use App\Models\Document; // важно добавить!

class Chunk extends Model
{
    protected $fillable = ['name', 'content'];

    public static function render($name, $variables = [])
    {
        $chunk = Cache::rememberForever("chunk_{$name}", function () use ($name) {
            return self::where('name', $name)->first();
        });

        if (!$chunk) {
            return "<!-- Чанк '{$name}' не найден -->";
        }

        return Blade::render($chunk->content, $variables);
    }

    protected static function booted()
    {
        static::saved(function ($chunk) {
            Cache::forget("chunk_{$chunk->name}");

            // 💥 Теперь очищаем кэш всех документов
            Document::clearAllDocumentCache();
        });

        static::deleted(function ($chunk) {
            Cache::forget("chunk_{$chunk->name}");

            // 💥 И при удалении тоже
            Document::clearAllDocumentCache();
        });
    }
}