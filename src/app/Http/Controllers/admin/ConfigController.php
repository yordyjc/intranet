<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Models\User;

/**
* @OA\Info(title="API Intranet", version="1.0")
*
* @OA\Server(url="http://localhost:8000")
*/

class ConfigController extends Controller
{
    /**
    * @OA\Get(
    *     path="/user",
    *     summary="Mostrar usuarios",
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar todos los usuarios."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function index()
    {
        return User::all();
    }
}
