<?php

namespace App\Http\Controllers\API\V1\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::latest()->paginate(10);

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            SupplierResource::collection($suppliers)
                ->withQuery($request->query())
                ->response()->getData(),
        );
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(SupplierRequest $request)
    {
        return success_response(
            'Supplier created successfully!',
            Response::HTTP_CREATED,
            new SupplierResource(Supplier::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            new SupplierResource($supplier)
        );
    }

    /**
     * Update the specified resource in database.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return success_response(
            'Supplier updated successfully!',
            Response::HTTP_OK,
            new SupplierResource($supplier)
        );
    }

    /**
     * Remove the specified resource from database
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return success_response(
            'Supplier deleted successfully!',
            Response::HTTP_OK,
            new SupplierResource($supplier)
        );
    }

    /**
     * Select suppliers
     * @return JsonResponse
     */
    public function selectSuppliers()
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            SupplierResource::collection(Supplier::latest()->get()),
        );
    }
}
