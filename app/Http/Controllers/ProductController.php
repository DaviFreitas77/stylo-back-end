<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'lastPrice' => ['required', 'numeric'],
            'idCategory' => ['required', 'int'],
            'image' => ['required', 'string']
        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->lastPrice = $request->lastPrice;
        $product->fkCategory = $request->idCategory;
        $product->image = $request->image;
        $colors = json_decode($request->colors);
        $sizes = json_decode($request->sizes);
        $product->save();

        foreach ($colors as $chave) {
            $productColor = new ProductColor;
            $productColor->fkProduct = $product->id;
            $productColor->fkColor = $chave;
            $productColor->save();
        };

        foreach ($sizes as $chave) {
            $productSize  = new ProductSize;
            $productSize->fkProduct = $product->id;
            $productSize->fkSize = $chave;
            $productSize->save();
        }
        return response()->json(['message' => "Produto cadastrado"], 201);
    }
}
