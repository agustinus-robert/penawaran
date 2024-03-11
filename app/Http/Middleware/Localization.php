<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         if (Session::has('locale')) {
            app()->setLocale(Session::get('locale'));
        }
        else { 
            app()->setLocale('id');
        }
        
        return $next($request);
    }
}
