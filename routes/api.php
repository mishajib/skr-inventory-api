<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{
    Brand\BrandsController,
    Category\CategoriesController,
    Product\ProductsController,
    Purchase\PurchasesController,
    Supplier\SuppliersController,
    Unit\UnitsController,
    User\UsersController
};

Route::group(['prefix' => 'v1'], function () {
    require __DIR__ . '/api/v1/auth.php';

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::apiResource('users', UsersController::class)->middleware('admin');
        Route::apiResource('brands', BrandsController::class);
        Route::apiResource('categories', CategoriesController::class);
        Route::apiResource('units', UnitsController::class);
        Route::apiResource('suppliers', SuppliersController::class);
        Route::apiResource('products', ProductsController::class);
        Route::apiResource('purchases', PurchasesController::class)->middleware('admin');

        // Select options routes
        Route::get('select-brands', [BrandsController::class, 'selectBrands']);
        Route::get('select-categories', [CategoriesController::class, 'selectCategories']);
        Route::get('select-units', [UnitsController::class, 'selectUnits']);
        Route::get('select-suppliers', [SuppliersController::class, 'selectSuppliers']);
        Route::get('select-products', [ProductsController::class, 'selectProducts']);
    });
});
