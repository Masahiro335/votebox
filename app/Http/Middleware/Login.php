<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \App\Models\User;

class Login
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->Auth = null;

		var_dump(session()->get('Auth'));

		//ログイン
		if( empty(session()->has('Auth')) == false){
			$this->Auth = session()->get('Auth');
			$entUser = User::where('Users.id', $this->Auth['id'])
				->where('is_deleted', false)
				->first()
			;
			
			if( (new \App\Http\Controllers\AppController())->LoginSession($entUser) == false ){
				$this->Auth = session()->get('Auth');
			}
		}

        return $next($request);
    }
}
