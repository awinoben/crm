<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed campaign_id
 * @property mixed name
 * @property mixed email
 * @property mixed phone_number
 * @property mixed category
 */
class LeadGenerationRequest extends FormRequest
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
            'category' => ['string', 'required', 'max:255', 'exists:lead_types,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ];
    }
}
