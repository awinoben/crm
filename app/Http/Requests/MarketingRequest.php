<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed campaign_id
 * @property mixed subject
 * @property mixed description
 * @property mixed frequency
 * @property mixed scheduled_at
 * @property mixed tool_ids
 */
class MarketingRequest extends FormRequest
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
            'campaign_id' => ['nullable', 'string', 'max:255', 'exists:campaigns,id'],
            'tool_ids' => ['required', 'array'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'schedule_at' => ['date', 'nullable', 'after_or_equal:date'], // should be given when the frequency = once
            'frequency' => ['string', 'required', 'in:once,hourly,daily,weekly,monthly,quarterly,yearly'],
            'is_closed' => ['integer', 'nullable', 'in:1,0']
        ];
    }
}
