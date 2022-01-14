<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
            'lead_type_id' => ['string', 'required', 'exists:lead_types,id'],
            'name' => ['string', 'required', 'max:255'],
            'email' => ['string', 'nullable', 'max:255'],
            'phone_number' => ['string', 'nullable', 'max:255'],
            'location' => ['string', 'nullable', 'max:255'],
            'professional' => ['string', 'nullable', 'max:255'],
            'social_media' => ['string', 'nullable', 'max:255']
        ];
    }
}
