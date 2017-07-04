<?php

namespace App\Http\Middleware;

use Closure;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Route,URL,Auth;

class AuthenticateAdmin
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
        if(Auth::guard('api')->user()->is_super){
            return $next($request);
        }

        $previousUrl = URL::previous();

        if(!Auth::guard('api')->user()->can(Route::currentRouteName())) {

            return response()->json(['status' => -1, 'message' => '您没有权限执行此操作'], 403);

        }
        return $next($request);
    }
}
