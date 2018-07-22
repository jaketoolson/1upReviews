<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use Exception;
use OneUpReviews\Events\CampaignEmailCreated;
use OneUpReviews\Models\EmailTemplate;
use OneUpReviews\Models\User;
use OneUpReviews\Models\CampaignEmail;
use OneUpReviews\Models\Client;
use OneUpReviews\Models\Tenant;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CampaignEmailService
{
    public function getAll(): ?Collection
    {
        return CampaignEmail::orderByDesc('created_at')->get();
    }

    /**
     * @param Tenant $tenant
     * @param Client $client
     * @param User $sentBy
     * @param EmailTemplate $emailTemplate
     * @return CampaignEmail
     */
    public function create(
        Tenant $tenant,
        Client $client,
        User $sentBy,
        EmailTemplate $emailTemplate
    ): CampaignEmail
    {
        $bodyHtml = $emailTemplate->body_html;
        $bodyText = $emailTemplate->body_text;
        $subject = $emailTemplate->subject;

        $email = CampaignEmail::create([
            'tenant_id' => $tenant->id,
            'client_id' => $client->id,
            'sent_by' => $sentBy->id,
            'email_template_id' => $emailTemplate->id,
            'recipient_email' => $client->email_address,
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'body_text' => $bodyText,
        ]);

        event(new CampaignEmailCreated($email->id));

        return $email;
    }

    /**
     * @param string $column
     * @param mixed $value
     * @return CampaignEmail
     * @throws ModelNotFoundException
     * @throws QueryException
     */
    public function findWithNoGlobalScope(string $column, $value): CampaignEmail
    {
        return CampaignEmail::where($column, '=', $value)
            ->with([
                'tenant',
                'client',
            ])
            ->withoutGlobalScope('tenant_id')
            ->firstOrFail();
    }

    /**
     * @param string $column
     * @param mixed $value
     * @return CampaignEmail
     * @throws ModelNotFoundException
     * @throws QueryException
     */
    public function findEmail(string $column, $value): CampaignEmail
    {
        return $this->findWithNoGlobalScope($column, $value);
    }

    /**
     * @param string $column
     * @param $value
     * @return Email
     */
    public function findEmailWithTenantScope(string $column, $value): CampaignEmail
    {
        return CampaignEmail::where($column, '=', $value)
            ->with([
                'tenant',
                'client',
                'tenant.meta',
                'emailCampaign',
                'emailCampaign.socialFocus'
            ])
            ->firstOrFail();
    }
}
