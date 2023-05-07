<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'code'           => $this->code,
            'cost'           => $this->cost,
            'price'          => $this->price,
            'image'          => storageLink($this->image),
            'note'           => $this->note,
            'stock_quantity' => $this->stock->sum('qty'),
            'brand'          => new BrandResource($this->whenLoaded('brand')),
            'category'       => new CategoryResource($this->whenLoaded('category')),
            'unit'           => new UnitResource($this->whenLoaded('unit')),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
