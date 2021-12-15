<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\ProductCategory
 *
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property bool $mobile_visibility
 * @property int $order
 * @property int|null $parent_id
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string $meta_slug
 * @property string|null $meta_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Media|null $banner
 * @property-read Media|null $logo
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @mixin Eloquent
 */
class ProductCategory extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const LOGO_MEDIA_COLLECTION = 'logo';
    public const BANNER_MEDIA_COLLECTION = 'banner';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'parent_id',
        'mobile_visibility',
        'order',
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
        'parent_id' => 'integer',
        'mobile_visibility' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->meta_slug = Str::slug($model->title);
        });

        static::saving(static function ($model) {
            $model->meta_slug = Str::slug($model->title);
        });
    }

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
    public function banner(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', self::BANNER_MEDIA_COLLECTION);
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
            ->addMediaCollection('banner')
            ->singleFile();
    }
}
