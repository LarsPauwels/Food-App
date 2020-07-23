<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	/**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Food Application",
     *      description="API for Food Application",
     *      @OA\Contact(
     *          email="lars.pauwels@telenet.be"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     *
     * @OA\SecurityScheme(
     *  securityScheme="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT"
     *  )
     */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
