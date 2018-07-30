<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Repositories;

use OneUpReviews\Models\Client;

class ClientEloquentRepository extends BaseEloquentRepository implements ClientRepository
{
    public function model(): string
    {
        return Client::class;
    }
}
