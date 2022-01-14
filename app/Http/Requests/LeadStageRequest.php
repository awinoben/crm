<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed is_yes
 */
class LeadStageRequest extends FormRequest
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
            'stage_id' => ['nullable', 'string', 'max:255', 'exists:stages,id'],
            'lead_id' => ['nullable', 'string', 'max:255', 'exists:leads,id'],
            'keywords' => ['nullable', 'array'],
            'products_and_services' => ['nullable', 'array'],
            'description' => ['nullable', 'string'],
            'is_complete' => ['nullable', 'integer', 'in:1,0'],
            'is_closed' => ['nullable', 'integer', 'in:1,0'],
            'closed_us' => ['nullable', 'string', 'in:worn,lost'],
        ];
    }
}
