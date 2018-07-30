<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web;

use Illuminate\Http\Request;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('emails')->orderByDesc('created_at')->get();

        return $this->view('clients.index', compact('clients'));
    }

    public function create()
    {
        return $this->view('clients.create');
    }

    public function store(Request $request)
    {
        Client::create([
            'tenant_id' => auth()->user()->tenant_id,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email_address' => $request->get('email_address'),
            'business_name' => $request->get('business_name')
        ]);

        return $this->redirect('/clients');
    }
}
