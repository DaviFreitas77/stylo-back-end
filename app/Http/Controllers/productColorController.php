<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;

class productColorController extends Controller
{
    public function createRelacionameto(Request $request)
    {
        $productColor = new ProductColor;
        $productColor->fkProduct = $request->fkProduct;
        $productColor->fkColor = $request->Color;

        $productColor->save();

        return response()->json(['message' => "relacionamento criado"]);
    }
}
