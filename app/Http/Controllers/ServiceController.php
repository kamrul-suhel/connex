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
    public function getService(ServiceRequest $request)
    {
        switch ($request->serviceType) {
            case 'serviceA':
                $data = [
                    'message' => 'Sent request into Microservice A',
                    'payload' => $request->all()
                ];
                return $this->successResponse($data);

            case 'serviceB':
                $data = [
                    'message' => 'Sent request into Microservice B',
                    'payload' => $request->all()
                ];
                return $this->successResponse($data);

            case 'serviceC':
                $data = [
                    'message' => 'Sent request into Microservice C',
                    'payload' => $request->all()
                ];
                return $this->successResponse($data);

            default:
                return $this->errorResponse('Something went wrong.'); // Which is not reach
        }
    }
}
