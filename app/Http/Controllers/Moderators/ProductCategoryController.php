<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\ProductCategory\GetProductCategoriesRequest;
use App\Http\Requests\Moderators\ProductCategory\UpdateProductCategoryRequest;
use App\Http\Resources\Moderators\ProductCategory\ProductCategoryResource;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetProductCategoriesRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetProductCategoriesRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $limit = data_get($data, 'limit');
        $categories = ProductCategory::query()
            ->with('logo', 'parent')
            ->when(isset($data['title']), fn(Builder $q) => $q->where('title', 'like', '%' . $data['title'] . '%'))
            ->when(
                isset($data['sort']),
                fn(Builder $query) => $query->orderBy($data['sort'], $data['sort_type'])
            )
            ->orderBy('order');

        if ($limit) {
            return ProductCategoryResource::collection($categories->latest()->paginate($limit));
        }
        return ProductCategoryResource::collection($categories->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(): void
    {
    }

    /**
     * Display the specified resource.
     *
     * @param ProductCategory $productCategory
     * @return JsonResponse
     */
    public function show(ProductCategory $productCategory): JsonResponse
    {
        return $this->respondSuccess(
            ProductCategoryResource::make(
                $productCategory->loadMissing('banner', 'parent', 'bannerMenu', 'bannerMobile', 'slider', 'logo')
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductCategoryRequest $request
     * @param ProductCategory $product_category
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws Throwable
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $product_category): JsonResponse
    {
        try {
            DB::beginTransaction();
            $product_category->update($request->validated());
            $data = $request->validated();
            if (data_get($data, 'logo_upload')) {
                $product_category->addMediaFromRequest('logo_upload')->toMediaCollection(
                    ProductCategory::LOGO_MEDIA_COLLECTION
                );
            } elseif (array_key_exists('logo_upload', $data)) {
                $product_category->logo()->delete();
            }
            if (data_get($request, 'banner_upload')) {
                $product_category->addMediaFromRequest('banner_upload')->toMediaCollection(
                    ProductCategory::BANNER_MEDIA_COLLECTION
                );
            } elseif (array_key_exists('banner_upload', $data)) {
                $product_category->banner()->delete();
            }
            if (data_get($request, 'banner_menu_upload')) {
                $product_category->addMediaFromRequest('banner_menu_upload')->toMediaCollection(
                    ProductCategory::BANNER_MENU_MEDIA_COLLECTION
                );
            } elseif (array_key_exists('banner_menu_upload', $data)) {
                $product_category->banner()->delete();
            }
            if (data_get($request, 'banner_mobile_upload')) {
                $product_category->addMediaFromRequest('banner_mobile_upload')->toMediaCollection(
                    ProductCategory::BANNER_MOBILE_MEDIA_COLLECTION
                );
            } elseif (array_key_exists('banner_mobile_upload', $data)) {
                $product_category->banner()->delete();
            }
            if (data_get($data, 'slider_upload')) {
                foreach ($data['slider_upload'] as $file) {
                    $product_category->addMedia($file)->toMediaCollection(ProductCategory::SLIDER_MEDIA_COLLECTION);
                }
            }
            if (data_get($data, 'deleted_files')) {
                $product_category->slider()->whereIn('id', $data['deleted_files'])?->delete();
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new $exception();
        }
        return $this->respondSuccess();
    }

}
