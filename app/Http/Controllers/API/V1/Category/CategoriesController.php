<?php

namespace App\Http\Controllers\API\V1\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::latest()->paginate(10);

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            CategoryResource::collection($categories)
                ->withQuery($request->query())
                ->response()->getData(),
        );
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(CategoryRequest $request)
    {
        return success_response(
            'Category created successfully!',
            Response::HTTP_CREATED,
            new CategoryResource(Category::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            new CategoryResource($category)
        );
    }

    /**
     * Update the specified resource in database.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return success_response(
            'Category updated successfully!',
            Response::HTTP_OK,
            new CategoryResource($category)
        );
    }

    /**
     * Remove the specified resource from database
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return success_response(
            'Category deleted successfully!',
            Response::HTTP_OK,
            new CategoryResource($category)
        );
    }

    /**
     * Select categories
     * @return JsonResponse
     */
    public function selectCategories()
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            CategoryResource::collection(Category::latest()->get()),
        );
    }
}
