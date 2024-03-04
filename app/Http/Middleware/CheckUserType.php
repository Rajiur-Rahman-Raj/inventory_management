<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->user_type == 1 && $user->role_id == 0){
            return $next($request);
        }

        if ($user->user_type == 2){
            abort(404);
        }

        $userPermission = optional($user->role)->permission;
        if ($user->role) {
            if (in_array($request->route()->getName(), $userPermission)) {
                return $next($request);
            }
        }

        return  abort(404);

    }
}
