<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => 'required|string',
            'expiration_year' => 'required|int',
            'expiration_month' => 'required|int',
            'cvc' => 'required|int',
        ];
    }
}
