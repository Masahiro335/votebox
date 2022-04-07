<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Factory;

class LoginCheck
{
    public function __construct(Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( empty($request->Auth) ){
			session()->flash('flash_error_message', 'ログインして下さい。');
			return redirect()->route('login');
		}

        $this->viewFactory->share('is_mypage', true);

        return $next($request);
    }
}
