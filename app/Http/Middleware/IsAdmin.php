<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param \App\Enums\DiscordPermissions $permission
     * @return mixed
     */
    public function handle($request,Closure $next,$permission)
    {
        if(!$permission & $request->session()->get("guild_permissions"))
            return abort(501);

        return $next($request);
    }
}
