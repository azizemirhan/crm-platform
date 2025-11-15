<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('contacts.edit');
    }

    public function rules(): array
    {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'salutation' => 'nullable|in:Mr,Mrs,Ms,Dr,Prof',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('contacts')->ignore($this->contact->id),
            ],
            'secondary_email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'title' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'linkedin_url' => 'nullable|url',
            'mailing_street' => 'nullable|string',
            'mailing_city' => 'nullable|string|max:100',
            'mailing_state' => 'nullable|string|max:100',
            'mailing_postal_code' => 'nullable|string|max:20',
            'mailing_country' => 'nullable|string|max:2',
            'lead_source' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive,disqualified',
            'description' => 'nullable|string',
            'custom_fields' => 'nullable|array',
        ];
    }
}