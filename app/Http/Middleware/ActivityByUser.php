<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ActivityByUser
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
        if (auth()->check()) {
            $expiresAt = Carbon::now()->addMinute(1); // keep online for 1 min
            Cache::put('user-is-online-' . auth()->id, true, $expiresAt);
            User::where('id', auth()->id)->update(['last_seen' => (new \DateTime())->format("Y-m-d H:i:s")]);
        }

        return $next($request);
    }
}
