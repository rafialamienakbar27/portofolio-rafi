<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'cover_image',
        'technologies',
        'demo_url',
        'repo_url',
        'category',
        'year',
        'order_column',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'year' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (empty($project->slug) && ! empty($project->title)) {
                $base = Str::slug($project->title);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $project->slug = $slug;
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_column')->orderByDesc('year');
    }
}
