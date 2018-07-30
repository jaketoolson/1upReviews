<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use DB;
use OneUpReviews\Events\OrganizationCreatedEvent;
use OneUpReviews\Events\OrganizationCreatingEvent;
use OneUpReviews\Exceptions\UserEmailInvalidOrNonUniqueException;
use OneUpReviews\Models\Organization;
use OneUpReviews\Models\OrganizationParams;
use OneUpReviews\Models\User;
use OneUpReviews\Models\UserParams;
use Throwable;

class AccountService
{
    /**
     * @param OrganizationParams $organizationParams
     * @param UserParams $userParams
     * @return User
     * @throws UserEmailInvalidOrNonUniqueException
     * @throws Throwable
     */
    public function registerTenantAndUserAccount(OrganizationParams $organizationParams, UserParams $userParams): User
    {
        if (! $this->checkIfEmailValidAndUnique($userParams->getEmailAddress())) {
            throw new UserEmailInvalidOrNonUniqueException('Invalid email');
        }

        return DB::transaction(function() use ($organizationParams, $userParams) {
            $organization = new Organization([
                'name' => $organizationParams->getName(),
            ]);

            event(new OrganizationCreatingEvent($organization));

            $organization->save();

            $user = $this->makeUser($organization->id, $userParams);
            $user->save();

            event(new OrganizationCreatedEvent($user->organization->id, $user->id));

            return $user;
        });
    }

    private function makeUser(int $organizationId, UserParams $userParams): User
    {
        return new User([
            'organization_id' => $organizationId,
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
