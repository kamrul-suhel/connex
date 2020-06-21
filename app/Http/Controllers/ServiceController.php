<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponder;

    /**
     * @param ServiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getService(ServiceRequest $request){
        return $this->successResponse(['message' => 'Request sent.']);
    }
}
