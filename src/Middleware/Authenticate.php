<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(preg_match("/\bpanel\b/", $request->route()->getName())){
                return route('panel.unauthenticated');
            }else{
                session()->flash('login', true);
                return route('/');
            }
        }
    }
}
