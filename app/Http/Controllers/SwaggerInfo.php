<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 * title="DistribuIT API", 
 * description="Documentation about endpoints to clients outside Laravel, use it if you want    make a app using javascript frameworks or some derived applications outside the main app",version="1.0.0", 
 * @OA\Contact(email="jonathan.juarez.valera@gmail.com", name="Jonathan Juárez Valera", url="https://imjhondev.netlify.app/"))
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
