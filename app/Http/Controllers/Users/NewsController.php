<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\News\GetNewsRequest;
use App\Http\Resources\Users\News\NewsResource;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        /** @noinspection PhpUndefinedMethodInspection */
        $news = News::query()
            ->visible()
            ->with('logo')
            ->when($request->date_from, fn(Builder $q) => $q->whereDate('published_at', '>=', $request->date_from))
            ->when($request->date_to, fn(Builder $q) => $q->whereDate('published_at', '<=', $request->date_to))
            ->orderBy('published_at')
            ->select('id', 'title', 'meta_slug', 'published_at')
            ->paginate(20);

        return NewsResource::collection($news);
    }


    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return JsonResponse
     */
    public function show(News $news): JsonResponse
    {
        return $this->respondSuccess(NewsResource::make($news->loadMissing('logo')));
    }
}
