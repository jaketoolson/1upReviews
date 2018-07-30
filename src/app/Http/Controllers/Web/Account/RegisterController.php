<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account;

use Log;
use OneUpReviews\Exceptions\UserEmailInvalidOrNonUniqueException;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\AccountCreationRequest;
use OneUpReviews\Models\TenantParams;
use OneUpReviews\Models\UserParams;
use OneUpReviews\Services\AccountService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RegisterController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index(): Response
    {
        return $this->view('account.register');
    }

    public function store(AccountCreationRequest $request)
    {
        $tenantParams = new TenantParams($request->get('company_name'));
        $userParams = new UserParams(
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('email'),
            $request->get('password')
        );

        try {
            $this->accountService->registerTenantAndUserAccount($tenantParams, $userParams);
        } catch (UserEmailInvalidOrNonUniqueException | Throwable $e) {
            Log::error($e);
            return $this->redirect('/account/register')
                ->withInput($request->except(['password']));
        }

        return $this->redirect('/account/login');
    }
}
