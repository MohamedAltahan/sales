<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            //if the request is coming from backend'admin'
            if ($request->is('admin') || $request->is('admin/*')) {
                //redirect to admin login
                return route('admin.showlogin');
                //if the request is coming from any thing else backend'admin'
            } else {
                //redirect to frontend page
                //return route('login');
                //now we don't have frontend so you will be routed to backend also

                return route('admin.showlogin');
            }
        }
    }
}
