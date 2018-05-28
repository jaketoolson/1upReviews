<?php
/**
 * Copyright (c) 2017. Jake Toolson <jaketoolson@gmail.com>
 */

namespace Orion\OneUpReviews\Services;

use Exception;
use Orion\OneUpReviews\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientService
{
    /**
     * @return null|Collection
     */
    public function getAll(): ?Collection
    {
        return Client::orderByDesc('created_at')->get();
    }

    /**
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function findByUuid(string $uuid)
    {
        return Client::where('uuid', '=', $uuid)->firstOrFail();
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $emailAddress
     * @param null|string $businessName
     * @return Client
     */
    public function create(
        string $firstName,
        string $lastName,
        string $emailAddress,
        ?string $businessName = null
    ): Client
    {
        return Client::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email_address' => $emailAddress,
            'business_name' => $businessName
        ]);
    }

    /**
     * @param string $uuid
     * @param string $firstName
     * @param string $lastName
     * @param string $emailAddress
     * @param null|string $businessName
     * @return Client
     */
    public function update(
        string $uuid,
        string $firstName,
        string $lastName,
        string $emailAddress,
        ?string $businessName = null
    ): Client
    {
        $client = Client::where('uuid', '=', $uuid)->firstOrFail();
        $client->update([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email_address' => $emailAddress,
            'business_name' => $businessName
        ]);

        return $client;
    }

    /**
     * @param string $uuid
     * @throws Exception
     */
    public function delete(string $uuid): void
    {
        $client = Client::where('uuid', '=', $uuid)->firstOrFail();
        $client->delete();
    }
}
