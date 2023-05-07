<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id, // add this line to get the product_id
            'product'    => new ProductResource($this->product),
            'qty'        => $this->qty,
            'price'      => $this->price,
            'total'      => $this->total
        ];
    }
}
