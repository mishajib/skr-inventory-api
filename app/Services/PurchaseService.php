<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Purchase;

class PurchaseService
{
    /**
     * Get purchase total
     * @param $purchaseItems
     * @return float|int
     */
    public static function getPurchaseTotal($purchaseItems): float|int
    {
        $total = 0;
        foreach ($purchaseItems as $item) {
            $total += (int)$item['qty'] * (double)$item['price'];
        }

        return $total;
    }

    /**
     * Create purchase details
     * @param array $purchaseItems
     * @param Purchase $purchase
     * @return void
     */
    public static function createPurchaseDetails(array $purchaseItems, Purchase $purchase): void
    {
        foreach ($purchaseItems as $purchaseItem) {
            $purchaseItem['purchase_id'] = $purchase->id;
            $priceTotal                  = (double)$purchaseItem['price'] * (int)$purchaseItem['qty'];
            $purchaseItem['total']       = $priceTotal;
            $purchase->purchaseDetails()->create($purchaseItem);

            // Update product quantity and purchase price/cost
            $product = Product::find($purchaseItem['product_id']);
            if ($product) {
                $product->update([
                    'cost' => $purchaseItem['price']
                ]);

                // Add quantity to product stock
                $product->stock()->create([
                    'qty' => $purchaseItem['qty']
                ]);
            }
        }
    }

    /**
     * Update purchase details
     * @param array $purchaseItems
     * @param Purchase $purchase
     * @return void
     */
    public static function updatePurchaseDetails(array $purchaseItems, Purchase $purchase): void
    {
        // Decrease product stock
        self::decreaseProductStock($purchase);

        foreach ($purchaseItems as $purchaseItem) {
            $purchaseItem['purchase_id'] = $purchase->id;
            $priceTotal                  = (double)$purchaseItem['price'] * (int)$purchaseItem['qty'];
            $purchaseItem['total']       = $priceTotal;
            $purchase->purchaseDetails()->create($purchaseItem);

            // Update product quantity and purchase price/cost
            $product = Product::find($purchaseItem['product_id']);
            if ($product) {
                $product->update([
                    'cost' => $purchaseItem['price']
                ]);

                // Add quantity to product stock
                $product->stock()->create([
                    'qty' => $purchaseItem['qty']
                ]);
            }
        }
    }

    /**
     * Decrease product stock
     * @param Purchase $purchase
     * @return void
     */
    public static function decreaseProductStock(Purchase $purchase): void
    {
        foreach ($purchase->purchaseDetails as $purchaseDetail) {
            $product = Product::find($purchaseDetail->product_id);

            if ($product) {
                foreach ($product->stock as $stock) {
                    if ($stock->qty >= $purchaseDetail->qty) {
                        $stock->update([
                            'qty' => $stock->qty - $purchaseDetail->qty
                        ]);
                        break;
                    } else {
                        $purchaseDetail->qty -= $stock->qty;
                        $stock->delete();
                    }
                }
            }
        }
    }

}
