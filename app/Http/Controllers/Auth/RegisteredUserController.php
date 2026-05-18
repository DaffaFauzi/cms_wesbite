<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * Disabled — in a multi-company CMS, users are created by super_admin.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('login')
            ->withErrors(['email' => 'Public registration is disabled. Contact your administrator.']);
    }

    /**
     * Disabled — reject any POST to /register.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('login')
            ->withErrors(['email' => 'Public registration is disabled. Contact your administrator.']);
    }
}
