<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'headline',
        'bio',
        'email',
        'phone',
        'location',
        'avatar_url',
        'cv_url',
        'github_url',
        'linkedin_url',
        'instagram_url',
        'hero_tagline',
        'skills',
    ];

    protected $casts = [
        'skills' => 'array',
    ];

    /**
     * Helper untuk mendapatkan singleton profile.
     * Karena selalu hanya ada satu owner portfolio.
     */
    public static function singleton(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            ['name' => 'Owner']
        );
    }
}
