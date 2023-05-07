<?php

namespace App\Http\Controllers\API\V1\Unit;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\UnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = Unit::latest()->paginate(10);

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            UnitResource::collection($units)
                ->withQuery($request->query())
                ->response()->getData(),
        );
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(UnitRequest $request)
    {
        return success_response(
            'Unit created successfully!',
            Response::HTTP_CREATED,
            new UnitResource(Unit::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            new UnitResource($unit)
        );
    }

    /**
     * Update the specified resource in database.
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());

        return success_response(
            'Unit updated successfully!',
            Response::HTTP_OK,
            new UnitResource($unit)
        );
    }

    /**
     * Remove the specified resource from database
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return success_response(
            'Unit deleted successfully!',
            Response::HTTP_OK,
            new UnitResource($unit)
        );
    }

    /**
     * Select units
     * @return JsonResponse
     */
    public function selectUnits()
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            UnitResource::collection(Unit::latest()->get()),
        );
    }
}
