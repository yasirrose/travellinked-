<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class siteAuth

{

    /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure  $next

     * @param  string|null  $guard

     * @return mixed

     */

    public function handle($request, Closure $next, $guard = null)

    {
        if($request->session()->get('siteLogin') == 0 || empty($request->session()->get('siteLogin'))){
            if($request->ajax() || $request->wantsJson()){

                return response('Unauthorized.', 401);

            }
            else
            {
                return redirect()->to('login')->with('error','Please login first to get access!');
            }
        }
        return $next($request);

    }



}



