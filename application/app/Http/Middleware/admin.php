<?php



namespace App\Http\Middleware;



use Closure;

use Illuminate\Support\Facades\Auth;



class admin

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
        if (Auth::guard($guard)->guest()){
			if($request->ajax() || $request->wantsJson()){
			    return response('Unauthorized.', 401);
            }
			else
			{
			    return redirect()->to('admin/login')->with('error','Please login first to get access!');
			}
		}
		if(Auth::user()->role == 1)
		{
        	return $next($request);
		}
		else
		{
			return redirect()->to('login')->with('access','you are not authorized for this action!');
		}

    }

}

