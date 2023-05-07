<?php

namespace App\Http\Controllers\API\V1\Brand;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::latest()->paginate(10);

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            BrandResource::collection($brands)
                ->withQuery($request->query())
                ->response()->getData(),
        );
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(BrandRequest $request)
    {
        return success_response(
            'Brand created successfully!',
            Response::HTTP_CREATED,
            new BrandResource(Brand::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            new BrandResource($brand)
        );
    }

    /**
     * Update the specified resource in database.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());

        return success_response(
            'Brand updated successfully!',
            Response::HTTP_OK,
            new BrandResource($brand)
        );
    }

    /**
     * Remove the specified resource from database
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return success_response(
            'Brand deleted successfully!',
            Response::HTTP_OK,
        );
    }

    /**
     * Select brands
     * @return JsonResponse
     */
    public function selectBrands()
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            BrandResource::collection(Brand::latest()->get()),
        );
    }
}
