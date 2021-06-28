<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Category;
use App\Jobs\CategoryCreated;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function create(Request $request)
    {
        // TODO validation logic
        $category = Category::create([
            'title' => $request->title
        ]);

        CategoryCreated::dispatch($category->toArray())->onQueue('category');


        // TODO handle validation errors in Handlers

        // Fire an event category:create

        return response()->json($category);
    }

    public function destroy($category_id)
    {
        $category = Category::find($category_id);
        $category->delete();
        return response()->json([]);
    }
}
