<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use DB;
use OneUpReviews\Events\TenantCreatedEvent;
use OneUpReviews\Events\TenantCreatingEvent;
use OneUpReviews\Exceptions\UserEmailInvalidOrNonUniqueException;
use OneUpReviews\Models\Tenant;
use OneUpReviews\Models\TenantParams;
use OneUpReviews\Models\User;
use OneUpReviews\Models\UserParams;
use Throwable;

class AccountService
{
    /**
     * @param TenantParams $tenantParams
     * @param UserParams $userParams
     * @return User
     * @throws UserEmailInvalidOrNonUniqueException
     * @throws Throwable
     */
    public function registerTenantAndUserAccount(TenantParams $tenantParams, UserParams $userParams): User
    {
        if (! $this->checkIfEmailValidAndUnique($userParams->getEmailAddress())) {
            throw new UserEmailInvalidOrNonUniqueException('Invalid email');
        }

        return DB::transaction(function() use ($tenantParams, $userParams) {
            $tenant = new Tenant([
                'name' => $tenantParams->getCompanyName(),
            ]);

            event(new TenantCreatingEvent($tenant));

            $tenant->save();

            $user = $this->makeUser($tenant->id, $userParams);
            $user->save();

            event(new TenantCreatedEvent($user->tenant->id, $user->id));

            return $user;
        });
    }

    private function makeUser(int $tenantId, UserParams $userParams): User
    {
        return new User([
            'tenant_id' => $tenantId,
            'first_name' => $userParams->getFirstName(),
            'last_name' => $userParams->getLastName(),
            'email' => $userParams->getEmailAddress(),
            'password' => bcrypt($userParams->getPassword()),
        ]);
    }

    private function checkIfEmailValidAndUnique(string $email): bool
    {
        $valid = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (! $valid) {
            return false;
        }

        $exists = User::where('email', $email)->first();

        return $exists ? false : true;
    }
}
