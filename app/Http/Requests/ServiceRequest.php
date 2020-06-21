<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'serviceType' => 'required|in:service1,service2,service3',
            'name' => 'required|string',
            'phone' => 'required|min:11|numeric',
            'email' => 'required|email',
            'query_type' => 'required|array',
            'query_type.id' => 'required|integer',
            'query_type.title' => 'required|string',
            'call_stats' => 'required|array',
            'call_stats.id' => 'required|integer',
            'call_stats.length' => 'required',
            'call_stats.recording_url' => 'required|string',
            'campaign' => 'required|array',
            'campaign.id' => 'required|integer', // if database 'required|exists:campaigns,id
            'campaign.name' => 'required|string',
            'campaign.description' => 'required|string'
        ];
    }
}
