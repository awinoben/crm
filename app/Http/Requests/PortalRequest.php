<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed industry_id
 * @property mixed funnel
 * @property mixed url
 */
class PortalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'industry_id' => ['string', 'required','exists:industries,id'],
            'funnel' => ['string', 'required', 'max:255'],
            'url' => ['url', 'required', 'max:255']
        ];
    }
}
