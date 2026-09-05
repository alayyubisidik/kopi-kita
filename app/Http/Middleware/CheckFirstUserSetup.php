<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstUserSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum ada user sama sekali di database
        if (User::count() === 0) {
            // Jika user mencoba mengakses route selain /setup-admin,
            // redirect ke /setup-admin
            if (! $request->is('setup-admin') && ! $request->is('setup-admin/*')) {
                return redirect()->route('setup-admin.create');
            }
        }
        // Jika sudah ada user dan user mencoba mengakses /setup-admin,
        // redirect ke dashboard (jika sudah login) atau login (jika belum login)
        elseif ($request->is('setup-admin') || $request->is('setup-admin/*')) {
            if (auth()->check()) {
                return redirect()->route('dashboard.index');
            } else {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
