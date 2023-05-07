<?php

namespace App\Http\Controllers\API\V1\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\PurchaseRequest;
use App\Http\Resources\Purchase2Resource;
use App\Http\Resources\PurchaseResource;
use App\Models\Product;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchases = Purchase::latest()->paginate(10);

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            PurchaseResource::collection($purchases)
                ->withQuery($request->query())
                ->response()->getData(),
        );
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $purchaseData  = $request->except(['products']);
            $purchaseItems = $request->get('products');

            // Get total purchase amount
            $purchaseData['total'] = PurchaseService::getPurchaseTotal($purchaseItems);

            // Create purchase
            $purchase = Purchase::create($purchaseData);


            // Create purchase items
            PurchaseService::createPurchaseDetails($purchaseItems, $purchase);

            DB::commit();

            return success_response(
                'Purchase created successfully!',
                Response::HTTP_CREATED,
                new PurchaseResource($purchase)
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return error_response(
                'Something went wrong, please try again!',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [
                    'message' => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
                    'trace'   => $e->getTraceAsString(),
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public
    function show(Purchase $purchase)
    {
        $purchase->load(['purchaseDetails', 'supplier', 'purchaseDetails.product']);
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            new Purchase2Resource($purchase)
        );
    }

    /**
     * Update the specified resource in database.
     */
    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        try {
            DB::beginTransaction();

            $purchase->load(['purchaseDetails', 'supplier', 'purchaseDetails.product']);

            $purchaseData  = $request->except(['products']);
            $purchaseItems = $request->get('products');

            // Get total purchase amount
            $purchaseData['total'] = PurchaseService::getPurchaseTotal($purchaseItems);

            // Update purchase
            $purchase->update($purchaseData);

            // Delete old purchase items
            $purchase->purchaseDetails()->delete();

            // Create purchase items
            PurchaseService::updatePurchaseDetails($purchaseItems, $purchase);

            DB::commit();

            return success_response(
                'Purchase updated successfully!',
                Response::HTTP_OK,
                new PurchaseResource($purchase->refresh())
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return error_response(
                'Something went wrong, please try again!',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [
                    'message' => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
                    'trace'   => $e->getTraceAsString(),
                ]
            );
        }
    }

    /**
     * Remove the specified resource from database
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return success_response(
            'Purchase deleted successfully!',
            Response::HTTP_OK,
            new PurchaseResource($purchase)
        );
    }
}
