<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Product\GetProductsRequest;
use App\Http\Resources\Users\Product\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        $trainings = Product::query()
            ->with('logo')
            ->when($request->name, fn(Builder $q) => $q->where('name', 'like', '%' . $request->name . '%'))
            ->orderBy('name')
            ->paginate(20);

        return ProductResource::collection($trainings);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return void
     */
    public function show(Product $product): void
    {
        //
    }

}
