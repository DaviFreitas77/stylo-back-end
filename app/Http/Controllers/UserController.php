<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\JWK;
use PhpParser\Node\Stmt\Return_;

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
            "email.unique" => "email ja vinculado a uma conta!",
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "adm";
        $user->save();

        Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "message" => "conta criada com sucesso,redirecionando...",
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }




    public function login(Request $request)
    {
        $credentials  = $request->only("email", "password");

        $emailExisting = User::where("email", $request->email)->first();

        if ($emailExisting && $emailExisting->password === null) {
            return response()->json([
                'message' => 'Este e-mail está vinculado a um login com Google.'
            ], 403);
        }


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


    public function LoginGoogle(Request $request)
    {


        $token = $request->token;

        if (!$token) {
            return response()->json(['token não encontrado'], 400);
        }
        try {
            $jwks = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v3/certs'), true);

            $keys = JWK::parseKeySet($jwks);

            $decoded = JWT::decode($token, $keys);

            $user = User::where('email', $decoded->email)->first();

            if ($user && $user->password === null) {
                Auth::login($user);
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ]);
            }

            $user = new User;
            $user->email = $decoded->email;
            $user->name = $decoded->name;
            $user->role = "user";
            $user->save();


            $tokenJwt = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $tokenJwt,
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
