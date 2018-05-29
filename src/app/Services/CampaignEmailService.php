<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use Exception;
use OneUpReviews\Events\CampaignEmailCreated;
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
     * @param Tenant   $tenant
     * @param Client   $client
     * @param User     $sentBy
     * @param int|null $emailCampaignId
     * @param string   $recipientEmail
     * @param string   $subject
     * @param string   $bodyHtml
     *
     * @return CampaignEmail
     * @throws Exception
     */
    public function create(
        Tenant $tenant,
        Client $client,
        User $sentBy,
        ?int $emailCampaignId,
        string $recipientEmail,
        string $subject,
        string $bodyHtml
    ): CampaignEmail
    {
        if (! $emailCampaignId) {
            
        }

        $email = new CampaignEmail([
            'tenant_id' => $tenant->id,
            'client_id' => $client->id,
            'sent_by' => $sentBy->id,
            'email_campaign_id' => $emailCampaignId,
            'recipient_email' => $recipientEmail,
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'body_text' => '',
            'provider_message_id' => '',
        ]);

        $tenant->emails()->save($email);

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
                'tenant.meta',
                'emailCampaign',
                'emailCampaign.socialFocus'
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
