<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Api Documentation",
 *      description="Api description",
 *      @OA\Contact(
 *          email="zn0923n@gmail.com"
 *      )
 * ),
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description=" API Server"
 * ),
 *
 * @OA\Schemes(format="http"),
 * @OA\Components(
 *      @OA\SecurityScheme(
 *          securityScheme="bearerAuth",
 *          type="http",
 *          scheme="bearer"
 *      )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
