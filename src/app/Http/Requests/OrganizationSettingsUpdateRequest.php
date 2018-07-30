<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationSettingsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'social_focus_id' => 'required|int'
        ];
    }
}
