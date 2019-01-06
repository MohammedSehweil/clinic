<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class RedirectIfPrivate.
 */
class RedirectIfPrivate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = currentUser();
        if ($user and in_array($user->type, ['private-doctor']) and !$user->info_filled) {
            return redirect()->route('admin.private-doctor.create', ['privatedoctor' => $user->id]);
        }

        if ($user and in_array($user->type, ['nurse']) and !$user->info_filled) {
            return redirect()->route('admin.nurse.create', ['nurse' => $user->id]);
        }


        return $next($request);
    }
}
