<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            "name" => ['required', 'string'],
            "email" => ['required', 'string', 'unique:users,email'],
            "password" => ['required', 'string']
        ], [
            "name.required" => "o nome é obrigatório",
            "email.required" => "o email é obrigatório",
            "password.required" => "a senha é obrigatório",
            "email.unique" => "este email ja possui uma conta",
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["message" => "Cadastrado com sucesso"], 201);
    }




    public function login(Request $request)
    {
        $credentials  = $request->only("email", "password");

        if (!Auth::attempt($credentials)) {
            abort(401, "credenciais invalidas");
        }

        $user = $request->user();

       $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
}
