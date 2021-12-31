<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Slider extends Model implements HasMedia
{
    use HasFactory;

    use HasFactory;
    use InteractsWithMedia;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['image', 'mediaFile'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'description',
        'collection_name',
        'title',
        'title_color',
        'subtitle',
        'subtitle_color',
        'link',
        'button',
        'button_text',
        'order',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'model_id' => 'integer',
        'button' => 'boolean',
    ];

    /**
     * @return MorphOne
     */
    public function image(): morphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'default');
    }

    /**
     * @return MorphOne
     */
    public function mediaFile(): morphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'media_file');
    }


    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->singleFile();
    }
}
