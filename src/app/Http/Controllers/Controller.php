<?php

namespace App\Http\Controllers;
/**
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Autenticación con token de Laravel Sanctum (Bearer {token})"
 * )
 */


abstract class Controller
{
    //
}
