<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed leads
 * @property mixed campaign_id
 */
class AssignLeadToCampaignRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'campaign_id' => ['string', 'required', 'max:255', 'exists:campaigns,id'],
            'leads' => ['array', 'required']
        ];
    }
}
