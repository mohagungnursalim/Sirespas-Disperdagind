<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // if(auth()->user()->is_admin == 1){
        //     return $next($request);
        // }
   
        // return redirect('home')->with('error',"You don't have admin access.");

        if(!auth()->check() || !auth()->user()->is_admin){
            abort(404);
        }
        return $next($request);
    }
    
    // public function handle($request, Closure $next)
    // {
        
    // }
}
