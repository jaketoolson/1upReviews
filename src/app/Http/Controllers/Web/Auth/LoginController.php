<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Auth;

use OneUpReviews\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function index(): Response
    {
        return $this->view('auth.login');
    }

    public function login(Request $request): Response
    {
        $credentials = $request->only(['email', 'password']);

        if (! auth()->attempt($credentials)) {
            return $this->redirect('/auth/login');
        }

        return $this->redirect('/');
    }

    public function logout(Request $request)
    {
        auth('web')->logout();

        $request->session()->invalidate();

        return $this->redirect('/auth/login');
    }
}
