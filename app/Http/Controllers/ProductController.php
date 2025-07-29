<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
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
        $product->news = $request->news;
        $colors = $request->colors;
        $sizes =  $request->sizes;
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

    public function fetchProduct()
    {
        $products = Product::with(['category', 'colors', 'sizes'])->get();

        $result = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "lastPrice" => $product->lastPrice,
                "image" => $product->image,
                "category" => $product->category,
                "colors" => $product->colors->map(function ($color) {
                    return [
                        "id" => $color->id,
                        "name" => $color->name,
                    ];
                }),
                "sizes" => $product->sizes->map(function ($size) {
                    return [
                        "id" => $size->id,
                        "name" => $size->name,
                    ];
                })
            ];
        });



        return response()->json($result);
    }

    public function featuredProducts()
    {
        $product = Product::where('news', '=', '1')->get();

        return response()->json($product);
    }

    public function fetchProductId($id)
    {
        $product = Product::with(['category', 'colors', 'sizes'])->where('id', $id)->first();

        $result = [

            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "lastPrice" => $product->lastPrice,
            "image" => $product->image,
            "description" => $product->description,
            "colors" => $product->colors->map(function($colors){
                return[
                 "id" => $colors->id,
                 "name" => $colors->name   
                ];
            }),
            "sizes" => $product->sizes->map(function($sizes){
                return [
                    "id" => $sizes->id,
                    "name" => $sizes->name,
                ];
            })

        ];


        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json($result);
    }
}
