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
        $pages = Page::query()->with('banner', 'contentImage1', 'contentImage2')->get();
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
            $page->update($request->validated());
            if ($request->file('banner_upload')) {
                $page->addMediaFromRequest('banner_upload')->toMediaCollection('banner');
            }
            if ($request->file('contentImage1')) {
                $page->addMediaFromRequest('contentImage1')->toMediaCollection('contentImage1');
            }
            if ($request->file('contentImage2')) {
                $page->addMediaFromRequest('contentImage2')->toMediaCollection('contentImage2');
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $this->respondSuccess();
    }

}
