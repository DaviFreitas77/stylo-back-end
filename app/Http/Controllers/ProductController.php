<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function createProduct(Request $request)
    {

        if ($request->user()->role !== 'adm') {
            return response()->json(['error' => 'Acesso não autorizado'], 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'idCategory' => ['required', 'int'],

        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->lastPrice = $request->lastPrice;
        $product->fkCategory = $request->idCategory;
        $product->news = $request->news;
        $variation = $request->variation;
        $product->save();

        foreach ($variation as $productVariation) {

            foreach ($productVariation['sizes'] as $size) {
                $variations = new ProductVariacoes;
                $variations->fkProduto = $product->id;
                $variations->fkColor = $productVariation['colorId'];
                $variations->image = $productVariation['imageUrl'];
                $variations->fkSize = $size;
                $variations->save();
            }
        }

        return response()->json(['message' => "Produto cadastrado"], 201);
    }

    public function fetchProduct()
    {
        $products = Product::with(['category', 'variations.color', 'variations.size', 'variations'])->get();

        $result = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "lastPrice" => $product->lastPrice,
                'description' => $product->description,
                "category" => $product->category,
                "image" => $product->variations->first()->image,
                "variations" => $product->variations->map(function ($variation) {
                    return [
                        "id" => $variation->id,
                        "image" => $variation->image,
                        "color" => [
                            "id" => $variation->color->id ?? null,
                            "name" => $variation->color->name ?? null,
                        ],
                        "size" => [
                            "id" => $variation->size->id ?? null,
                            "name" => $variation->size->name ?? null,
                        ],
                    ];
                }),
            ];
        });


        return response()->json($result);
    }

    public function featuredProducts()
    {
        $product = Product::with(['variations'])->where('news', '=', '1')->get();

        return $product->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                'category' => $product->category,
                'price' => $product->price,
                'lastPrice'  => $product->lastPrice,
                "image" => $product->variations->first()->image,
            ];
        });

        return response()->json($product);
    }

    public function fetchProductId($id)
    {
        $product = Product::with(['category', 'variations.color', 'variations.size'])->where('id', $id)->first();

        $result = [

            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "lastPrice" => $product->lastPrice,
            'category' => $product->category->name,
            'description' => $product->description,
            'variations' => $product->variations
                ->groupBy(fn($variation) => $variation->color->id)
                ->map(fn($variationsByColor) => [
                    "image" => $variationsByColor->first()->image,
                    "color" => [
                        "id"   => $variationsByColor->first()->color->id,
                        "name" => $variationsByColor->first()->color->name,
                    ],
                    "sizes" => $variationsByColor->map(fn($v) => [
                        "id"   => $v->size->id,
                        "name" => $v->size->name,
                    ])->values(),
                ])->values(),

        ];


        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json($result);
    }

    public function recomendation($id)
    {


        $product = Product::with(['variations'])->where('id', '=', $id)->first();

        $category = $product->category->id;

        $products = Product::with('variations')->where('fkCategory', $category)->where("id", "!=", $id)->limit(6)->get();

        if ($products->isEmpty()) {
            $allProduct = Product::with("variations")->limit(6)->get();
            $result = $allProduct->map(function ($prod) {
                return  [
                    'id' => $prod->id,
                    "name" => $prod->name,
                    "price" => $prod->price,
                    "lastPrice" => $prod->lastPrice,
                    "image" => $prod->variations->first()->image,
                    'category' => $prod->category,

                ];
            });
            return response()->json($result);
        }
        $result = $products->map(function ($prod) {
            return  [
                'id' => $prod->id,
                "name" => $prod->name,
                "price" => $prod->price,
                "lastPrice" => $prod->lastPrice,
                "image" => $prod->variations->first()->image,
                'category' => $prod->category,

            ];
        });

        return response()->json($result);
    }
    public function delProduct($id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json(['message' => "produto não existe"]);
        }

        $product->delete();

        return response()->json(['message' => "produto deletado"]);
    }
}
