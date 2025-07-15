<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string']
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
        ]);

        $existingCategpry = Category::where('name', $request->name)->first();

        if ($existingCategpry) {
            return response()->json(['message' => "Categoria ja cadastrada"], 400);
        }

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return response()->json(['message' => "categoria cadastrada"], 201);
    }

    public function fetchCategory()
    {
        $categories = Category::all();

        return response()->json($categories);
    }
}
