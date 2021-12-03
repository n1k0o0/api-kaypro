<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\News
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string|null $published_at
 * @property int|null $moderator_id
 * @property bool $visibility 0 - Invisible, 1 - Visible
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Moderator|null $author
 * @property-read Media|null $logo
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @mixin Eloquent
 */
class News extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const LOGO_MEDIA_COLLECTION = 'logo';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
            'title',
            'text',
            'moderator_id',
            'published_at',
            'visibility',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
            'id' => 'integer',
            'moderator_id' => 'integer',
            'visibility' => 'boolean',
            'published_at' => 'datetime',
    ];

    /**
     * @param $value
     * @return string|null
     */
    public function getPublishedAtAttribute($value): ?string
    {
        return $value;
    }

    /**
     * @return MorphOne
     */
    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', self::LOGO_MEDIA_COLLECTION);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
                ->addMediaCollection('logo')
                ->singleFile();
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Moderator::class, 'moderator_id');
    }

    /**
     * Scope a query to only include visible news.
     *
     * @param $query
     * @return Builder
     */
    public function scopeVisible($query): Builder
    {
        return $query->where('visibility', 1);
    }
}
