<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use DB;
use Illuminate\Contracts\Hashing\Hasher;
use OneUpReviews\Events\OrganizationCreatedEvent;
use OneUpReviews\Events\OrganizationCreatingEvent;
use OneUpReviews\Exceptions\EmailAddressAlreadyExists;
use OneUpReviews\Exceptions\EmailAddressInvalidException;
use OneUpReviews\Exceptions\UserEmailInvalidOrNonUniqueException;
use OneUpReviews\Foundation\Exceptions\HashedPasswordsDoNotMatchException;
use OneUpReviews\Models\Organization;
use OneUpReviews\Models\OrganizationParams;
use OneUpReviews\Models\User;
use OneUpReviews\Models\UserParams;
use Throwable;

class AccountService
{
    private $hashManager;

    public function __construct(Hasher $hashManager)
    {
        $this->hashManager = $hashManager;
    }

    /**
     * @param OrganizationParams $organizationParams
     * @param UserParams $userParams
     * @return User
     * @throws EmailAddressAlreadyExists
     * @throws EmailAddressInvalidException
     * @throws Throwable
     */
    public function registerOrganizationAndUserAccount(OrganizationParams $organizationParams, UserParams $userParams): User
    {
        if (! $this->checkIfEmailValid($userParams->getEmailAddress())) {
            throw new EmailAddressInvalidException("Invalid email used at registration: {$userParams->getEmailAddress()}");
        }

        if ($this->checkIfEmailAlreadyExists($userParams->getEmailAddress())) {
            throw new EmailAddressAlreadyExists("Duplicate email attempted at registration: {$userParams->getEmailAddress()}");
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

    /**
     * @param int $userId
     * @param string $newFirstName
     * @param string $newLastName
     * @param string $newEmailAddress
     * @return bool
     * @throws UserEmailInvalidOrNonUniqueException
     */
    public function updateUser(int $userId, string $newFirstName, string $newLastName, string $newEmailAddress): bool
    {
        if (! $this->checkIfEmailValid($newEmailAddress)) {
            throw new UserEmailInvalidOrNonUniqueException('Invalid email');
        }

        $user = User::findOrFail($userId);

        return $user->update([
            'first_name' => $newFirstName,
            'last_name' => $newLastName,
            'email' => $newEmailAddress,
        ]);
    }

    /**
     * @param int $userId
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool
     * @throws HashedPasswordsDoNotMatchException
     */
    public function updatePassword(int $userId, string $currentPassword, string $newPassword): bool
    {
        if (! $this->passwordMatchesExistingForUser($userId, $currentPassword)) {
            throw new HashedPasswordsDoNotMatchException('Passwords do not match');
        }

        $user = User::findOrFail($userId);

        return $user->update([
            'password' => bcrypt($newPassword),
        ]);
    }

    public function updateOrganization(int $organizationId, string $name, int $socialFocusId): bool
    {
        $organization = Organization::findOrFail($organizationId);

        return $organization->update([
            'name' => $name,
            'social_focus_id' => $socialFocusId,
        ]);
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

    private function checkIfEmailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function checkIfEmailAlreadyExists(string $email): bool
    {
        $exists = User::where('email', $email)->first();

        return $exists ? true : false;
    }

    private function passwordMatchesExistingForUser(int $userId, string $password): bool
    {
        $user = User::findOrFail($userId);

        return $this->hashManager->check($password, $user->password);
    }
}
