<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * We can filter request based on serviceType, and change request param
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        // Check service type is exists or not.
        if (!$request->has('serviceType')) {
            return [
                'serviceType' => 'required|in:serviceA,serviceB,serviceC',
            ];
        }

        // Change dynamically to access all data
        if(
            $request->headers->has('api-token') &&
            !empty($request->headers->has('api-token')) &&
            $request->headers->get('api-token') === '8c4955934af8524c934904d699d1c344'
        ){
            // Do not need to modify
            return [];
        }

        $validate = null;
        switch ($request->serviceType) {
            case 'serviceA':
                $validate = $this->getValidationfieldForServiceA($request);
                break;

            case 'serviceB':
                $validate = $this->getValidationfieldForServiceB($request);
                break;

            case 'serviceC':
                $validate = $this->getValidationfieldForServiceC($request);
        }

        return $validate;
    }

    /**
     * Validate field for Service A
     * @param Request $request
     * @return string[]
     */
    protected function getValidationfieldForServiceA(Request $request)
    {
        // If service A & campaign B then do not validate campaign data
        $validateFields = [
            'name' => 'required|string',
            'phone' => 'required|min:11|numeric',
            'email' => 'required|email',
            'query_type' => 'required|array',
            'query_type.id' => 'required|integer',
            'query_type.title' => 'required|string',
            'call_stats' => 'required|array',
            'call_stats.id' => 'required|integer',
            'call_stats.length' => 'required',
            'call_stats.recording_url' => 'required|string'
        ];

        if (
            $request->serviceType === 'serviceA' &&
            $request->has('campaign') &&
            (int)$request->campaign['id'] != 1516 // Campaign B
        ) {
            $validateFields['campaign'] = 'required|array';
            $validateFields['campaign.id'] = 'required|integer'; // if database 'required|exists:campaigns,id
            $validateFields['campaign.name'] = 'required|string';
            $validateFields['campaign.description'] = 'required|string';
        }

        return $validateFields;
    }

    /**
     * Validate field for Service B
     * @param Request $request
     * @return string[]
     */
    protected function getValidationfieldForServiceB(Request $request)
    {
        // If service B can receive only sales information
        $validateFields = [
            'query_type' => 'required|array',
            'query_type.id' => 'required|integer',
            'query_type.title' => 'required|string'
        ];

        return $validateFields;
    }

    /**
     * Validate field for Service C
     * @param Request $request
     * @return string[]
     */
    protected function getValidationfieldForServiceC(Request $request)
    {
        // If service A & campaign B then do not validate campaign data
        $validateFields = [
            'name' => 'required|string',
            'phone' => 'required|min:11|numeric',
            'email' => 'required|email',
            'campaign.description' => 'required|string',
            'query_type' => 'required|array',
            'query_type.id' => 'required|integer',
            'query_type.title' => 'required|string',
            'call_stats' => 'required|array',
            'call_stats.id' => 'required|integer',
            'call_stats.length' => 'required',
            'call_stats.recording_url' => 'required|string',
            'campaign' => 'required|array',
            'campaign.id' => 'required|integer', // if database 'required|exists:campaigns,id
            'campaign.name' => 'required|string'
        ];

        return $validateFields;
    }

}
