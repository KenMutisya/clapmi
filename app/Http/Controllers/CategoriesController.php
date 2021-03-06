<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function create()
    {
        //
    }

    public function store(CreateCategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();

        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
                'name' => 'required|string|max:255',
        ]);

        $category->name = $request->name;
        $category->save();

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->forceDelete();

        return response()->json([
                'message' => 'Category deleted successfully',
        ]);
    }
}