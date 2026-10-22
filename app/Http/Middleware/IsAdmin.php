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
        // Discord returns permissions as a string and middleware params are strings, so compare as integers.
        $permission = (int)$permission;
        $granted = (int)$request->session()->get("guild_permissions",0);

        if($permission !== ($granted & $permission))
            return abort(403);

        return $next($request);
    }
}
