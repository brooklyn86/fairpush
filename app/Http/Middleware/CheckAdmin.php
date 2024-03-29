<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->role_id == User::ADMIN){
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
