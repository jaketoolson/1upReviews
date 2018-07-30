<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

use Illuminate\Database\Seeder;

class CreateStripePlans extends Seeder
{
    public function run()
    {
        \OneUpReviews\Models\SubscriptionPlan::create([
            'stripe_plan_id' => 'plan_DK7miJ196quauD',
            'stripe_product_id' => 'prod_DK7lDnZWKb95Oo',
            'interval' => 'monthly',
            'amount' => 10000,
            'name' => 'monthly',
            'product_name' => '1upreviews_monthly',
        ]);
    }
}
