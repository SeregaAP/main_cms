<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Template;
use App\Models\DocumentTvValue;
use App\Models\TvForm;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'title',
        'content',
        'type',
        'meta_title',
        'meta_description',
        'alias',
        'parent_id',
        'position',
        'format',
        'user_id',
        'published',
        'show_in_menu',
        'template_id',
        'is_cache',
        'full_path', // Добавляем новое поле
    ];

    protected $casts = [
        'published' => 'boolean',
        'show_in_menu' => 'boolean',
        'is_cache' => 'boolean',
        'parent_id' => 'integer',
        'user_id' => 'integer',
        'position' => 'integer',
    ];

    // Добавляем виртуальный атрибут для URL
    protected $appends = ['full_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Document::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Document::class, 'parent_id')->orderBy('position');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function generateFullPath(): string
    {
        if (!$this->parent_id) {
            return $this->alias;
        }
    
        return $this->parent->full_path . '/' . $this->alias;
    }

    public function refreshFullPathRecursively(): void
    {
        $this->full_path = $this->generateFullPath();
        $this->save();
    
        foreach ($this->children as $child) {
            $child->refreshFullPathRecursively();
        }
    }

    /**
     * Получить полный URL
     */
    public function getFullUrlAttribute()
    {
        return url('/' . $this->full_path);
    }

    /**
     * Получить цепочку родителей (для хлебных крошек)
     */
    public function getBreadcrumbs()
    {
        $breadcrumbs = collect();
        $current = $this;
        
        while ($current) {
            $breadcrumbs->prepend([
                'title' => $current->title,
                'url' => $current->full_url,
            ]);
            $current = $current->parent;
        }
        
        return $breadcrumbs;
    }

    /**
     * Проверить уникальность полного пути
     */
    public static function isFullPathUnique($fullPath, $excludeId = null)
    {
        $query = self::where('full_path', $fullPath);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return !$query->exists();
    }

    /**
     * Создать полный путь из алиаса и родителя
     */
    public static function buildFullPath($alias, $parentId = null)
    {
        if (!$parentId) {
            return $alias;
        }
        
        $parent = self::find($parentId);
        if (!$parent) {
            return $alias;
        }
        
        return $parent->full_path . '/' . $alias;
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function tv(string $key, $default = null)
    {
        return optional(
            $this->tvValues
                ->loadMissing('tvForm')
                ->firstWhere('tvForm.key', $key)
        )->value ?? $default;
    }

    public function document_tv_values()
    {
        return $this->hasMany(DocumentTvValue::class, 'document_id', 'id');
    }

    public function tvForms()
    {
        return TvForm::all(); // можно хранить отдельно в сервисе, если много
    }

    public function getTvValuesByName($document): array
    {
        // Загружаем все TV значения документа вместе с формой
        $tvValues = DocumentTvValue::where('document_id', $document->id)
            ->with('tvForm') // связь tvForm должна быть в модели DocumentTvValue
            ->get();

        // Преобразуем коллекцию в массив вида ['name' => 'value']
        return $tvValues->mapWithKeys(function ($tvValue) {
            return [$tvValue->tvForm->name => $tvValue->value];
        })->toArray();
    }

    public function getTvValue($document, string $name, $default = null)
    {
        $values = $this->getTvValuesByName($document);
        return $values[$name] ?? $default;
    }
}