<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class adminAuth
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
        if($request->session()->get('adminLogin') == 0 || empty($request->session()->get('adminLogin'))){
			if($request->ajax() || $request->wantsJson()){
			    return response('Unauthorized.', 401);
            }
			else
			{
			    return redirect()->to('admin/login')->with('error','Please login first to get access!');
			}
		}
		return $next($request);
	}
}

