<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account;

use Illuminate\Support\Facades\Auth;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\ProfileSettingsUpdateRequest;
use OneUpReviews\Services\AccountService;

class SettingsController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $user = Auth::user();

        return $this->view('account.settings', compact('user'));
    }

    public function update(ProfileSettingsUpdateRequest $request)
    {
        $this->accountService->updateUser(
            Auth::getUser()->id,
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('email')
        );

        return $this->redirect('/account/settings');
    }
}
