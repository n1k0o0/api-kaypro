<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Training
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $location
 * @property string $date
 * @property string $duration
 * @property string $city
 * @property string|null $price
 * @property string $lecturer
 * @property string|null $lecturer_description
 * @property string $lecturer_position
 * @property array|null $days
 * @property int $seats
 * @property int $empty_seats
 * @property string $status
 * @property bool $is_visible 0 - Invisible, 1 - Visible
 * @property bool $is_online 0 - Offline, 1 - Online
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|ApplicationTraining[] $applications
 * @property-read int|null $applications_count
 * @property-read Media|null $lecturerAvatar
 * @property-read Media|null $logo
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static Builder|Training visible()
 * @mixin Eloquent
 */
class Training extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const LOGO_MEDIA_COLLECTION = 'logo';
    public const BANNER_MEDIA_COLLECTION = 'banner';
    public const LECTURER_AVATAR_MEDIA_COLLECTION = 'lecturer_avatar';

    public const STATUS_PLANNED = 'planned',
        STATUS_CONTINUES = 'continues',
        STATUS_COMPLETED = 'completed';

    public const STATUSES = [
        self::STATUS_PLANNED,
        self::STATUS_CONTINUES,
        self::STATUS_COMPLETED
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'city',
        'location',
        'date',
        'duration',
        'price',
        'lecturer',
        'lecturer_position',
        'lecturer_description',
        'seats',
        'days',
        'empty_seats',
        'status',
        'is_visible',
        'is_online',
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
        'price' => 'integer',
        'is_visible' => 'boolean',
        'is_online' => 'boolean',
        'seats' => 'integer',
        'empty_seats' => 'integer',
        'days' => 'array',
        'date' => 'datetime',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function booted(): void
    {
        self::creating(static function ($model) {
            $model->empty_seats = $model->seats;
            $model->meta_slug = Str::slug($model->name);
        });
        static::saving(static function ($model) {
            $model->meta_slug = Str::slug($model->name);
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
     * @param $value
     * @return string|null
     */
    public function getDateAttribute($value): ?string
    {
        return Carbon::make($value)?->toDateString();
    }

    /**
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(ApplicationTraining::class);
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
     * @return MorphOne
     */
    public function lecturerAvatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', self::LECTURER_AVATAR_MEDIA_COLLECTION);
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
            ->addMediaCollection('lecturer_avatar')
            ->singleFile();
        $this
            ->addMediaCollection('banner')
            ->singleFile();
    }

    /**
     * Scope a query to only include visible training.
     *
     * @param $query
     * @return Builder
     */
    public function scopeVisible($query): Builder
    {
        return $query->where('is_visible', 1);
    }

    /**
     * Scope a query to only include visible training.
     *
     * @param $query
     * @return Builder
     */
    public function scopeActive($query): Builder
    {
        return $query->where('status', '<>', self::STATUS_COMPLETED);
    }

    /**
     * @return bool
     */
    public function notStarted(): boolean
    {
        return $this->status === self::STATUS_PLANNED;
    }

}
