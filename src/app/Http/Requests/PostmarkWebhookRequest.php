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

    public function recordTypeDelivered(): bool
    {
        return $this->getRecordType() === 'Delivery';
    }

    public function recordTypeBounced(): bool
    {
        return $this->getRecordType() === 'Bounce';
    }

    public function recordTypeOpened(): bool
    {
        return $this->getRecordType() === 'Open';
    }

    public function recordTypeLinkClicked(): bool
    {
        return $this->getRecordType() === 'Click';
    }

    public function getRecordType(): ?string
    {
        $content = $this->getDecodedContent();

        return $content['RecordType'] ?? null;
    }
}
