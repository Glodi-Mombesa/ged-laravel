<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Folder extends Model
{
    protected $fillable = [
        'name', 'slug', 'description',
        'service_id', 'parent_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function (Folder $folder) {
            if (empty($folder->slug)) {
                $folder->slug = Str::slug($folder->name);
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}