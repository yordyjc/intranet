<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/get-branches/{username}",
    *     summary="Obtene sucursales",
    *     @OA\Response(
    *         response=200,
    *         description="ok"
    *     ),
    *     @OA\Response(
    *         response="401",
    *         description="Acceso no autorizado"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Error en el servidor"
    *     ),
    *    security={{"sanctum": {}}},
    *    @OA\Parameter(
    *         name="username",
    *         in="path",
    *         description="Nombre de usuario",
    *         required=true,
    *         @OA\Schema(type="string")
    *     ),
    * )
    */
    public function getBranches($username) : JsonResponse
    {
        // return response()->json(['message' => 'ok']);
        $query = "SELECT
                        LTRIM(RTRIM(GE_SUCURSAL.SUCURSAL)) as CODIGO,
                        LTRIM(RTRIM(GE_SUCURSAL.NOMBRE)) as SUCURSAL
                    FROM
                        GE_SUCURSAL WITH ( NOLOCK )
                        INNER JOIN SY_SEGURIDADAUTORIZACIONES WITH ( NOLOCK ) ON RTRIM( GE_SUCURSAL.SUCURSAL ) = RTRIM( SY_SEGURIDADAUTORIZACIONES.CONCEPTO )
                    WHERE
                        GE_SUCURSAL.ESTADO = 'A'
                        AND SY_SEGURIDADAUTORIZACIONES.GRUPO = 'SUCURSAL'
                        AND SY_SEGURIDADAUTORIZACIONES.ESTADO = 'A'
                        AND SY_SEGURIDADAUTORIZACIONES.USUARIO = '".$username."'";
        $branches = DB::connection('sqlsrv')->select($query);
        return response()->json($branches);
    }

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
    *             @OA\Property(property="email", type="string", format="email", example="yordyjc.chura@gmail.com"),
    *             @OA\Property(property="password", type="string", format="password", example="12345")
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
     *         description="Tu token no es valido o ya expiro",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out"),
     *         )
     *     ),
     *    security={{"sanctum": {}}},
     * )
     */
    public function logout(Request $request) : JsonResponse
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
