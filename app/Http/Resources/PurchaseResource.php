<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'supplier'         => new SupplierResource($this->supplier),
            'invoice_no'       => $this->invoice_no,
            'date'             => Carbon::parse($this->date)->format('Y-m-d H:i:s'),
            'total'            => $this->total,
            'note'             => $this->note,
            'total_qty'        => $this->purchaseDetails->sum('qty'),
            'purchase_details' => PurchaseDetailResource::collection($this->purchaseDetails),
        ];
    }
}
