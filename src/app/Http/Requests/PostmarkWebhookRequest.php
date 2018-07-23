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

    public function getDecodedContent(): array
    {
        return json_decode($this->getContent(), true);
    }

    public function emailTypeDelivered(): bool
    {
        return $this->getEmailType() === 'Delivery';
    }

    public function emailTypeBounced(): bool
    {
        return $this->getEmailType() === 'Bounce';
    }

    public function emailTypeOpened(): bool
    {
        return $this->getEmailType() === 'Open';
    }

    public function emailTypeLinkClinked(): bool
    {
        return $this->getEmailType() === 'Click';
    }

    public function getEmailType(): ?string
    {
        $content = $this->getDecodedContent();

        return $content['RecordType'] ?? null;
    }
}
