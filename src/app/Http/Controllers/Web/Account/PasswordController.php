<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\PasswordUpdateRequest;
use OneUpReviews\Http\Requests\ProfileSettingsUpdateRequest;
use OneUpReviews\Services\AccountService;

class PasswordController extends Controller
{
    private $accountService;

    public function __construct(ResponseFactory $responseFactory, AccountService $accountService)
    {
        parent::__construct($responseFactory);

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
