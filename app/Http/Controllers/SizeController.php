<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function createSize(Request $request)
    {

        $validated = $request->validate([
            "name" => ['required', 'string']
        ], [
            "name.required" => "o tamanho é obrigatório"
        ]);
        $size = new Size;
        $size->name = $request->name;

        $size->save();

        return response()->json(['message' => 'tamanho criado']);
    }
}
