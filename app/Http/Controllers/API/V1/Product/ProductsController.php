<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::latest()->with(['brand', 'stock', 'unit', 'category'])->paginate(10);

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            ProductResource::collection($products)
                ->withQuery($request->query())
                ->response()->getData(),
        );
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->except(['image', 'quantity']);

        if ($request->hasFile('image')) {
            $data['image'] = imageUploadHandler(
                $request->file('image'),
                'products',
                '256x256'
            );
        }

        $product = Product::create($data);

        $product->stock()->create(['qty' => $request->quantity]);

        return success_response(
            'Product created successfully!',
            Response::HTTP_CREATED,
            new ProductResource($product)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['brand', 'stock', 'unit', 'category']);
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            new ProductResource($product)
        );
    }

    /**
     * Update the specified resource in database.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->except(['image', '_method']);

        if ($request->hasFile('image')) {
            $data['image'] = imageUploadHandler(
                $request->file('image'),
                'products',
                '256x256',
                $product->image
            );
        }

        $product->update($data);


        return success_response(
            'Product updated successfully!',
            Response::HTTP_OK,
            new ProductResource($product)
        );
    }

    /**
     * Remove the specified resource from database
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return success_response(
            'Product deleted successfully!',
            Response::HTTP_OK,
            new ProductResource($product)
        );
    }

    /**
     * Select products
     * @return JsonResponse
     */
    public function selectProducts(Request $request)
    {
        $products = Product::query()
            ->where('name', 'LIKE', '%' . $request->query('search') . '%')
            ->orWhere('code', 'LIKE', '%' . $request->query('search') . '%')
            ->take(10)->get();

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            ProductResource::collection($products),
        );
    }
}
