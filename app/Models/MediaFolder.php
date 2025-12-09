<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFolder extends Model
{
    protected $table = 'folders';
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(MediaFolder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MediaFolder::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(MediaFile::class);
    }

    // Полный путь папки
    public function getFullPathAttribute()
    {
        $path = [];
        $folder = $this;
        
        while ($folder) {
            $path[] = $folder->slug;
            $folder = $folder->parent;
        }
        
        return implode('/', array_reverse($path));
    }
}