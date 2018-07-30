<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account;

use OneUpReviews\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function index(): Response
    {
        return $this->view('account.login');
    }

    public function login(Request $request): Response
    {
        $credentials = $request->only(['email', 'password']);

        if (! auth()->attempt($credentials)) {
            return $this->redirect('/account/login');
        }

        return $this->redirect('/');
    }

    public function logout(Request $request)
    {
        auth('web')->logout();

        $request->session()->invalidate();

        return $this->redirect('/account/login');
    }
}
