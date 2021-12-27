<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\Page\UpdatePagesRequest;
use App\Http\Resources\Moderators\Page\PageResource;
use App\Models\Page;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $pages = Page::query()->with(
            'banner',
            'contentImage1',
            'contentImage2',
            'sliders',
            'lineImage',
            'lineMedia',
            'instagram',
        )->get();
        return $this->respondSuccess(PageResource::collection($pages));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePagesRequest $request
     * @param Page $page
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdatePagesRequest $request, Page $page): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            logger([44, $data]);
            $page->update($data);
            if ($request->file('banner_upload')) {
                $page->addMediaFromRequest('banner_upload')->toMediaCollection(PAGE::BANNER_MEDIA_COLLECTION);
            }
            if ($request->file('contentImage1')) {
                $page->addMediaFromRequest('contentImage1')->toMediaCollection(PAGE::CONTENT_IMAGE_1_MEDIA_COLLECTION);
            }
            if ($request->file('contentImage2')) {
                $page->addMediaFromRequest('contentImage2')->toMediaCollection(PAGE::CONTENT_IMAGE_2_MEDIA_COLLECTION);
            }
            if ($request->file('lineImage')) {
                $page->addMediaFromRequest('lineImage')->toMediaCollection(Page::LINE_IMAGE_MEDIA_COLLECTION);
            }
            if ($request->file('lineMedia')) {
                $page->addMediaFromRequest('lineMedia')->toMediaCollection(Page::LINE_MEDIA_MEDIA_COLLECTION);
            }
            if (data_get($data, 'instagram')) {
                foreach ($data['instagram'] as $file) {
                    $page->addMedia($file)->toMediaCollection(Page::INSTAGRAM_MEDIA_COLLECTION);
                }
            }
            if (data_get($data, 'deleted_files')) {
                $page->instagram()->whereIn('id', $data['deleted_files'])?->delete();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $this->respondSuccess();
    }

}
