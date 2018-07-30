<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Mail;

interface MailHeaders
{
    public const HEADER_CAMPAIGN_EMAIL_ID = 'X-PM-Metadata-campaign-email-id';
    public const HEADER_ORGANIZATION_ID = 'X-PM-Metadata-organization-id';
    public const HEADER_MESSAGE_ID = 'X-PM-Message-Id';
}
