<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\Page\PageResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return JsonResponse
     */
    public function show(Page $page): JsonResponse
    {
        return $this->respondSuccess(
            PageResource::make(
                $page->loadMissing(
                    'banner',
                    'contentImage1',
                    'contentImage2',
                    'lineMedia',
                    'lineImage',
                    'instagram',
                    'sliders'
                )
            )
        );
    }

}
