<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const BANNER_MEDIA_COLLECTION = 'banner';
    public const CONTENT_IMAGE_1_MEDIA_COLLECTION = 'contentImage1';
    public const CONTENT_IMAGE_2_MEDIA_COLLECTION = 'contentImage2';

    public const FEEDBACK_TYPE_SUPPORT = 'support',
        FEEDBACK_TYPE_APPEAL = 'appeal',
        FEEDBACK_TYPE_REQUEST = 'request',
        FEEDBACK_TYPE_COOPERATION = 'cooperation';
    public const FEEDBACK_TYPES_TEXT = [
        self::FEEDBACK_TYPE_SUPPORT => 'Поддержка',
        self::FEEDBACK_TYPE_APPEAL => 'Обращение',
        self::FEEDBACK_TYPE_REQUEST => 'Запрос технологу',
        self::FEEDBACK_TYPE_COOPERATION => 'Сотрудничество'
    ];
    public const FEEDBACK_TYPES = [
        self::FEEDBACK_TYPE_SUPPORT,
        self::FEEDBACK_TYPE_APPEAL,
        self::FEEDBACK_TYPE_REQUEST,
        self::FEEDBACK_TYPE_COOPERATION
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'content',
        'meta_description',
        'meta_title',
        'meta_h1',
        'meta_keywords',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'content' => 'array',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    public static function booted(): void
    {
        static::saving(static function ($model) {
            if ($model->name === 'help' || $model->name === 'document') {
                $cont = (array)$model->content;
                foreach ($cont as $key => $value) {
                    if (empty($value['title'])) {
                        throw ValidationException::withMessages(
                            ['title' => 'The Section title is required']
                        );
                    }
                    $cont[$key]['meta_slug'] = Str::slug($value['title']);
                }
                $model->content = json_encode($cont, JSON_THROW_ON_ERROR);
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }

    /**
     * @param $value
     * @return void
     * @throws \JsonException
     */
    public function setContentAttribute($value): void
    {
        $this->attributes['content'] = json_decode(
            json_encode($value, JSON_THROW_ON_ERROR),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
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
    public function contentImage1(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', self::CONTENT_IMAGE_1_MEDIA_COLLECTION);
    }

    /**
     * @return MorphOne
     */
    public function contentImage2(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', self::CONTENT_IMAGE_2_MEDIA_COLLECTION);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('banner')
            ->singleFile();
        $this
            ->addMediaCollection('contentImage1')
            ->singleFile();
        $this
            ->addMediaCollection('contentImage2')
            ->singleFile();
    }
}
