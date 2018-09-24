<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin' , 'http://localhost:3000');
        $response->header( 'Access-Control-Allow-Headers', 'Authorization, Content-Type, X-Auth-Token, Origin, X-CS-TOKEN, X-CS-PUBLIC, X-HI-ROY, X-Requested-With, X-CSRF-TOKEN');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Credentials', 'true');
        return $response;
    }

}
