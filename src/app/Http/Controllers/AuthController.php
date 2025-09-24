<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
    * @OA\Post(
    *     path="/api/login",
    *     summary="Iniciar sesion",
    *     @OA\Response(
    *         response=200,
    *         description="Login correcto."
    *     ),
    *     @OA\Response(
    *         response="401",
    *         description="Contraseña o usuario incorrecto"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Error en el servidor"
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"email","password"},
    *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
    *             @OA\Property(property="password", type="string", format="password", example="123456")
    *         )
    *     ),
    * )
    */
    public function login(Request $request) : JsonResponse
    {
        try
        {
            $user = User::where('email', $request->email)->first();
            if (! $user || ! \Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Contraseña o usuario incorrecto'
                ], 401);
            }
            //Se debe enviar el nombre del dispositivo desde el cliente
            $token = $user->createToken($request->device_name ?? 'unknown')->plainTextToken;
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => 'Error en el servidor'
            ], 500);
        }

        return response()->json(['token' => $token]);
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesion",
     *     @OA\Response(
     *         response=200,
     *         description="Logged out."
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error en el servidor"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Tu token no es valido o ya expiro"
     *     ),
     *    security={{"sanctum": {}}},
     * )
     */
    public function logout(Request $request)
    {
        try
        {
            $request->user()->currentAccessToken()->delete();
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => 'Error en el servidor'
            ], 500);
        }
        return response()->json(['message' => 'Logged out']);
    }
}
