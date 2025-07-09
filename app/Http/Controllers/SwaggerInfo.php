<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="MarketAPI", version="1.0.0", @OA\Contact(email="jonathan.juarez.valera@gmail.com"))
 * @OA\SecurityScheme(
 *      securityScheme="bearerToken",
 *      type="http",
 *      scheme="bearer"
 *  )
 */
class SwaggerInfo extends Controller
{
    //
}
