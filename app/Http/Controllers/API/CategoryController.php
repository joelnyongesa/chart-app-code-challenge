<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $input = $request -> validate([
            'name'=>['required', 'string', 'max:255'],
            'description'=>['required', 'string', 'max:255']
        ]);

        $category = Category::create([
            'name'=>$input['name'],
            'description'=>$input['description']
        ]);

        if($category){
            return response()->json([
                'message'=>'category added successfully',
                'category'=>$category,
            ], 201);
        } else{
            return response()->json([
                'message'=>'Failed to create category',
            ], 500);
        }
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $input = $request->validate([
            'name'=>['required', 'string', 'max:255'],
            'description'=>['required', 'string', 'max:255']
        ]);

        $category = Category::findOrFail($id);
        $category->update($input);

        return response()->json([
            'message'=>'Product updated successfully',
            'category'=>$category,
        ]);
    }

    public function destroy(Category $category, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message'=>'Product deleted successfully.'
        ]);
    }
}
