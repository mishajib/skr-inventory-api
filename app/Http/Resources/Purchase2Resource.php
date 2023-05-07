<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class Purchase2Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date'              => Carbon::parse($this->date)->format('Y-m-d H:i:s'),
            'invoice_no'        => $this->invoice_no,
            'supplier_id'       => $this->supplier_id,
            'note'              => $this->note,
            'products'          => PurchaseDetail2Resource::collection($this->purchaseDetails),
            'selected_products' => PurchaseDetail3Resource::collection($this->purchaseDetails),
        ];
    }
}
