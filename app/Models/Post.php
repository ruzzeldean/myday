<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Override;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable(['title', 'image', 'content'])]
class Post extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    // UUID-based post slug generation
    #[Override]
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn () => Str::uuid()->toString())
            ->saveSlugsTo('uuid')
            ->doNotGenerateSlugsOnUpdate();
    }

    // Post to User model eloquent relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Delete image when force deleting
    #[Override]
    protected static function booted()
    {
        static::forceDeleted(function (Post $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }
}
