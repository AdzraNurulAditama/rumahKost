<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class AdminMiddleware
{
    public function handle($request, Closure $next)
{

    if (!auth()->check()) {
        return redirect()->route('admin.login');
    }

    $role = trim(auth()->user()->role);

    if (!in_array($role, ['admin', 'Super Admin'])) {
        abort(403, 'Akses ditolak!');
    }

    return $next($request);
}
}