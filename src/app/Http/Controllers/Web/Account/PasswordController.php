<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account;

use Illuminate\Support\Facades\Auth;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\PasswordUpdateRequest;
use OneUpReviews\Services\AccountService;

class PasswordController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $user = Auth::user();

        return $this->view('account.password', compact('user'));
    }

    public function update(PasswordUpdateRequest $request)
    {
        $this->accountService->updatePassword(
            Auth::getUser()->id,
            $request->get('old_password'),
            $request->get('new_password')
        );

        return $this->redirect('/account/password');
    }
}
