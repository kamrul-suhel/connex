<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponder;
use Closure;

class VerifyService
{
    use ApiResponder;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Change dynamically to access all data
        if(
            $request->headers->has('api-token') &&
            !empty($request->headers->has('api-token')) &&
            $request->headers->get('api-token') === '8c4955934af8524c934904d699d1c344'
        ){
            // Do not need to modify
            return $next($request);
        }

        // Check service A can not have campaign B data
        $request = $this->modifyRequest($request);

        return $next($request);
    }

    /**
     * This function will modify request base on serviceType param
     * @param $request
     * @return mixed
     */
    private function modifyRequest($request)
    {
        if (
        $request->has('serviceType')
        ) {
            switch ($request->serviceType) {
                case 'serviceA':
                    if (
                        $request->campaign &&
                        (int)$request->campaign['id'] == 1516 // then remove campaign B data from request
                    ) {
                        unset($request['campaign']);
                    }
                    break;

                case 'serviceB': // Receive payloads about sales only
                    unset($request['campaign']);
                    unset($request['call_stats']);
                    unset($request['name']);
                    unset($request['phone']);
                    unset($request['email']);
                    break;
            }
        }

        return $request;
    }
}
