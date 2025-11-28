<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'email' => 'required|email',
        ], [
            'email.required' => 'El campo correo es obligatorio.',
            'email.email' => 'El correo no tiene el formato correcto.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $credentials = request(['email', 'password']);
        if (! $token = Auth::guard('api')->attempt($credentials)) {
    // O si usas el helper global auth() y el guard por defecto es 'api' con 'jwt':
    // if (! $token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized: Invalid Credentials'], 401);
    }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
{
    $user = Auth::user();

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => config('jwt.ttl') * 60,
    
    ], Response::HTTP_OK);
}
}