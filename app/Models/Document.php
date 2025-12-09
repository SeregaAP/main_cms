<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Document extends Model
{
    protected $fillable = ['title', 'alias', 'content', 'parent_id', 'published', 'type', 'uri','template_id'];

    public function parent()
    {
        return $this->belongsTo(Document::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Document::class, 'parent_id');
    }

    protected static function booted()
    {
        static::creating(function ($document) {
            // Генерация alias заранее
            if (!$document->alias) {
                $document->alias = Str::slug($document->title);
            }
        });

        static::saving(function ($document) {
            // Строим URI через parent_id рекурсивно
            $document->uri = $document->buildUri();
        });

        // ✅ Очищаем кеш при сохранении документа
        static::saved(function ($document) {
            //Cache::forget('document_html_' . $document->id);
            self::clearAllDocumentCache();
        });

        // ✅ Очищаем кеш при удалении документа
        static::deleted(function ($document) {
            //Cache::forget('document_html_' . $document->id);
            self::clearAllDocumentCache();
        });
    }

    public static function clearAllDocumentCache()
    {
        $store = \Cache::store(config('cache.default'));
        foreach (self::all(['id']) as $doc) {
            $store->forget('document_html_' . $doc->id);
        }
    }

    public function buildUri(): string
    {
        if ($this->parent_id) {
            $parent = self::find($this->parent_id);
            if ($parent) {
                // Рекурсивно строим URI родителя
                return rtrim($parent->buildUri(), '/') . '/' . $this->alias;
            }
        }
        return '/' . $this->alias;
    }

    public function updateUriRecursively(): void
    {
        //$oldCacheKey = 'document_html_' . $this->getOriginal('id');
        //Cache::forget($oldCacheKey);

        // Сначала обновляем свой URI
        $this->uri = $this->buildUri();
        $this->saveQuietly(); // без вызова событий saving, чтобы избежать рекурсии

        //Cache::forget('document_html_' . $this->id);

        // Потом обновляем URI всех детей
        foreach ($this->children as $child) {
            $child->updateUriRecursively();
        }
    }

    public function isDescendantOf(Document $doc): bool
    {
        return str_starts_with($this->uri, rtrim($doc->uri, '/') . '/');
    }

    public function allDescendants()
    {
        $descendants = collect();
    
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->allDescendants());
        }
    
        return $descendants;
    }


    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function tvs()
    {
        return $this->hasMany(DocumentTv::class, 'document_id');
    }
}