<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const LOGO_MEDIA_COLLECTION = 'logo';
    public const VIDEO_MEDIA_COLLECTION = 'video';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_1c',
        'barcode',
        'vendor_code',
        'count',
        'name',
        'unit',
        'category',
        'volume',
        'weight',
        'dimension',
        'characteristic',
        'full_description',
        'composition',
        'country',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_slug',
        'meta_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'count' => 'integer',
        'barcode' => 'integer',
        'weight' => 'double',
        'status' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'meta_slug';
    }

    /**
     * @return MorphOne
     */
    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', self::LOGO_MEDIA_COLLECTION);
    }

    /**
     * @return MorphOne
     */
    public function video(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', self::VIDEO_MEDIA_COLLECTION);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile();
        $this
            ->addMediaCollection('video')
            ->singleFile();
    }
}
