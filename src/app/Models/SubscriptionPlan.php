<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

class SubscriptionPlan extends BaseEloquentModel
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'stripe_plan_id',
        'stripe_product_id',
        'name',
        'plan_name',
        'amount',
        'interval',
    ];
}
