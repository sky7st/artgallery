<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
class EnquiryAccess
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
        if(Gate::check('view self enquiry') || Gate::check('view all enquiry')){
            return $next($request);    
        }
        return abort(401);
    }
}
