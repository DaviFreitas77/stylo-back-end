<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function createColor(Request $request)
    {

        $validated = $request->validate([
            "name" => ['required', 'string']
        ], [
            "name.required" => "o nome da cor é obrigatória"
        ]);

        $color = new Colors;
        $color->name = $request->name;
        $color->save();

        return response()->json((['message' => 'cor criada com sucesso']));
    }
}
