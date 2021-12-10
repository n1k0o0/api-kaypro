<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\News\CreateNewsRequest;
use App\Http\Requests\Moderators\News\GetNewsRequest;
use App\Http\Requests\Moderators\News\UpdateNewsRequest;
use App\Http\Resources\Moderators\News\NewsResource;
use App\Models\News;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetNewsRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetNewsRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $limit = data_get($data, 'limit');
        $trainings = News::query()
            ->with('logo', 'author')
            ->when(isset($data['name']), fn(Builder $q) => $q->where('name', 'like', '%' . $data['name'] . '%'))
            ->when(
                isset($data['published_at']),
                fn(Builder $q) => $q->whereDate('published_at', $data['published_at'])
            )
            ->when(
                isset($data['sort']),
                fn(Builder $query) => $query->orderBy($data['sort'], $data['sort_type'])
            );

        if ($limit) {
            return NewsResource::collection($trainings->latest()->paginate($limit));
        }
        return NewsResource::collection($trainings->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateNewsRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CreateNewsRequest $request): JsonResponse
    {
        try {
            /* @var News $news */
            DB::beginTransaction();
            $news = News::query()->create($request->safe()->merge(['moderator_id' => auth()->id()])->all());

            if (data_get($request, 'logo_upload')) {
                $news->addMediaFromRequest('logo_upload')->toMediaCollection(News::LOGO_MEDIA_COLLECTION);
            }
            if (data_get($request, 'banner_upload')) {
                $news->addMediaFromRequest('banner_upload')->toMediaCollection(News::BANNER_MEDIA_COLLECTION);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return JsonResponse
     */
    public function show(News $news): JsonResponse
    {
        return $this->respondSuccess(NewsResource::make($news->loadMissing('banner')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNewsRequest $request
     * @param News $news
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws Throwable
     */
    public function update(UpdateNewsRequest $request, News $news): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $news->update($data);
            if (data_get($data, 'logo_upload')) {
                $news->addMediaFromRequest('logo_upload')->toMediaCollection(News::LOGO_MEDIA_COLLECTION);
            }
            if (data_get($request, 'banner_upload')) {
                $news->addMediaFromRequest('banner_upload')->toMediaCollection(News::BANNER_MEDIA_COLLECTION);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }


        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return JsonResponse
     */
    public function destroy(News $news): JsonResponse
    {
        $news->delete();
        return $this->respondSuccess();
    }
}
