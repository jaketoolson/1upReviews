<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostmarkWebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        $content = $this->getContent();

        return !(! $content || $content === '[]' || $content === '');
    }

    public function rules(): array
    {
        return [];
    }
}
