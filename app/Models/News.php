<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
            'visibility' => 'integer',
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

}
