<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Training extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const LOGO_MEDIA_COLLECTION = 'logo';
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
            'id' => 'integer',
            'is_visible' => 'boolean',
            'seats' => 'integer',
            'empty_seats' => 'integer',
            'days' => 'array',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function booted(): void
    {
        self::creating(function ($model) {
            $model->empty_seats = $model->seats;
        });
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
    }

}
