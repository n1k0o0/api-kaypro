<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\Product\GetProductsRequest;
use App\Http\Requests\Moderators\Product\UpdateProductRequest;
use App\Http\Resources\Moderators\Product\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetProductsRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetProductsRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $limit = data_get($data, 'limit');
        $products = Product::query()
            ->when(isset($data['name']), fn(Builder $q) => $q->where('name', 'like', '%' . $data['name'] . '%'))
            ->when(
                isset($data['sort']),
                fn(Builder $query) => $query->orderBy($data['sort'], $data['sort_type'])
            );


        if ($limit) {
            return ProductResource::collection($products->latest()->paginate($limit));
        }
        return ProductResource::collection($products->get());
    }


    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return $this->respondSuccess(ProductResource::make($product->loadMissing('logo', 'video')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws Throwable
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $product->update($data);

            if (data_get($data, 'logo_upload')) {
                $product->addMediaFromRequest('logo_upload')->toMediaCollection(
                    Product::LOGO_MEDIA_COLLECTION
                );
            } elseif (array_key_exists('logo_upload', $data)) {
                $product->logo()->delete();
            }
            if (data_get($data, 'video_upload')) {
                $product->addMediaFromRequest('video_upload')->toMediaCollection(
                    Product::VIDEO_MEDIA_COLLECTION
                );
            } elseif (array_key_exists('video_upload', $data)) {
                $product->video()->delete();
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new $exception();
        }
        return $this->respondSuccess();
    }


}
