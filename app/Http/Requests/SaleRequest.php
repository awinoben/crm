<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed description
 */
class SaleRequest extends FormRequest
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
            'lead_id' => ['required', 'string', 'max:255', 'exists:leads,id'],
            'product_id' => ['required', 'string', 'max:255', 'exists:products,id'],
            'description' => ['required', 'string'],
            'close_rate' => ['integer', 'nullable', 'in:1,2,3,4,5,6,7,8,9,10'],
            'is_closed' => ['integer', 'nullable', 'in:1,0'],
            'is_cancelled' => ['integer', 'nullable', 'in:1,0'],
        ];
    }
}
