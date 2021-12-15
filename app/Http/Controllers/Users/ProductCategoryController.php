<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ProductCategory\GetProductCategoriesRequest;
use App\Http\Resources\Users\ProductCategory\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        $categories = ProductCategory::query()
            ->with('logo')
            ->when($request->title, fn(Builder $q) => $q->where('title', 'like', '%' . $request->title . '%'))
            ->orderBy('order')
            ->select('id', 'title', 'meta_slug', 'order', 'subtitle')
            ->paginate(20);

        return ProductCategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param ProductCategory $product_category
     * @return JsonResponse
     */
    public function show(ProductCategory $product_category): JsonResponse
    {
        return $this->respondSuccess(
            ProductCategoryResource::make($product_category->loadMissing('banner', 'parent', 'subcategories'))
        );
    }


}
