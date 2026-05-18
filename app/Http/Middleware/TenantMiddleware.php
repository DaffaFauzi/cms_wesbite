<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return $next($request);
        }

        $role = auth()->user()->role;

        // super_admin has global access — no company scope needed
        if ($role === 'super_admin') {
            return $next($request);
        }

        // admin / editor: resolve company_id into session
        if (in_array($role, ['admin', 'editor'])) {
            if (! session()->has('company_id')) {
                $companyId = auth()->user()->company_id;

                if ($companyId) {
                    // Restore from user record (e.g. after session expiry)
                    session(['company_id' => $companyId]);
                } else {
                    // User has no company — force logout with a clear message
                    auth()->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')
                        ->withErrors(['email' => 'Your account has no company assigned. Contact your super admin.']);
                }
            }
        }

        return $next($request);
    }
}