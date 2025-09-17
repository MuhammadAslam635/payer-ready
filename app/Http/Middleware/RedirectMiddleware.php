<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserType;

class RedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        $currentRoute = $request->route()->getName();

        // Only redirect if user is not already on their correct dashboard
        if ($user->user_type === UserType::SUPER_ADMIN && $currentRoute !== 'super_admin.dashboard') {
            return redirect()->route('super_admin.dashboard');
        }
        if ($user->user_type === UserType::DOCTOR && $currentRoute !== 'doctor.dashboard') {
            return redirect()->route('doctor.dashboard');
        }
        if ($user->user_type === UserType::ORGANIZATION_ADMIN && $currentRoute !== 'organization_admin.dashboard') {
            return redirect()->route('organization_admin.dashboard');
        }
        if ($user->user_type === UserType::COORDINATOR && $currentRoute !== 'coordinator.dashboard') {
            return redirect()->route('coordinator.dashboard');
        }

        return $next($request);
    }
    }
